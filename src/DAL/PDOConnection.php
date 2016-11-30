<?php
namespace AitchKay\ISchema\DAL;


class PDOConnection implements PDOInterface
{

    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private $dns;
    private $pdo;

    public function __construct($driver, $host, $database, $user, $password)
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->setDns();
        $this->setPdo();

    }

    /**
     *
     */
    private function setDns()
    {
        $this->dns = $this->driver . ':dbname=' . $this->database . ";host=" . $this->host;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    protected function setPdo()
    {
        $this->pdo = new \PDO($this->getDns(), $this->user, $this->password);

    }

    /**
     * @return string
     */
    private function getDns()
    {
        return $this->dns;
    }
}