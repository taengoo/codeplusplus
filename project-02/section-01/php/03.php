<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Code++</title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/test.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/test-theme.css" rel="stylesheet">

    <link href="/dist/css/highlight-default.css" rel="stylesheet">
    <link href="/dist/css/highlight-theme.css" rel="stylesheet">
	
	<style>.hljs { padding: 0 1.5em; }</style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Code++</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="page-heading">
        <h1 class="page-title">Section 1.3</h1>
      </div>

      <h3 class="section-header">ADDING THE BOILERPLATE HTML AND CSS</h3>
      <p>
<?php echo nl2br(htmlentities(
"The main boilerplate for an HTML5 file is minimal. You
get a valid HTML file with a <canvas> element inside of a
container centered on the page, as shown in Listing 1-1.
")); ?>
      </p>
	  
	  <pre><code class="html"><?php echo htmlentities('
<!--
LISTING 1-1: Boilerplate game HTML 
-->
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Alien Invasion</title>
		<link rel="stylesheet" href="base.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<canvas id="game" width="320" height="480"></canvas>
		</div>
		<script src="game.js"></script>
	</body>
</html>
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The only external files so far are the base.css file, an external style sheet, and a nonexistent
game.js file that will contain the JavaScript code for the game. Drop the HTML from Listing 1-1
into a new directory, and call it index.html.

In base.css you need two separate sections. The first is a CSS reset. CSS resets make sure all elements
look the same in all browsers and any per-element styling and padding is removed. To do this,
the reset sets the size of all elements to 100% (16 pixels for fonts) and removes all padding, borders,
and margins. The reset used is the well-known Eric Meyer reset: http://meyerweb.com/eric/
tools/css/reset/.

You can simply copy the CSS code verbatim to the top of base.css.

Next, you need to add two additional styles to the CSS file, as shown in Listing 1-2.
"); ?>
      </p>
	  
	  <pre><code class="css">
/* LISTING 1-2: Base canvas and container styles */
/* Center the container */
#container {
  padding-top:50px;
  margin:0 auto;
  width:480px;
}
/* Give canvas a background */
canvas {
  background-color: black;
}
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The first container style gives the container a little padding at the top of the page and centers its content
in the middle of the page. The second style gives the canvas element a black background.
"); ?>
      </p>
	  <br>
	  <br>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/dist/js/test.min.js"></script>
    <script src="/dist/js/highlight.pack.js"></script>
    <script>
    hljs.configure({ tabReplace: '  ' });
    hljs.initHighlightingOnLoad();
    </script>
  </body>
</html>
