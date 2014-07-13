<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SocialTest | 5150 Studios</title>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/styles.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/typeahead.min.js" type="text/javascript"></script>

</head>
<body>

<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">SocialTest</h3>
              <ul class="nav masthead-nav">
                <li class="active"><a href="#{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/') }}/postcode">Start</a></li>
                <li><a href="{{ url('/') }}/about">About</a></li>
                <li><a href="{{ url('/') }}/contact">Contact</a></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">

<div class="searching">
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
    </div><!-- /searching -->

            <h1 class="cover-heading">Welcome to SocialTest.</h1>
            <p class="lead">SocialTest was developed during GovHack 2014 by Mick Davies @ 5150 Studios during a 46 hour development period.<br /><br />You can search through multiple government datasets comparing Soft Crimes, Centrelink Assistance and Rental Prices to gauge your opinion on South-East Queensland suburbs.<br /><br />We also provide a unique score for each suburb which is based on a number of criteria points and factors using government data.</p>
            <p class="lead">
              <a href="{{ url('/') }}/postcode" class="btn btn-lg btn-primary">Start Now</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>SocialTest developed during GovHack 2014  | <a target="_blank" href="http://www.5150studios.com.au">5150 Studios</a> | <a target="_blank" href="https://www.facebook.com/5150StudiosAus">Facebook</a> | <a target="_blank" href="https://www.twitter.com/_mickdavies">@_mickdavies</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

<footer>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>



