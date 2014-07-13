<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SocialTest | 5150 Studios</title>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/styles.css">

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyBPMVJ5E0oetFFf0AZIGHIo8ipmRGQ7_Lo&amp;sensor=true"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/typeahead.min.js" type="text/javascript"></script>



</head>
<body>

<!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/') }}">SocialTest</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/') }}/postcode">Start</a></li>
            <li><a href="{{ url('/') }}/about">About</a></li>
            <li><a href="{{ url('/') }}/api">API</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/') }}/contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


        <div class="container">
            @yield('content')

            <div class="row">
              <div class="mastfoot col-md-12">

                  <p>SocialTest developed during GovHack 2014  | <a target="_blank" href="http://www.5150studios.com.au">5150 Studios</a> | <a target="_blank" href="https://www.facebook.com/5150StudiosAus">Facebook</a> | <a target="_blank" href="https://www.twitter.com/_mickdavies">@_mickdavies</a></p>
              </div>
            </div>

        </div>





</body>
</html>