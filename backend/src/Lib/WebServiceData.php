<?php
namespace src\Lib;

class WebServiceData
{
    /**
     * Check that the data received with the request is correct
     *
     * This will check that we received all the data as defined in
     * $required_inputs AND that no extra data was received.
     *
     * @param  arr $required_inputs  Data fields to check
     * @param  arr $data             User's data
     *
     * @return boolean               The check result
     */
    public static function receivedDataCheck($required_inputs, $data)
    {
        if (self::requiredDataCheck($required_inputs, $data) === false ||
            self::extraDataCheck($required_inputs, $data) === false) {
            return false;
        }

        return true;
    }


    /**
     * Check that all the data was received with the request
     *
     * @param  arr $required_inputs  Data fields to check
     * @param  arr $data             User's data
     *
     * @return boolean               The check result
     */
    public static function requiredDataCheck($required_inputs, $data)
    {
        foreach ($required_inputs as $input) {
            if (!array_key_exists($input, $data)) {
                return false;

            }
        }

        return true;
    }


    /**
     * Check that there was no extra data received
     *
     * @param  arr $required_inputs  Data fields to check
     * @param  arr $data             User's data
     *
     * @return boolean               The check result
     */
    public static function extraDataCheck($required_inputs, $data)
    {

        if (count($required_inputs) !== count($data)) {
            return false;
        }

        return true;
    }
}
