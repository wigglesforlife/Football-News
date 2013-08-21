<?php

class StoriesController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	private $LIMIT = 20;

	public function show($offset = null)
	{
		if ($offset)
			$stories = Story::take($this->LIMIT)->skip($offset)->get();
		else
			$stories = Story::take($this->LIMIT)->get();

		if ($stories->toArray())
			return Response::json($stories->toArray(), 200);
		else
			return Response::json('No stories found', 404);
	}

}