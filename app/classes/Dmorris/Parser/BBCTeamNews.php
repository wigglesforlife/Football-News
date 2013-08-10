<?php

namespace Dmorris\Parser;

class BBCTeamNews extends Parser {

	public function __construct($url = 'http://www.bbc.co.uk/sport/football/teams/liverpool', $keywords = array())
	{
		parent::__construct($url, $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('#more-headlines ul a');

		if($current && count($current))
			foreach($current as $story)
				$gossip[] = array('story' => trim(htmlspecialchars_decode($story->text(),ENT_QUOTES)), 'source' => $story->href, 'timestamp' => time(), 'id' => md5($story->href));

		return $gossip;

	}
}