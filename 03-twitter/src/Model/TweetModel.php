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

    public function insert(string $author, string $content)
    {
        $request = $this->db->prepare('INSERT INTO tweet SET author = :author, content = :content, published_at = NOW()');
        $request->execute([
            "author" => $author,
            "content" => $content
        ]);
    }
}