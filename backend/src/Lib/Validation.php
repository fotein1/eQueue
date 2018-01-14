<?php
namespace src\Lib;

/**
 *  class collection of Constant nessages variables
 */
class Validation
{
    const VALID     = 'VALID';

    const TOO_SHORT = 'TOO_SHORT';
    const TOO_LONG  = 'TOO_LONG';
    const TOO_BIG   = 'TOO_BIG';
    const TOO_SMALL = 'TOO_SMALL';
    const INVALID   = 'INVALID';


    /**
     * Check the validation results are all valid
     *
     * @param  arr     $validation_result The validation results
     *
     * @return boolean                    True if valid, else false
     */
    public static function checkValidationResults($validation_result)
    {
        foreach ($validation_result as $result) {
            if ($result !== self::VALID) {
                return false;
            }
        }

        return true;
    }


    /**
     * Check the validation results are all valid with method ValidationServiceProvider
     *
     * @param  arr     $validation_result The validation results
     *
     * @return mixed                    True if valid, else error message
     */
    public static function checkErrorValidationResults($errors)
    {
        if (count($errors) > 0) {
                foreach ($errors as $error) {
                    return  $error->getPropertyPath().' '.$error->getMessage()."\n";
                }
        }
        return true;
    }


    /**
     * Check if id is valid
     *
     * @param  int     $id  The id to validate
     *
     * @return const        The validation result
     */
    public static function validId($id)
    {
        if (!self::isNumeric($id)) {
            return self::INVALID;
        }
        if (!self::validMinValue($id, 1)) {
            return self::INVALID;
        }
        if (!self::isNatural($id)) {
            return self::INVALID;
        }
        if (!self::validMaxLength($id, 4)) {
            return self::TOO_BIG;
        }

        return self::VALID;
    }


    /**
     * Check maximum length
     *
     * @param  str $string String yo validate
     * @param  int $min    Minimum acceptable length
     *
     * @return boolean     The validation results
     */
    public static function validMinLength($string, $min)
    {
        $length = strlen($string);

        if ($length < $min) {
            return false;
        }

        return true;
    }


    /**
     * Check maximum length
     *
     * @param  str $string String to validate
     * @param  int $max    Maximum acceptable length
     *
     * @return boolean     The validation results
     */
    public static function validMaxLength($string, $max)
    {
        $length = strlen($string);

        if ($length > $max) {
            return false;
        }

        return true;
    }


    /**
     * Check minimum value
     *
     * @param  int $number Number yo validate
     * @param  int $min    Minimum acceptable value
     *
     * @return boolean     The validation results
     */
    public static function validMinValue($number, $min)
    {
        if ($number < $min) {
            return false;
        }

        return true;
    }


    /**
     * Check maximum value
     *
     * @param  int $number Number yo validate
     * @param  int $max    Maximum acceptable value
     *
     * @return boolean     The validation results
     */
    public static function validMaxValue($number, $max)
    {
        if ($number > $max) {
            return false;
        }

        return true;
    }


    /**
     * method to check alphabetical characters
     *
     * @param  str     $string The string to validate
     *
     * @return boolean         The validation results
     */
    public static function isAlpha($string)
    {
        return (bool)preg_match("/^([a-zA-Z])+$/i", $string);
    }


    /**
     * method to check alphanumeric characters
     *
     * @param  str     $string The string to validate
     *
     * @return boolean         The validation results
     */
    public static function isAlphaNumeric($string)
    {
        return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $string);
    }


    /**
     * method to check numeric characters
     *
     * @param  int     $number The number to validate
     *
     * @return boolean         The validation results
     */
    public static function isNumeric($number)
    {
        return (bool)is_numeric($number);
    }


    /**
     * method to check numbers are not decimal
     *
     * @param  int     $number The number to validate
     *
     * @return boolean         False if is decimal,true if is int
     */
    public static function isNatural($number)
    {
        return (bool)preg_match("/^([0-9])+$/i", $number);
    }
}
