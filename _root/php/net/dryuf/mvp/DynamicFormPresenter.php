<?php

namespace net\dryuf\mvp;


abstract class DynamicFormPresenter extends \net\dryuf\mvp\FormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->formattedData = new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatFormPrefix($formClazz)
	{
		return str_replace('\\', '_', str_replace(".", "_", $formClazz))."__";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplay($displayArgs, $fieldDef)
	{
		$display = $fieldDef->getDisplay();
		$match = \net\dryuf\core\StringUtil::matchText("^(\\w+)\\((.*)\\)\$", $display);
		if (is_null($match)) {
			throw new \net\dryuf\core\InvalidValueException($display, "Invalid value for ".$this->formClassName.".".$fieldDef->getName());
		}
		$displayType = $match[1];
		$argsList = \net\dryuf\core\StringUtil::splitRegExp($match[2], ",\\s*");
		foreach ($argsList as $arg)
			$displayArgs->add($arg);
		if (($displayType === "hidden")) {
		}
		elseif (($displayType === "text")) {
			if (count($argsList) != 1)
				throw new \net\dryuf\core\InvalidValueException($display, "Invalid value for ".$this->formClassName.".".$fieldDef->getName().", text requires one argument");
		}
		elseif (($displayType === "password")) {
			if (count($argsList) != 1)
				throw new \net\dryuf\core\InvalidValueException($display, "Invalid value for ".$this->formClassName.".".$fieldDef->getName().", password requires one argument");
		}
		elseif (($displayType === "textarea")) {
			if (count($argsList) != 2)
				throw new \net\dryuf\core\InvalidValueException($display, "Invalid value for ".$this->formClassName.".".$fieldDef->getName().", textarea requires one argument");
		}
		return $displayType;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			formOutputType($fieldDef, $displayType, $displayArgs, $formatted)
	{
		$name = $fieldDef->getName();
		$full = $this->formWebPrefix.$name;
		if (!is_null($fieldDef->getAssocClass())) {
			$this->formOutputRef($fieldDef, $displayType, $displayArgs, $formatted);
		}
		elseif (($displayType === "hidden")) {
			$this->outputFormat("<input id=%A name=%A type=\"hidden\" value=%A />\n", $full, $full, $formatted);
		}
		elseif (($displayType === "text")) {
			$this->outputFormat("<input id=%A name=%A type=\"text\" width=%A value=%A />\n", $full, $full, $displayArgs[0], is_null($formatted) ? "" : $formatted);
		}
		elseif (($displayType === "password")) {
			$this->outputFormat("<input id=%A name=%A type=\"password\" width=%A />\n", $full, $full, $displayArgs[0]);
		}
		elseif (($displayType === "textarea")) {
			$this->outputFormat("<textarea id=%A name=%A cols=%A rows=%A>%S</textarea>\n", $full, $full, $displayArgs[0], $displayArgs[1], is_null($formatted) ? "" : $formatted);
		}
		elseif (($displayType === "checkbox")) {
			$this->outputFormat("<input id=%A name=%A type=\"checkbox\"%s />\n", $full, $full, ($formatted === "true") ? " checked='checked'" : "");
		}
		elseif (($displayType === "captcha")) {
			$this->outputFormat("<input id=%A name=%A type=\"text\" width=%A value=%A />\n", $full, $full, $displayArgs[0], is_null($formatted) ? "" : $formatted);
			$this->outputFormat("<br/><img src=\"%U\" onclick=\"javascript:this.src = this.src.replace('#.*', '')+'#'+(new Date()).getTime();\" />\n", \net\dryuf\srvui\PageUrl::createRooted("/captcha/"));
		}
		elseif (($displayType === "select")) {
			\net\dryuf\textual\TextualManager::createTextualUnsafe($fieldDef->needTextual(), $this->getCallerContext())->convert($formatted, null);
			$this->outputFormat("<select id=%A name=%A width=%A>\n", $full, $full, $displayArgs[0]);
			foreach ($this->getSelectList($fieldDef, $displayArgs)->entrySet() as $validEntry) {
				$this->outputFormat("\t<option value=%A%s>%S</option>\n", $validEntry->getKey(), ($formatted === $validEntry->getKey()) ? " selected='selected'" : "", $validEntry->getValue());
			}
			$this->output("</select>\n");
		}
		elseif (($displayType === "file")) {
			$this->outputFormat("<input id=%A name=%A type=\"file\" />", $full, $full);
		}
		else {
			throw new \net\dryuf\core\InvalidValueException($displayType, $this->formClassName.".".$name.": unknown display type");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			getSelectList($fieldDef, $displayArgs)
	{
		$i = 0;
		$map = new \net\dryuf\util\php\StringNativeHashMap();
		$map->put("", "");
		foreach (\net\dryuf\core\StringUtil::splitRegExp($displayArgs[1], "\\^") as $s)
			$map->put(strval($i++), $s);
		return $map;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			formOutputRef($fieldDef, $displayType, $displayArgs, $internal)
	{
		throw new \net\dryuf\core\InvalidValueException($displayType, $this->formClassName.".".$fieldDef->getName().": ref display is not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			plainOutputType($fieldDef, $displayType, $displayArgs, $formatted)
	{
		$name = $fieldDef->getName();
		if (!is_null($fieldDef->getAssocClass())) {
			$this->plainOutputRef($fieldDef, $displayType, $displayArgs, $formatted);
		}
		elseif (($displayType === "hidden")) {
		}
		elseif (($displayType === "text")) {
			$this->output(htmlspecialchars($formatted));
		}
		elseif (($displayType === "password")) {
		}
		elseif (($displayType === "textarea")) {
			$this->output(htmlspecialchars($formatted));
		}
		elseif (($displayType === "checkbox")) {
			$this->output(htmlspecialchars($formatted));
		}
		elseif (($displayType === "select")) {
			$internal = \net\dryuf\textual\TextualManager::createTextualUnsafe($fieldDef->needTextual(), $this->getCallerContext())->convert($formatted, null);
			$this->output(htmlspecialchars(\net\dryuf\core\StringUtil::splitRegExp($displayArgs[1], "\\^\\s*")[$internal]));
		}
		elseif (($displayType === "file")) {
		}
		else {
			throw new \net\dryuf\core\InvalidValueException($displayType, $this->formClassName.".".$name.": unknown display type");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			plainOutputRef($fieldDef, $displayType, $displayArgs, $internal)
	{
		throw new \net\dryuf\core\InvalidValueException($displayType, $this->formClassName.".".$fieldDef->getName().": ref display is not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			autoOutputType($fieldDef, $displayType, $displayArgs, $formatted)
	{
		$fieldRoles = $fieldDef->getRoles();
		if ($this->getCallerContext()->checkRole($fieldRoles->roleNew())) {
			$this->formOutputType($fieldDef, $displayType, $displayArgs, $formatted);
		}
		elseif ($this->getCallerContext()->checkRole($fieldRoles->roleGet())) {
			$this->plainOutputType($fieldDef, $displayType, $displayArgs, $formatted);
		}
		else {
			$this->plainOutputType($fieldDef, $displayType, $displayArgs, "?");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			autoOutputRef($fieldDef, $displayType, $displayArgs, $internal)
	{
		$fieldRoles = $fieldDef->getRoles();
		if ($this->getCallerContext()->checkRole($fieldDef->getRoles()->roleNew())) {
			$this->formOutputRef($fieldDef, $displayType, $displayArgs, $internal);
		}
		elseif ($this->getCallerContext()->checkRole($fieldRoles->roleGet())) {
			$this->plainOutputRef($fieldDef, $displayType, $displayArgs, $internal);
		}
		else {
			$this->plainOutputRef($fieldDef, $displayType, $displayArgs, "?");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			initData()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			initForm()
	{
		if (!is_null(($this->initError = $this->initData()))) {
			$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $this->initError);
			return;
		}
		foreach ($this->getDisplayableFields() as $fieldDef) {
			$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fieldDef->needTextual(), $this->getCallerContext());
			$internal = $this->getBackingValue($fieldDef);
			$this->formattedData->put($fieldDef->getName(), is_null($internal) ? "" : $textual->format($internal, null));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			needMandatory($action, $fieldDef)
	{
		return $fieldDef->getMandatory();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			retrieve($errors, $action)
	{
		foreach ($this->getDisplayableFields() as $fieldDef) {
			$name = $fieldDef->getName();
			$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fieldDef->needTextual(), $this->getCallerContext());
			$froles = $fieldDef->getRoles();
			if (!$this->getCallerContext()->checkRole($froles->roleNew())) {
				if ($this->getCallerContext()->checkRole($froles->roleGet())) {
					$this->formattedData->put($name, $textual->format($this->getBackingValue($fieldDef), null));
				}
			}
			else {
				$handling = -1;
				$displayArgs = new \net\dryuf\util\ArrayList();
				$displayType = $this->getDisplay($displayArgs, $fieldDef);
				if (($displayType === "checkbox")) {
					$param = ($this->getRequest()->getParamDefault($this->formWebPrefix.$name, "off") === "on") ? "true" : "false";
				}
				elseif (($displayType === "captcha")) {
					$param = $this->getRequest()->getParamDefault($this->formWebPrefix.$name, "");
					$handling = 1;
					if (!($param === \net\dryuf\mvp\DynamicFormPresenter::getRequestCaptcha($this->getRequest()))) {
						$errors->put($name, $this->localize("net.dryuf.textual.Captcha", "Incorrect captcha"));
					}
					$this->formattedData->put($name, $param);
				}
				elseif (($displayType === "file")) {
					$file = $this->getRequest()->getFile($this->getFormFieldName($name));
					$param = null;
					if (!is_null($file) && ((($param = $file->getName())) == null)) {
						$param = null;
					}
					if (($handling = !is_null($param) ? 1 : 0) > 0) {
						\net\dryuf\mvp\DynamicFormPresenter::putIntoMapString($this->formattedData, $name, $textual->prepare($param, $file->getName()));
					}
				}
				else {
					$param = $this->getRequest()->getParamDefault($this->formWebPrefix.$name, "");
				}
				if ($handling == 0 || ($handling < 0 && (\net\dryuf\mvp\DynamicFormPresenter::putIntoMapString($this->formattedData, $name, $textual->prepare($param, "")) === ""))) {
					if ($fieldDef->getMandatory() && $this->needMandatory($action, $fieldDef)) {
						$errors->put($name, $this->localize("net.dryuf.mvp.DynamicForm", "Field is mandatory"));
					}
					else {
						$this->setBackingValue($fieldDef, null);
					}
				}
				elseif (!is_null(($error = $textual->check($this->formattedData->get($name), "")))) {
					$errors->put($name, $error);
				}
				else {
					$this->setBackingValue($fieldDef, $textual->convert($this->formattedData->get($name), ""));
				}
			}
		}
		return $errors->isEmpty();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		putIntoMapString($map, $key, $value)
	{
		$map->put($key, $value);
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFieldsEdit()
	{
		foreach ($this->getDisplayableFields() as $fieldDef) {
			try {
				$this->renderFieldEdit($fieldDef);
			}
			catch (\net\dryuf\core\RuntimeException $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to render field ".$fieldDef->getName().": ".strval($ex), $ex);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFieldEdit($fieldDef)
	{
		$displayArgs = new \net\dryuf\util\ArrayList();
		$displayType = $this->getDisplay($displayArgs, $fieldDef);
		if (!($displayType === "hidden")) {
			$this->outputFormat("<tr class=\"field\"><td class=\"key\"><label for=%A>%W:</label></td><td class=\"mandind\"></td><td class=\"value\">", $this->formWebPrefix.$fieldDef->getName(), $this->formClassName, $fieldDef->getName());
		}
		{
			$this->autoOutputType($fieldDef, $displayType, $displayArgs->toArray(self::$stringArray), $this->formattedData->get($fieldDef->getName()));
		}
		if (!($displayType === "hidden")) {
			$this->output("</td></tr>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFieldPlain($fieldDef)
	{
		$displayArgs = new \net\dryuf\util\ArrayList();
		$displayType = $this->getDisplay($displayArgs, $fieldDef);
		if (!($displayType === "hidden")) {
			$this->outputFormat("<tr class=\"plain\"><td class=\"key\">%W:</td><td class=\"mandind\"></td><td class=\"value\">", $this->formClassName, $fieldDef->getName());
		}
		{
			$this->plainOutputType($fieldDef, $displayType, $displayArgs->toArray(self::$stringArray), $this->formattedData->get($fieldDef->getName()));
		}
		if (!($displayType === "hidden")) {
			$this->output("</td></tr>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFieldsPlain()
	{
		foreach ($this->getDisplayableFields() as $fieldDef) {
			$this->renderFieldPlain($fieldDef);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFields()
	{
		$this->renderFieldsEdit();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderActionSubmit($action)
	{
		$this->outputFormat("<tr class=\"actions\"><td class=\"key\"></td><td class=\"mandind\" /><td class=\"value\"><input type=\"submit\" name=%A value=%A/></td></tr>\n", $this->formWebPrefix.$action->name(), $action->name(), $this->formClassName);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderSubmit()
	{
		foreach ($this->getActionDefs() as $action) {
			$this->renderActionSubmit($action);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if (!is_null($this->initError)) {
		}
		else {
			$this->outputFormat("<form name=%A method=\"POST\" enctype=\"multipart/form-data\">\n", $this->formWebPrefix);
			$this->output("<table class=\"net-dryuf-web-Form\">\n");
			$this->renderFields();
			$this->renderSubmit();
			$this->output("</table>\n");
			$this->output("</form>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFormFieldName($fieldName)
	{
		return $this->formWebPrefix.$fieldName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\app\FieldDef<java\lang\Object>>')
	*/
	protected function		getDisplayableFields()
	{
		if (is_null($this->displayableFields))
			$this->displayableFields = $this->buildDisplayableFields();
		return $this->displayableFields;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\app\FieldDef<java\lang\Object>>')
	*/
	protected abstract function	buildDisplayableFields();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected abstract function	setBackingValue($fieldDef, $value);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected abstract function	getBackingValue($fieldDef);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$selectFieldName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSelectFieldName()
	{
		return $this->selectFieldName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSelectFieldName($selectFieldName_)
	{
		$this->selectFieldName = $selectFieldName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$initError = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	static				$stringArray;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$formattedData;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\app\FieldDef<java\lang\Object>>')
	*/
	protected			$displayableFields;

	public static function		_initManualStatic()
	{
		self::$stringArray = array();
	}

};

\net\dryuf\mvp\DynamicFormPresenter::_initManualStatic();


?>
