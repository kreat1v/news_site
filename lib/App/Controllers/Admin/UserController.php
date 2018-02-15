<?php

namespace App\Controllers\Admin;

use App\Entity\User;
use App\Core\App;

class UserController extends \App\Controllers\Base
{
	private $userModel;

	public function __construct(array $params = [])
	{
		parent::__construct( $params );

		$this->userModel = new User(App::getConnection());
	}

	public function indexAction()
	{
		$this->data = $this->userModel->list();
	}

	public function editRoleAction() {
		$id = isset($this->params[0]) ? $this->params[0] : null;
		$role = isset($this->params[1]) ? $this->params[1] : null;

		if (!$id || !$role) {
			App::getSession()->addFlash('Missing user id or role not defined.');
		} else {
			$this->data = [
				'role' => $role
			];
			$this->userModel->save($this->data, $id);
			App::getSession()->addFlash('Role changed.');
			App::getRouter()->redirect(App::getRouter()->buildUri('index'));
		}
	}

	public function editActiveAction() {
		$id = isset($this->params[0]) ? $this->params[0] : null;
		$active = $this->params[1];
//		$active = isset($this->params[1]) ? $this->params[1] : null;

		if (!$id) {
			App::getSession()->addFlash('Missing user id.');
		} else {
			$this->data = [
				'active' => $active
			];
			$this->userModel->save($this->data, $id);
			App::getSession()->addFlash('Activity parameter changed.');
			App::getRouter()->redirect(App::getRouter()->buildUri('index'));
		}
	}
}