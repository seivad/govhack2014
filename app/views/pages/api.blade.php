@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>API Documentation</h1>
			<hr />
		    <p class="lead">Please get in touch for further information or recommendations.</p>

		    <div class="panel-group" id="api-accordion">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#api-accordion" href="#collapseOne">
			          /postcode
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in">
			      <div class="panel-body">
			        <p>All Suburb / Postcode Information as an overview page</p>
			        <p><strong>Use:</strong> <code><a target="_blank" href="{{ url('/') }}/postcode">{{ url('/') }}/postcode</a></code></p>
			      </div>
			    </div>
			  </div>
			  
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#api-accordion" href="#collapseTwo">
			          /postcode/{postcode}
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse">
			      <div class="panel-body">
			        <p>Requires a 4 digit South-East Queensland postcode number.<br />
			        Returns a specific page of data for that particular postcode.<br />
			        6 Months of Crime Data as a line graph and soft crime breakdown.<br />
			        Provides the month of March Centrelink assistance payouts <em>(requires additional data from data.gov.au)</em>.<br />
			        Provides 3 months of Rental Bonds lodged via the ATO (January to March only). <em>(requires additional data from data.gov.au)</em>.</p>
			        <p>
			        	<strong>Use:</strong> <code><a target="_blank" href="{{ url('/') }}/postcode/4208">{{ url('/') }}/postcode/4208</a></code>
			        </p>
			      </div>
			    </div>
			  </div>
			  
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#api-accordion" href="#collapseThree">
			          /postcode/{postcode}?month={month name}
			        </a>
			      </h4>
			    </div>
			    <div id="collapseThree" class="panel-collapse collapse">
			      <div class="panel-body">
			        <p>Requires a 4 digit South-East Queensland postcode number.<br />
			        Returns a specific page of data for that particular postcode based on the query string <code>?month=march</code>.<br />
			        6 Months of Crime Data as a line graph and soft crime breakdown.<br />
			        Provides the month of March Centrelink assistance payouts <em>(requires additional data from data.gov.au)</em>.<br />
			        Provides 3 months of Rental Bonds lodged via the ATO (January to March only). <em>(requires additional data from data.gov.au)</em>.</p>

			        <p>
			        	<strong>Use:</strong> <code><a target="_blank" href="{{ url('/') }}/postcode/4208?month=march">{{ url('/') }}/postcode/4208?month=march</a></code>
			        </p>
			      </div>
			    </div>
			  </div>

			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#api-accordion" href="#collapseFour">
			          /postcode/{postcode}?start_date={year-month-day}&amp;end_date={year-month-day}
			        </a>
			      </h4>
			    </div>
			    <div id="collapseFour" class="panel-collapse collapse">
			      <div class="panel-body">
			        <p>Requires a 4 digit South-East Queensland postcode number.<br />
			        Returns a specific page of data for that particular postcode based on the query string which includes both a <code>?start_date=2014-01-01</code> and <code>&end_date=2014-06-01</code>.<br />
			        From <code>start_date</code> to <code>end_date</code> work of Crime Data as a line graph and soft crime breakdown.<br />
			        Provides the month of March Centrelink assistance payouts <em>(requires additional data from data.gov.au)</em>.<br />
			        Provides 3 months of Rental Bonds lodged via the ATO (January to March only). <em>(requires additional data from data.gov.au)</em>.</p>

			        <p>
			        	<strong>Use:</strong> <code><a target="_blank" href="{{ url('/') }}/postcode/4208?start_date=2014-01-01&amp;end_date=2014-06-01">{{ url('/') }}/postcode/4208?start_date=2014-01-01&amp;end_date=2014-06-01</a></code>
			        </p>
			      </div>
			    </div>
			  </div>
			</div>



		</div>
	</div>
@stop