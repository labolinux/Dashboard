<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 18/01/2018
 * Time: 11:11
 */

namespace App\Builder;

use Ratp\Direction;
use Ratp\Line;
use Ratp\MissionsNext;
use Ratp\Station;

class MissionNextBuilder
{

    /**
     * @param array $parameters
     *
     * @return MissionsNext
     */
    public static function build(array $parameters = [])
    {
        $prefix = $parameters["type"][0];
        $line = new Line();
        $line->setId(strtoupper($prefix).$parameters["code"]);
        $station = new Station();
        $station->setName($parameters["station"]);
        $station->setLine($line);
        $direction = new Direction();
        $direction->setSens($parameters["sens"]);
        $missionNext = new MissionsNext($station, $direction);
        return $missionNext;
    }

}