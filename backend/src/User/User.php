<?php
namespace src\User;

use src\Lib;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class User
{
    public function getUserByUserId(Application $app, Request $request, $user_id)
    {
        $userModel = $app['user_model'];

        $user = $userModel->getUserByUserId($user_id);
        if ($user === false) {
            throw new \RuntimeException();
        }

        if (empty($user)) {
            throw new NotFoundHttpException;
        }

        return $app->json(array('user' => $user));
    }


    /**
     * Register user, generate a token
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function registerUser(Application $app, Request $request)
    {
        $userModel = $app['user_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::RegisterUserDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $validation_result = Lib\UserDataValidation::validateRegisterUserData($data);
        if (Lib\Validation::checkValidationResults($validation_result) === false) {
            return $app->json($validation_result, 400);
        }

        $data['password'] = md5($data['password']);

        $user_id = $userModel->createNewUser($data);
        if ($user_id === false) {
            throw new \RuntimeException();
        }

        $token = bin2hex(openssl_random_pseudo_bytes(20));

        $insert_token = $userModel->insertUserToken($token, $user_id);
        if ($insert_token === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('token' => $token, 'user_id' => $user_id));
    }


    /**
     * Login user, generate a token
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function loginUser(Application $app, Request $request)
    {
        $userModel = $app['user_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::LoginUserDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $validation_result = Lib\UserDataValidation::validateLoginrUserData($data);
        if (Lib\Validation::checkValidationResults($validation_result) === false) {
            return $app->json($validation_result, 400);
        }

        $data['password'] = md5($data['password']);

        $user = $userModel->getUsersByUsernameAndPassword($data);
        if ($user === false) {
            throw new \RuntimeException();
        }

        $token = bin2hex(openssl_random_pseudo_bytes(20));

        $insert_token = $userModel->insertUserToken($token, $user['user_id']);
        if ($insert_token === false) {
            throw new \RuntimeException();
        }
 
        return $app->json(array('token' => $token, 'user_id' => $user['user_id']));
    }


    /**
     * method to logout a user
     * 
     * @param  Application $app     The silex application
     * @param  Request     $request The request object
     * @param  int         $user_id The user id
     * 
     * @return mix                  The response
     */
    public function logoutUser(Application $app, Request $request, $user_id)
    {
        $userModel = $app['user_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::LogoutUserDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $deleted_token = $userModel->deleteUserOauthToken($data['token'], $user_id);
        if ($deleted_token === false || $deleted_token > 1) {
            throw new \RuntimeException();
        }

        if ($deleted_token === 0) {
            throw new NotFoundHttpException;
        }

        return $app->json(array('detail' => 'success'));
    }


    /**
     * method to get a list of required fields
     *
     * @return arr   The array with required fields
     */
    public static function RegisterUserDataWhitelist()
    {
        return array(
            'username',
            'password',
            'first_name',
            'last_name',
            'email'
        );
    }


    /**
     * method to get a list of required fields
     *
     * @return arr   The array with required fields
     */
    public static function LoginUserDataWhitelist()
    {
        return array(
            'username',
            'password'
        );
    }

    public static function LogoutUserDataWhitelist()
    {
        return array(
            'token'
        );
    }
}
