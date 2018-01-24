<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 14/01/2018
 * Time: 19:01
 */

namespace App\Services;


use App\Builder\MissionNextBuilder;
use App\Helper\ResponseHelper;
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
     * @var string
     */
    private $externalEndpoint;

    /**
     * RatpService constructor.
     *
     * @param Api $api
     * @param Storage $storage
     * @param $externalEndpoint
     */
    public function __construct(Api $api, Storage $storage, $externalEndpoint)
    {
        $this->api = $api;
        $this->storage = $storage;
        $this->externalEndpoint = $externalEndpoint;
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function geMissionNext(array $parameters)
    {

        if (null != $this->externalEndpoint) {
            return $this->callExternalApi($parameters);
        }

        $missions = [];

        $results = $this->getFromCache("getMissionsNext", MissionNextBuilder::build($parameters), "ratp.next_missions");

        /** @var Mission $item */
        foreach ($results->getReturn()->getMissions() as $item) {

            $mission[] = [
                'destination' => $this->getTerminus($item->getStations()),
                'message' => $this->getStationMessage($item->getStationsMessages())
            ];

            $missions['schedules'] = $mission;
        }

        $missions['_info'] = $this->getInfosStation($results->getReturn()->getArgumentLine());

        return ['result' => $missions];
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function callExternalApi(array $parameters)
    {
        $url = $this->externalEndpoint . sprintf("/schedules/%s/%s/%s/%s", $parameters["type"], $parameters["code"], $parameters["station"], $parameters["sens"]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Dashboard SUPINFO'
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return ResponseHelper::formatResponse($resp);
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