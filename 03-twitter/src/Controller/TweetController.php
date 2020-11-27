<?php


namespace Twitter\Controller;

use Twitter\Http\Request;
use Twitter\Http\Response;
use Twitter\Model\JsonTweetModel;
use Twitter\Model\TweetModel;

class TweetController extends Controller
{
    protected JsonTweetModel $model;

    public function __Construct(
        JsonTweetModel $model
    ){
        $this->model = $model;
    }

    /**
     * @return Response
     */
    public function listTweets(): Response
    {
        return $this->render('tweet/list.html.php', [
            "tweets" => $this->model->findAll(),
            "firstname" => "Damien"
        ]);
    }

    public function getForm(): Response
    {
        return $this->render('tweet/form.html.php');
    }

    public function saveTweet(Request $request): Response
    {
        $this->model->insert('Damien', $request->get('content'));
        return $this->redirect('/');
    }

    public function deleteTweet(Request $request): Response
    {
        $this->model->delete($request->get('id'));
        return $this->redirect('/');
    }
}