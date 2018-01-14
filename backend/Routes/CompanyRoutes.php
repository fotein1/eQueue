<?php
namespace Routes;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

use src\Company;

class CompanyRoutes implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $factory = $app['controllers_factory'];

        $app['company_model'] = new Company\model\CompanyModel($app);

        // Get company
        $factory->get('/{company_id}', 'src\Company\Company::getCompanyByCompanyId');

        // Register new company
        $factory->post('/register', 'src\Company\Company::registerCompany');

        // Login company
        $factory->post('/login', 'src\Company\Company::loginCompany');

        // Sign out company
        $factory->delete('/logout/{company_id}', 'src\Company\Company::logoutCompany');

        // Get all companies
        $factory->get('/category/{category}', 'src\Company\Company::getAllCompaniesByCategory');

        return $factory;
    }
}
