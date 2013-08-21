<?php

namespace Dmorris\Parser\FootballStories;
use Dmorris\Parser\StoryParser;

class BBCStory extends StoryParser 
{

	/**
	 * Parse the typical BBC Sport Page
	 */
	public function typicalPage()
	{
		$return = false;
		$short_description = $this->dom->find('#story_continues_1',0);
		$timestamp = $timestamp = $this->dom->find('#toolbar .page-timestamp',0);

		if($short_description && $timestamp && $timestamp->find('.date',0) && $timestamp->find('.time',0) && $return = true)
		{
			$this->data['short_description'] = $this->cleanParserString($short_description->text());
			$this->data['time'] = strtotime($timestamp->find('.date',0)->text() .' '. $timestamp->find('.time',0)->text());
		}

		return $return;
	}

}