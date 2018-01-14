<?php
namespace src\Queue;

use src\Lib;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Queue
{
    /**
     * Register user, generate a token
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function subscribeUser(Application $app, Request $request, $user_id)
    {
        $queueModel = $app['queue_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::subscribeUserOnQueueDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $validation_result = Lib\QueueDataValidation::validateSubscribeUserData($data);
        if (Lib\Validation::checkValidationResults($validation_result) === false) {
            return $app->json($validation_result, 400);
        }

        $data['user_id'] = $user_id;

        // Unauthorized user
        $user = $queueModel->getUserByTokenAndUserId($data);
        if ($user === false) {
            throw new \RuntimeException();
        }
        if ($user === array()) {
            throw new UnauthorizedHttpException;
        }

        // Get current queue number of queue
        $current_queue_number = $queueModel->getQueueNumberByCompanyId($data['company_id']);
        if ($current_queue_number === false) {
            throw new \RuntimeException();
        }
        if ($current_queue_number === array()) {
            throw new NotFoundHttpException;
        }

        //Check if user is already subscribed in queue
        $user = $queueModel->getSubscriberByUserAndCompany($data);
        if ($user === false) {
            throw new \RuntimeException();
        }
        if ($user !== array()) {
            throw new BadRequestHttpException;
        }

        $current_queue_number["current_queue_number"]++;
        $data['queue_number'] = $current_queue_number["current_queue_number"];
        if ($queueModel->subscribeUserOnQueue($data) === false) {
            throw new \RuntimeException();
        }

        if ($queueModel->updateCompanyQueue($data) === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('queue_number' => $data['queue_number']));
    }


    /* * Register user, generate a token
     *
     * @param  Application $app The silex object
     *
     * @return mix              The response
     */
    public function unSubscribeUser(Application $app, Request $request, $company_id)
    {
        $queueModel = $app['queue_model'];

        $data = $request->request->get('smp_request_data');

        if (empty($data)) {
            throw new BadRequestHttpException;
        }

        $required_inputs = self::unSsubscribeUserOnQueueDataWhitelist();
        if (Lib\WebServiceData::receivedDataCheck($required_inputs, $data) === false) {
            throw new BadRequestHttpException;
        }

        $data['company_id'] = $company_id;

        // Unauthorized Company
        $company = $queueModel->getCompanyByTokenAndCompanyId($data);
        if ($company === false) {
            throw new \RuntimeException();
        }
        if ($company === array()) {
            throw new UnauthorizedHttpException;
        }

        // Get current queue number of queue
        $current_queued = $queueModel->getCurrentQueuedUserByCompanyId($data['company_id']);
        if ($current_queued === false) {
            throw new \RuntimeException();
        }
        if ($current_queued === array()) {
            throw new NotFoundHttpException;
        }

        $data['user_id']      = $current_queued['current_queued_user_id'];
        $data['queue_number'] = $current_queued['current_queue_number'];

        // Delete current queue number of queue
        $deleted_queued_user = $queueModel->removeQueuedUserByCompanyIdAndUserId($data);
        if ($deleted_queued_user === false || $deleted_queued_user > 1) {
            throw new \RuntimeException();
        }

        if ($deleted_queued_user === 0) {
            throw new NotFoundHttpException;
        }

        $current_queued_user = $queueModel->getFirstQueuedUserByCompanyId($company_id);
        if ($current_queued_user === false) {
            throw new \RuntimeException();
        }

        if ($current_queued_user === array()) {
            $data['user_id']      = NULL;
            $data['queue_number'] = 0;
        } else {
            $data['user_id']      = $current_queued_user['user_id'];
            $data['queue_number'] = $current_queued_user['queue_number'];
        }

        if ($queueModel->updateCompanyQueue($data) === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('current_queue_number' => $data['queue_number']));
    }


    /**
     * Get all the queues for a user
     * @param  Application $app   
     * @param  Request     $request 
     * @param  int         $user_id 
     * 
     * @return arr
     */
    public function getAllQueuesForAUser(Application $app, Request $request, $user_id)
    {
        $queueModel = $app['queue_model'];

        $queues = $queueModel->getAllQueuesForAUser($user_id);
        if ($queues === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('queues' => $queues ));
    }


    /**
     * Get all queued users for a queue
     * 
     * @param  Application $app        
     * @param  Request     $request    
     * @param  int         $company_id 
     * 
     * @return arr
     */
    public function getAllQueuedUsersForACompany(Application $app, Request $request, $company_id)
    {
        $queueModel = $app['queue_model'];

        $queued_users = $queueModel->getAllQueuedUsersForACompany($company_id);
        if ($queued_users === false) {
            throw new \RuntimeException();
        }

        return $app->json(array('queued_users' => $queued_users));
    }


    /**
     * method to get a list of required fields
     *
     * @return arr   The array with required fields
     */
    public static function subscribeUserOnQueueDataWhitelist()
    {
        return array(
            'company_id',
            'token'
        );
    }

    public static function unSsubscribeUserOnQueueDataWhitelist()
    {
        return array(
            'token'
        );
    }
}
