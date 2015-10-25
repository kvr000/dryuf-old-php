#!/bin/sh

set -e
set -o pipefail

mydir=`dirname $0`

if [ $# -ne 2 ]; then
	echo "Usage: $0 source-dir dest-dir" >&2
	exit 2
fi
srcdir=$1
dstdir=$2

( cd $srcdir && find . -name \*.php ) |
	(
		ex=true;
		while read f; do
			mkdir -p "$dstdir/`dirname $f`";
			$mydir/remove_phpns.pl "$srcdir/$f" "$dstdir/$f" &
		done
		wait || ex=false
		$ex
	)
