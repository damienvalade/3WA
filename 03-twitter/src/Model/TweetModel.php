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

    public function findByContent($content)
    {
        $dbRequest = $this->db->prepare('SELECT t.* FROM tweet t WHERE content = :content');
        $dbRequest->execute([
            "content" => $content
        ]);
        return $dbRequest->fetchAll();
    }

    public function insert(string $author, string $content)
    {
        $query = $this->db->prepare('INSERT INTO tweet SET author = :author, content = :content, published_at = NOW()');
        $query->execute([
            "author" => $author,
            "content" => $content
        ]);
    }

    public function delete(int $id)
    {
        $query = $this->db->prepare('DELETE FROM tweet WHERE id = :id');
        $query->execute([
            "id" => $id
        ]);
    }
}