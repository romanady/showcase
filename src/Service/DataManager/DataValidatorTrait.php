<?php

namespace App\Service\DataManager;


trait DataValidatorTrait
{

    public function getValueFromArray($array, $value, $json = false)
    {
        // todo redo this
        if (isset($array[$value])) {
            return $array[$value];
        }

        return '';
    }
}
