<?php


use Jajo\JSONDB;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Test\PDOFactory;
use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Model\JsonTweetModel;
use Twitter\Model\TweetModel;
use Twitter\Model\TweetModelInterface;

class TweetControllerTest extends TestCase
{
    protected PDO $db;
    protected TweetModelInterface $model;
    protected TweetController $controller;

    public function setUp(): void
    {
        $this->db = PDOFactory::getPdo();
        //$this->db = new JSONDB(__DIR__ . '/../../json');

        $this->db->query('DELETE FROM tweet');
        /*$this->db->delete()
            ->from('tweet.json')
            ->trigger();
        */

        $this->model = new TweetModel($this->db);
        $this->controller = new TweetController($this->model);
        //$this->model = new JsonTweetModel($this->db);
        //$this->controller = new TweetController($this->model);
    }

    public function testAccessListTweets()
    {
        $this->model->insert('Lior','Mon tweet de test');
        $this->model->insert('Magalie','Un autre tweet');
        $this->model->insert('Elise','Autre tweet encore');

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

        $response = $this->controller->saveTweet($request);

        $tweet = $this->model->findByContent('Le contenue de fou');

        $this->assertIsObject($tweet);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }

    public function testDeleteTweet()
    {
        $id = $this->model->insert("Lior", "Mon tweet de test");

        $request = new Request([
            'id' => $id
        ]);

        $response = $this->controller->deleteTweet($request);

        $query = $this->model->findById($id);
        $this->assertFalse($query);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }
}