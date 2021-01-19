<?php

namespace Multisearch\Api;

class MultisearchApi
{
	public function __construct()
    {
        $this->service = new MultisearchRequest();
    }

	public function getQuery($query)
	{
		return $response = $this->service->getResponse($query);
	}

	public function parse($data)
	{
		$queryResult = [];
		$res = [];
		$items = [];
		$categories = [];
		$jsonData = json_decode($data, true);
		
		if (!$jsonData || empty($jsonData['results'])) {
			return;
		}
		
		if ($jsonData['corrected']) {
			$queryResult['corrected']['phrase'] = $jsonData['corrected']['phrase'];
			$queryResult['corrected']['highlight'] = $jsonData['corrected']['highlight'];
		}

		parse_str($this->service->url, $urlArr);
		$offset = $urlArr["offset"];
		$limit = $urlArr["limit"];

		if ($jsonData['results']['items'] && $jsonData['results']['categories']) { // ТОВАРЫ КАТЕГОРИИ ?t=
			foreach($jsonData['results']['items'] as $item) {
				$items[] = $item;
				$queryResult['result']['items'] = $items;
			}	
			foreach($jsonData['results']['categories'] as $category) {
				$categories[] = $category;
				$queryResult['result']['categories'] = $categories;
			}
			$queryResult['total'] = $jsonData['results']['count'];
			$queryResult['limit'] = $limit;
			$queryResult['offset'] = $offset;
			
			if ($queryResult['offset'] > 0 && $queryResult['offset'] < $queryResult['total']) {
				$queryResult['offset'] = $queryResult['offset'] + $queryResult['limit'];
			}
			
		} else { // все товары
			$queryResult['total'] = $jsonData['total'];
			foreach($jsonData['results'] as $result) {
				$res['category'] = $result['category'];
				$res['items'] = $result['items'];
				$queryResult['result'][] = $res;
			}
		}
		return $queryResult;
	}

	public function run($query)
	{
		$data = $this->getQuery($query);
		$parseData = $this->parse($data);
		return $parseData;
	}
}