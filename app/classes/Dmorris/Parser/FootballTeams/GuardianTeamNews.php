<?php

namespace Dmorris\Parser\FootballTeams;

class GuardianTeamNews extends Parser {

	public function __construct($url = 'http://www.theguardian.com/football/liverpool', $keywords = array())
	{
		parent::__construct($url, $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('div.eight-col div.edge ul.list a.link-text');

		// if it's empty, there's a chance it's the Guardian's old design. Reparse against the old design.
		if(!$current OR !count($current))
			$current = $this->dom->find('#auto-trail-block .linktext a');

		// If we have something then loop and process
		if($current && count($current))
			foreach($current as $curr)
				$gossip[] = array('story' => trim(htmlspecialchars_decode($curr->text(), ENT_QUOTES)), 'source' => $curr->href, 'timestamp' => time(), 'id' => md5($curr->href));	

		return $gossip;
	}
}