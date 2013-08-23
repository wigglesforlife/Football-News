<?php

$url = 'By Tom Mallows.   Last Updated: August 19, 2013 11:04am';


function finddate($string){
	
		$datetimes = array();
		$firststring = explode(' ', $string);

		// Find our date/times
		while(count($firststring) > 1)
		{
			$teststring = $firststring;
			while(count($teststring) > 1)
			{
				$implode = implode(' ', $teststring);
				//echo "\n", $implode;
				
				if(strlen(trim($implode)) > 0 && strtotime($implode))
					$datetimes[] =  $implode;
				array_shift($teststring);
			}
			array_pop($firststring);
		}

		// Assume that the string with the most characters is the most accurate i.e 30th August 2013 is more accurate than 30th.
		$biggest = '';
		print_r($datetimes);
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
		echo $biggest;
		return $biggest;

}

$datetime = finddate($url);
echo "\n\n\n",$datetime,"\n\n\n";