<!DOCTYPE html>
<html>
  <head>
    <title>{{ ButlerHTML::siteName() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- Bootstrap -->
    <link href="{{ ButlerHTML::themeUrl() }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="{{ ButlerHTML::pageClasses() }}">
    <h1><a href="{{ ButlerHTML::siteHome() }}">{{ ButlerHTML::siteName() }}</a></h1>
    @yield('content')

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ ButlerHTML::themeUrl() }}/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ ButlerHTML::themeUrl() }}/js/bootstrap.min.js"></script>
  </body>
</html>
