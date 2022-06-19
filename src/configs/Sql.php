<?php

namespace CriminalOccurence\configs;

/**
 * Sql.
 *
 * Data access object.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 */

use PDO;

class Sql
{
    public function __construct(
        protected ?PDO $connection = null
    ) {
        $this->connection = new \PDO(
            "mysql:dbname=" . strval($_ENV["DBNAME"]) . ";host=" . strval($_ENV["HOST"]),
            strval($_ENV["USER"]),
            strval($_ENV["PASSWORD"]),
            [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
        );
    }

    private function setParams($statement, $params = [])
    {
        foreach ($params as $key => $value) {
            // dynamic bind parans
            $this->bindParams($statement, $key, $value);
        }
    }

    private function bindParams($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params = [])
    {
        $stmt = $this->connection->prepare($rawQuery);
        $this->setParams($stmt, $params);

        return $stmt->execute();
    }

    public function select($rawQuery, $params = [])
    {
        $stmt = $this->connection->prepare($rawQuery);
        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}
