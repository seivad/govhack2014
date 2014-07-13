@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h1>Search For Your Postcode</h1>
			<hr />
			<form role="form">
				<div class="form-group">
				    <div class="input-group">
				      <input type="text" class="form-control typeahead" data-provide="typeahead" placeholder="4208..." />
				      <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
				    </div>
				    <span class="help-block">Start typing to select your Postcode.</span>
				  </div>
			</form>

			<script>
				var data = [
				@foreach($postcodes as $postcode)
					<?php if ($postcode === end($postcodes)) : ?>
						"{{ $postcode->postcode }}"
					<?php else : ?>
						"{{ $postcode->postcode }}",
					<?php endif; ?>
				@endforeach
				];



			$('.typeahead').typeahead(
			{
			items: 4,
			source:data,
			updater: function(item) {
				console.log(item);
				return window.location.replace("{{ url('/') }}/postcode/" + item);
			}
			});

			</script>

			<h3>Total Crime Per Suburb</h3>

			<ul class="list-group">
				@foreach($crimeTotalPerPostcode as $crime)
				  <li class="list-group-item">
				    <span class="badge">{{ $crime->count }}</span>
				    <a href="{{ url('/') }}/postcode/{{ $crime->postcode }}">{{ $crime->suburb }}</a>
				  </li>
				@endforeach
			</ul>

		</div>
	</div>
@stop