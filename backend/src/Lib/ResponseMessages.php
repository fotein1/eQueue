<?php
namespace src\Lib;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

/**
 *  class collecyion of Constant nessages variables
 */
class ResponseMessages
{
    const SUCCESS        = 'Success';
    const CREATE_SUCCESS = 'Create success';
    const UPDATE_SUCCESS = 'Update_success';
    const DELETE_SUCCESS = 'Delete_success';

    const NOT_FOUND             = 'Not found';
    const INTERNAL_SERVER_ERROR = 'Internal server error';
    const INVALID_REQUEST       = 'Invalid Request';
    const DEFAULT_MESSAGE       = 'We are sorry, but something went terribly
                                   wrong.';


    /**
     * output  of a message
     *
     * @param  str $message default=null
     *
     * @return arr          details of message
     */
    public static function customMessage($message = null)
    {
        if ($message === null) {
            $message = '';
        }

        return array('Detail' => $message);
    }


    /**
     * output message for internal server error
     *
     * @return arr  details of message
     */
    public static function internalServerError()
    {
        return array('Detail' => self::INTERNAL_SERVER_ERROR);
    }


    /**
     * output message not found
     *
     * @return arr details of message
     */
    public static function notFound()
    {
        return array('Detail' => self::NOT_FOUND );
    }


    /**
     * output message invalid request
     *
     * @return arr details of  message
     */
    public static function invalidRequest()
    {
        return array('Detail' => self::INVALID_REQUEST );
    }


    /**
     * output  message  sucess
     *
     * @return constant   details of message
     */
    public static function success()
    {
        return  self::SUCCESS ;
    }


    /**
     * output of successful create
     *
     * @return arr details of message
     */
    public static function createSuccess()
    {
        return array('Detail' => self::CREATE_SUCCESS);
    }


    /**
     * output of succesful update
     *
     * @return arr details of message
     */
    public static function updateSuccess()
    {
        return array('Detail' => self::UPDATE_SUCCESS);
    }


    /**
     * output of succesful delete
     *
     * @return arr details of message
     */
    public static function deleteSuccess()
    {
        return array('Detail' => self::DELETE_SUCCESS);
    }
}
