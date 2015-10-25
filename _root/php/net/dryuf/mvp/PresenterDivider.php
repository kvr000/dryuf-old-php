<?php

namespace net\dryuf\mvp;


interface PresenterDivider
{
	/**
	 * Gets list of all pages.
	 * 
	 * @return
	 * 	set of all pages
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			getPageList();

	/**
	 * Checks for page definition.
	 * 
	 * @return 1
	 * 	if the page is accessible
	 * @return 0
	 * 	if the page does not exist
	 * @return -1
	 * 	if the access is denied
	 */
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			checkPage($presenter, $page);

	/**
	 * Checks for page definition, including all the steps until process()+
	 * @return
	 * 	created page
	 * @return null
	 * 	if not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	function			tryPage($presenter);

	/**
	 * Checks for page definition, including all the steps until process()+
	 * Processes already retrieved path element+
	 * @return
	 * 	created page
	 * @return null
	 * 	if not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	function			tryPageConsumed($presenter, $page);

	/**
	 * Checks for page definition or language, including all the steps until process()+
	 * Processes already retrieved path element+
	 * @return
	 * 	created page
	 * @return null
	 * 	if the passed page was language and it was consumed
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	function			tryLangConsumed($presenter, $page);

	/**
	 * Process the current URL and create appropriate structure.
	 * 
	 * @param presenter
	 * 	owning presenter
	 * 
	 * @return
	 * 	value returned from created presenter process call
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			process($presenter);

	/**
	 * Process the passed URL element and create appropriate structure.
	 * 
	 * @param presenter
	 * 	owning presenter
	 * @param page
	 * 	next element to process
	 * 
	 * @return
	 * 	value returned from created presenter process call
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			processConsumed($presenter, $page);
};


?>
