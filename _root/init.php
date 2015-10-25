<?php


$dr_started_time = microtime(true);

$theconfig = __DIR__."/etc/_local/loadconfig.php";
if (!file_exists($theconfig))
	$theconfig = __DIR__."/etc/config.php";
require $theconfig;

date_default_timezone_set('UTC');
\net\dryuf\core\Dryuf::installDryufEnv();
\net\dryuf\core\Dryuf::installExceptionHandler();


?>
