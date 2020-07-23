<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 15:35
 */

/**
 * Database connection
 */
namespace App\Model;

use \PDO;

class Connection
{
    /**
     * @var PDO
     *
     * @access private
     */
    private $pdoConnection;

    private $user;

    private $host;

    private $password;

    private $dbName;

    /**
     * Initialize
     *
     * @access public
     */
    public function __construct()
    {
            $this->user = DB_USER;
            $this->host = DB_HOST;
            $this->password = DB_PWD;
            $this->dbName = DB_NAME;
        try {
            $this->pdoConnection = new PDO(
                'mysql:host=' . $this->host . '; dbname=' . $this->dbName . '; charset=utf8',
                $this->user,
                $this->password
            );
            $this->pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // show errors in DEV environment
            if (APP_DEV) {
                $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            echo('<div class="error">Error !: ' . $e->getMessage() . '</div>');
        }
    }


    /**
     * @return PDO $pdo
     */
    public function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }
}
