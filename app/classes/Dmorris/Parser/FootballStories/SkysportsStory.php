<?php

namespace Dmorris\Parser\FootballStories;
use Dmorris\Parser\StoryParser;

class SkysportsStory extends StoryParser 
{

	/**
	 * Parse the two typical types of Skysports page. Two types, an article or a match report/preview.
	 */
	public function typicalPage()
	{
		$return = false;
		$short_description = $this->dom->find('.article-body p[itemprop=description]',0);
		$timestamp = $timestamp = $this->dom->find('div.article-info span.highlight',0);

		// If it's an article...
		if($short_description && $timestamp && $return = true)
		{
			$this->data['short_description'] = $this->cleanParserString($short_description->text());
			$this->data['time'] = strtotime($timestamp->text());
		}
		else // Preview/Match report.
		{
			$short_description =  $this->dom->find('.v5-art-body p.v5-txt-strong',0);
			$timestamp = $this->dom->find('p.v5-txt-cpt',0);

			if($short_description && $timestamp && $return = true)
			{
				$this->data['short_description'] = $this->cleanParserString($short_description->text());
				$this->data['time'] = strtotime(trim(str_replace('Last Updated:', '', $timestamp->text())));
			}
		}

		return $return;
	}

}