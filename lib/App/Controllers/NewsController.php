<?php

namespace App\Controllers;

use \App\Entity\Category;
use \App\Entity\Comments;
use \App\Entity\Answers;
use \App\Entity\Vote;
use \App\Entity\News;
use \App\Entity\Tags;
use \App\Entity\NewsTag;
use \App\Core\App;
use \App\Core\Config;

class NewsController extends Base

{
	/** @var Category */
	private $categoryModel;
	private $newsModel;
	private $tagsModel;
	private $newsTagModel;
	private $commentsModel;
	private $answersModel;
	private $voteModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->tagsModel = new Tags(App::getConnection());
		$this->newsTagModel = new NewsTag(App::getConnection());
		$this->commentsModel = new Comments(App::getConnection());
		$this->answersModel = new Answers(App::getConnection());
		$this->voteModel = new Vote(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->newsModel->list();
	}

	public function viewAction()
	{
		$newsId = $this->params[0];

		// получение новости
		$news = $this->newsModel->getBy('id', $newsId);

		// проверка - аналитическая статья, или нет
		if ($news['analytics'] == 1 && !App::getSession()->get('id')) {
			$arrContent = explode('. ', $news['content']);
			$content = [];
			for ($i = 0; $i < 5; $i++) {
				$content[] = $arrContent[$i];
			}
			$content = implode('. ', $content);

			if (!empty($news)) {
				$this->data['news']['title'] = $news['title'];
				$this->data['news']['content'] = $content . '.';
				$this->data['news']['analytics'] = $news['analytics'];
			}
		} else {
			// получение категории
			$category = $this->categoryModel->getBy('id', $news['id_category']);

			// получение изображений
			$images = array_values(array_diff(scandir(Config::get('gallery') . $news['img_dir']), ['.', '..']));

			// получение тэгов
			$newsTag = $this->newsTagModel->list(['id_news' => "$newsId"]);
			$tagsId = '';
			foreach ($newsTag as $value) {
				$tagsId .= $value['id_tags'];
				$tagsId .= ', ';
			}
			$tagsId = trim($tagsId, ', ');
			$tags = $this->tagsModel->getTags($tagsId);

			// просмотры новости
			$nowWatching = rand(0, 5);
			$allWathching = $news['views'] + $nowWatching;
			$this->newsModel->save(['views' => $allWathching], $newsId);

			// комментарии
			$comments = $this->commentsModel->getComments('id_news', $newsId);
			$answers = $this->answersModel->getAnswers($newsId);
			$vote = $this->voteModel->getVote(App::getSession()->get('id'), $newsId);

			// то, что отдаем
			if (!empty($news)) {
				$this->data['news'] = $news;
				$this->data['gallery'] = $images;
				$this->data['tags'] = $tags;
				$this->data['nowWatching'] = $nowWatching;
				$this->data['category'] = $category;
				$this->data['comments'] = $comments;
				$this->data['answers'] = $answers;
				$this->data['vote'] = $vote;
			} else {
				$this->page404();
			}
		}
	}
}

