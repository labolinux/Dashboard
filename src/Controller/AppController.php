<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 12/01/2018
 * Time: 10:16
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="app")
     */
    public function appAction()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/check")
     */
    public function versionAction()
    {
        return $this->json(['version' => $this->get('api.ratp')->getVersion()]);
    }
}