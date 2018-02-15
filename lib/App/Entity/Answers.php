<?php

namespace App\Entity;

class Answers extends Base
{
	private $user;
	private $comments;
	private $news;

	private function getUser()
	{
		if (empty($this->user)) {
			$this->user = new User($this->conn);
		}

		return $this->user;
	}

	private function getComments()
	{
		if (empty($this->comments)) {
			$this->comments = new Comments($this->conn);
		}

		return $this->comments;
	}

	private function getNews()
	{
		if (empty($this->news)) {
			$this->news = new News($this->conn);
		}

		return $this->news;
	}

	/**
	 * @param $id новости
	 *
	 * @return mixed
	 */
	public function getAnswers($id)
	{
		$fieldsNews = $this->getNews()->getTableName();
		$fieldsComments = $this->getComments()->getTableName();
		$fieldsUser = $this->getUser()->getTableName();
		$fieldsAnswers = $this->getTableName();

		if (empty($id)) {
			return null;
		}

		$sql = "SELECT $fieldsAnswers.*, $fieldsUser.firstName, $fieldsUser.secondName, $fieldsUser.email
			  	FROM $fieldsAnswers
				JOIN $fieldsComments ON $fieldsAnswers.id_comments = $fieldsComments.id 
				JOIN $fieldsUser ON $fieldsAnswers.id_user = $fieldsUser.id 
				JOIN $fieldsNews ON $fieldsComments.id_news = $fieldsNews.id 
				WHERE $fieldsNews.id = $id 
				ORDER BY $fieldsAnswers.id DESC";
		return $this->conn->query($sql);
	}

	public function getTableName()
	{
		return 'answers';
	}

	public function checkFields($data)
	{
		if (!is_string($data['messages']) || !strlen($data['messages'])) {
			throw new \Exception('The message field can not be empty.');
		}
	}

	public function getFields()
	{
		return [
			'id',
			'id_user',
			'id_comments',
			'date',
			'messages'
		];
	}
}