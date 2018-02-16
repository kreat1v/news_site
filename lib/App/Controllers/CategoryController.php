<?php

namespace App\Controllers;

use \App\Entity\Category;
use \App\Entity\News;
use \App\Entity\Comments;
use \App\Core\App;
use \App\Core\Pagination;
use \App\Core\Config;

class CategoryController extends Base

{
	/** @var Category */
	private $categoryModel;
	private $newsModel;
	private $commentsModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->commentsModel = new Comments(App::getConnection());
	}

	public function indexAction()
	{
		$this->data['carousel'] = $this->newsModel->getSection(5, 0);

		$this->data['category'] = $this->categoryModel->list();

		foreach ($this->data['category'] as $category) {
			if ($category['title'] == 'Analytics') {
				$this->data['news'][$category['id']] = $this->newsModel->getSection(5, 0, 'analytics', 1);
				continue;
			}

			$this->data['news'][$category['id']] = $this->newsModel->getSection(5, 0, 'id_category', $category['id']);
		}

		$this->data['topUser'] = $this->commentsModel->topUser();

		$this->data['topNews'] = $this->commentsModel->topNews();
	}

	public function viewAction()
	{
		$page = $this->params[1];
		$categoryId = $this->params[0];

		$category = $this->categoryModel->getBy('id', $categoryId);

		if ($category['title'] == 'Analytics') {
			$newsCount = count($this->newsModel->list(['analytics' => 1]));
		} else {
			$newsCount = count($this->newsModel->list(['id_category' => $categoryId]));
		}

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

		if ($category['title'] == 'Analytics') {
			$news = $this->newsModel->getSection(Config::get('pagLimit'), $offset, 'analytics', 1);
		} else {
			$news = $this->newsModel->getSection(Config::get('pagLimit'), $offset, 'id_category', $categoryId);
		}

		if (!empty($category) && !empty($news) && $page != 0) {
			$this->data['category'] = $category;
			$this->data['news'] = $news;
		} else {
			$this->page404();
		}
	}
}