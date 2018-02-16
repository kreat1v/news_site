<?php

namespace App\Controllers;

use \App\Entity\Category;
use \App\Entity\News;
use \App\Entity\Tags;
use \App\Entity\NewsTag;
use \App\Entity\Comments;
use \App\Core\App;
use \App\Core\Pagination;
use \App\Core\Config;

class SearchController extends Base

{
	/** @var Category */
	private $categoryModel;
	private $newsModel;
	private $tagsModel;
	private $newsTagModel;
	private $commentsModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->tagsModel = new Tags(App::getConnection());
		$this->newsTagModel = new NewsTag(App::getConnection());
		$this->commentsModel = new Comments(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->newsModel->list(['active' => 1]);
	}

	public function tagsAction()
	{
		$tags = $this->tagsModel->getBy('title', $this->params[0]);

		$page = $this->params[1];
		$tagsId = $tags['id'];
		$newsTag = $this->newsTagModel->list(['id_tags' => "$tagsId"]);
		$newsCount = count($newsTag);

		$pag = new Pagination();
		$pagination = $pag->getLinks(
			$newsCount,
			Config::get('pagLimit'),
			$page,
			Config::get('pagButtonLimit'));
		if (!empty($pagination)) {
			$this->data['pagination'] = $pagination;
		} else {
			$this->data['pagination'] = null;
		}
		$offset = $this->data['pagination'] ? $pagination['middle'][$page] : 0;

		$newsId = '';
		foreach ($newsTag as $value) {
			$newsId .= $value['id_news'];
			$newsId .= ', ';
		}
		$newsId = trim($newsId, ', ');

		$news = $this->newsModel->getNews(
			$newsId,
			Config::get('pagLimit'),
			$offset);

		if (!empty($news && $page != 0)) {
			$this->data['news'] = $news;
			$this->data['tags'] = $tags;
		} else {
			$this->page404();
		}
	}

	public function searchTagsAction()
	{
		$queryString = $_GET['term'];

		if (strlen($queryString) > 0) {
			$tags = $this->tagsModel->list();

			$arrayTags = array_column($tags, 'title');

			$newTags = [];
			foreach ($arrayTags as $value) {
				$pos = strpos($value, $queryString);
				if ($pos !== false) {
					$newTags[] = $value;
				}
			}

			echo json_encode($newTags);
			die();
		}

		echo null;
		die();
	}

	public function usersAction()
	{
		$page = $this->params[1];
		$userId = $this->params[0];
		$comments = $this->commentsModel->getComments('id_user', $userId);
		$commentsCount = count($comments);

		$pag = new Pagination();
		$pagination = $pag->getLinks(
			$commentsCount,
			Config::get('pagLimit'),
			$page,
			Config::get('pagButtonLimit'));
		if (!empty($pagination)) {
			$this->data['pagination'] = $pagination;
		} else {
			$this->data['pagination'] = null;
		}
		$offset = $this->data['pagination'] ? $pagination['middle'][$page] : 0;

		$commentsSection = $this->commentsModel->getSection(Config::get('pagLimit'), $offset, $userId, 'date');

		if (!empty($commentsSection && $page != 0)) {
			$this->data['userComments'] = $comments[0];
			$this->data['commentsSection'] = $commentsSection;
		} else {
			$this->page404();
		}
	}

	public function filterAction()
	{
		$this->data['category'] = $this->categoryModel->list();
		$this->data['tags'] = $this->tagsModel->list();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data['data'] = [
					'dateFrom' => isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '',
					'dateTo' => isset($_POST['dateTo']) ? $_POST['dateTo'] : '',
					'tags' => isset($_POST['tags']) ? $_POST['tags'] : '',
					'category' => isset($_POST['category']) ? $_POST['category'] : ''
				];

				$this->data['result'] = $this->newsModel->filter($this->data['data']);

			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}
}