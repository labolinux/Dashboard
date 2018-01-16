<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 12/01/2018
 * Time: 14:21
 */


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AppControllerTest extends WebTestCase
{
    /**
     * @dataProvider routes
     *
     * @param $path
     */
    public function testRouting($path)
    {
        $client = static::createClient();
        $client->request('GET', $path);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

    }

    public function routes()
    {
        yield ['/'];
    }

}