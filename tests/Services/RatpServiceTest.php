<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 14/01/2018
 * Time: 18:58
 */

namespace App\Tests\Services;


use App\Storage;
use PHPUnit\Framework\TestCase;
use App\Services\RatpService;
use Ratp\Api;

class RatpServiceTest extends TestCase
{
    public function testConstruct()
    {
        /** @var Storage $storage */
        $storage = $this->createMock(Storage::class);
        $service = new RatpService(new Api(), $storage);
        $this->assertInstanceOf(RatpService::class, $service);
    }


}