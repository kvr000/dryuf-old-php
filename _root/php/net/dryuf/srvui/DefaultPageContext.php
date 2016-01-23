<?php

namespace net\dryuf\srvui;


class DefaultPageContext extends \net\dryuf\core\Object implements \net\dryuf\srvui\PageContext
{
	/**
	*/
	function			__construct($callerContext_, $request_)
	{
		$this->linkedFiles = new \net\dryuf\util\php\StringNativeHashMap();
		$this->metas = new \net\dryuf\util\php\StringNativeHashMap();
		$this->pendingMessages = new \net\dryuf\util\LinkedList();

		parent::__construct();
		$this->callerContext = $callerContext_;
		$this->uiContext = $this->callerContext->getUiContext();
		$this->request = $request_;
		$this->response = $this->request->getResponse();
		$this->started = intval(microtime(true)*1000);
		$this->remainPath = $this->request->getPath();
		while (substr($this->remainPath, 0, strlen("/")) == "/")
			$this->remainPath = strval(substr($this->remainPath, 1));
		if (($this->remainPath === ""))
			$this->remainPath = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setServerError($code, $message)
	{
		$this->serverError = $code;
		$this->serverMessage = $message;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			getSession()
	{
		if (is_null($this->session))
			$this->session = $this->getRequest()->getSession();
		return $this->session;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			forceSession()
	{
		return $this->getRequest()->forceSession();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			invalidateSession()
	{
		$this->getRequest()->invalidateSession();
		$this->session = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			output($content)
	{
		try {
			fwrite($this->response->getOutputStream(), $content);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLanguage()
	{
		return $this->uiContext->getLanguage();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContextPath()
	{
		return "";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProcessingPath()
	{
		return $this->processingPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathElement()
	{
		if (is_null($this->remainPath))
			return null;
		if (preg_match(',([^/]+)(/+(.*))?$,', $this->remainPath, $match)) {
			$parsed = $match[1];
			$this->processingPath = urldecode($parsed);
			if (($parsed === ".") || ($parsed === ".."))
				throw new \net\dryuf\core\ReportException("wrong path element: ".$parsed);
			$this->currentPath .= $parsed;
			$this->realPath .= $parsed;
			if (is_null($this->remainPath = isset($match[3]) ? $match[3] : null)) {
			}
			else {
				$this->currentPath .= "/";
				$this->realPath .= "/";
				if (($this->remainPath === ""))
					$this->remainPath = null;
			}
		}
		else {
			throw new \net\dryuf\core\ReportException("unexpected state, remainPath not null and doesn't match: ".$this->remainPath);
		}
		return $this->processingPath;
	}

	/**
	 * Gets next path element, excluding the optional slash.
	 * Checks for safety of the element, i.e. it must not contain special filesystem characters, like /.
	 * 
	 * @return next path element
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathElementSafe()
	{
		if (is_null(($element = $this->getPathElement())))
			return null;
		if (\net\dryuf\core\StringUtil::indexOf($element, '/') >= 0)
			throw new \net\dryuf\core\IllegalArgumentException("/ not allowed as part of path");
		if (($element === ".."))
			throw new \net\dryuf\core\IllegalArgumentException(".. not allowed as part of path");
		return $element;
	}

	/**
	 * Puts back the last element so it can be processed again.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			putBackLastElement()
	{
		if (!preg_match('/^(|.*\/)([^\/]+\/*)$/', $this->currentPath, $match))
			throw new \net\dryuf\core\RuntimeException("failed to find last element in currentPath: ".$this->currentPath);
		$this->currentPath = $match[1];
		$this->realPath = strval(substr($this->realPath, 0, strlen($this->realPath)-strlen($match[2])));
		$this->remainPath = !is_null($this->remainPath) ? $match[2].$this->remainPath : $match[2];
	}

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLastElement()
	{
		if (!preg_match('/^(|.*\/)([^\/]+\/*)$/', $this->currentPath, $match))
			throw new \net\dryuf\core\RuntimeException("failed to find last element in currentPath: ".$this->currentPath);
		return $match[2];
	}

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLastElementWithoutSlash()
	{
		if (!preg_match('/^(|.*\/)([^\/]+)\/*$/', $this->currentPath, $match))
			throw new \net\dryuf\core\RuntimeException("failed to find last element in currentPath: ".$this->currentPath);
		return $match[2];
	}

	/**
	 * Get reverse path to current path part.
	 * 
	 * @return
	 * 	reverse path to current path part.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getReversePath()
	{
		return is_null($this->remainPath) ? "" : \net\dryuf\core\StringUtil::replaceRegExp(\net\dryuf\core\StringUtil::replaceRegExp($this->remainPath, "[^/]+/", "../"), "[^/]+\$", "");
	}

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
	public function			needPathFinal()
	{
		return is_null($this->getPathElement());
	}

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
	public function			needPathSlash($needSlash)
	{
		if ($needSlash) {
			if (!(substr($this->currentPath, -strlen("/")) == "/") && !($this->currentPath === "")) {
				if (!($this->getRequest()->getMethod() === "GET")) {
					$this->setServerError(405, "Method Not Allowed");
				}
				else {
					$this->getResponse()->redirect("/".$this->currentPath."/");
				}
				return false;
			}
		}
		else {
			if (substr($this->currentPath, -strlen("/")) == "/" || ($this->currentPath === "")) {
				return false;
			}
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFullUrl()
	{
		$servletRequest = $this->getRequest()->getServletRequest();
		$url = $servletRequest->getRequestURL();
		if (!is_null(($query = $servletRequest->getQueryString())))
			$url->append($query);
		return strval($url);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			redirect(string $url)
	{
		if (!is_null($this->redirected)) {
			throw new \net\dryuf\core\RuntimeException("already redirected to ".$this->redirected);
		}
		$this->redirected = $url;
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			redirectImm($url)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unimplemented");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRedirected()
	{
		return $this->redirected;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localize($className, $text)
	{
		return $this->uiContext->localize($className, $text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localizeArgs($className, $text, $args)
	{
		return $this->uiContext->localizeArgs($className, $text, $args);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMeta($metaTag)
	{
		$typedMetas = $this->metas->get($metaTag->getType());
		if (is_null($typedMetas))
			$this->metas->put($metaTag->getType(), $typedMetas = new \net\dryuf\util\php\StringNativeHashMap());
		$typedMetas->put($metaTag->getName(), $metaTag);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMetaName($name, $content)
	{
		$this->addMeta(new \net\dryuf\srvui\MetaTag("name", $name, $content));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMetaHttp($name, $content)
	{
		$this->addMeta(new \net\dryuf\srvui\MetaTag("http-equiv", $name, $content));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\util\Map<java\lang\String, net\dryuf\srvui\MetaTag>>')
	*/
	public function			getMetas()
	{
		return $this->metas;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addLinkedFile($type, $url)
	{
		$linked = $this->linkedFiles->get($type);
		if (is_null($linked))
			$this->linkedFiles->put($type, $linked = new \net\dryuf\util\LinkedHashSet());
		$linked->add($url);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addLinkedContent($type, $identity, $content)
	{
		$linked = $this->linkedFiles->get($type);
		if (is_null($linked))
			$this->linkedFiles->put($type, $linked = new \net\dryuf\util\LinkedHashSet());
		$linked->add(\net\dryuf\srvui\PageUrl::createVirtual("@".(is_null($identity) ? "" : $identity), \net\dryuf\core\Options::buildListed("content", $content)));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\srvui\PageUrl>')
	*/
	public function			getLinkedFiles($type)
	{
		return $this->linkedFiles->get($type);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessage($msgType, $msg)
	{
		$this->pendingMessages->add(new \net\dryuf\srvui\PendingMessage($msgType, $msg));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessageLocalized($msgType, $classname, $msg)
	{
		$this->pendingMessages->add(new \net\dryuf\srvui\PendingMessage($msgType, $this->localize($classname, $msg)));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
		$this->callerContext->close();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setActiveField($priority, $activeField_)
	{
		$this->activeField = $activeField_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\srvui\PendingMessage>')
	*/
	public function			getPendingMessages()
	{
		return $this->pendingMessages;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$redirected;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$serverError = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getServerError()
	{
		return $this->serverError;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$serverMessage;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	protected			$uiContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public function			getUiContext()
	{
		return $this->uiContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCallerContext($callerContext_)
	{
		$this->callerContext = $callerContext_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	protected			$request;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	public function			getRequest()
	{
		return $this->request;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	protected			$response;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public function			getResponse()
	{
		return $this->response;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$title = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getTitle()
	{
		return $this->title;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTitle($title_)
	{
		$this->title = $title_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$activeField;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getActiveField()
	{
		return $this->activeField;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$started = 0;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getStarted()
	{
		return $this->started;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setStarted($started_)
	{
		$this->started = $started_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentPath = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCurrentPath()
	{
		return $this->currentPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCurrentPath($currentPath_)
	{
		$this->currentPath = $currentPath_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$realPath = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRealPath()
	{
		return $this->realPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRealPath($realPath_)
	{
		$this->realPath = $realPath_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$remainPath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRemainPath()
	{
		return $this->remainPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRemainPath($remainPath_)
	{
		$this->remainPath = $remainPath_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$processingPath = "";

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\util\Collection<net\dryuf\srvui\PageUrl>>')
	*/
	protected			$linkedFiles;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\util\Map<java\lang\String, net\dryuf\srvui\MetaTag>>')
	*/
	protected			$metas;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\srvui\PendingMessage>')
	*/
	protected			$pendingMessages;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	protected			$session;

	public static function		_initManualStatic()
	{
	}

};

\net\dryuf\srvui\DefaultPageContext::_initManualStatic();


?>
