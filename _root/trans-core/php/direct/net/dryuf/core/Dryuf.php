<?php

namespace net\dryuf\core;


/**
 * Various reflection methods managing special behaviour of specific target languages.
 */
class Dryuf extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		convertClassname($name)
	{
		return $name;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		dotClassname($name)
	{
		return $name;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		pathClassname($name)
	{
		return str_replace(".", "/", $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		dashClassname($name)
	{
		return str_replace(".", "-", $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		assertNotNull($value, $message)
	{
		if (is_null($value))
			throw new \net\dryuf\core\NullPointerException($message);
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public static function		loadClass($name)
	{
		try {
			return $name;
		}
		catch (\net\dryuf\core\ClassNotFoundException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Constructor<java\lang\Object>')
	*/
	public static function		getConstructor($clazz, $params)
	{
		try {
			return (=f_I_x=)clazz.getConstructor(params)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Constructor<java\lang\Object>')
	*/
	public static function		loadConstructor($className, $params)
	{
		try {
			return (=f_I_x=)Class.forName(className).getConstructor(params)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Constructor<java\lang\Object>')
	*/
	public static function		findConstructorN($clazz, $n)
	{
		$best = null;
		foreach ((=f_I_x=)clazz.getConstructors()(=x_I_f=) as $c) {
			if (count($c->getParameterTypes()) == $n) {
				if (!is_null($best))
					throw new \net\dryuf\core\UnsupportedOperationException("call createClassArg".$n." ambigious");
				$best = $c;
			}
		}
		if (is_null($best))
			throw new \net\dryuf\core\UnsupportedOperationException("No constructor found which accepts ".$n." arguments");
		return $best;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg0($clazz)
	{
		try {
			return \net\dryuf\core\Dryuf::createClassArg0($clazz);
		}
		catch (\java\lang\InstantiationException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\java\lang\IllegalAccessException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg1($clazz, $arg0)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 1)->newInstance($arg0);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg2($clazz, $arg0, $arg1)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 2)->newInstance($arg0, $arg1);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg3($clazz, $arg0, $arg1, $arg2)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 3)->newInstance($arg0, $arg1, $arg2);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg4($clazz, $arg0, $arg1, $arg2, $arg3)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 4)->newInstance($arg0, $arg1, $arg2, $arg3);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg5($clazz, $arg0, $arg1, $arg2, $arg3, $arg4)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 5)->newInstance($arg0, $arg1, $arg2, $arg3, $arg4);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg6($clazz, $arg0, $arg1, $arg2, $arg3, $arg4, $arg5)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 6)->newInstance($arg0, $arg1, $arg2, $arg3, $arg4, $arg5);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg7($clazz, $arg0, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6)
	{
		try {
			return \net\dryuf\core\Dryuf::findConstructorN($clazz, 7)->newInstance($arg0, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createObjectArgs($constructor, $params)
	{
		try {
			return $constructor->newInstance($params);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public static function		getObjectMethod($object, $method, $params)
	{
		try {
			return (=f_I_x=)object.getClass().getMethod(method, params)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public static function		getClassMethod($clazz, $method, $params)
	{
		try {
			return (=f_I_x=)clazz.getMethod(method, params)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		invokeMethod($object, $method, $args)
	{
		try {
			return (=f_I_x=)method.invoke(object, args)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		invokeMethodString0($object, $methodName)
	{
		return \net\dryuf\core\Dryuf::invokeMethod($object, \net\dryuf\core\Dryuf::getObjectMethod($object, $methodName));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Field')
	*/
	public static function		getClassField($cls, $fieldName)
	{
		try {
			return (=f_I_x=)cls.getDeclaredField(fieldName)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Field')
	*/
	public static function		getClassPublicField($cls, $fieldName)
	{
		try {
			return (=f_I_x=)cls.getField(fieldName)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getFieldValueNamed($object, $fieldName)
	{
		try {
			$field = (=f_I_x=)object.getClass().getDeclaredField(fieldName)(=x_I_f=);
			(=f_I_x=)field.setAccessible(true)(=x_I_f=);
			return (=f_I_x=)field.get(object)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getFieldValue($object, $field)
	{
		try {
			(=f_I_x=)field.setAccessible(true)(=x_I_f=);
			return (=f_I_x=)field.get(object)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		setFieldValue($object, $field, $value)
	{
		try {
			(=f_I_x=)field.setAccessible(true)(=x_I_f=);
			(=f_I_x=)field.set(object, value)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::propagateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		callGetter($object, $fieldName)
	{
		return \net\dryuf\core\Dryuf::invokeMethod($object, \net\dryuf\core\Dryuf::getObjectMethod($object, "get".\net\dryuf\core\StringUtil::capitalize($fieldName), array()), array());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		callSetter($object, $fieldName, $value)
	{
		return \net\dryuf\core\Dryuf::invokeMethod($object, \net\dryuf\core\Dryuf::getObjectMethod($object, "set".\net\dryuf\core\StringUtil::capitalize($fieldName), get_class($value)), $value);
	}

	(=f_I_x= msg="java.lang.NoSuchMethodException: no method java.lang.reflect.AnnotatedElement.toString()")
	public static <T extends Annotation>T getMandatoryAnnotation(AnnotatedElement ae, Class<T> annotationClass) {
	    T annotation = ae.getAnnotation(annotationClass);
	    if (annotation == null) throw new net.dryuf.core.ReportException("Annotation " + annotationClass.getName() + " not found on " + ae.toString());
	    return annotation;
	}(=x_I_f=)/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		getStackTrace($aThrowable)
	{
		$result = new \java\io\StringWriter();
		$printWriter = new \java\io\PrintWriter($result);
		$aThrowable->printStackTrace($printWriter);
		return strval($result);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatExceptionFull($ex)
	{
		$result = new \java\io\StringWriter();
		$printWriter = new \java\io\PrintWriter($result);
		$printWriter->append(strval($ex))->append("\n");
		$ex->printStackTrace($printWriter);
		return strval($result);
	}

	/**
	 * Translates the passed exception into RuntimeException if necessary.
	 * 
	 * @return
	 * 	wrapping exception
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\RuntimeException')
	*/
	public static function		translateException($ex)
	{
		if ($ex instanceof \net\dryuf\core\RuntimeException) {
			return $ex;
		}
		elseif ($ex instanceof \java\lang\reflect\InvocationTargetException) {
			return \net\dryuf\core\Dryuf::translateCausingException($ex);
		}
		else {
			return new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	 * Translates the passed exception into RuntimeException if necessary.
	 * 
	 * @return
	 * 	wrapping exception
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\RuntimeException')
	*/
	public static function		translateCausingException($ex)
	{
		if (!is_null($ex->getCause()))
			$ex = $ex->getCause();
		if ($ex instanceof \net\dryuf\core\RuntimeException) {
			return $ex;
		}
		elseif ($ex instanceof \java\lang\reflect\InvocationTargetException) {
			return \net\dryuf\core\Dryuf::translateCausingException($ex);
		}
		else {
			return new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	 * Propagates the passed exception, wrapping it in RuntimeException if necessary.
	 * 
	 * @return
	 * 	the method actually never returns, it just defines the return type to easily write throw propagateException(...)
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\RuntimeException')
	*/
	public static function		propagateException($ex)
	{
		if ($ex instanceof \net\dryuf\core\RuntimeException)
			throw $ex;
		if ($ex instanceof \java\lang\Error)
			throw $ex;
		throw new \net\dryuf\core\RuntimeException($ex);
	}

	/**
	 * Propagates the passed exception cause, wrapping it in RuntimeException if necessary.
	 * 
	 * @return
	 * 	the method actually never returns, it just defines the return type to easily write throw propagateException(...)
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\RuntimeException')
	*/
	public static function		propagateCausingException($ex)
	{
		if (!is_null($ex->getCause()))
			throw \net\dryuf\core\Dryuf::propagateException($ex->getCause());
		throw \net\dryuf\core\Dryuf::propagateException($ex);
	}
};


?>
