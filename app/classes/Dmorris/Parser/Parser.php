<?php

namespace Dmorris\Parser;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Cache;

abstract class Parser
{
	protected $url;
	protected $dom;
	protected $keywords;
	protected $recentlyCached = false;

	public function __construct($url = null, $keywords = array())
	{
		$this->url = $url;
		$this->keywords = $keywords;
		$this->getDom();
	}

	public function getDom()
	{
		if($this->url)
			$this->dom = HtmlDomParser::str_get_html($this->getHtml());
	}

	public function parse() {}

	public function hasKeywords($string)
	{
		if(!count($this->keywords))
			return true;

		$string = strtolower(htmlspecialchars_decode($string,ENT_QUOTES));

		foreach ($this->keywords as $keyword)
			if (strpos($string, strtolower($keyword)) !== false)
				return true;

		return false;

	}

	public function getHtml()
	{
		if(Cache::has(md5($this->url)))
			return Cache::get(md5($this->url));

		$curl = curl_init();		
	    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_URL, $this->url);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);       

	    $data = curl_exec($curl);
	    curl_close($curl);

	    if($data === false && curl_errno($curl))
	    	throw new Exception("HTTP request on ".$this->link." failed. cURL errno: ".curl_errno($curl));

	    Cache::add(md5($this->url), $data, 30);
	    $this->recentlyCached = true;

	    return $data;


	}

	public function recentlyCached()
	{
		return $this->recentlyCached;
	}

	public function __destruct()
	{
		$this->dom->clear();
	}

}