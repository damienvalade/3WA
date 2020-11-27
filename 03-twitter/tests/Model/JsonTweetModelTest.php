<?php


use Jajo\JSONDB;
use PHPUnit\Framework\TestCase;
use Twitter\Model\JsonTweetModel;

class JsonTweetModelTest extends TestCase
{
    public function testFindAllTweets()
    {
        $json_db = new JSONDB( __DIR__ . '/../../json' );

        $json_db->delete()
            ->from('tweet.json')
            ->trigger();

        $json_db->insert( 'tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Lior',
                'content' => 'Mon tweet de test',
                'published_at' => new \DateTime()
            ]
        );
        $json_db->insert( 'tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Magalie',
                'content' => 'Un autre tweet',
                'published_at' => new \DateTime()
            ]
        );
        $json_db->insert( 'tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Elise',
                'content' => 'Autre tweet encore',
                'published_at' => new \DateTime()
            ]
        );

        $model = new JsonTweetModel($json_db);
        $resultTweet = $model->findAll();

        $this->assertIsArray($resultTweet);
        $this->assertCount('3',$resultTweet);
    }
}