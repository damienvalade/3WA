<?php


namespace Twitter\Controller;

use PDO;
use Twitter\Http\Request;
use Twitter\Http\Response;
use Twitter\Model\TweetModel;

class TweetController
{
    protected TweetModel $model;

    public function __Construct(
        TweetModel $model
    ){
        $this->model = $model;
    }

    /**
     * @return Response
     */
    public function listTweets(): Response
    {
        $tweets = $this->model->findAll();

        ob_start();
        require_once(__DIR__ .'/../../templates/tweet/list.html.php');
        $result = ob_get_clean();

        return new Response($result);
    }

    public function getForm(): Response
    {
        ob_start();
        require_once(__DIR__ .'/../../templates/tweet/form.html.php');
        $result = ob_get_clean();

        return new Response($result);
    }

    public function saveTweet(Request $request): Response
    {
        $content = $request->get('content');
        $this->model->insert('Damien', $content);
        return new Response();
    }
}