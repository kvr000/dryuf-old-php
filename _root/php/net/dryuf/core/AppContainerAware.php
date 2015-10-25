<?php

namespace net\dryuf\core;


/**
 * {@code AppContainerAware} marks the bean which is aware of {@link AppContainer} and receives notification during application
 * startup.
 */
interface AppContainerAware
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer);
};


?>
