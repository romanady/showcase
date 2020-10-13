<?php

namespace App\Tests\Helper;

use App\Helper\ImageLoader;
use App\Tests\TestTrait;
use PHPUnit\Framework\TestCase;

class ImageLoaderTest extends TestCase
{
    use TestTrait;
    public function testImageLoad()
    {
        $successImage = $this->getSuccessImage();
        $expectedSuccess = $this->getExpectedSuccess();
        $missingImage = $this->getMissingImage();
        $expectedNotFound = null;
        $this->assertEquals($expectedSuccess, base64_encode(ImageLoader::getImage($successImage)));
        $this->assertEquals($expectedNotFound, ImageLoader::getImage($missingImage));
    }
}
