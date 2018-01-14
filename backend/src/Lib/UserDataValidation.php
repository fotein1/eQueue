<?php
namespace src\Lib;

use Silex\Application;

class UserDataValidation
{


    /**
     * method to validate all input register data
     *
     * @param  arr $data   User's data
     *
     * @return arr $result Validated user's data
     */
    public static function validateRegisterUserData($data)
    {

        $result['username'] = self::validateUsername($data['username']);

        $result['password'] = self::validatePassword($data['password']);

        $result['first_name'] = self::validateFirstName($data['first_name']);

        $result['last_name'] = self::validateLastName($data['last_name']);

        $result['email'] = self::validateEmail($data['email']);

        return $result;
    }


    /**
     * method to validate all login input data
     *
     * @param  arr $data   User's data
     *
     * @return arr $result Validated user's data
     */
    public static function validateLoginrUserData($data)
    {
        $result['username'] = self::validateUsername($data['username']);

        $result['password'] = self::validatePassword($data['password']);

        return $result;
    }


    /**
     * method to validate first name, check min, max length and valid pattern
     *
     * @param  str $first_name  User's first name
     *
     * @return str              Validation r
     *
     */
    public static function validatefirstName($first_name)
    {
        if (!Validation::validMaxLength($first_name, 12)) {
            return Validation::TOO_lONG;
        }
        if (!Validation::isAlpha($first_name)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


    /**
     * method to validate last name, check min, max length and valid pattern
     *
     * @param  str $last_name  User's last name
     *
     * @return str             Validation result
     */
    public static function validateLastName($last_name)
    {

        if (!Validation::validMaxLength($last_name, 12)) {
            return Validation::TOO_lONG;
        }
        if (!Validation::isAlpha($last_name)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


    /**
     * method to validate username, check min, max length and valid pattern
     *
     * @param  str $username  User's first name
     *
     * @return str            Validation Result
     **/
    public static function validateUsername($username)
    {
        if (!Validation::validMinLength($username, 4)) {
            return Validation::TOO_SHORT;
        }

        if (!Validation::validMaxLength($username, 12)) {
            return Validation::TOO_lONG;
        }

        if (!Validation::isAlphaNumeric($username)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


    /**
     * method to validate password, check min, max length, valid pattern
     *
     * @param  str $password  User's password
     *
     * @return str            Validation Result
     **/
    public static function validatePassword($password)
    {
        if (!Validation::validMinLength($password, 6)) {
            return Validation::TOO_SHORT;
        }

        if (!Validation::validMaxLength($password, 20)) {
            return Validation::TOO_lONG;
        }

        // Some special characters are okay, but not all
        $okay_characters = array('!', '?', '@', '#', '$', '%', '^', '&', '*', ' ');
        $cleansed_password = str_replace($okay_characters, '', $password);
        if (!Validation::isAlphaNumeric($cleansed_password)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


    /**
     * method to validate email
     *
     * @param  str $email User's email
     *
     * @return str        Validation result
     */
    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }
}
