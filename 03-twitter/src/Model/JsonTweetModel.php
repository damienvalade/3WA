<?php


namespace Twitter\Model;


use Jajo\JSONDB;

class JsonTweetModel
{
    protected JSONDB $jsonDb;

    public function __Construct(JSONDB $jsonDb){
        $this->jsonDb = $jsonDb;
    }

    public function findAll(): array
    {
        return $this->jsonDb->select( '*' )
            ->from('tweet.json')
            ->get();
    }
}