<?php
namespace src\Company\model;

use Silex\Application;
use Doctrine\DBAL;

/**
 * Collection of User datbase queries
 */
class CompanyModel
{
    /**
     * Doctrine database  connection
     * @var str
     */
    private $db;


    /**
     * Construct the database connection
     */
    public function __construct(Application $app)
    {
        $this->db = $app['db'];

        date_default_timezone_set('Europe/Berlin');
    }


    /**
     * Get company
     * 
     * @param  int $company_id 
     * 
     * @return arr
     */
    public function getCompanyByCompanyId($company_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
                name,
                address,
                current_queue_number
            FROM
                companies
            WHERE
                company_id = ?";

        $params[] = $company_id;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            return array();
        }

        return $result;
    }


    /**
     * Insert a new company
     *
     * @param  Arr     $database Company's  data
     *
     * @return boolean           True if a new company is created,false 
     */
    public function createNewCompany($data)
    {
        $db=$this->db;

        $sql = "
            INSERT INTO
                companies
                    (category,
                    name,
                    address,
                    username,
                    password)
            VALUES
                (?, ?, ?, ?, ?)";

        $params[] = $data['category'];
        $params[] = $data['name'];
        $params[] = $data['address'];
        $params[] = $data['username'];
        $params[] = $data['password'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $db->lastInsertId();
    }


    /**
     * Insert company token
     * 
     * @param str $token   
     * @param int $company_id 
     * 
     * @return mix 
     */
    public function insertCompanyToken($token, $company_id)
    {
        $db=$this->db;

        $sql = "
            INSERT INTO
                oauth_companies(token, company_id)
            VALUES
                (?,?)
            ON DUPLICATE KEY UPDATE
                token = ?";

        $params[] = $token;
        $params[] = $company_id;
        $params[] = $token;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $db->lastInsertId();
    }


    /**
     * Get companies by username and password
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function getCompaniesByUsernameAndPassword($data)
    {
        $db=$this->db;

        $sql = "
            SELECT
                company_id
            FROM
                companies
            WHERE
                username = ?
            AND 
                password = ?";

        $params[] = $data['username'];
        $params[] = $data['password'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            return array();
        }

        return $result;
    }


    /**
     * 
     * @param int $category 
     * 
     * @return arr     
     */
    public function getCompaniesByCategory($category)
    {
        $db=$this->db;

        $sql = "
            SELECT
                *
            FROM
                companies
            WHERE
                category = ?";

        $params[] = $category;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return array();
        }

        return $result;
    }


    /**
     * Delete user token
     * 
     * @param arr $data 
     *  
     * @return arr
     */
    public function deleteCompanyOauthToken($token, $company_id)
    {
        $db=$this->db;

        $sql = "
            DELETE FROM
                oauth_companies 
            WHERE
                token = ?
            AND
                company_id = ?";

        $params[] = $token;
        $params[] = $company_id;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $query->rowCount();
    }
}
