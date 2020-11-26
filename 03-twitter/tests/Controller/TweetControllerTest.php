<?php


use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Test\PDOFactory;
use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Model\TweetModel;

class TweetControllerTest extends TestCase
{
    protected PDO $db;
    protected TweetModel $model;
    protected TweetController $controller;

    public function setUp(): void
    {
        $this->db = PDOFactory::getPdo();
        $this->db->query('DELETE FROM tweet');
        $this->model= new TweetModel($this->db);
        $this->controller = new TweetController($this->model);
    }

    public function testAccessListTweets()
    {
        $this->db->query('INSERT INTO tweet SET author = "Lior", content = "Mon tweet de test", published_at = NOW()');
        $this->db->query('INSERT INTO tweet SET author = "Magalie", content = "Un autre tweet", published_at = NOW()');
        $this->db->query('INSERT INTO tweet SET author = "Elise", content = "Autre tweet encore", published_at = NOW()');

        $response = $this->controller->listTweets();

        $this->assertStringContainsString('<ul>', $response->getContent());

        $crawler = new Crawler($response->getContent());
        $count = $crawler->filter('li')->count();

        $this->assertEquals(3, $count);

        $this->assertStringContainsString('Mon tweet de test', $response->getContent());
        $this->assertStringContainsString('Un autre tweet', $response->getContent());
        $this->assertStringContainsString('Autre tweet encore', $response->getContent());
    }

    public function testTweetForm()
    {
        $response = $this->controller->getForm();

        $crawler = new Crawler($response->getContent());

        $form = $crawler->filter('form');
        $this->assertEquals('save.php', $form->attr('action'));
        $this->assertEquals('post', $form->attr('method'));

        $count = $form->count();
        $this->assertEquals(1, $count);

        $count = $crawler->filter('textarea')->count();
        $this->assertEquals(1, $count);
    }

    public function testAddTweetFromForm()
    {
        $request = new Request([
            "content" => "Le contenue de fou"
        ]);

        $this->controller->saveTweet($request);

        $dbRequest = $this->db->prepare('SELECT t.* FROM tweet t WHERE content = :content');
        $dbRequest->execute([
           "content" => "Le contenue de fou"
        ]);

        $this->assertEquals(1, $dbRequest->rowCount());
    }
}