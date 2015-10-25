<?php


if (!function_exists("boolval")) {
	function boolval($s)
	{
		return $s == "1" || $s == "true";
	}
}

?>
