<?php

namespace net\dryuf\oper;


interface ObjectOperMarshaller
{
	/**
	 * Preprocesses input.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			preprocessInput($context);

	/**
	 * Gets static operation method.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	function			getStaticOperMethod($context);

	/**
	 * Gets object operation method.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	function			getObjectOperMethod($context);

	/**
	 * Gets generic input data.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	function			getInputData($context);

	/**
	 * Gets action input data.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getActionData($context, $actionClass);

	/**
	 * Gets list parameters.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperContext\ListParams')
	*/
	function			getListParams($context);

	/**
	 * Gets view filter data.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getViewFilter($context, $filterClass);

	/**
	 * Renders output through operContext.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			outputUnauthorizedException($context, $ex);

	/**
	 * Renders output through operContext.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			outputAccessValidationException($context, $ex);

	/**
	 * Renders output through operContext.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			outputDataValidationException($context, $ex);

	/**
	 * Renders output through operContext.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			outputUniqueValidationException($context, $ex);

	/**
	 * Renders output through operContext.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			outputObject($context, $output);
};


?>
