<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 17/01/2018
 * Time: 14:30
 */

namespace App\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MissionController
 *
 * @package App\Controller\Api
 * @Route("/missions")
 */
class MissionController extends Controller
{

    /**
     * @param Request $request
     * @param $code
     * @param $station
     * @param $sens
     *
     * @param string $type
     *
     * @return JsonResponse
     * @Route("/ratp/{code}/{station}/{sens}/{type}", name="depart_ratp")
     */
    public function missionsAction(Request $request, $code, $station, $sens, $type = "metros")
    {
        $params = [
            'code' => $code,
            'station' => $station,
            'sens' => $sens,
            'type' => $type
        ];

        $missions = $this->get('service.ratp')->geMissionNext($params);

        return $this->json($missions);
    }

    /**
     * @param Request $request
     * @param $code
     *
     * @return JsonResponse
     * @Route("/transilien/gare/{code}/depart", name="depart_sncf")
     */
    public function missionsTransilien(Request $request, $code)
    {
        $missions = $this->get("service.sncf")->getNextTrains($code);

        return $this->json($missions);
    }
}