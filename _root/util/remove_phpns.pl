#!/usr/bin/env perl

use strict;
use warnings;

use Data::Dumper;
use FileHandle;


sub convertNamespaced($)
{
}

sub splitQuoted($)
{
	my $s			= shift;

	my $q = index($s, "\"");
	my $a = index($s, "\'");
	return ($s, "", "") if ($q < 0 && $a < 0);
	if ($q >= 0 && ($a < 0 || $q < $a)) {
		my $qe = $q+1;
		for (;;) {
			my $b = index($s, "\\", $qe);
			$qe = index($s, "\"", $qe);
			die "cannot find end of the quote" unless ($qe >= 0);
			if ($b < 0 || $qe <= $b) {
				return ( substr($s, 0, $q), substr($s, $q, $qe+1-$q), substr($s, $qe+1) );
			}
			$qe = $b+2;
		}
	}
	else {
		my $ae = $a+1;
		for (;;) {
			my $b = index($s, "\\", $ae);
			$ae = index($s, "\'", $ae);
			die "cannot find end of the apostrophe" unless ($ae >= 0);
			if ($b < 0 || $ae <= $b) {
				return ( substr($s, 0, $a), substr($s, $a, $ae+1-$a), substr($s, $ae+1) );
			}
			$ae = $b+2;
		}
	}
}

die "Usage: $0 source-file destination-file" unless (@ARGV == 2);
my $sfname = shift @ARGV;
my $dfname = shift @ARGV;

my $sfd = FileHandle->new($sfname, "<")
	or die "failed to open $sfname: $!";
my $dfd = FileHandle->new($dfname, ">")
	or die "failed to open $dfname: $!";

my $ns;
my $lineno = 0;
my $out = "";
my $pendout = "";
while (defined (my $rest = <$sfd>)) {
	$lineno++;
	if ($rest =~ m/^}$/) {
		$out .= $pendout;
		$pendout = $_;
	}
	while ($rest ne "") {
		my ($pre, $quot, $post);
		eval {
			($pre, $quot, $post) = splitQuoted($rest);
			die unless (defined $pre);
			1;
		}
			or die "$sfname:$lineno: $@";
		while ($pre ne "") {
			if ($pre =~ m/^(\s*)(namespace\s+([a-z0-9_\\]+))\s*{(.*)$/s) {
				die "$sfname:$lineno: namespace specified for the second time" if (defined $ns);
				$pendout .= $1;
				$ns = $3;
				$pre = $4;
				$ns =~ s/\\/_/g;
				$ns .= "_";
				next;
			}
			if (defined $ns && $pre =~ m/^(\s*)((abstract\s+)*class\s+)([A-Za-z0-9_]+)(.*)$/s) {
				$pendout .= "$1$2$ns$4";
				$pre = $5;
				next;
			}
			if ($pre =~ m/^(.*?)(\\?((\w+\\)+)|\\)(.*)$/s) {
				my ($b, $r) = ($2, $5);
				$pendout .= $1;
				$b =~ s/^\\//;
				$b =~ s/\\/_/g;
				$pendout .= "$b";
				$pre = $r;
				next;
			}
			$pendout .= $pre;
			$pre = "";
		}
		$pendout .= $pre;
		$pendout .= $quot;
		$rest = $post;
	}
}
$dfd->print($out);
if (defined $ns) {
	die "cannot match end of ns" if ($pendout !~ m/^}\s*(.*)$/s);
	$dfd->print($1);
}
else {
	$dfd->print($pendout);
}
