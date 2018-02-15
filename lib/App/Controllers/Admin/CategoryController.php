<?php

namespace App\Controllers\Admin;

use \App\Entity\Category;
use \App\Core\App;

class CategoryController extends \App\Controllers\Base

{
	/** @var Category */
	private $categoryModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->categoryModel = new Category(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->categoryModel->list();
	}

	public function editAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = isset($this->params[0]) ? $this->params[0] : null;

				$this->data = [
					'title' => $_POST['title'],
					'moderation' => $_POST['moderation'],
					'new' => true
				];
				$this->categoryModel->save($this->data, $id);

				App::getSession()->addFlash('Category has been saved');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}

		if (isset($this->params[0]) && $this->params[0] > 0) {
			$this->data = $this->categoryModel->getBy('id', $this->params[0]);
		}
	}

	public function deleteAction()
	{
		$id = isset($this->params[0]) ? $this->params[0] : null;

		if (!$id) {
			App::getSession()->addFlash('Missing category id');
		} else {
			$this->categoryModel->delete($id);
			App::getSession()->addFlash('Category has been deleted');
		}

		App::getRouter()->redirect(App::getRouter()->buildUri('index'));
	}
}