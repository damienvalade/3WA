<?php


use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Twitter\Controller\TweetController;

class TweetControllerTest extends TestCase
{
    public function testAccessListTweets()
    {
        $db = new PDO('mysql:host=localhost;dbname=twitter_test', 'root', '',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $db->query('DELETE FROM tweet');

        $db->query('INSERT INTO tweet SET author = "Lior", content = "Mon tweet de test", published_at = NOW()');
        $db->query('INSERT INTO tweet SET author = "Magalie", content = "Un autre tweet", published_at = NOW()');
        $db->query('INSERT INTO tweet SET author = "Elise", content = "Autre tweet encore", published_at = NOW()');

        $controller = new TweetController($db);
        $response = $controller->listTweets();

        $this->assertStringContainsString('<ul>', $response->getContent());

        $crawler = new Crawler($response->getContent());
        $count = $crawler->filter('li')->count();
        $this->assertEquals(3, $count);

        $this->assertStringContainsString('Mon tweet de test', $response->getContent());
        $this->assertStringContainsString('Un autre tweet', $response->getContent());
        $this->assertStringContainsString('Autre tweet encore', $response->getContent());

        $db->query('DELETE FROM tweet');
    }
}