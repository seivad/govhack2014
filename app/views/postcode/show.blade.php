@extends('layouts.master')

@section('content')

 <script>
	
	var geocoder, map, latlng;

    function initialize() {

        geocoder = new google.maps.Geocoder();

        var mapOptions = {
            zoom: 13,
            center: codeAddress(),
            streetViewControl: false,
            overviewMapControl: false,
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            mapTypeControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

  		 	map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

	}

	


    //Get map location
    function codeAddress() {
		var address = "{{ $postcode }}, Queensland, Australia";
		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		  	console.log(results);
		    latlng = results[0].geometry.location;
		    findSuburbName();
		    map.setCenter(results[0].geometry.location);
		  } else {
		    alert('Geocode was not successful for the following reason: ' + status);
		  }
		});
	}


	function findSuburbName() {
		geocoder.geocode({'latLng': latlng}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	    	console.log(results);
	        var suburb = results[1].address_components[0].long_name + ', ' + results[1].address_components[1].long_name;
	        $('.suburb').prepend(suburb);
	    } else {
	      console.log('Geocoder failed due to: ' + status);
	    }
	  });

	}


google.maps.event.addDomListener(window, 'load', initialize);
    </script>

	<div class="row">
		<div class="col-md-6">
			<h1>{{ $postcode }} <small class="suburb"></small></h1>
			<h4>{{ $viewingPeriod }}</h4>
			<hr />
			<div id="map-canvas" style="height:320px;"></div>
			<hr />
		</div>
	</div>



<div class="row datapoints">	
<div class="col-md-6">

<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#crime"><span class="glyphicon glyphicon-plus"></span> Crime <span class="badge pull-right">{{ $crimeTotal[0]->count }} Incidents</span></a>
      </h4>
    </div>
    <div id="crime" class="panel-collapse collapse in">
      <div class="panel-body">
      	<div class="alert alert-danger"><strong>Most Common Crime:</strong> {{ $highestCrime[0]->offence_description }}: {{ $highestCrime[0]->count }} times</div>
       	
       	<span class="label label-primary">{{ $crimePercentage['4208'] }}% Overall</span>
       	<span class="label label-danger">{{ $crimeTotal[0]->count }} Incidents</span>
       	<span class="label label-warning">Most Common Crime: {{ $highestCrime[0]->offence_description }}</span>
      	
      	<hr />

       	<ul>
       		@if( count($crimes) > 1 )
       			
				@foreach($crimes as $crime)
					<li><strong>{{ $crime->offence_description }}:</strong> {{ $crime->count }}</li>
				@endforeach
			@else
				<li>There are no records for that date period!</li>
			@endif
		</ul>

		<hr />

		<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

      	var data = google.visualization.arrayToDataTable([
		['Date', 'Total Incidents'],
      	
      	@foreach($crimeGraph as $crime)

      		<?php 
      			$dateObj   = DateTime::createFromFormat('!n-Y', $crime->month.'-'.$crime->year);
				//$monthName = $dateObj->format('m-Y');
				$monthName = $dateObj->format('F');

				if ($crime === end($crimeGraph)) :
        			echo "['$monthName ($crime->count)',$crime->count]";
        		else :
					echo "['$monthName ($crime->count)',$crime->count],";
				endif;
				
      		?>

      	@endforeach
      	]);


        var options = {
          title: 'Crime up to 6 Month Overview',
          hAxis: {title: 'Incidents Per Month',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          'legend': 'none',
          chartArea:{left:50,top:30,width:"85%",height:"72%"}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      $(window).resize(function(){
		  drawChart();
		});


    </script>
    
    	<div id="chart_div" class="chart" style="width: 100%; height: 300px"></div>

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#centrelink">
          <span class="glyphicon glyphicon-plus"></span> Centrelink Assistance (March)
        </a>
      </h4>
    </div>
    <div id="centrelink" class="panel-collapse collapse">
      <div class="panel-body">

      	<table class="table table-responsive table-bordered table-striped">
      		<tr>
      			<th>Assistance</th>
      			<th><a href="/postcode/{{ $compareToCentrelinkSmaller[0]->postcode }}">{{ $compareToCentrelinkSmaller[0]->postcode }}</a></th>
      			<th class="warning">{{ $postcode }}</th>
      			<th><a href="/postcode/{{ $compareToCentrelinkLarger[0]->postcode }}">{{ $compareToCentrelinkLarger[0]->postcode }}</a></th>
      		</tr>
      		<tr>
      			<td>Abstudy Living Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->abstudy_living_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->abstudy_living_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->abstudy_living_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Abstudy Non Living Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->abstudy_non_living_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->abstudy_non_living_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->abstudy_non_living_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Age Pension</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->age_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->age_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->age_pension }}</td>
      		</tr>
      		<tr>
      			<td>Austudy</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->austudy }}</td>
      			<td class="warning">{{ $centrelink[0]->austudy }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->austudy }}</td>
      		</tr>
      		<tr>
      			<td>Carer Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->carer_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->carer_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->carer_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Carer Allowance (child health care card only)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->carer_allowance_child_health_care_card_only }}</td>
      			<td class="warning">{{ $centrelink[0]->carer_allowance_child_health_care_card_only }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->carer_allowance_child_health_care_card_only }}</td>
      		</tr>
      		<tr>
      			<td>Carer Payment</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->carer_payment }}</td>
      			<td class="warning">{{ $centrelink[0]->carer_payment }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->carer_payment }}</td>
      		</tr>
      		<tr>
      			<td>Commonwealth Seniors Health Card</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->commonwealth_seniors_health_card }}</td>
      			<td class="warning">{{ $centrelink[0]->commonwealth_seniors_health_card }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->commonwealth_seniors_health_card }}</td>
      		</tr>
      		<tr>
      			<td>Double Orphan Pension</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->double_orphan_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->double_orphan_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->double_orphan_pension }}</td>
      		</tr>
      		<tr>
      			<td>Disability Support Pension</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->disability_support_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->disability_support_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->disability_support_pension }}</td>
      		</tr>
      		<tr>
      			<td>Family Tax Benefit Part A</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->family_tax_benefit_part_a }}</td>
      			<td class="warning">{{ $centrelink[0]->family_tax_benefit_part_a }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->family_tax_benefit_part_a }}</td>
      		</tr>
      		<tr>
      			<td>Family Tax Benefit Part B</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->family_tax_benefit_part_b }}</td>
      			<td class="warning">{{ $centrelink[0]->family_tax_benefit_part_b }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->family_tax_benefit_part_b }}</td>
      		</tr>
      		<tr>
      			<td>Health Care Card</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->health_care_card }}</td>
      			<td class="warning">{{ $centrelink[0]->health_care_card }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->health_care_card }}</td>
      		</tr>
      		<tr>
      			<td>Low Income Card</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->low_income_card }}</td>
      			<td class="warning">{{ $centrelink[0]->low_income_card }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->low_income_card }}</td>
      		</tr>
      		<tr>
      			<td>Newstart Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->newstart_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->newstart_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->newstart_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Parenting Payment (Partnered)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->parenting_payment_partnered }}</td>
      			<td class="warning">{{ $centrelink[0]->parenting_payment_partnered }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->parenting_payment_partnered }}</td>
      		</tr>
      		<tr>
      			<td>Parenting Payment (Single)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->parenting_payment_single }}</td>
      			<td class="warning">{{ $centrelink[0]->parenting_payment_single }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->parenting_payment_single }}</td>
      		</tr>
      		<tr>
      			<td>Partner Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->partner_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->partner_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->partner_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Pensioner Concession Card</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->pensioner_concession_card }}</td>
      			<td class="warning">{{ $centrelink[0]->pensioner_concession_card }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->pensioner_concession_card }}</td>
      		</tr>
      		<tr>
      			<td>Sickness Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->sickness_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->sickness_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->sickness_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Special Benefit</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->special_benefit }}</td>
      			<td class="warning">{{ $centrelink[0]->special_benefit }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->special_benefit }}</td>
      		</tr>
      		<tr>
      			<td>Wife Pension (Partner on Age Pension)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->wife_pension_partner_on_age_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->wife_pension_partner_on_age_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->wife_pension_partner_on_age_pension }}</td>
      		</tr>
      		<tr>
      			<td>Wife Pension (Partner on Disability Support Pension)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->wife_pension_partner_on_disability_support_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->wife_pension_partner_on_disability_support_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->wife_pension_partner_on_disability_support_pension }}</td>
      		</tr>
      		<tr>
      			<td>Widow Allowance</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->widow_allowance }}</td>
      			<td class="warning">{{ $centrelink[0]->widow_allowance }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->widow_allowance }}</td>
      		</tr>
      		<tr>
      			<td>Widow B Pension</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->widow_b_pension }}</td>
      			<td class="warning">{{ $centrelink[0]->widow_b_pension }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->widow_b_pension }}</td>
      		</tr>
      		<tr>
      			<td>Youth Allowance (Other)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->youth_allowance_other }}</td>
      			<td class="warning">{{ $centrelink[0]->youth_allowance_other }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->youth_allowance_other }}</td>
      		</tr>
      		<tr>
      			<td>Youth Allowance (Student and Apprentice)</td>
      			<td>{{ $compareToCentrelinkSmaller[0]->youth_allowance_student_and_apprentice }}</td>
      			<td class="warning">{{ $centrelink[0]->youth_allowance_student_and_apprentice }}</td>
      			<td>{{ $compareToCentrelinkLarger[0]->youth_allowance_student_and_apprentice }}</td>
      		</tr>
      	</table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#realestate">
          <span class="glyphicon glyphicon-plus"></span> Real Estate
        </a>
      </h4>
    </div>
    <div id="realestate" class="panel-collapse collapse">
      <div class="panel-body">
      	@if( count($realestates) > 1 )
			@foreach($realestates as $idx => $realestate)
			<div class="panel {{ 'panel-'.$colours[array_rand($colours)] }}">
		      <div class="panel-heading">
		        <h3 class="panel-title">{{ $realestate->count }} {{ str_plural($realestate->building_type) }}</h3>
		      </div>
		      <div class="panel-body">
		        ${{ money_format('%i', $realestate->average_weekly_rent) }} Approx. average per week
		      </div>
		    </div>
			@endforeach
		@else
			<div class="panel {{ 'panel-danger">
		      <div class="panel-heading">
		        <h3 class="panel-title">No Records</h3>
		      </div>
		      <div class="panel-body">
		        There are no records for this month
		      </div>
		    </div>
		@endif
      </div>
    </div>
  </div>
</div>

</div><!-- /col-md-6 -->
</div><!-- /row /datapoints -->

	<div class="row">
		<div class="col-md-6">
			<div class="socialmedia">
				<hr />
				<?php
					$link = urlencode(Request::url());
					$title = urlencode($postcode . ' | Share on SocialTest');
								
					echo '<a href="http://www.facebook.com/sharer.php?u='.$link.'&amp;t='.$title.'" target="_blank"><i class="fa fa-3x fa-facebook-square"></i></a>
					<a href="http://twitter.com/share?text='.$title.'&url='.$link.'" target="_blank"><i class="fa fa-3x fa-twitter-square"></i></a>
					<a href="https://plusone.google.com/_/+1/confirm?hl=en&url='.$link.'&title='.$title.'" target="_blank"><i class="fa fa-3x fa-google-plus-square"></i></a>';

				?>
				<hr />
			</div>
			
			

		    <div id="disqus_thread"></div>
		    <script type="text/javascript">
		        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		        var disqus_shortname = 'socialtest5150studios'; // required: replace example with your forum shortname

		        /* * * DON'T EDIT BELOW THIS LINE * * */
		        (function() {
		            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		        })();
		    </script>
		    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

			<script type="text/javascript">
		    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		    var disqus_shortname = 'socialtest5150studios'; // required: replace example with your forum shortname

		    /* * * DON'T EDIT BELOW THIS LINE * * */
		    (function () {
		        var s = document.createElement('script'); s.async = true;
		        s.type = 'text/javascript';
		        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
		        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		    }());
		    </script>
		</div>
	</div>

@stop