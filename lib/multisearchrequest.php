<?php

namespace Multisearch\Api;

class MultisearchRequest
{
	public $url = 'https://api.multisearch.io/';
	private $siteId = '12345';
	private $lang = 'ru';

	public function getResponse($query)
    {
		$this->url .= '?id=' .$this->siteId. '&lang=' .$this->lang. '&fields=true'.$query;
		return $this->sendRequest($this->url);
    }
	
	public function sendRequest($url)
	{
		$ch = curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        foreach ($this->headerData as $name => $value) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("$name: $value" ));
        } 
        curl_setopt($ch,CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \RuntimeException(curl_error($ch));
        }
        curl_close($ch);
        return $data;
	}

}