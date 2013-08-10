<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sunra\PhpSimple\HtmlDomParser;
use Dmorris\Parser\GuardianTeamNews;
use Dmorris\Parser\ESPNTeamNews;
use Dmorris\Parser\SkysportsTeamNews;
use Dmorris\Parser\BBCGossip;
use Dmorris\Parser\BBCTeamNews;

class ParseBBCGossipCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'parse:bbcgossip';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Retrieve and parse the BBC Gossip page';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		
		// $starttime = microtime(true);
		// $this->line('Retreving information...');
		// $info = array();
		// $sites = array(new GuardianTeamNews, new SkysportsTeamNews, new BBCGossip, new ESPNTeamNews);

		// foreach($sites as $site)
		// 	foreach($site->parse() as $link)
		// 		$info[] = $link;
		// $this->line(' ');

		// foreach($info as $link)
		// {
		// 	$this->info($link['id'] . ' generated at ' . date('H:i d/m/Y', $link['timestamp']));
		// 	$this->line($link['story']);
		// 	$this->comment($link['source']);
		// 	$this->line(' ');
		// }

		// $endtime = (microtime(true) - $starttime);
		// $this->info(count($sites).' sites succesfully parsed in ' .$endtime. ' seconds!');

		// $dom = HtmlDomParser::file_get_html('http://www.bbc.co.uk/sport/football/teams');
		// foreach($dom->find('div.competition ul a') as $a)
		// {
		// 	try 
		// 	{
		// 		$Teamlink = new Teamlink;
		// 		$Teamlink->team = $a->text();
		// 		$Teamlink->link = 'http://www.bbc.co.uk'.$a->href;
		// 		$Teamlink->parser = 'BBCTeamNews';
		// 		$Teamlink->save();
		// 		$this->info($Teamlink->team.' => '. $Teamlink->link);
		// 	}
		// 	catch(Exception $e)
		// 	{
		// 		$this->error($e->getMessage());
		// 	}
		// }
	

		// $ch = curl_init();
	 //    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	 //    curl_setopt($ch, CURLOPT_HEADER, 0);
	 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 //    curl_setopt($ch, CURLOPT_URL, $url);
	 //    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

	 //    $data = curl_exec($ch);
	 //    curl_close($ch);

	 //    print_r($data);

		// $test = new SkysportsTeamNews($url);

		// print_r($test->getHtml());


		// foreach(Teamlink::where('parser','=','GuardianTeamNews')->get() as $story)
		// 	$this->line(implode('', array($story->team,' => ',$story->link)));

		// $e = new BBCTeamNews();

		// print_r($e->parse());

		// foreach(Story::all() as $story)
		// 	$this->line($story['team'].': '.$story['source']);


			//$this->line($a->title.' => '.$a->href);
		//print_r(Teamlink::all());

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
		// return array(
		// 	array('example', InputArgument::REQUIRED, 'An example argument.'),
		// );
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

}