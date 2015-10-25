<?php

namespace net\dryuf\geo\resolve\nominatim;


class NominatimGeocodeResolver extends \net\dryuf\core\Object implements \net\dryuf\geo\resolve\GeocodeResolver
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
	public function			lookupGeocode($lng, $lat)
	{
		$dbConnection = null;
		try {
			$dbConnection = $this->nominatimDataSource->getConnection();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		try {
			$languagePreference = \net\dryuf\util\LinkedList::createFromArray(array( "cs", "en" ));
			$languagePreferenceSql = "ARRAY[".\net\dryuf\core\StringUtil::joinEscaped(function ($input) { return "?"; }, ",", $languagePreference)."]";
			$lookupMain = $dbConnection->prepareStatement("SELECT place_id, parent_place_id FROM placex\nWHERE\n\tST_DWithin(ST_SetSRID(ST_Point(?, ?), 4326), geometry, ?)\n\tAND rank_search != 28 AND rank_search >= ?\n\tAND (name IS NOT NULL OR housenumber IS NOT NULL)\n\tAND class NOT IN (\"waterway\")\n\tAND (ST_GeometryType(geometry) NOT IN (\"ST_Polygon\",\"ST_MultiPolygon\")\n\tOR ST_DWithin(ST_SetSRID(ST_Point(?, ?), 4326), ST_Centroid(geometry), ?))\nORDER BY\n\tST_distance(ST_SetSRID(ST_Point(?, ?), 4326), geometry) ASC LIMIT 1\n");
			for ($i = 0; $i < 1; $i++) {
				$showAddressDetails = true;
				$lngDouble = $lng/1.0E7;
				$latDouble = $lat/1.0E7;
				$pointSQL = "ST_SetSRID(ST_Point(?, ?), 4326)";
				$maxRank = 28;
				$searchDiameter = 1.0E-4;
				$placeId = null;
				$area = false;
				$maxAreaDistance = 1;
				$place = null;
				while (is_null($placeId) && $searchDiameter < $maxAreaDistance) {
					$searchDiameter = $searchDiameter*2;
					if ($searchDiameter > 2 && $maxRank > 4)
						$maxRank = 4;
					if ($searchDiameter > 1 && $maxRank > 9)
						$maxRank = 8;
					if ($searchDiameter > 0.8 && $maxRank > 10)
						$maxRank = 10;
					if ($searchDiameter > 0.6 && $maxRank > 12)
						$maxRank = 12;
					if ($searchDiameter > 0.2 && $maxRank > 17)
						$maxRank = 17;
					if ($searchDiameter > 0.1 && $maxRank > 18)
						$maxRank = 18;
					if ($searchDiameter > 0.008 && $maxRank > 22)
						$maxRank = 22;
					if ($searchDiameter > 0.001 && $maxRank > 26)
						$maxRank = 26;
					if (is_null(($place = \net\dryuf\sql\SqlHelper::executeRow($lookupMain, 
						array(
							$lngDouble,
							$latDouble,
							$searchDiameter,
							$maxRank,
							$lngDouble,
							$latDouble,
							$searchDiameter,
							$lngDouble,
							$latDouble
						))))) {
						continue;
					}
					$placeId = $place->get("place_id");
				}
				if (!is_null($placeId)) {
					$sql = "select address_place_id from place_addressline where cached_rank_address <= ? and place_id = ? order by cached_rank_address desc,isaddress desc,distance desc limit 1";
					if (is_null(($placeId = \net\dryuf\sql\SqlHelper::queryColumn($dbConnection, $sql, 
						array(
							$maxRank,
							$placeId
						))))) {
						throw new \net\dryuf\core\RuntimeException("Could not get parent for place.");
					}
					if (!is_null($placeId) && !is_null($place->get("place_id")) && $maxRank < 28) {
						$sql = "select address_place_id from place_addressline where cached_rank_address <= ? and place_id = ? order by cached_rank_address desc,isaddress desc,distance desc limit 1";
						if (is_null(($placeId = \net\dryuf\sql\SqlHelper::queryColumn($dbConnection, $sql, 
							array(
								$maxRank,
								$place->get("place_id")
							))))) {
							throw new \net\dryuf\core\RuntimeException("Could not get larger parent for place.");
						}
					}
				}
				if (!is_null($placeId)) {
					$sql = "select placex.*,\n"."get_address_by_language(place_id, ".$languagePreferenceSql.") as langaddress,\n"."get_name_by_language(name, ".$languagePreferenceSql.") as placename,\n"."get_name_by_language(name, ARRAY['ref']) as ref,\n"."st_y(st_centroid(geometry)) as lat, st_x(st_centroid(geometry)) as lon\n"."from placex where place_id = ?";
					$binds = new \net\dryuf\util\LinkedList();
					$binds->addAll($languagePreference);
					$binds->addAll($languagePreference);
					$binds->add($placeId);
					if (is_null(($place = \net\dryuf\sql\SqlHelper::queryRow($dbConnection, $sql, $binds->toArray())))) {
						throw new \net\dryuf\core\RuntimeException("bad place");
					}
				}
			}
		}
		catch (\net\dryuf\sql\SqlException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
		finally {
			try {
				$dbConnection->close();
			}
			catch (\net\dryuf\sql\SqlException $ex) {
			}
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\sql\DataSource')
	@\javax\inject\Inject
	@\javax\inject\Named(value = "javax.sql.DataSource-nominatim")
	*/
	protected			$nominatimDataSource;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Integer, java\lang\Integer>')
	*/
	static				$zoomRank;

	public static function		_initManualStatic()
	{
		self::$zoomRank = \net\dryuf\util\MapUtil::createNativeHashMap(0, 2, 1, 2, 2, 2, 3, 4, 4, 4, 5, 8, 6, 10, 7, 10, 8, 12, 9, 12, 10, 17, 11, 17, 12, 18, 13, 18, 14, 22, 15, 22, 16, 26, 17, 26, 18, 30, 19, 30);
	}

};

\net\dryuf\geo\resolve\nominatim\NominatimGeocodeResolver::_initManualStatic();


?>
