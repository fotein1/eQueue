<?php
namespace src\Lib;

use Silex\Application;

class CompanyDataValidation
{
    const BANKS            = '0';
    const HOSPITALS        = '1';
    const PUBLIC_COMPANIES = '2';
    const SHOPS            = '3';

    /**
     * method to validate all input register data
     *
     * @param  arr $data   User's data
     *
     * @return arr $result Validated user's data
     */
    public static function validateRegisterCompanyData($data)
    {
        $result['name'] = self::validateCompanyName($data['name']);

        $result['address'] = self::validateCompanyAddress($data['address']);

        $result['category'] = self::validateCompanyCategory($data['category']);

        $result['username'] = self::validateUsername($data['username']);

        $result['password'] = self::validatePassword($data['password']);

        return $result;
    }


    /**
     * method to validate all input register data
     *
     * @param  arr $data   User's data
     *
     * @return arr $result Validated user's data
     */
    public static function validateLoginCompanyData($data)
    {
        $result['username'] = self::validateUsername($data['username']);

        $result['password'] = self::validatePassword($data['password']);

        return $result;
    }


    /**
     * method to validate company name, check min, max length and valid pattern
     *
     * @param  str $name 
     *
     * @return str   
     *
     */
    public static function validateCompanyName($name)
    {
        if (!Validation::validMaxLength($name, 12)) {
            return Validation::TOO_lONG;
        }
        if (!Validation::isAlpha($name)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


   /**
     * method to validate company address, check min, max length and valid pattern
     *
     * @param  str $name 
     *
     * @return str   
     *
     */
    public static function validateCompanyAddress($address)
    {
        if (!Validation::validMaxLength($address, 12)) {
            return Validation::TOO_lONG;
        }
        if (!Validation::isAlpha($address)) {
            return Validation::INVALID;
        }

        return Validation::VALID;
    }


    /**
     * method to validate company category
     *
     * @param  str $category 
     *
     * @return str   
     *
     */
    public static function validateCompanyCategory($category)
    {
        if ($category !== self::BANKS &&
            $category !== self::HOSPITALS &&
            $category !== self::PUBLIC_COMPANIES &&
            $category !== self::SHOPS
        ) {
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
}
