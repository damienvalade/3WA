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
        $this->model = new TweetModel($this->db);
        $this->controller = new TweetController($this->model);
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

        $data = $this->model->findByContent('Le contenue de fou');

        $this->assertCount(1, $data);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }

    public function testDeleteTweet()
    {
        $this->db->query('INSERT INTO tweet SET author = "Lior", content = "Mon tweet de test", published_at = NOW()');
        $id = $this->db->lastInsertId();

        $request = new Request([
            'id' => $id
        ]);

        $response = $this->controller->deleteTweet($request);

        $query = $this->db->prepare('SELECT t.* FROM tweet t WHERE id = :id');
        $query->execute([
            "id" => $id
        ]);
        $this->assertEquals(0, $query->rowCount());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }
}