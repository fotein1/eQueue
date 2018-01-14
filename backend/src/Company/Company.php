<?php
namespace src\Company;

use src\Lib;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Company
{
    /**
     * Get single company by company id
     * 
     * @param  Application $app     
     * @param  Request     $request 
     * @param  int         $user_id 
     * 
     * @return arr
     */
    public function getCompanyByCompanyId(Application $app, $company_id)
    {
        $companyModel = $app['company_model'];

        $company = $companyModel->getCompanyByCompanyId($company_id);
        if ($company === false) {
            throw new \RuntimeException();
        }

        if (empty($company)) {
            throw new NotFoundHttpException;
        }

        return $app->json(array('company' => $company));
    }


    /**
     * Register company
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function registerCompany(Application $app, Request $request)
    {
        $companyModel = $app['company_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::registerCompanyDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $validation_result = Lib\CompanyDataValidation::validateRegisterCompanyData($data);
        if (Lib\Validation::checkValidationResults($validation_result) === false) {
            return $app->json($validation_result, 400);
        }

        $data['password'] = md5($data['password']);

        $company_id = $companyModel->createNewCompany($data);
        if ($company_id === false) {
            throw new \RuntimeException();
        }

        $token = bin2hex(openssl_random_pseudo_bytes(20));

        $insert_token = $companyModel->insertCompanyToken($token, $company_id);
        if ($insert_token === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('token' => $token, 'company_id' => $company_id));
    }


    /**
     * Login company, generate a token
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function loginCompany(Application $app, Request $request)
    {
        $companyModel = $app['company_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::loginCompanyDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $validation_result = Lib\CompanyDataValidation::validateLoginCompanyData($data);
        if (Lib\Validation::checkValidationResults($validation_result) === false) {
            return $app->json($validation_result, 400);
        }

        $data['password'] = md5($data['password']);

        $company = $companyModel->getCompaniesByUsernameAndPassword($data);
        if ($company === false) {
            throw new \RuntimeException();
        }

        if (empty($companies)) {
            throw new NotFoundHttpException();
        }

        $token = bin2hex(openssl_random_pseudo_bytes(20));

        $insert_token = $companyModel->insertCompanyToken($token, $company['company_id']);
        if ($insert_token === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('token' => $token, 'company_id' => $company['company_id']));
    }


    /**
     * method to logout company
     * 
     * @param  Application $app        The silex application
     * @param  Request     $request    The request object
     * @param  int         $company_id The company id
     * 
     * @return mix                  The response
     */
    public function logoutCompany(Application $app, Request $request, $company_id)
    {
        $companyModel = $app['company_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::LogoutUserDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $deleted_token = $companyModel->deleteCompanyOauthToken($data['token'], $company_id);
        if ($deleted_token === false || $deleted_token > 1) {
            throw new \RuntimeException();
        }

        if ($deleted_token === 0) {
            throw new NotFoundHttpException();
        }

        return $app->json(array('detail' => 'success'));
    }


    /**
     * Get all companies for a type
     * 
     * @param  Application $app        
     * @param  int         $category 
     * 
     * @return arr               
     */
    public function getAllCompaniesByCategory(Application $app, $category)
    {
        $companyModel = $app['company_model'];

        if (Lib\CompanyDataValidation::validateCompanyCategory($category) !== Lib\Validation::VALID) {
            throw new NotFoundHttpException();
        }

        $companies = $companyModel->getCompaniesByCategory($category);
        if ($companies === false) {
            throw new \RuntimeException();
        }

        if (empty($companies)) {
            throw new NotFoundHttpException();
        }

        return $app->json(array('companies' => $companies));
    }


    /**
     * method to get a list of required fields
     *
     * @return arr   The array with required fields
     */
    public static function registerCompanyDataWhitelist()
    {
        return array(
            'name',
            'address',
            'category',
            'username',
            'password'
        );
    }


    /**
     * method to get a list of required fields
     *
     * @return arr   The array with required fields
     */
    public static function loginCompanyDataWhitelist()
    {
        return array(
            'username',
            'password'
        );
    }


    /**
     * method to get log out list of required fields
     */
    public static function LogoutUserDataWhitelist()
    {
        return array(
            'token'
        );
    }
}
