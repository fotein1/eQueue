<?php
namespace src\Lib;

use Silex\Application;

class QueueDataValidation
{
    /**
     * method to validate all input register data
     *
     * @param  arr $data   User's data
     *
     * @return arr $result Validated user's data
     */
    public static function validateSubscribeUserData($data)
    {
        $result['company_id'] = Validation::validId($data['company_id']);

        return $result;
    }
}
