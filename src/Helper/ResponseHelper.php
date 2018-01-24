<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 17/01/2018
 * Time: 22:06
 */

namespace App\Helper;

class ResponseHelper
{

    /**
     * @param mixed $response
     *
     * @return array
     */
    public static function formatResponse($response)
    {
        $jsonArray = json_decode($response, JSON_OBJECT_AS_ARRAY);

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