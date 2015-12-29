<?php


$workRoot								= dirname(dirname(__DIR__))."/_root/";

if (file_exists(__DIR__."/_local/preconfig.php"))
	require(__DIR__."/_local/preconfig.php");

set_include_path("$workRoot/php".PATH_SEPARATOR."$workRoot/third".PATH_SEPARATOR.get_include_path());
require_once "net/dryuf/core/Dryuf.php";

\net\dryuf\core\Dryuf::installDryufEnv();

\net\dryuf\core\Dryuf::$workRoot					= $workRoot;
\net\dryuf\core\Dryuf::$config['appRoot']				= getcwd()."/";

\net\dryuf\core\Dryuf::$printUnhandled					= 3;

\net\dryuf\core\Dryuf::$config['localize.languages']			= array();
\net\dryuf\core\Dryuf::$config['localize.clazz']			= 'net\dryuf\keydb\CsvdbKeyValueDb';
\net\dryuf\core\Dryuf::$config['localize.dbext']			= '.csvdb';
#\net\dryuf\core\Dryuf::$config['localize.clazz']			= 'net\dryuf\keydb\DbaKeyValueDb';
#\net\dryuf\core\Dryuf::$config['localize.dbext']			= '.db';
\net\dryuf\core\Dryuf::$config['localize.defaultLanguage']		= 'en';
\net\dryuf\core\Dryuf::$config['localize.locale.en']			= 'en.UTF-8';
\net\dryuf\core\Dryuf::$config['localize.locale.cs']			= 'cs_CZ.UTF-8';


\net\dryuf\core\Dryuf::$config['app.sysRoles']             		= array("guest", "free", "user", "admin", "sysconf", "extreme", "translation", "devel", "timing");

\net\dryuf\core\Dryuf::$config['net.dryuf.dao.appdb']			= "driver=net.dryuf.sql.mysqli.MysqliConnection;host=localhost;user=dryuf;pass=dryuf;db=dryuf";
#\net\dryuf\core\Dryuf::$config['net.dryuf.dao.appdb']			= "driver=net.dryuf.sql.sqlite3.Sqlite3Connection;file=:memory:;open_mode=2";
\net\dryuf\core\Dryuf::$config['net.dryuf.dao.nominatim']		= "driver=net.dryuf.sql.pgsql.PgsqlConnection;db=nominatim";

\net\dryuf\core\Dryuf::$config['net.dryuf.nocache']	       		= false;
\net\dryuf\core\Dryuf::$config['net.dryuf.js.debug']        		= 1;
\net\dryuf\core\Dryuf::$config['net.dryuf.app.debug']       		= 3;
\net\dryuf\core\Dryuf::$config['net.dryuf.debug.localize']  		= 0;

\net\dryuf\core\Dryuf::$config['net.dryuf.core.dataCacheClazz']		= 'net.dryuf.cache.php.DummyDataCache';


\net\dryuf\core\Dryuf::$config['net.dryuf.email']			= "null@localhost";

\net\dryuf\core\Dryuf::$config['appDomainId']				= "dryuf";
\net\dryuf\core\Dryuf::$config['appName']				= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
\net\dryuf\core\Dryuf::$config['adminShow']				= "user";


\net\dryuf\core\Dryuf::$beans['javax.persistence.EntityManager-dryuf']	= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\phpjpa\EntityManagerPhpJpa(), $name, array("persistenceUnit" => "dryuf", "dialect" => new \net\dryuf\sql\mysqli\MysqliSqlDialect(), "exceptionTranslator" => new \net\dryuf\dao\mysql\JpaExceptionTranslatorMysql(), "dataSource" => $appContainer->getBean("javax.sql.DataSource-dryuf"))); };
\net\dryuf\core\Dryuf::$beans['net.dryuf.transaction.TransactionManager-dryuf'] = function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\phpjpa\JpaTransactionManager($appContainer), $name, array("name" => $name, "entityManager" => $appContainer->getRealBean("javax.persistence.EntityManager-dryuf"))); };
\net\dryuf\core\Dryuf::$beans['javax.sql.DataSource-dryuf']		= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\sql\ConnectionManager(), $name, array("connectUrl" => \net\dryuf\core\Dryuf::$config['net.dryuf.dao.appdb'], 'useCache' => 0)); };
\net\dryuf\core\Dryuf::$beans['javax.sql.DataSource-nominatim']		= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\sql\ConnectionManager(), $name, array("connectUrl" => \net\dryuf\core\Dryuf::$config['net.dryuf.dao.nominatim'], 'useCache' => 0)); };

\net\dryuf\core\Dryuf::$beans['resourceResolver']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\io\ClassPathResourceResolver(), $name, null); };

\net\dryuf\core\Dryuf::$beans['timeBo']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\time\SysTimeBo(), $name, null); };

\net\dryuf\core\Dryuf::$beans['testBean']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\core\test\TestBean(), $name, array("timeBo" => $appContainer->getBean("timeBo"), "captchaService" => $appContainer->getBean("captchaService"))); };

\net\dryuf\core\Dryuf::$beans['loggerService']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\logger\php\PhpLoggerService(), $name, null); };

\net\dryuf\core\Dryuf::$beans['mimeTypeService']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\text\mime\MappedMimeTypeService(), $name, null); };

\net\dryuf\core\Dryuf::$beans['emailSender']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\mail\php\PhpEmailSender(), $name, array("defaultFrom" => \net\dryuf\core\Dryuf::$config['net.dryuf.email'])); };

\net\dryuf\core\Dryuf::$beans['captchaService']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\image\php\PhpCaptchaService(), $name, null); };

\net\dryuf\core\Dryuf::$beans['imageResizeService']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\image\php\ImagickResizeService(), $name, null); };

\net\dryuf\core\Dryuf::$beans['galleryStoreService']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\file\fs\FsFileStoreService(), $name, array("root" => $appContainer->getWorkRoot()."_store/")); };

\net\dryuf\core\Dryuf::$beans['genericDryufDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\test\data\dao\jpa\GenericDryufDaoJpa(), $name, null); };

\net\dryuf\core\Dryuf::$beans['testMainDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\tenv\jpadao\TestMainDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['testChildDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\tenv\jpadao\TestChildDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['testEntDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\test\data\dao\jpa\TestEntDaoJpa(), $name, null); };

\net\dryuf\core\Dryuf::$beans['userAccountDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userLoginRecordDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserLoginRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['appDomainDefDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\AppDomainDefDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userAccountDomainDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDomainDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userAccountDomainRoleDao']		= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDomainRoleDaoJpa(), $name, null); };

\net\dryuf\core\Dryuf::$beans['userAccountBo']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\bo\DbUserAccountBo(), $name, null); };
\net\dryuf\core\Dryuf::$beans['authenticationFrontend']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\web\php\PhpAuthenticationFrontend(), $name, null); };

\net\dryuf\core\Dryuf::$beans['forumHeaderDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\jpadao\ForumHeaderDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['forumRecordDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\jpadao\ForumRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['forumBo']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\sql\SqlForumBo(), $name, null); };

\net\dryuf\core\Dryuf::$beans['galleryHeaderDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\gallery\jpadao\GalleryHeaderDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['gallerySectionDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\gallery\jpadao\GallerySectionDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['galleryRecordDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\gallery\jpadao\GalleryRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['galleryBo']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\gallery\sql\SqlGalleryBo(), $name, null); };

\net\dryuf\core\Dryuf::$beans['pollGroupDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\poll\jpadao\PollGroupDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['pollHeaderDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\poll\jpadao\PollHeaderDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['pollOptionDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\poll\jpadao\PollOptionDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['pollRecordDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\poll\jpadao\PollRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['pollBo']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\poll\sql\SqlPollBo(), $name, null); };

\net\dryuf\core\Dryuf::$beans['ratingHeaderDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\rating\jpadao\RatingHeaderDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['ratingRecordDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\rating\jpadao\RatingRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['ratingBo']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\rating\sql\SqlRatingBo(), $name, null); };

\net\dryuf\core\Dryuf::$config['rolesDependencies']			= array(
	"guest"			=> array("guest"),
	"free"			=> array("free,admin"),
	"user"			=> array("user,admin"),
	"admin"			=> array("admin"),
	"sysmeta"		=> array("sysmeta"),
	"sysconf"		=> array("sysconf"),
	"swapuser"		=> array("swapuser"),
	"dataop"		=> array("dataop"),
	"devel"			=> array("devel,sysmeta"),
	"extreme"		=> array("dataop"),
	"translation"		=> array("guest"),
	"timing"		=> array("admin"),
);

\net\dryuf\core\Dryuf::$config['dryuf-net.dryuf.jpa.entities']		= array(
	'net.dryuf.security.AppDomainAlias',
	'net.dryuf.security.AppDomainDef',
	'net.dryuf.security.AppDomainRole',
	'net.dryuf.security.UserAccount',
	'net.dryuf.security.UserAccountDomain',
	'net.dryuf.security.UserAccountDomainRole',
	'net.dryuf.security.LoginRecord',

	'net.dryuf.tenv.TestMain',
	'net.dryuf.tenv.TestChild',

	'net.dryuf.comp.forum.ForumHeader',
	'net.dryuf.comp.forum.ForumRecord',

	'net.dryuf.comp.gallery.GalleryHeader',
	'net.dryuf.comp.gallery.GalleryRecord',
	'net.dryuf.comp.gallery.GallerySection',
	'net.dryuf.comp.gallery.GallerySource',

	'net.dryuf.comp.poll.PollGroup',
	'net.dryuf.comp.poll.PollHeader',
	'net.dryuf.comp.poll.PollOption',
	'net.dryuf.comp.poll.PollRecord',

	'net.dryuf.comp.rating.RatingHeader',
	'net.dryuf.comp.rating.RatingRecord',

	'net.dryuf.config.DbConfigProfile',
	'net.dryuf.config.DbConfigSection',
	'net.dryuf.config.DbConfigEntry',
);


array_push(\net\dryuf\core\Dryuf::$aops, new \net\dryuf\aop\php\InjectPostProcessor());
array_push(\net\dryuf\core\Dryuf::$aops, new \net\dryuf\dao\phpjpa\PersistenceAopPostProcessor());

date_default_timezone_set('UTC');

if (file_exists(__DIR__."/_local/postconfig.php"))
	require(__DIR__."/_local/postconfig.php");


?>
