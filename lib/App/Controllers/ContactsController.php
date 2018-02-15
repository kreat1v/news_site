<?php

namespace App\Controllers;

use App\Entity\Contacts;
use App\Core\App;

class ContactsController extends Base
{
	private $contactsModel;

	public function __construct(array $params = [])
	{
		parent::__construct( $params );

		$this->contactsModel = new Contacts(App::getConnection());
	}

	public function indexAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				if (App::getSession()->get('id')) {
					$this->data = [
						'name' => App::getSession()->get('name'),
						'email' => App::getSession()->get('email'),
						'messages' => $_POST['messages'],
						'id_user' => App::getSession()->get('id')
					];
				} else {
					$this->data = [
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'messages' => $_POST['messages']
					];
				}

				$this->contactsModel->save($this->data);
				App::getSession()->addFlash('Thanks for your feedback!');
				App::getRouter()->redirect(App::getRouter()->buildUri('contacts.view'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function viewAction()
	{
		$this->data = $this->contactsModel->list(['id_user' => App::getSession()->get('id')]);
	}
}