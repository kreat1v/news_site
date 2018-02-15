<?php

namespace App\Entity;

class Vote extends Base
{
	private $comments;

	private function getComments()
	{
		if (empty($this->comments)) {
			$this->comments = new Comments($this->conn);
		}

		return $this->comments;
	}

	public function getVote($id_user, $id_news)
	{
		$fieldsComments = $this->getComments()->getTableName();
		$fieldsVote = $this->getTableName();

		if (empty($id_user) || empty($id_news) ) {
			return null;
		}

		$sql = "SELECT $fieldsVote.*
			  	FROM $fieldsVote
				JOIN $fieldsComments ON $fieldsComments.id = $fieldsVote.id_comments 
				WHERE $fieldsComments.id_news = $id_news AND $fieldsVote.id_user = $id_user";
		return $this->conn->query($sql);
	}

	public function getTableName()
	{
		return 'vote';
	}

	public function checkFields($data) {}

	public function getFields()
	{
		return [
			'id',
			'id_comments',
			'id_user',
			'mark'
		];
	}
}