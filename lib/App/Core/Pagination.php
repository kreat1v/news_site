<?php

namespace App\Core;

class Pagination
{
	/**
	 * @param int $all        - Полное кол-во элементов (Материалов в категории)
	 * @param int $limit      - Кол-во элементов на странице
	 * @param int $start      - Текущее смещение элементов
	 * @return array
	 */
	public function getLinks($all, $limit, $start, $buttonLimit)
	{
		// Нихрена не делаем, если лимит больше или равен кол-ву всех элементов вообще,
		// И если лимит = 0. 0 - будет означать "не разбивать на страницы".
		if ($limit >= $all || $limit == 0) {
			return null;
		}

		$pagesArr = []; // пременная для промежуточного хранения массива навигации
		$data = [];

		$pages = ceil($all / $limit); // кол-во страниц

		if ($pages < $start || $start == 0) {
			return null;
		}

		// Заполняем массив: ключ - это номер страницы, значение - это смещение для БД.
		// Нумерация здесь нужна с единицы. А смещение с шагом = кол-ву материалов на странице.
		for ($i = 0; $i < $pages; $i++) {
			$pagesArr[$i + 1] = $i * $limit;
		}

		// Теперь что бы на странице отображать нужное кол-во ссылок
		// дробим массив со значениями [№ страницы] => "смещение" на
		// Части (чанки)
		$allPages = array_chunk($pagesArr, $buttonLimit, true);

		// Получаем индекс чанка в котором находится нужное смещение.
		// И далее только из него сформируем список ссылок:
		$needChunk = $this->searchPage($allPages, $start);

		// Формируем ссылку "передыдущая"
		if ($start > 1) {
			$data['back'] = $start - 1;
		} else {
			$data['back'] = null;
		}

		// Выводим ссылки из нужного чанка
		foreach ($allPages[$needChunk] as $pageNum => $offset) {
			$data['middle'][$pageNum] = $offset;
		}

		// Формируем ссылку "в конец"
		if ($pages > $start) {
			$data['forward'] = $start + 1;
		} else {
			$data['forward'] = null;
		}

		$data['last'] = $pages;

		return $data;
	}

	/**
	 * Ищет в каком чанке находится сраница со смещением $needPage
	 * @param array $pagesList массив чанков (массивов страниц разбитый по лимиту ссылок на странице)
	 * @param int $needPage - смещение
	 * @return number Ключ чанка в котором есть нужная страница
	 */
	protected function searchPage($pagesList, $needPage)
	{
		foreach ($pagesList as $chunk => $pages) {
			if (in_array($needPage, array_flip($pages))) {
				return $chunk;
			}
		}

		return 0;
	}
}