<?php


use PHPUnit\Framework\TestCase;
use Test\PDOFactory;
use Twitter\Model\LogTweetModel;
use Twitter\Model\TweetModel;

class TweetModelTest extends TestCase
{
    public function testSelectAll()
    {
        $db = PDOFactory::getPdo();

        $db->query('DELETE FROM tweet');

        $db->query('INSERT INTO tweet SET author = "Lior", content = "Mon tweet de test", published_at = NOW()');
        $db->query('INSERT INTO tweet SET author = "Magalie", content = "Un autre tweet", published_at = NOW()');
        $db->query('INSERT INTO tweet SET author = "Elise", content = "Autre tweet encore", published_at = NOW()');

        $modelTweet = new TweetModel($db);
        $resultTweet = $modelTweet->findAll();

        $this->assertIsArray($resultTweet);
        $this->assertCount('3',$resultTweet);

        $modelLog = new LogTweetModel($db);
        $resultLog = $modelLog->findAll();

        $this->assertIsArray($resultLog);
        $this->assertCount('3',$resultLog);
    }
}