<?php

class PostcodeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /postcode
	 *
	 * @return Response
	 */
	public function index()
	{

		$postcodes = DB::table('centrelink')
						->select(DB::raw('DISTINCT(postcode) as postcode'))
						->get();

		$crimeTotalPerPostcode = DB::table('crime')
									->select(DB::raw('postcode, suburb, COUNT(*) AS count'))
									->groupBy('suburb')
									->get();

									unset($crimeTotalPerPostcode[0]);


		return View::make('postcode.index',  compact('postcodes', 'crimeTotalPerPostcode'));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /postcode/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /postcode
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /postcode/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($postcode)
	{
		//Set the default timezone for all of the Date formatting functions
		date_default_timezone_set('Australia/Brisbane');

		//API Control
		if( !is_null(Input::get('month')) ) :

			$monthName = (!is_null(Input::get('month'))) ? Input::get('month') : 'march';
			$year = 2014;
			$dateObj   = DateTime::createFromFormat('!F', $monthName);
			$monthNum = $dateObj->format('n'); // 3
			$previousMonthsNum = $monthNum;
			$start_date = date('Y-m-d', mktime(0, 0, 0, $monthNum, 1, $year));
			$end_date = date('Y-m-t', mktime(0, 0, 0, $monthNum, 1, $year));
			$viewingPeriod = ucfirst($monthName);


		elseif( !is_null(Input::get('start_date')) && !is_null(Input::get('end_date')) ) :
			
			$start_date = Input::get('start_date');
			$end_date = Input::get('end_date');
			$dateObj   = DateTime::createFromFormat('Y-m-d', $start_date);
			$monthNum = $dateObj->format('n'); // 3
			$previousMonthsNum = $monthNum;
			$viewingPeriod = 'Between ' . date('jS F Y',strtotime($start_date)) . ' and ' . date('jS F Y',strtotime($end_date));

		else :

			$start_date = date('Y-m-d',strtotime('-5 Months'));
			$end_date = date('Y-m-d', time());
			$monthNum = date('n', time());
			$previousMonthsNum = $monthNum - 6;
			$viewingPeriod = date('jS F Y') . " to " . date('jS F Y',strtotime('-5 Months'));

		endif;


		//Database Queries
		$crimes = DB::table('crime')
					->select(DB::raw('DISTINCT(offence_description) as offence_description, count(offence_description) as count'))
					->where('postcode', '=', $postcode)
					->whereBetween('start_date', array($start_date, $end_date))
					->groupBy('offence_description')
					->having('count', '>=', 1)
					->get();

		$crimeGraph = DB::table('crime')
						->select(DB::raw('YEAR(start_date) as year, MONTH(start_date) as month, COUNT(*) as count'))
						->WHERE('postcode', '=', $postcode)
						->whereBetween('start_date', array($start_date, $end_date))	
						->groupBy('year')
						->groupBy('month')
						->orderBy('year', 'ASC')
						->get();

		$realestates = DB::table('bonds')
							->select(DB::raw('DISTINCT(dwelling_type) as building_type, AVG(weekly_rent) as average_weekly_rent, count(dwelling_type) as count'))
							->where('postcode', '=', $postcode)
							->whereBetween('month', array($previousMonthsNum, $monthNum))
							->groupBy('dwelling_type')
							->having('count', '>=', 1)
							->get();

		$centrelink = DB::table('centrelink')->where('postcode', '=', $postcode)->get();


		//Treat the arrays
		if( count($centrelink) > 1 ) :
			array_walk_recursive($centrelink[0], function(&$value) {
				$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
			});
		endif;

		//Used for Centrelink Comparisons
		$smallerPostcode = $postcode;
		$smallerPostcode--;

		$largerPostcode = $postcode;
		$largerPostcode++;

		//Get Adjacent Suburbs Centrelink Data for comparison
		$compareToCentrelinkSmaller = DB::table('centrelink')->where('postcode', '=', $smallerPostcode)->get();
		$compareToCentrelinkLarger = DB::table('centrelink')->where('postcode', '=', $largerPostcode)->get();

		//Remove the HTML issue with the less than sign in the database from the dataset
		if( count($compareToCentrelinkSmaller) > 1 ) :
		array_walk_recursive($compareToCentrelinkSmaller[0], function(&$value) {
				  $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				});	
		endif;
	
	
		//Remove the HTML issue with the less than sign in the database from the dataset
		if( count($compareToCentrelinkLarger) > 1 ) :
		array_walk_recursive($compareToCentrelinkLarger[0], function(&$value) {
				  $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				});
		endif;

		$crimeTotal = DB::table('crime')
								->select(DB::raw('postcode, COUNT(*) AS count'))
								->WHERE('postcode', '=', $postcode)
								->whereBetween('start_date', array($start_date, $end_date))	
								->groupBy('postcode')
								->orderBy('postcode', 'ASC')
								->get();

		$highestCrime = DB::table('crime')
								->select(DB::raw('postcode, offence_description, COUNT(*) AS count'))
								->WHERE('postcode', '=', $postcode)
								->whereBetween('start_date', array($start_date, $end_date))	
								->groupBy('postcode')
								->groupBy('offence_description')
								->orderBy('count', 'DESC')
								->limit(1)
								->get();

		$crimeTotalPerPostcode = DB::table('crime')
								->select(DB::raw('postcode, suburb, COUNT(*) AS count'))
								->groupBy('postcode')
								->get();


		$crimePercentage = array();
		$total = 0;

		foreach($crimeTotalPerPostcode as $crime) {
			$total = $total + $crime->count;
		}

		foreach($crimeTotalPerPostcode as $crime) {
			$crimePercentage[$crime->postcode] = number_format((($crime->count / $total) * 100), 2);
		}

		//Additional Info
		$colours = array('primary', 'success', 'info', 'warning', 'danger');

		//display view
		return View::make('postcode.show', compact('viewingPeriod', 'crimes', 'crimeTotal', 'crimeGraph', 'highestCrime', 'crimePercentage', 'centrelink', 'compareToCentrelinkSmaller', 'compareToCentrelinkLarger', 'realestates', 'postcode', 'colours'));
	}

	public function missingMethod($parameters = array())
	{
	    //Above All Else, Look Good
	    return Redirect::to('/');
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /postcode/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /postcode/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /postcode/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}