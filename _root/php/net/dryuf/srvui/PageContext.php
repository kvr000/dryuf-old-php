<?php

namespace net\dryuf\srvui;


interface PageContext extends \java\lang\AutoCloseable
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setServerError($code, $message);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	function			getRequest();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	function			getResponse();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	function			getSession();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	function			forceSession();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			invalidateSession();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			output($content);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLanguage();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getContextPath();

	/**
	 * Gets current path after partial parsing.
	 * 
	 * @return
	 * 	current path
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getCurrentPath();

	/**
	 * Gets currently processing path.
	 * 
	 * @return
	 * 	processing path
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getProcessingPath();

	/**
	 * Gets remaining path from parsed URL.
	 * 
	 * @return
	 * 	remaining path
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRemainPath();

	/**
	 * Gets next path element, excluding the optional slash.
	 * 
	 * @return next path element
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getPathElement();

	/**
	 * Gets next path element, excluding the optional slash.
	 * Checks for safety of the element, i.e. it must not contain special filesystem characters, like /.
	 * 
	 * @return next path element
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getPathElementSafe();

	/**
	 * Puts back the last element so it can be processed again.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			putBackLastElement();

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLastElement();

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLastElementWithoutSlash();

	/**
	 * Get reverse path to current path part.
	 * 
	 * @return
	 * 	reverse path to current path part.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getReversePath();

	/**
	 * Checks that there is no more item in the path.
	 * 
	 * @return true
	 * 	if there is no more item
	 * @return false
	 * 	if there is an item remaining
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			needPathFinal();

	/**
	 * Checks if the current path ends with slash, depending on needSlash parameter. Either redirects to slashed
	 * path or creates not found presenter if the condition is not satisfied.
	 * 
	 * @return current element
	 * 	if the condition was satisfied
	 * @return null
	 * 	otherwise, in that case process() function should return !needSlash
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			needPathSlash($needSlash);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRealPath();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setRealPath($realPath);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getFullUrl();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			redirect(string $url);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			redirectImm($url);

	/**
	 * Gets redirected URL.
	 * 
	 * @return null
	 * 	if no redirect was requested
	 * @return
	 * 	redirect string if redirect was requested
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRedirected();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			localize($className, $text);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			localizeArgs($className, $text, $args);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addMeta($metaTag);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addMetaName($name, $content);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addMetaHttp($name, $content);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\util\Map<java\lang\String, net\dryuf\srvui\MetaTag>>')
	*/
	function			getMetas();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addLinkedFile($type, $url);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addLinkedContent($type, $identity, $content);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\srvui\PageUrl>')
	*/
	function			getLinkedFiles($type);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addMessage($msgType, $msg);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addMessageLocalized($msgType, $classname, $msg);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			close();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setActiveField($priority, $activeField_);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\srvui\PendingMessage>')
	*/
	function			getPendingMessages();
};


?>
