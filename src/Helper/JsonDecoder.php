<?php

namespace App\Helper;

class JsonDecoder
{
    /**
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function safeJsonDecode($value)
    {
        $decoded = json_decode($value, true);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $decoded;
            case JSON_ERROR_DEPTH:
                throw new \Exception('Maximum stack depth exceeded');
            case JSON_ERROR_STATE_MISMATCH:
                throw new \Exception('Underflow or the modes mismatch');
            case JSON_ERROR_CTRL_CHAR:
                throw new \Exception('Unexpected control character found');
            case JSON_ERROR_SYNTAX:
                throw new \Exception('Syntax error, malformed JSON');
            case JSON_ERROR_UTF8:
                $clean = iconv("UTF-8", "UTF-8//IGNORE", $value);
                return json_decode($clean, true);
            default:
                throw new \Exception('Unknown error');
        }
    }
}
