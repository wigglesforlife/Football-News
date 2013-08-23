<?php

namespace Dmorris\Parser\FootballTeams;
use Dmorris\Parser\Parser;
use Dmorris\Parser\FootballStories\SkysportsStory;

class SkysportsTeamNews extends Parser {

	private $yeah = false;

	public function __construct($url = 'http://www1.skysports.com/football/teams/liverpool', $keywords = array())
	{
		parent::__construct($url, $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('#news-latest .v5-list-t6',0);

		if($current && count($current) && $current->children())
		{
			foreach($current->children() as $story)
			{
				$storyparser = new SkysportsStory($story->first_child()->href);
				$pagedata = $storyparser->parse();
				$storyparser->freeMemory();
				unset($storyparser);
				$gossip[] =  array(
					'story' => $this->cleanParserString($story->first_child()->text()), 
					'source' => $story->first_child()->href, 
					'id' => md5($story->first_child()->href),
					'timestamp' => $pagedata['time'],
					'short_description' => $pagedata['short_description'],
				);
			}
		}

		return $gossip;
	}
}