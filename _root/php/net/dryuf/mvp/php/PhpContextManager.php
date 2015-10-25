<?php

namespace net\dryuf\mvp\php;


class PhpContextManager
{
	static function			createAppContainer()
	{
		return new \net\dryuf\core\php\PhpAppContainer(\net\dryuf\core\Dryuf::$workRoot, array('appRoot' => \net\dryuf\core\Dryuf::$config['appRoot'], "config" => \net\dryuf\core\Dryuf::$config, "aops" => \net\dryuf\core\Dryuf::$aops, "beans" => \net\dryuf\core\Dryuf::$beans, 'rolesDependencies' => \net\dryuf\core\Dryuf::$config['rolesDependencies']));
	}

	static function			createCallerContext()
	{
		return \net\dryuf\srvui\php\PhpCallerContext::createFromSession(self::createAppContainer());
	}

	static function			createRootPresenter()
	{
		return new \net\dryuf\mvp\WebRootPresenter(self::createCallerContext(), new \net\dryuf\mvp\php\PhpWebRequest());
	}

	static function			initSessioned()
	{
		session_start();
		$presenter = self::createRootPresenter();
		if (is_null($presenter->getCallerContext()->getUserId())) {
			header($_SERVER['SERVER_PROTOCOL']." 405 No session");
			echo "No session found. Please login.";
			exit(0);
		}
		return $presenter;
	}

	static function			initSessionless()
	{
		session_start();
		$presenter = self::createRootPresenter();
		return $presenter;
	}

	static function			initSessionlessPage()
	{
		return new \net\dryuf\mvp\TestBasePresenter(self::initSessionless(), \net\dryuf\core\Options::$NONE);
	}

	static function			initTesting()
	{
		$presenter = new \net\dryuf\mvp\WebRootPresenter(self::createAppContainer()->createCallerContext(), new \net\dryuf\mvp\php\PhpWebRequest());
		$presenter->forceSession();
		$presenter->getCallerContext()->loggedIn(\net\dryuf\core\Dryuf::$config['net.dryuf.test.user'], \net\dryuf\core\Dryuf::$config['app.sysRoles']);
		return $presenter;
	}
};


?>
