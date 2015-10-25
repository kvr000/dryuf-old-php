<?php


$workRoot							= dirname(dirname(__DIR__))."/_root/";

if (file_exists(__DIR__."/_local/preconfig.php"))
	require(__DIR__."/_local/preconfig.php");

set_include_path("$workRoot/php".PATH_SEPARATOR.get_include_path());
require_once "net/dryuf/core/Dryuf.php";

\net\dryuf\core\Dryuf::installDryufEnv();

\net\dryuf\core\Dryuf::$workRoot						= $root;
\net\dryuf\core\Dryuf::$config['appRoot']					= getcwd()."/";

\net\dryuf\core\Dryuf::$printUnhandled						= 3;

\net\dryuf\core\Dryuf::$config['localize.languages']				= array("cs");
\net\dryuf\core\Dryuf::$config['localize.clazz']				= 'net\dryuf\hashdb\CsvdbKeyValueDb';
\net\dryuf\core\Dryuf::$config['localize.dbext']				= '.csvdb';
#\net\dryuf\core\Dryuf::$config['localize.clazz']				= 'net\dryuf\hashdb\DbaKeyValueDb';
#\net\dryuf\core\Dryuf::$config['localize.dbext']				= '.db';
\net\dryuf\core\Dryuf::$config['localize.defaultLanguage']			= 'cs';
\net\dryuf\core\Dryuf::$config['localize.locale.en']				= 'en.UTF-8';
\net\dryuf\core\Dryuf::$config['localize.locale.cs']				= 'cs_CZ.UTF-8';


\net\dryuf\core\Dryuf::$config['app.sysRoles']             			= array("guest", "free", "user", "admin", "sysconf", "extreme", "translation", "devel", "timing");

\net\dryuf\core\Dryuf::$config['net.dryuf.dao.appdb']				= "driver=net.dryuf.sql.mysqli.MysqliConnection;host=localhost;user=dryuf;pass=dryuf;db=dryuf";

\net\dryuf\core\Dryuf::$config['net.dryuf.nocache']            			= false;
\net\dryuf\core\Dryuf::$config['net.dryuf.js.debug']				= 1;
\net\dryuf\core\Dryuf::$config['net.dryuf.js.obfuscate']			= "LC_ALL=cs_CZ.utf8 java -jar /home/rat/install/yuicompressor-2.4.2/build/yuicompressor-2.4.2.jar --type js";
\net\dryuf\core\Dryuf::$config['net.dryuf.app.debug']				= 3;
\net\dryuf\core\Dryuf::$config['net.dryuf.debug.localize']			= 0;

\net\dryuf\core\Dryuf::$config['net.dryuf.core.dataCacheClazz']			= 'net.dryuf.cache.php.ApcDataCache';

\net\dryuf\core\Dryuf::$beans['javax.persistence.EntityManager-dryuf']		= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\phpjpa\EntityManagerPhpJpa(), $name, array("persistenceUnit" => "dryuf", "dialect" => new \net\dryuf\sql\mysqli\MysqliSqlDialect(), "dataSource" => $appContainer->getBean("javax.sql.DataSource-dryuf"))); };
\net\dryuf\core\Dryuf::$beans['net.dryuf.transaction.TransactionManager-dryuf']	= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\dao\phpjpa\JpaTransactionManager($appContainer), $name, array("name" => $name, "entityManager" => $appContainer->getRealBean("javax.persistence.EntityManager-dryuf"))); };
\net\dryuf\core\Dryuf::$beans['javax.sql.DataSource-dryuf']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\sql\ConnectionManager(), $name, array("connectUrl" => \net\dryuf\core\Dryuf::$config['net.dryuf.dao.appdb'])); };

\net\dryuf\core\Dryuf::$beans['timeBo']						= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\service\time\SysTimeBo(), $name, null); };

\net\dryuf\core\Dryuf::$beans['testBean']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\core\tenv\TestBean(), $name, null); };

\net\dryuf\core\Dryuf::$beans['userAccountDao']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userLoginRecordDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserLoginRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['appDomainDefDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\AppDomainDefDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userAccountDomainDao']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDomainDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['userAccountDomainRoleDao']			= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\jpadao\UserAccountDomainRoleDaoJpa(), $name, null); };

\net\dryuf\core\Dryuf::$beans['userAccountBo']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\bo\UserAccountBoDb(), $name, null); };
\net\dryuf\core\Dryuf::$beans['authenticationFrontend']				= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\security\web\php\PhpAuthenticationFrontend(), $name, null); };

\net\dryuf\core\Dryuf::$beans['forumHeaderDao']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\jpadao\ForumHeaderDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['forumRecordDao']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\jpadao\ForumRecordDaoJpa(), $name, null); };
\net\dryuf\core\Dryuf::$beans['forumBo']					= function($appContainer, $name) { return $appContainer->postProcessBean(new \net\dryuf\comp\forum\sql\SqlForumBo(), $name, null); };

\net\dryuf\core\Dryuf::$config['dryuf-jpa.entities']				= array(
	'net.dryuf.security.UserAccount',
	'net.dryuf.security.UserAccountDomain',
	'net.dryuf.security.UserAccountDomainRole',

	'net.dryuf.test.TestMain',
	'net.dryuf.test.TestChild',

	'net.dryuf.comp.forum.ForumHeader',
	'net.dryuf.comp.forum.ForumRecord',

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
