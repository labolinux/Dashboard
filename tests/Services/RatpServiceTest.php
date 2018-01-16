<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 14/01/2018
 * Time: 18:58
 */

namespace App\Tests\Services;


use PHPUnit\Framework\TestCase;
use App\Services\RatpService;

class RatpServiceTest extends TestCase
{
    public function testConstruct()
    {
        $service = new RatpService();
        $this->assertInstanceOf(RatpService::class, $service);
    }


}