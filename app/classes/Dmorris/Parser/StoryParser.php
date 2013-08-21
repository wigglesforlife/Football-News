<?php

namespace Dmorris\Parser;
use Dmorris\Parser\KindParser;

abstract class StoryParser extends KindParser
{
	protected $data = array('short_description' => '', 'time' => 0);

	public function parse()
	{
		// If this has not been added to our database then include it.
		if(!$this->ignoreParse)
			$this->typicalPage() OR $this->metaData();

		return $this->data;

	}

	/**
	 * Occasionally page will not match expected format. Try and search for meta tags with the data instead.
	 */
	public function metaData()
	{
		$return = false;
		$short_description = $this->dom->find('meta[name=Description]',0);
		$timestamp = $this->dom->find('meta[name=OriginalPublicationDate]',0);
		if(!$timestamp)
			$timestamp = $this->dom->find('meta[name=DCTERMS.created]',0);

		if($short_description && $timestamp && $return = true)
		{
			$this->data['short_description'] = $this->cleanParserString($short_description->content);
			$this->data['time'] = strtotime($timestamp->content);
		}

		return $return;
	}

	public function typicalPage()
	{
		return false;
	}
}


