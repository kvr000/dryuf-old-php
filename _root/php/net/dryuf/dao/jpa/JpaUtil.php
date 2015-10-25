<?php

namespace net\dryuf\dao\jpa;


class JpaUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getSingleResultOptional($query)
	{
		$results = $query->getResultList();
		if ($results->size() == 1)
			return $results->get(0);
		if ($results->size() == 0)
			return null;
		throw new \javax\persistence\NonUniqueResultException("query returned more than one row");
	}
};


?>
