<?php

namespace Dmorris\Parser\FootballTeams;

class ESPNTeamNews extends Parser {

	public function __construct($url = '', $keywords = array())
	{
		parent::__construct('http://espnfc.com/team/_/id/364/liverpool', $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('#mod-tab-content-headlines ul.headlines',0);

		foreach($current->children() as $curr)
		{
			$link = $curr->first_child();
			$gossip[] = array('timestamp' => time(), 'story' => trim(htmlspecialchars_decode($link->text(),ENT_QUOTES)), 'source' => $link->href, 'id' => md5($link->href));
		}	
			

		return $gossip;
	}
}