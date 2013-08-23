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
			$this->data['time'] = $this->getTime($timestamp->text());
		}
		else // Preview/Match report.
		{
			$short_description =  $this->dom->find('.v5-art-body p.v5-txt-strong',0);
			$timestamp = $this->dom->find('p.v5-txt-cpt',0);

			if($short_description && $timestamp && $return = true)
			{
				$this->data['short_description'] = $this->cleanParserString($short_description->text());
				$this->data['time'] = $this->getTime($timestamp->text());
			}
		}

		return $return;
	}

	/**
	* Some Skysports tags with the publication date also contain variations of different words such as
	* the author's name and other arbitary text. Since it's all in one tag it needs to be extracted.
	* This is a rudimentary method of finding date/times by trying subsets of the string to check for dates.
	*/
	private function parseSkysportsTimeString($string)
	{
		// If our string is already a time no need to parse.
		if(strtotime($string))
			return strtotime($string);

		$datetimes = array();
		$firststring = explode(' ', $string);

		// Find our date/times
		while(count($firststring) > 1)
		{
			$teststring = $firststring;
			while(count($teststring) > 1)
			{
				$implode = implode(' ', $teststring);
				
				if(strlen(trim($implode)) > 0 && strtotime($implode))
					$datetimes[] =  $implode;
				array_shift($teststring);
			}
			array_pop($firststring);
		}
		unset($firststring);



		// Assume that the string with the most characters is the most accurate i.e 30th August 2013 is more accurate than 30th.
		$biggest = '';
		if(count($datetimes) > 0)
		{
			foreach($datetimes as $dt)
			{
				if(strlen($dt) > strlen($biggest))
				{
					$biggest = $dt;
				}
			}
		}		
		else
		{
			return false;
		}
		return $biggest;
	}

	private function getTime($string)
	{
		$time = $this->parseSkysportsTimeString($string);
		if($time && strtotime($time))
			return strtotime($time);
		return time();
	}

}