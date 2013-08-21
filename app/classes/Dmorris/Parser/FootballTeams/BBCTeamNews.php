<?php

namespace Dmorris\Parser\FootballTeams;
use Dmorris\Parser\Parser;
use Dmorris\Parser\FootballStories\BBCStory;
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
		{
			foreach($current as $story)
			{
				$storyparser = new BBCStory($story->href);
				$pagedata = $storyparser->parse();
				unset($storyparser);
				$gossip[] = array(
					'story' => trim(htmlspecialchars_decode($story->text(),ENT_QUOTES)), 
					'source' => $story->href, 
					'timestamp' => $pagedata['time'],
					'short_description' => $pagedata['short_description'], 
					'id' => md5($story->href)
				);
			}
		}
		return $gossip;

	}
}