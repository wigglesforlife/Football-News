<?php

namespace Dmorris\Parser;

class BBCGossip extends Parser {

	public function __construct($url = '', $keywords = array())
	{
		$keywords = array('liverpool');
		parent::__construct('http://www.bbc.co.uk/sport/0/football/gossip/', $keywords);
	}

	public function parse()
	{
		$gossip = array();
		$current = $this->dom->find('#headline', 0)->next_sibling()->next_sibling()->next_sibling()->next_sibling();
		while($current->id != 'also-related-links')
		{
			if($current->nodeName() == 'p' && $this->hasKeywords($current->text()))
			{
				$story = trim(htmlspecialchars_decode($current->text(), ENT_QUOTES));
				$current = $current->next_sibling();
				while ($current->nodeName() != 'p')
					$current = $current->next_sibling();
				if($current->find('a',0))
					$link = $current->find('a',0)->getAttribute('href');
				$gossip[] = array('story' => $story, 'source' => $link, 'timestamp' => time(), 'id' => md5($link));
			}
			$current = $current->next_sibling();
		}

		return $gossip;
	}
}