<?php

namespace App\Controllers\Admin;

use \App\Entity\Contacts;
use \App\Core\App;

class ContactsController extends \App\Controllers\Base
{
	private $contactsModel;

	public function __construct(array $params = [])
	{
		parent::__construct( $params );

		$this->contactsModel = new Contacts(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->contactsModel->list();
	}

	public function userAction()
	{
		$messages = $this->contactsModel->list();

		if (!empty($messages)) {
			foreach ($messages as $value) {
				if (isset($value['id_user'])) {
					$this->data[] = $value;
				}
			}
		}
	}

	public function anonymousAction()
	{
		$messages = $this->contactsModel->list();

		if (!empty($messages)) {
			foreach ($messages as $value) {
				if (!isset($value['id_user'])) {
					$this->data[] = $value;
				}
			}
		}
	}

	public function editAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = isset($this->params[0]) ? $this->params[0] : null;

				$this->data = [
					'messages' => $_POST['messages']
				];
				$this->contactsModel->save($this->data, $id);

				App::getSession()->addFlash('Message has been saved');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}

		if (isset($this->params[0]) && $this->params[0] > 0) {
			$this->data = $this->contactsModel->getBy('id', $this->params[0]);
		}
	}

	public function deleteAction()
	{
		$id = isset($this->params[0]) ? $this->params[0] : null;

		if (!$id) {
			App::getSession()->addFlash('Missing message id');
		} else {
			$this->contactsModel->delete($id);
			App::getSession()->addFlash('Message has been deleted');
		}

		App::getRouter()->redirect(App::getRouter()->buildUri('index'));
	}
}