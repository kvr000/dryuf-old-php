LANGS=nolang $(shell php -r 'require "etc/config.php"; echo implode(" ", \net\dryuf\core\Dryuf::$$config["localize.languages"]);')

all:
	echo Please specify target >&2
	false

tags: notags
	dryuf_gentags

notags:
	rm -f tags

cc:
	rm -rf _rtcache/* _cache/*
	mkdir -m 0777 _rtcache _cache/tmp

devinit: cc
	mkdir -p log
	chmod 777 log
	for f in $(LANGS); do true > log/localize-$$f.log && chmod 666 log/localize-$$f.log || break; done
	ln -sf ../../dryuf/dryuf-core/target/localize/ .
	mkdir -m 0777 -p _cache
	chmod 777 _cache

transgen-core:
	cd trans-core/ && mvn -f ../../../dryuf-core/pom.xml -P phptrans -Dtrans.dir=$$PWD/php/ -Dtrans.files=$$PWD/php/trans.files
transdiff-core:
	diff -urN --exclude=\*.class --exclude=\*.java trans-core/php/direct/ trans-core/php/_build/ > trans-core/php/_trans.diff || [ $$? -le 1 ]
transdry-core: transdiff-core
	cd php/ && patch -p3 --dry-run < ../trans-core/php/_trans.diff
transpatch-core: transdiff-core
	cd php/ && patch -p3 < ../trans-core/php/_trans.diff
	( cd trans-core/php/direct && patch -p3 < ../_trans.diff )
transfull-core: transgen-core
	$(MAKE) transpatch-core

transgen-geo:
	cd trans-geo/ && mvn -f ../../../dryuf-geo/pom.xml -P phptrans -Dtrans.dir=$$PWD/php/ -Dtrans.files=$$PWD/php/trans.files
transdiff-geo:
	diff -urN --exclude=\*.class --exclude=\*.java trans-geo/php/direct/ trans-geo/php/_build/ > trans-geo/php/_trans.diff || [ $$? -le 1 ]
transdry-geo: transdiff-geo
	cd php/ && patch -p3 --dry-run < ../trans-geo/php/_trans.diff
transpatch-geo: transdiff-geo
	cd php/ && patch -p3 < ../trans-geo/php/_trans.diff
	( cd trans-geo/php/direct && patch -p3 < ../_trans.diff )
transfull-geo: transgen-geo
	$(MAKE) transpatch-geo

transgen-mvp:
	cd trans-mvp/ && mvn -f ../../../dryuf-mvp/pom.xml -P phptrans -Dtrans.dir=$$PWD/php/ -Dtrans.files=$$PWD/php/trans.files
transdiff-mvp:
	diff -urN --exclude=\*.class --exclude=\*.java trans-mvp/php/direct/ trans-mvp/php/_build/ > trans-mvp/php/_trans.diff || [ $$? -le 1 ]
transdry-mvp: transdiff-mvp
	cd php/ && patch -p3 --dry-run < ../trans-mvp/php/_trans.diff
transpatch-mvp: transdiff-mvp
	cd php/ && patch -p3 < ../trans-mvp/php/_trans.diff
	( cd trans-mvp/php/direct && patch -p3 < ../_trans.diff )
transfull-mvp: transgen-mvp
	$(MAKE) transpatch-mvp

transgen-security-mvp:
	cd trans-security-mvp/ && mvn -f ../../../dryuf-security-mvp/pom.xml -P phptrans -Dtrans.dir=$$PWD/php/ -Dtrans.files=$$PWD/php/trans.files
transdiff-security-mvp:
	diff -urN --exclude=\*.class --exclude=\*.java trans-security-mvp/php/direct/ trans-security-mvp/php/_build/ > trans-security-mvp/php/_trans.diff || [ $$? -le 1 ]
transdry-security-mvp: transgen-security-mvp
	cd php/ && patch -p3 --dry-run < ../trans-security-mvp/php/_trans.diff
transpatch-security-mvp: transdiff-security-mvp
	cd php/ && patch -p3 < ../trans-security-mvp/php/_trans.diff
	( cd trans-security-mvp/php/direct && patch -p3 < ../_trans.diff )
transfull-security-mvp: transgen-security-mvp
	$(MAKE) transpatch-security-mvp

transgen-comp:
	cd trans-comp/ && mvn -f ../../../dryuf-comp/pom.xml -P phptrans -Dtrans.dir=$$PWD/php/ -Dtrans.files=$$PWD/php/trans.files
transdiff-comp:
	diff -urN --exclude=\*.class --exclude=\*.java trans-comp/php/direct/ trans-comp/php/_build/ > trans-comp/php/_trans.diff || [ $$? -le 1 ]
transdry-comp: transdiff-comp
	cd php/ && patch -p3 --dry-run < ../trans-comp/php/_trans.diff
transpatch-comp: transdiff-comp
	cd php/ && patch -p3 < ../trans-comp/php/_trans.diff
	( cd trans-comp/php/direct && patch -p3 < ../_trans.diff )
transfull-comp: transgen-comp
	$(MAKE) transpatch-comp


transgen-all: transgen-core transgen-geo transgen-mvp transgen-security-mvp transgen-comp
transdiff-all: transdiff-core transdiff-comp transdiff-geo transdiff-mvp transdiff-security-mvp
transdry-all: transdry-core transdry-comp transdry-geo transdry-mvp transdry-security-mvp
transpatch-all: transpatch-core transpatch-comp transpatch-geo transpatch-mvp transpatch-security-mvp
transfull-all: transgen-all
	$(MAKE) transpatch-all

transstat:
	find php/ -name \*.php | perl -e 'no locale; print(sort(map({ s,^php/,,; $$_ } my @x = <>)));' > php/_all.files
	find trans-*/php/direct/ -name \*.php | perl -e 'no locale; print(sort(map({ s,^trans-[-a-zA-Z_]+/php/direct/,,; $$_ } my @x = <>)));' > php/_transdo.files
	cat php/_transdo.files php/transno.files php/transobsolete.files | perl -e 'use File::Slurp; my %notrans = map({ $$_ => 1; } <>); print(grep({ !$$notrans{$$_}; } read_file("php/_all.files")));' > php/_unknown.files
	cat php/_unknown.files
