<?php

namespace Twitter\Model;

use PDO;

class TweetModel
{
    protected PDO $db;

    public function __Construct(PDO $db){
        $this->db = $db;
    }

    public function findAll(): array
    {

        return $this->db
            ->query("SELECT t.* FROM tweet t")
            ->fetchAll();
    }
}