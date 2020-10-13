<?php
namespace App\Tests\Helper;

use App\Helper\JsonDecoder;
use PHPUnit\Framework\TestCase;

class JsonDecoderTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testSuccessfulDecode()
    {
        $validJson = '{ "name":"John", "age":30 }';
        $expected = [
            'name' => 'John',
            'age' => 30
        ];
        $decoded = JsonDecoder::safeJsonDecode($validJson);
        $this->assertEquals($expected, $decoded);
    }
}
