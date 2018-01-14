<?php
namespace src\User\model;

use Silex\Application;
use Doctrine\DBAL;

/**
 * Collection of User datbase queries
 */
class UserModel
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
     * Get all users by user id
     * 
     * @param int $user_id 
     * 
     * @return arr
     */
    public function getUserByUserId($user_id)
    {
        $db=$this->db;

        $sql = "
            SELECT
                first_name,
                last_name,
                email
            FROM
                users
            WHERE
                user_id = ?";

        $params[] = $user_id;

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
    public function createNewUser($data)
    {
        $db=$this->db;

        $sql = "
            INSERT INTO
                users
                    (username,
                    password,
                    first_name,
                    last_name,
                    email)
            VALUES
                (?, ?, ?, ?, ?)";

        $params[] = $data['username'];
        $params[] = $data['password'];
        $params[] = $data['first_name'];
        $params[] = $data['last_name'];
        $params[] = $data['email'];

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $db->lastInsertId();
    }


    /**
     * Insert user token
     * 
     * @param str $token   
     * @param int $user_id 
     * 
     * @return mix 
     */
    public function insertUserToken($token, $user_id)
    {
        $db=$this->db;

        $sql = "
            INSERT INTO
                oauth_users (token, user_id)
            VALUES
                (?, ?)
            ON DUPLICATE KEY UPDATE
                token = ?";

        $params[] = $token;
        $params[] = $user_id;
        $params[] = $token;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $db->lastInsertId();
    }


    /**
     * Get user by username ad password
     * 
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function getUsersByUsernameAndPassword($data)
    {
        $db=$this->db;

        $sql = "
            SELECT
                user_id
            FROM
                users
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
     * Delete user token
     * 
     * @param arr $data 
     *  
     * @return arr
     */
    public function deleteUserOauthToken($token, $user_id)
    {
        $db=$this->db;

        $sql = "
            DELETE FROM
                oauth_users 
            WHERE
                token = ?
            AND
                user_id = ?";

        $params[] = $token;
        $params[] = $user_id;

        $query = $db->prepare($sql);
        if ($query->execute($params) === false) {
            return false;
        }

        return $query->rowCount();
    }
}
