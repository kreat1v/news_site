<?php

namespace App\Controllers;

use App\Entity\User;
use App\Core\App;

class UserController extends Base
{
	private $userModel;

	public function __construct(array $params = [])
	{
		parent::__construct( $params );

		$this->userModel = new User(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->userModel->getBy('id', App::getSession()->get('id'));
	}

	public function registerAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data = [
					'firstName' => $_POST['firstName'],
					'secondName' => $_POST['secondName'],
					'email' => $_POST['email'],
					'password' => $_POST['password'],
					'confirmPassword' => $_POST['confirmPassword'],
					'role' => 'user'
				];

				$this->userModel->register($this->data);

				App::getSession()->addFlash('Thank you for registering!');
				App::getRouter()->redirect(App::getRouter()->buildUri('user.login'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function loginAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data = [
					'email' => $_POST['email'],
					'password' => $_POST['password']
				];

				$user = $this->userModel->login($this->data);

				App::getSession()->set('id', $user['id']);
				App::getSession()->set('name', $user['firstName']);
				App::getSession()->set('email', $user['email']);
				App::getSession()->set('role', $user['role']);

				App::getSession()->addFlash('Hello, ' . $user['firstName'] . '!');
				App::getRouter()->redirect(App::getRouter()->buildUri('user.index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function logoutAction()
	{
		App::getSession()->destroy();
		App::getSession()->addFlash('You have completed the session');
		App::getRouter()->redirect(App::getRouter()->buildUri('category.index'));
	}

	public function editAction() {
		if (App::getSession()->get('id')) {
			$this->data = $this->userModel->getBy('id', App::getSession()->get('id'));
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = App::getSession()->get('id') ? App::getSession()->get('id') : null;

				$this->data = [
					'firstName' => $_POST['firstName'],
					'secondName' => $_POST['secondName'],
					'email' => $_POST['email'],
				];

				if (App::getSession()->get('email') == $this->data['email']) {
					unset($this->data['email']);
				}

				$this->userModel->edit($this->data, $id);

				if (isset($this->data['email'])) {
					App::getSession()->set('email', $this->data['email']);
				}

				App::getSession()->addFlash('Your data has been saved successfully.');
				App::getRouter()->redirect(App::getRouter()->buildUri('user.index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function editPasswordAction() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$id = App::getSession()->get('id') ? App::getSession()->get('id') : null;

				$this->data = [
					'oldPassword' => $_POST['oldPassword'],
					'password' => $_POST['password'],
					'confirmPassword' => $_POST['confirmPassword'],
				];

				$this->userModel->editPassword($this->data, $id);

				App::getSession()->addFlash('Your new password has been saved successfully.');
				App::getRouter()->redirect(App::getRouter()->buildUri('user.index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}
}