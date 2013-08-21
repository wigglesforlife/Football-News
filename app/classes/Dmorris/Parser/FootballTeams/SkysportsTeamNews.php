<?php

namespace Dmorris\Parser\FootballTeams;

class SkysportsTeamNews extends Parser {

	public function __construct($url = 'http://www1.skysports.com/football/teams/liverpool', $keywords = array())
	{
		parent::__construct($url, $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('#news-latest .v5-list-t6',0);

		if($current && count($current) && $current->children())
			foreach($current->children() as $story)
				$gossip[] = array('story' => trim(htmlspecialchars_decode($story->first_child()->text(),ENT_QUOTES)), 'source' => $story->first_child()->href, 'timestamp' => time(), 'id' => md5($story->first_child()->href));

		return $gossip;

	}
}