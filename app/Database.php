<?php


class Database
{
    private $connection;

    /**
     * @var mysqli
     */

    public function connect(string $host, string $username, string $password, string $database)
    {
        $this-> connection = mysqli_connect($host, $username, $password, $database);
        if (!$this->connection) {
            die(mysqli_connect_error());
        }
        if (!mysqli_set_charset($this->connection, 'utf8')) {
            die(mysqli_connect_error($this->connection));
        }
    }

    public function query(string $sql)//: mysqli_result
    {
        $resultSet = mysqli_query($this->connection, $sql);
        if (!$resultSet) {
            die(mysqli_error($this->connection));
        }
        return $resultSet;
    }

    public function fetch(mysqli_result $resultSet): ?array
    {
        return mysqli_fetch_assoc($resultSet);
    }

    public function close()
    {
        mysqli_close($this->connection);
    }

}