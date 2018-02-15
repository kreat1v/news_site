<?php

namespace App\Controllers\Admin;

use \App\Entity\Ad;
use \App\Core\App;

class AdController extends \App\Controllers\Base

{
	private $adModel;

	public function __construct($params = [])
	{
		parent::__construct($params);

		$this->adModel = new Ad(App::getConnection());
	}

	public function leftAction()
	{
		$this->data = $this->adModel->list(['side' => 'left']);
	}

	public function rightAction()
	{
		$this->data = $this->adModel->list(['side' => 'right']);
	}

	public function getAdBody($side)
	{
		$this->data = $this->adModel->list(['side' => $side]);

		return $this->data;
	}

	public function editAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = isset($this->params[1]) ? $this->params[1] : null;

				$this->data = [
					'side' => $this->params[0],
					'title' => $_POST['title'],
					'price' => $_POST['price'],
					'content' => $_POST['content'],
					'new' => true
				];
				$this->adModel->save($this->data, $id);

				App::getSession()->addFlash('Ad has been saved');
				App::getRouter()->redirect(App::getRouter()->buildUri($this->params[0]));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}

		if (isset($this->params[1]) && $this->params[1] > 0) {
			$this->data = $this->adModel->getBy('id', $this->params[1]);
		}
	}

	public function deleteAction()
	{
		$id = isset($this->params[1]) ? $this->params[1] : null;

		if (!$id) {
			App::getSession()->addFlash('Missing ad id');
		} else {
			$this->adModel->delete($id);
			App::getSession()->addFlash('Ad has been deleted');
		}

		App::getRouter()->redirect(App::getRouter()->buildUri($this->params[0]));
	}
}