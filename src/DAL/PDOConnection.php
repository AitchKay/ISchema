<?php
namespace AitchKay\ISchema\DAL;


use PDO;

class PDOConnection implements PDOInterface
{

    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private $dsn;
    private $pdo;

    public function __construct($driver, $host, $database, $user, $password)
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->setDsn();
        $this->setPdo();

    }

    /**
     *
     */
    private function setDsn()
    {
        if($this->driver=='sqlsrv') $this->dsn ="dblib:host=".$this->host.':1433'. ';dbname=' . $this->database.";charset=utf8";
        else
        $this->dsn = $this->driver . ':dbname=' . $this->database . ";host=" . $this->host;


    }

    public function getPdo()
    {
        return $this->pdo;
    }

    protected function setPdo()
    {

        $this->pdo = new PDO($this->getDsn(), $this->user, $this->password);

    }

    /**
     * @return string
     */
    private function getDsn()
    {
        return $this->dsn;
    }

    public function getDriver(){
        return $this->driver;
    }
}