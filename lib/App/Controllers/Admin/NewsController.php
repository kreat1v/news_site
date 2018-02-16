<?php

namespace App\Controllers\Admin;

use \App\Entity\Category;
use \App\Entity\News;
use \App\Entity\Tags;
use \App\Entity\NewsTag;
use \App\Core\App;
use \App\Core\Config;

class NewsController extends \App\Controllers\Base
{
	/** @var Category */
	private $categoryModel;
	private $newsModel;
	private $tagsModel;
	private $newsTagModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
		$this->newsModel = new News(App::getConnection());
		$this->tagsModel = new Tags(App::getConnection());
		$this->newsTagModel = new NewsTag(App::getConnection());
	}

	public function indexAction()
	{
		$count = count($this->newsModel->list());
		$this->data = $this->newsModel->getSection($count, 0);
	}

	public function editAction()
	{
		$this->data['categoryList'] = $this->categoryModel->list();
		$this->data['tagsList'] = $this->tagsModel->list();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = isset($this->params[0]) ? $this->params[0] : null;

				$this->data['news'] = [
					'id_category' => $_POST['id_category'],
					'title' => $_POST['title'],
					'analytics' => empty($_POST['analytics']) ? 0 : 1,
					'content' => $_POST['content'],
					'date' => date('Y-m-d H:i:s'),
					'new' => true
				];
				$this->newsModel->save($this->data['news'], $id);

				if (!$id) {
					$id = $this->newsModel->getSection(1, 0)[0]['id'];
				}

				$this->data['tags'] = $_POST['tags'];
				$this->newsTagModel->saveTags($this->data['tags'], $id);

				if ($_FILES['images']['error'][0] == 0) {
					$news = $this->newsModel->getBy('id', $id);
					$nameDir = isset($news[0]['img_dir']) ? $news[0]['img_dir'] : null;

					if (!isset($nameDir)) {
						$nameDir = date('U');
						$this->saveImages($_FILES['images'], $nameDir);
						$this->newsModel->save(['img_dir' => "$nameDir"], $id);
					} else {
						$this->saveImages($_FILES['images'], $nameDir);
					}
				}

				App::getSession()->addFlash('News has been saved');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}

		if (isset($this->params[0]) && $this->params[0] > 0) {
			$newsId = $this->params[0];
			$news = $this->newsModel->getBy('id', $newsId);

			$images = array_values(array_diff(scandir(Config::get('gallery') . $news['img_dir']), ['.', '..']));
			$this->data['gallery'] = $images;

			$newsTag = $this->newsTagModel->list(['id_news' => $newsId]);
			$tagsId = '';
			foreach ($newsTag as $value) {
				$tagsId .= $value['id_tags'];
				$tagsId .= ', ';
			}
			$tagsId = trim($tagsId, ', ');

			$tags = $this->tagsModel->getTags($tagsId);

			$this->data['news'] = $news;
			$this->data['tags'] = $tags;
		}
	}

	private function reArrayFiles($file_post)
	{
		$file_ary = [];
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i < $file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
	}

	private function saveImages(array $images, $nameDir)
	{
		try {
			$files = $this->reArrayFiles($images);

			if (!file_exists(Config::get('gallery') . $nameDir)) {
				mkdir(Config::get('gallery') . $nameDir, 0777);
			}

			foreach ($files as $key => $value) {
				if (!file_exists($files[$key]['tmp_name'])) {
					throw new \Exception('Images are not downloaded!');
				}

				if ($files[$key]['size'] > 1024 * 3 * 1024) {
					throw new \Exception('The file exceeds 3 megabytes.');
				}

				if (strcmp(substr($files[$key]['type'], 0, 6), 'image/') != 0) {
					throw new \Exception('You are trying to download an image!');
				}

				$file_type = pathinfo($files[$key]['name'], PATHINFO_EXTENSION);
				$file_path = $nameDir . DS . uniqid('img_') . '.' . $file_type;

				if (!move_uploaded_file($files[$key]['tmp_name'], Config::get('gallery') . $file_path)) {
					throw new \Exception('Images are not downloaded!');
				}
			}
		} catch (\Exception $exception) {
			rmdir(Config::get('gallery').$nameDir);
			App::getSession()->addFlash($exception->getMessage());
		}
	}

//	public function deleteImageAction()
//	{
//		$id = isset($this->params[0]) ? $this->params[0] : null;
//		$idImg = isset($this->params[1]) ? $this->params[1] : null;
//
//		if (!$id) {
//			App::getSession()->addFlash('Missing news id');
//		} else {
//			$news = $this->newsModel->getBy('id', $id);
//			$images = array_values(array_diff(scandir(Config::get('gallery') . $news['img_dir']), ['.', '..']));
//
//			foreach ($images as $key => $img) {
//				if ($key == $idImg) {
//					unlink(Config::get('gallery') . $news['img_dir'] . DS . $img);
//				}
//			}
//
//		}
//		App::getRouter()->redirect(App::getRouter()->buildUri('news.edit',[$id]));
//	}
}