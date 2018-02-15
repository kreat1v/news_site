<?php // Хэшируем пароль.

namespace App\Core;

class Password
{
	private $salt;
	private $hashedPassword;

	public function __construct($password, $saltText = null)
	{
		$this->salt = md5(is_null($saltText) ? Config::get('salt') : $saltText);
		$this->hashedPassword = md5($this->salt . $password);
	}

	public function __toString()
	{
		return $this->hashedPassword;
	}
}