<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 17/01/2018
 * Time: 22:06
 */

namespace App\Helper;

use Psr\Http\Message\ResponseInterface;

class ResponseHelper
{

    public static function formatResponse(ResponseInterface $response)
    {
        $jsonArray = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY);
        return self::toArray($jsonArray);
    }

    /**
     * Eventuel traitement à effectuer
     * par exemple retirer les données inutiles
     *
     * @param $data
     *
     * @return mixed
     */
    private static function toArray($data)
    {
        return $data;
    }
}