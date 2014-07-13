<?php

class PagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /contact
	 *
	 * @return Response
	 */
	public function contact()
	{
		return View::make('pages.contact');
	}



	public function about()
	{
		return View::make('pages.about');
	}


	public function api()
	{
		return View::make('pages.api');
	}


}