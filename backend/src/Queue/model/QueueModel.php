<?php
namespace src\Queue\model;

use Silex\Application;
use Doctrine\DBAL;

/**
 * Collection of User datbase queries
 */
class QueueModel
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
     * Function to get user by token and user_id
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function getUserByTokenAndUserId($data)
    {
        $db=$this->db;

        $sql = "
            SELECT
                user_id
            FROM
                oauth_users
            WHERE
                user_id = ?
            AND
                token = ?";

        $params[] = $data['user_id'];
        $params[] = $data['token'];

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
     * Insert a new user
     *
     * @param  Arr     $database New user's  data
     *
     * @return boolean           True if a new user created,false 
     */
    public function getQueueNumberByCompanyId($company_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
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
     * Get Subscriber
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function getSubscriberByUserAndCompany($data)
    {
        $db=$this->db;

        $sql = "
            SELECT
                queue_number
            FROM
                users_companies
            WHERE
                user_id = ?
            AND 
                company_id = ?";

        $params[] = $data['user_id'];
        $params[] = $data['company_id'];

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
     * Insert user in queue
     * 
     * @param aee $data 
     * 
     * @return aee
     */
    public function subscribeUserOnQueue($data)
    {
        $db=$this->db;

        $sql = "
            INSERT INTO
                users_companies
                    (user_id,
                    company_id,
                    queue_number)
            VALUES
                (?, ?, ?)";

        $params[] = $data['user_id'];
        $params[] = $data['company_id'];
        $params[] = $data['queue_number'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $db->lastInsertId();
    }


    public function updateCompanyQueue($data)
    {
        $db=$this->db;

        $sql = "
            UPDATE
                companies
            SET
                current_queue_number = ?,
                current_queued_user_id = ?
            WHERE
                company_id = ?";

        $params[] = $data['queue_number'];
        $params[] = $data['user_id'];
        $params[] = $data['company_id'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return  $query->rowCount();
    }


    /**
     * Get company by token an company id
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function getCompanyByTokenAndCompanyId($data)
    {
        $db=$this->db;

        $sql = "
            SELECT
                company_id
            FROM
                oauth_companies
            WHERE
                company_id = ?
            AND
                token = ?";

        $params[] = $data['company_id'];
        $params[] = $data['token'];

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
     * Get first queued user
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function getCurrentQueuedUserByCompanyId($company_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
                current_queued_user_id,
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
     * Remove user from company's queue
     * 
     * @param arr $data 
     * 
     * @return arr
     */
    public function removeQueuedUserByCompanyIdAndUserId($data)
    {
        $db=$this->db;

        $sql = "
            DELETE FROM
                users_companies 
            WHERE
                company_id = ?
            AND
                user_id = ?
            AND
                queue_number = ?";

        $params[] = $data['company_id'];
        $params[] = $data['user_id'];
        $params[] = $data['queue_number'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $query->rowCount();
    }

    /**
     * Get first queued user for a company
     */
    public function getFirstQueuedUserByCompanyId($company_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
               user_id,
               queue_number
            FROM
               users_companies 
            WHERE
               company_id = ?
            AND
               queue_number IN (
                   SELECT
                    MIN(queue_number)
                   FROM
                    users_companies
               )";

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
     * Get all queues for a user
     * 
     * @param int $user_id 
     * 
     * @return arr
     */
    public function getAllQueuesForAUser($user_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
                c.name,
                c.address,
                c.current_queue_number,
                uc.user_id,
                uc.queue_number
            FROM
                users_companies AS uc
            INNER JOIN 
                companies AS c
            ON 
                uc.company_id = c.company_id
            WHERE
               user_id = ?";

        $params[] = $user_id;

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
     * Get all queued users for a company
     * 
     * @param  int $company_id 
     * 
     * @return arr
     */
    public function getAllQueuedUsersForACompany($company_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
                u.first_name,
                u.last_name,
                u.email,
                uc.queue_number
            FROM
                users_companies AS uc
            INNER JOIN 
                users AS u
            ON 
                uc.user_id = u.user_id
            WHERE
               company_id = ?";

        $params[] = $company_id;

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
}
