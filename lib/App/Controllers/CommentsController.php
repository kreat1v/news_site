<?php

namespace App\Controllers;

use \App\Entity\Category;
use \App\Entity\News;
use \App\Entity\Comments;
use \App\Entity\Answers;
use \App\Entity\Vote;
use \App\Core\App;

class CommentsController extends Base

{
	private $categoryModel;
	private $newsModel;
	private $commentsModel;
	private $answersModel;
	private $voteModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->commentsModel = new Comments(App::getConnection());
		$this->answersModel = new Answers(App::getConnection());
		$this->voteModel = new Vote(App::getConnection());
	}

	public function sendAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = isset($this->params[1]) ? $this->params[1] : null;

				$this->data = [
					'id_user' => App::getSession()->get('id'),
					'id_news' => $this->params[0],
					'date' => date('Y-m-d H:i:s'),
					'messages' => $_POST['messages'],
					'active' => 1
				];

				$news = $this->newsModel->getBy('id', $this->data['id_news']);
				$category = $this->categoryModel->getBy('id', $news['id_category']);

				if ($category['moderation'] == 1) {
					$this->data['active'] = 0;
				}

				$this->commentsModel->save($this->data, $id);

				if (isset($id)) {
					App::getSession()->addFlash('Your comment has been edited.');
				} else {
					if ($this->data['active'] != 0) {
						App::getSession()->addFlash('Thank you for your comment!');
					} else {
						App::getSession()->addFlash('Your comment will appear after approval of the moderator.');
					}
				}
				App::getRouter()->redirect(App::getRouter()->buildUri('news.view', [$this->params[0]]));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
				App::getRouter()->redirect(App::getRouter()->buildUri('news.view', [$this->params[0]]));
			}
		}
	}

	public function answersAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data = [
					'id_user' => App::getSession()->get('id'),
					'id_comments' => $this->params[1],
					'date' => date('Y-m-d H:i:s'),
					'messages' => $_POST['answers'],
				];

				$this->answersModel->save($this->data);
				App::getSession()->addFlash('Thank you for your comment!');
				App::getRouter()->redirect(App::getRouter()->buildUri('news.view', [$this->params[0]]));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
				App::getRouter()->redirect(App::getRouter()->buildUri('news.view', [$this->params[0]]));
			}
		}
	}

	public function voteAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$voteList = $this->voteModel->list(['id_user' => App::getSession()->get('id')]);

				foreach ($voteList as $vote) {
					if ($vote['id_comments'] == $_POST['id_comments']) {
						echo json_encode(['result' => 'warning', 'msg' => 'You already voted']);
						die();
					}
				}

				$this->data = [
					'id_comments' => $_POST['id_comments'],
					'id_user' => App::getSession()->get('id'),
					'mark' => $_POST['type']
				];
				$this->voteModel->save($this->data);

				if ($this->data['mark'] == 'like') {
					$rating = $this->commentsModel->getBy('id', $this->data['id_comments'])['rating'];
					$this->commentsModel->save(['rating' => $rating + 1], $this->data['id_comments']);
				}

				if ($this->data['mark'] == 'dislike') {
					$rating = $this->commentsModel->getBy('id', $this->data['id_comments'])['rating'];
					$this->commentsModel->save(['rating' => $rating - 1], $this->data['id_comments']);
				}

				echo json_encode(['result' => 'success']);
				die();
			} catch (\Exception $exception) {
				echo json_encode(['result' => 'error', 'msg' => $exception->getMessage()]);
				die();
			}
		}
	}
}