<?php
namespace Routes;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

use src\User;

class UserRoutes implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $factory = $app['controllers_factory'];

        $app['user_model'] = new User\model\UserModel($app);

        // Get user
        $factory->get('/{user_id}', 'src\User\User::getUserByUserId');

        // Register new user
        $factory->post('/register', 'src\User\User::registerUser');

        // Sign in user
        $factory->post('/login', 'src\User\User::loginUser');

         // Sign out user
        $factory->delete('/logout/{user_id}', 'src\User\User::logoutUser');

        return $factory;
    }
}
