<?php

namespace net\dryuf\geo\resolve;


interface GeocodeResolver
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			lookupGeocode($lng, $lat);
};


?>
