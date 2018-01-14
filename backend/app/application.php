<?php
use Doctrine\DBAL;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Loader\FileLoader;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

$app = new Silex\Application;

//import our database settings from config.yml file
$configValues = Yaml::parse(file_get_contents(__DIR__ . '/../app/config.yml'));

//register docrtine silex service porvider to connect to database
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $configValues['config']['database']['db_options']
));

//create a logger - use the same instance of service across all of the code
$app['log_error'] = $app->share(function ($app) {
    return new Logger('log_error');
});
$app['log_error']->pushHandler(new StreamHandler(
    '../log/log_error.log',
    Logger::DEBUG
));

//create an error handler and log errors in logfile
$app->error(function (\Exception $e, $code) use ($app) {

    switch ($code) {
        case 404:
            $message = ' Not found';
            $app['log_error']->addError($message);
            break;
        case 500:
            $message = 'internal server error';
            $app['log_error']->addError($message);
            break;
        case 400:
            $message = 'Bad request';
            $app['log_error']->addError($message);
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
            $app['log_error']->addError($message);
    }

    return new Response($message);
});

// Handle json requests correctly
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            $data = array();
        }

        $request->request->replace($data);
        $request->request->set('smp_request_data', $data);
    }
});

return $app;
