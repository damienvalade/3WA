<?php


namespace Twitter\Controller;

use PDO;
use Twitter\Http\Response;

class TweetController
{
    protected PDO $dh;

    public function __Construct(PDO $dh){
        $this->dh = $dh;
    }

    /**
     * @return Response
     */
    public function listTweets(): Response
    {
        $result = $this->dh->query("SELECT t.* FROM tweet t");
        $tweets = $result->fetchAll();

        ob_start();
        require_once(__DIR__ .'/../../templates/tweet/list.html.php');
        $result = ob_get_clean();

        return new Response($result);
    }
}