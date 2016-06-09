<?php
namespace AitchKay\ISchema\DAL;


use PDO;

class PDOWrapper
{
    private $connection;
    private $statement;


    /**
     * ISchema constructor.
     * @param \PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->setConnection($connection);


    }

    //todo refactor to getPDO

    private function setConnection($connection)
    {
        $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->connection = $connection;
    }

    public function query($query)
    {
        $this->statement = $this->getConnection()->query($query);
        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function fetchColumn()
    {
        if ($this->getStatement()) return $this->getStatement()->fetchColumn();
    }

    public function getStatement()
    {
        return $this->statement;
    }

    public function fetchAllAssoc()
    {
        if ($this->getStatement()) return $this->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAll($fetch_type, $fetch_arg = null)
    {
        $statement = $this->getStatement();
        if ($statement) {
            $result = is_null($fetch_arg) ?
                $statement->fetchAll($fetch_type) :
                $statement->fetchAll($fetch_type, $fetch_arg);
            return $result;
        }
    }

    public function fetchAllClass($class)
    {
        if ($this->getStatement()) return $this->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function fetchValue()
    {
        if ($this->getStatement()) return $this->fetch(PDO::FETCH_COLUMN, 0);
    }

    public function fetch($fetch_type, $cursor = null)
    {
        if ($this->getStatement()) return $this->getStatement()->fetch($fetch_type, $cursor);
    }

    public function fetchAssoc()
    {
        if ($this->getStatement()) return $this->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchClass($class)
    {
        if ($this->getStatement()) {

            $this->getStatement()->setFetchMode(PDO::FETCH_CLASS, $class);
            return $this->fetch(PDO::FETCH_CLASS);
        }
    }

    public function lists()
    {
        if ($this->getStatement()) return $this->fetchAll(PDO::FETCH_COLUMN, 0);
    }


}