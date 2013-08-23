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
	    curl_setopt($curl, CURLOPT_FAILONERROR,true);  

	    $data = curl_exec($curl);

	    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	    if(($data === false && curl_errno($curl)) || !($httpCode >= 200 && $httpCode < 300))
	    	throw new \Exception("HTTP request on ".$this->url." failed. cURL errno: ".curl_errno($curl));

	    curl_close($curl);

	    

	    Cache::add(md5($this->url), $data, 30);
	    $this->recentlyCached = true;

	    return $data;


	}

	public function recentlyCached()
	{
		return $this->recentlyCached;
	}

	public function cleanParserString($string)
	{
		return trim(htmlspecialchars_decode($string,ENT_QUOTES));
	}

	public function freeMemory()
	{
		if(isset($this->dom) && $this->dom)
			$this->dom->clear();
		$this->dom = null;
		unset($this->dom);
	}

	public function __destruct()
	{
		$this->freeMemory();
	}

}