<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sunra\PhpSimple\HtmlDomParser;
use Dmorris\Parser\FootballTeams\GuardianTeamNews;
use Dmorris\Parser\FootballTeams\ESPNTeamNews;
use Dmorris\Parser\FootballTeams\SkysportsTeamNews;
use Dmorris\Parser\FootballTeams\BBCTeamNews;
use Dmorris\Parser\FootballStories\BBCStory;
use Dmorris\Parser\FootballStories\SkysportsStory;

class CrawlerUpdate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'crawler:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Crawl a specific site and update any new links';

	/**
	 * The parsers available to us.
	 *
	 * @var array
	 */
	protected $parsers = array('sky' => 'SkysportsTeamNews', 'guardian' => 'GuardianTeamNews', 'bbc' => 'BBCTeamNews');

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if($this->argument('parser') != 'all' AND !array_key_exists($this->argument('parser'), $this->parsers))
		{
			$this->error('Invalid argument used. Try ' . implode(array_keys($this->parsers),', ').' or all');
			return;
		}
		$teamlinks = $this->getTeamlinks();
		if(!count($teamlinks))
			$this->error('No links to update.');

		foreach($teamlinks as $teamlink)
		{
			$this->info('Parsing team: '.$teamlink->team);
			$this->update($teamlink->team, $this->parsers[$this->argument('parser')], $this->crawl($this->parsers[$this->argument('parser')], $teamlink->link));
		}
		$this->listStories($this->parsers[$this->argument('parser')]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('parser', InputArgument::OPTIONAL, 'Which Parser to use; '.implode(array_keys($this->parsers),', ').' or all','all'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

	protected function crawl($parser, $url)
	{
		$parser = new ReflectionClass('Dmorris\\Parser\\FootballTeams\\'.$parser);
		$parser = $parser->newInstance($url);
		$return = array();
		try 
		{
			if($parser->recentlyCached() OR !Cache::has(md5($url)))
				$this->comment('No cache. Sleeping for 1 second to be kind to servers.') && usleep(1000000);
			$return = $parser->parse();

			// Clear memory of the parser...
			$parser->freeMemory();
			$parser = null;
			unset($parser);
		}
		catch(Exception $e)
		{
			$this->error('Failure for '. $url);
		}

		return $return;


	}

	protected function getTeamlinks()
	{
		if($this->argument('parser') == 'all')
			return Teamlink::all();
		return Teamlink::where('parser','=',$this->parsers[$this->argument('parser')])->get();
	}

	protected function update($team, $parser, $data)
	{
		foreach($data as $headline)
		{
			try
			{
				// If we already have the story then skip this iteration of the loop - move onto the next.
				if(count(Story::where('hash','=',md5($headline['source']))->where('team','=',$team)->get()) > 0)
					continue;
				$this->comment('Saving: '.$headline['source']);
				$Story = new Story;
				$Story->team = $team;
				$Story->source = $headline['source'];
				$Story->hash = $headline['id'];
				$Story->story = $headline['story'];
				$Story->parser = $parser;
				$Story->created_at = $Story->freshTimestamp(); // Time this entry is created.
				$Story->updated_at = new DateTime("@".$headline['timestamp']); // Actual publication date.
				$Story->short_description = $headline['short_description'];

				$Story->save();
				
			}
			catch(Exception $e)
			{
				if(strpos($e->getMessage(), 'SQLSTATE[23000]') === false)
				{
					$this->error('Problem saving Story entry for url: '.$headline['source']);
					$this->error($e->getMessage());
				}
			}
		}
	}

	protected function listStories($parser)
	{
		foreach(Story::where('parser','=',$parser)->get() as $story)
			$this->line($story->team.'=>'.$story->source);
	}

}