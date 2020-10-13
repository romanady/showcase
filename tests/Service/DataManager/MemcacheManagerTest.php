<?php

namespace App\Tests\Service\DataManager;

use App\Service\DataManager\MemcacheManager;
use App\Tests\TestTrait;
use PHPUnit\Framework\TestCase;

class MemcacheManagerTest extends TestCase
{
    use TestTrait;
    public function testSuccessfulCache()
    {
        $key = '1';
        $successImage = $this->getSuccessImage();
        $expectedResult = $this->getExpectedSuccess();

        $memcacheManager = new MemcacheManager();
        $memcacheManager->loadImage($key, $successImage);

        $memcacheClient = $this->getMemcacheConnection();
        $this->assertEquals($expectedResult, $memcacheClient->get($key));
    }

    public function testMissingImage()
    {
        $key = '2';
        $missingImage = $this->getMissingImage();
        $expectedResult = null;

        $memcacheManager = new MemcacheManager();
        $memcacheManager->loadImage($key, $missingImage);

        $memcacheClient = $this->getMemcacheConnection();
        $this->assertEquals($expectedResult, $memcacheClient->get($key));
    }
}
