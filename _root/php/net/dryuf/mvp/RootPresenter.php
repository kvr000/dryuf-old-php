<?php

namespace net\dryuf\mvp;


abstract class RootPresenter extends \net\dryuf\mvp\Presenter
{
	/**
	*/
	function			__construct($callerContext_, $request_)
	{
		global $dr_started_time;

		parent::__construct();
		$this->started = isset($dr_started_time) ? $dr_started_time : microtime(true);
		$this->callerContext = $callerContext_;
		$this->pageContext = new \net\dryuf\srvui\DefaultPageContext($callerContext_, $request_);
		$this->uiContext = $this->callerContext->getUiContext();
		$this->request = $request_;
		$this->pendingMessages = new \net\dryuf\util\LinkedList();
		$this->refStringifier = new \net\dryuf\srvui\SimpleRefStringifier($this->getPageContext());
		$this->output = fopen("php://output", "a");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	public function			getRootPresenter()
	{
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDefaultPresenter()
	{
		return $this->createNotFoundPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	public function			getPageContext()
	{
		return $this->pageContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public function			getResponse()
	{
		return $this->getRequest()->getResponse();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getServerError()
	{
		return $this->serverError;
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

	///**
	//@\net\dryuf\core\Type(type = 'void')
	//*/
	//public abstract function	output($text);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	escapeText($text);

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
	public function			getRootPath()
	{
		return ".";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContextPath()
	{
		return "";
	}

	/**
	 * Gets next path element, excluding the optional slash.
	 * 
	 * @return next path element
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathElement()
	{
		return $this->pageContext->getPathElement();
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
		if (is_null($element = $this->getPathElement()))
			return null;
		if (strchr($element, "/") !== false)
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
		$this->pageContext->putBackLastElement();
	}

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLastElement()
	{
		return $this->pageContext->getLastElement();
	}

	/**
	 * Gets last element in the path, including the slash if directory.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLastElementWithoutSlash()
	{
		return $this->pageContext->getLastElementWithoutSlash();
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
		return $this->pageContext->getReversePath();
	}

	/**
	 * Checks that there is no more item in the path. If there is, createNotFoundPresenter() is called to create error presenter in parent presenter.
	 * 
	 * @return true
	 * 	if there is no more item
	 * @return false
	 * 	if there is an item remaining
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			needPathFinalParent()
	{
		if (!is_null($this->getPathElement())) {
			for ($p = $this; ; $p = $p->getLeadChild()) {
				if (is_null($p->getLeadChild())) {
					$p = $p->getParentPresenter();
					$p->setLeadChild(null);
					$p->createNotFoundPresenter();
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Checks that there is no more item in the path. If there is, createNotFoundPresenter() is called to create
	 * error presenter in current presenter.
	 * 
	 * @return true if there is no more item, false if there is item remaining
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			needPathFinalCurrent()
	{
		if (!is_null($this->getPathElement())) {
			for ($p = $this; ; $p = $p->getLeadChild()) {
				if (is_null($p->getLeadChild())) {
					$p->createNotFoundPresenter();
					return false;
				}
			}
		}
		return true;
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
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			needPathSlash($needSlash)
	{
		if (!$this->pageContext->needPathSlash($needSlash)) {
			if ($needSlash) {
				if ($this->getRequest()->getMethod() != "GET") {
					$presenter = $this->createUnallowedMethodPresenter();
					$presenter->prepare();
					$presenter->render();
				}
				else {
					$this->getResponse()->redirect("/".$this->pageContext->getCurrentPath()."/");
				}
				return null;
			}
			else {
				for ($p = $this; ; $p = $p->getLeadChild()) {
					if (is_null($p->getLeadChild())) {
						$p->createNotFoundPresenter();
						break;
					}
				}
				return null;
			}
		}
		return $this->pageContext->getProcessingPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCurrentPath()
	{
		return $this->pageContext->getCurrentPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRemainPath()
	{
		return $this->pageContext->getRemainPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRealPath()
	{
		return $this->pageContext->getRealPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRealPath($realPath)
	{
		$this->pageContext->setRealPath($realPath);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFullUrl()
	{
		return "http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			stringifyRef($ref)
	{
		return $this->refStringifier->stringifyRef($ref);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			redirect(\net\dryuf\srvui\PageUrl $ref)
	{
		if (!is_null($this->redirected)) {
			throw new \net\dryuf\core\RuntimeException("already redirected to ".$this->redirected);
		}
		$url = $this->stringifyRef($ref);
		$this->redirected = $url;
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			redirectImm($ref)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unimplemented");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("called processMore on RootPresenter");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("called processFinal on RootPresenter");
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
	public function			addLinkedFile($type, $url)
	{
		$this->pageContext->addLinkedFile($type, $url);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addLinkedContent($type, $identity, $content)
	{
		$this->pageContext->addLinkedContent($type, $identity, $content);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\srvui\PageUrl>')
	*/
	public function			getLinkedFiles($type)
	{
		return $this->pageContext->getLinkedFiles($type);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMeta($metaTag)
	{
		$this->pageContext->addMeta($metaTag);
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
		return $this->pageContext->getMetas();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessage($msgType, $msg)
	{
		$this->pageContext->addMessage($msgType, $msg);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessageLocalized($msgType, $classname, $msg)
	{
		$this->pageContext->addMessage($msgType, $this->localize($classname, $msg));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			run()
	{
		try {
			if ($this->process()) {
				if ($this->serverError != 0) {
					$this->getResponse()->sendStatus($this->serverError, $this->serverMessage);
				}
				$this->prepare();
				$this->render();
				$ret = true;
			}
			else {
				if ($this->serverError != 0) {
					$this->getResponse()->sendStatus($this->serverError, $this->serverMessage);
				}
				elseif (!is_null($this->redirected)) {
					$this->getResponse()->redirect($this->redirected);
				}
				$ret = false;
			}
			return $ret;
		}
		catch (\Exception $ex) {
			$this->close();
			throw $ex;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
		try {
			parent::close();
		}
		catch (\Exception $ex) {
			$this->callerContext->close();
			throw $ex;
		}
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
		return $this->pageContext->getPendingMessages();
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
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\RefStringifier')
	*/
	protected			$refStringifier;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\RefStringifier')
	*/
	public function			getRefStringifier()
	{
		return $this->refStringifier;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRefStringifier($refStringifier_)
	{
		$this->refStringifier = $refStringifier_;
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
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	protected			$session;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	protected			$pageContext;
};


?>
