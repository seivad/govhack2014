@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>About</h1>
		<hr />
	    <p class="lead">SocialTest was developed during GovHack 2014 by Mick Davies @ 5150 Studios during a 46 hour development period.<br /><br />You can search through multiple government datasets comparing Soft Crimes, Centrelink Assistance and Rental Prices to gauge your opinion on South-East Queensland suburbs.<br /><br />We also provide a unique score for each suburb which is based on a number of criteria points and factors using government data.</p>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h3>Current Features</h3>
	    <p>
	    	Postcode Lookup<br />
	    	Crime Data based on Postcode &amp; Suburb<br />
	    	Crime Graph based on start &amp; end date periods<br />
	    	Crime Incidents (Soft Crimes) and their count based on start &amp; end date periods<br />
	    	Centrelink Allowance Data and count <em>(March only)</em><br />
	    	Centrelink Allowance compared to adjacent suburb<br />
	    	Google Maps based on Postcode location<br />
	    	Rental Bonds lodged data and breakdown per Property Type and amount <em>(Jan 2014 to March 2014 only)</em><br />
	    	API Information and guide for Postcode search<br />
	    	Social Media Sharing <em>(Facebook, Twitter &amp; Google+)</em><br />
	    	Disqus Integration for commenting on particular Postcodes
	    </p>
	</div>
	<div class="col-md-4 col-md-offset-2">
		<h3>Roadmap Features</h3>
		<p>
			Individual Postcode Scoring based on multiple criteria points<br />
			Education data for primary to territary level<br />
			Education completion level per Postcode<br />
			Education Naplan score levels per Postcode<br/ >
			Search by Suburb Name as well as Postcode<br />
			5 Star Rating System per Postcode or Suburb<br />
			Better Integration of Google Maps with Overlay of Suburb / Postcode<br />
			Comparisons between Health and Local Industries<br />
			Detailed Correlation between Crime, Centrelink, Education, Job and Property per Suburb / Postcode<br />
			Suburb / Postcode comparison between up to 2 other Suburb / Postcodes<br />
			Additional Google Charts for comparisons<br />
			Larger Datasets <em>(if available from data.gov.au)</em>
		</p>
	</div>
</div><!-- /row -->
@stop