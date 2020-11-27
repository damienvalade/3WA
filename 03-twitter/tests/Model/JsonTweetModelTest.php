<?php


use Jajo\JSONDB;
use PHPUnit\Framework\TestCase;
use Twitter\Model\JsonTweetModel;

class JsonTweetModelTest extends TestCase
{
    private JSONDB $jsonDB;
    private JsonTweetModel $model;

    public function setUp(): void
    {
        $this->jsonDB = new JSONDB(__DIR__ . '/../../json');

        $this->jsonDB->delete()
            ->from('tweet.json')
            ->trigger();

        $this->model = new JsonTweetModel($this->jsonDB);
    }

    public function testFindAllTweets()
    {
        $this->jsonDB->insert('tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Lior',
                'content' => 'Mon tweet de test',
                'published_at' => new DateTime()
            ]
        );
        $this->jsonDB->insert('tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Magalie',
                'content' => 'Un autre tweet',
                'published_at' => new DateTime()
            ]
        );
        $this->jsonDB->insert('tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Elise',
                'content' => 'Autre tweet encore',
                'published_at' => new DateTime()
            ]
        );

        $model = new JsonTweetModel($this->jsonDB);
        $resultTweet = $model->findAll();

        $this->assertIsArray($resultTweet);
        $this->assertCount('3', $resultTweet);
    }

    public function testInsert()
    {
        $id = $this->model->insert('Damien', 'Mon super tweet');
        $this->assertNotNull($id);

        $tweet = $this->jsonDB->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();
        $this->assertIsArray($tweet);
        $this->assertEquals('Damien', $tweet[0]['author']);
        $this->assertEquals('Mon super tweet', $tweet[0]['content']);
    }

    public function testSelectById()
    {
        $id = uniqid();
        $this->jsonDB->insert('tweet.json',
            [
                'id' => $id,
                'author' => 'Damien',
                'content' => 'Mon super tweet',
                'published_at' => new DateTime()
            ]
        );
        $tweet = $this->model->findById($id);
        $this->assertIsObject($tweet);
        $this->assertEquals('Damien', $tweet->author);
        $this->assertEquals('Mon super tweet', $tweet->content);
    }

    public function testRemoveTweet()
    {
        $id = uniqid();
        $this->jsonDB->insert('tweet.json',
            [
                'id' => $id,
                'author' => 'Damien',
                'content' => 'Mon super tweet',
                'published_at' => new DateTime()
            ]
        );

        $this->model->delete($id);

        $tweets = $this->jsonDB
            ->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();

        $this->assertCount(0, $tweets);
    }

    public function testFindByContentTweet()
    {
        $content = 'Mon super tweet';

        $this->jsonDB->insert('tweet.json',
            [
                'id' => uniqid(),
                'author' => 'Damien',
                'content' => $content,
                'published_at' => new DateTime()
            ]
        );

        $tweet = $this->model->findByContent($content);
        $this->assertIsObject($tweet);
        $this->assertEquals('Damien', $tweet->author);
        $this->assertEquals('Mon super tweet', $tweet->content);
    }
}