<?php

namespace App\Entity;

class Comments extends Base
{
	private $user;
	private $news;

	private function getUser()
	{
		if (empty($this->user)) {
			$this->user = new User($this->conn);
		}

		return $this->user;
	}

	private function getNews()
	{
		if (empty($this->news)) {
			$this->news = new News($this->conn);
		}

		return $this->news;
	}

	public function topUser()
	{
		$fieldsComments = $this->getTableName();
		$fieldsUser = $this->getUser()->getTableName();

		$sql = "SELECT COUNT($fieldsComments.id_user) AS count, $fieldsUser.id, $fieldsUser.firstName, $fieldsUser.secondName, $fieldsUser.email 
			  	FROM $fieldsComments
				JOIN $fieldsUser ON $fieldsComments.id_user = $fieldsUser.id 
				WHERE $fieldsComments.active = 1 
				GROUP BY $fieldsComments.id_user 
				ORDER BY count DESC 
				LIMIT 5 OFFSET 0";
		return $this->conn->query($sql);
	}

	public function topNews()
	{
		$fieldsComments = $this->getTableName();
		$fieldsNews = $this->getNews()->getTableName();

		$sql = "SELECT COUNT($fieldsComments.id_news) AS count, $fieldsNews.id, $fieldsNews.title 
			  	FROM $fieldsComments
				JOIN $fieldsNews ON $fieldsComments.id_news = $fieldsNews.id 
				WHERE $fieldsComments.date >= CURDATE() AND $fieldsComments.active = 1 
				GROUP BY $fieldsComments.id_news 
				ORDER BY count DESC 
				LIMIT 3 OFFSET 0";
		return $this->conn->query($sql);
	}

	/**
	 * @param $where - искомый параметр
	 * @param $id новости или комментария
	 *
	 * @return mixed
	 */
	public function getComments($where, $id)
	{
		$fieldsComments = $this->getTableName();
		$fieldsUser = $this->getUser()->getTableName();

		if (empty($id)) {
			return null;
		}

		$sql = "SELECT $fieldsComments.*, $fieldsUser.firstName, $fieldsUser.secondName, $fieldsUser.email
			  	FROM $fieldsComments
				JOIN $fieldsUser ON $fieldsComments.id_user = $fieldsUser.id 
				WHERE $fieldsComments.$where = $id 
				ORDER BY $fieldsComments.rating	 DESC";
		return $this->conn->query($sql);
	}

	public function getSection($limit, $limitStart, $where = null, $sort = null)
	{
		if (isset($where)) {
			$this->conn->escape($where);
			$strWhere = " WHERE id_user = $where ";
		}

		if (isset($sort)) {
			$this->conn->escape($sort);
			$orderBy = " ORDER BY $sort DESC ";
		}

		$sql = 'SELECT * FROM ' . $this->getTableName() . $strWhere . $orderBy . ' LIMIT ' . $limit . ' OFFSET ' . $limitStart;

		return $this->conn->query($sql);
	}

	public function getTableName()
	{
		return 'comments';
	}

	public function checkFields($data)
	{
		foreach ($data as $value) {
			if (empty($value) && !strlen($value)) {
				throw new \Exception('The comments field can not be empty.');
			}
		}
	}

	public function getFields()
	{
		return [
			'id',
			'id_user',
			'id_news',
			'date',
			'messages',
			'rating',
			'active'
		];
	}
}