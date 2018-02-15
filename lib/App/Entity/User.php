<?php

namespace App\Entity;

use App\Core\Password;

class User extends Base
{
	public function getTableName()
	{
		return 'users';
	}

	public function checkFields($data)
	{
		foreach ($data as $value) {
			if (empty($value) && !strlen($value)) {
				throw new \Exception('Form fields can not be empty');
			}
		}
	}

	public function getFields()
	{
		return [
			'id',
			'firstName',
			'secondName',
			'email',
			'role',
			'password',
			'active'
		];
	}

	public function register(array $data)
	{
		if ($this->getBy('email', $data['email'])) {
			throw new \Exception('User with this email already registered');
		}

		if ($data['password'] != $data['confirmPassword']) {
			throw new \Exception('Passwords do not match');
		}

		$data['password'] = md5(new Password($data['password']));

		$this->save($data);
	}

	public function login(array $data)
	{
		$this->checkFields($data);

		$user = $this->getBy('email', $data['email']);

		if (!$user) {
			throw new \Exception('User with such an email does not exist');
		}

		if ($user['password'] != md5(new Password($data['password']))) {
			throw new \Exception('Wrong password');
		}

		if (!$user['active']) {
			throw new \Exception('You are blocked by an administrator');
		}

		return $user;
	}

	public function edit(array $data, $id)
	{
		if ($this->getBy('email', $data['email'])) {
			throw new \Exception('User with this email already registered');
		}

		$this->save($data, $id);
	}

	public function editPassword(array $data, $id)
	{
		$this->checkFields($data);

		$user = $this->getBy('id', $id);

		if ($user['password'] != md5(new Password($data['oldPassword']))) {
			throw new \Exception('The old password is not correct.');
		}

		if ($user['password'] == md5(new Password($data['password']))) {
			throw new \Exception('The new password can not be the same as the old one.');
		}

		if ($data['password'] != $data['confirmPassword']) {
			throw new \Exception('Passwords do not match');
		}

		$data['password'] = md5(new Password($data['password']));

		$this->save($data, $id);
	}
}