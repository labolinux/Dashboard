<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 14/01/2018
 * Time: 19:01
 */

namespace App\Services;


use App\Builder\MissionNextBuilder;
use App\Storage;
use Ratp\Api;
use Ratp\Line;
use Ratp\Mission;
use Ratp\Response\MissionResponse;
use Ratp\Station;
use Ratp\WrMissions;

class RatpService
{
    /**
     * @var Api
     */
    private $api;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * RatpService constructor.
     *
     * @param Api $api
     * @param Storage $storage
     */
    public function __construct(Api $api, Storage $storage)
    {
        $this->api = $api;
        $this->storage = $storage;
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function geMissionNext(array $parameters)
    {
        $missions = [];

        $results = $this->getFromCache("getMissionsNext", MissionNextBuilder::build($parameters), "ratp.next_missions");

        /** @var Mission $item */
        foreach ($results->getReturn()->getMissions() as $item) {

            $mission[] = [
                'direction' => $this->getTerminus($item->getStations()),
                'message' => $this->getStationMessage($item->getStationsMessages())
            ];

            $missions['missions'] = $mission;
        }

        $missions['_info'] = $this->getInfosStation($results->getReturn()->getArgumentLine());

        return $missions;
    }

    /**
     * @param Line $line
     *
     * @return array
     */
    public function getInfosStation(Line $line)
    {
        $info = [
            'image' => $line->getImage(),
            'name' => $line->getName(),
            'id' => $line->getId()
        ];

        return $info;
    }

    /**
     * @param array $missions
     *
     * @return string
     */
    public function getTerminus(array $missions)
    {
        /** @var Station $station */
        $station = array_pop($missions);

        return $station->getName();
    }

    public function getStationMessage(array $message)
    {
        $message = $message[0];
        if (strpos($message, 'mn')) {
             return str_replace('mn', 'min', $message);
        }
        return $message;
    }
    /**
     * @param $function
     * @param  mixed $arguments
     * @param $key
     *
     * @return mixed
     */
    private function getFromCache($function, $arguments, $key)
    {
        if (!method_exists($this->api, $function)) {
            throw new \InvalidArgumentException("Method $function doesn't exist");
        }
        $cache = $this->storage->getItem($key);
        if ($cache->isHit()) {
            $data = unserialize($cache->get());
        } else {
            $data = $this->api->$function($arguments);
            $this->storage->setItem($cache, $data);
        }
        return $data;
    }

}