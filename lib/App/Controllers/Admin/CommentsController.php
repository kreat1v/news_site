<?php

namespace App\Controllers\Admin;

use \App\Entity\Category;
use \App\Entity\News;
use \App\Entity\Comments;
use \App\Entity\User;
use \App\Core\App;

class CommentsController extends \App\Controllers\Base
{
	private $categoryModel;
	private $newsModel;
	private $commentsModel;
	private $userModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->commentsModel = new Comments(App::getConnection());
		$this->userModel = new User(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->commentsModel->list(['active' => 1]);
	}

	public function moderationAction()
	{
		$this->data = $this->commentsModel->list(['active' => 0]);
	}

	public function editAction()
	{
		$id = isset($this->params[0]) ? $this->params[0] : null;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data['comments'] = [
					'messages' => $_POST['messages'],
					'active' => isset($_POST['active']) ? 1 : 0
				];
				$this->commentsModel->save($this->data['comments'], $id);

				App::getSession()->addFlash('Comments has been saved');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}

		$comments = $this->commentsModel->getBy('id', $id);
		$user = $this->userModel->getBy('id', $comments['id_user']);
		$news = $this->newsModel->getBy('id', $comments['id_news']);
		$category = $this->categoryModel->getBy('id', $news['id_category']);

		if (!empty($id)) {
			$this->data['category'] = $category;
			$this->data['user'] = $user;
			$this->data['comments'] = $comments;
		} else {
			$this->page404();
		}
	}
}