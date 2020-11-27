<?php


namespace Twitter\Model;


use DateTime;
use Jajo\JSONDB;

class JsonTweetModel
{
    protected JSONDB $jsonDb;

    public function __Construct(JSONDB $jsonDb){
        $this->jsonDb = $jsonDb;
    }

    public function findAll()
    {
        return $this->jsonDb->select()
            ->from('tweet.json')
            ->get();
    }

    public function findById($id)
    {
        $tweets = $this->jsonDb->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();
        return isset($tweets[0]) ? (object) $tweets[0] : false;
    }

    public function findByContent($content)
    {
        $tweets = $this->jsonDb->select()
            ->from('tweet.json')
            ->where(['content' => $content])
            ->get();
        return isset($tweets[0]) ? (object) $tweets[0] : false;
    }

    public function insert(string $author, string $content)
    {
        $id = uniqid();

        $this->jsonDb->insert( 'tweet.json',
            [
                'id' => $id,
                'author' => $author,
                'content' => $content,
                'published_at' => new DateTime()
            ]
        );

        return $id;
    }

    public function delete($id)
    {
        $this->jsonDb
            ->delete()
            ->where(['id' => $id])
            ->trigger();
    }
}