<?php
namespace Routes;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

use src\Queue;

class QueueRoutes implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $factory = $app['controllers_factory'];

        $app['queue_model'] = new Queue\model\QueueModel($app);

        // Subscribe user to queue
        $factory->post('/user/{user_id}', 'src\Queue\Queue::subscribeUser');

        // Get all queues for a user
        $factory->get('/user/{user_id}', 'src\Queue\Queue::getAllQueuesForAUser');

        // Get all queued users for a company
        $factory->get('/company/{company_id}', 'src\Queue\Queue::getAllQueuedUsersForACompany');

        // Unsubscribe user from queue
        $factory->post('/company/{company_id}', 'src\Queue\Queue::unSubscribeUser');

        return $factory;
    }
}
