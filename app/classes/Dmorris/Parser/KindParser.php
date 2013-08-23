<?php

namespace Dmorris\Parser;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Cache;
use Dmorris\Parser\Parser;

/**
* Similar to ordinary parser, but doesn't blindly parse every link. If a link has already been parsed it will be skipped.
*/
abstract class KindParser extends Parser
{
	protected $ignoreParse = false;

	public function __construct($url = null, $keywords = array())
	{
		if(!$this->checkUrl($url))
		{
			parent::__construct($url, $keywords);
		}
			
		else
		{
			$this->ignoreParse = true;
			$this->url = $url;
			$this->keywords = $keywords;
		}
			
	}

	public function checkUrl($url = null)
	{
		is_null($url) AND $url = $this->url;
		return \Story::where('hash','=',md5($url))->count() > 0;
	}
}