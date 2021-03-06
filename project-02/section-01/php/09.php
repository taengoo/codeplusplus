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
        <h1 class="page-title">Section 1.9</h1>
      </div>

      <h3 class="section-header">PUTTING IN A TITLE SCREEN</h3>
      <p>
<?php echo nl2br(
"An animated starfield, although nice, isn't a game. To start to build out the same elements of the
game, one of the first requirements for a game is to display a title screen showing the users what
they can play.

The title screen for Alien Invasion isn't going to be anything special—just a text title and a subtitle.
So a generic GameScreen class with a title and subtitle centered on the screen is enough to get the
job done.
"); ?>
      </p>

      <h3 class="section-header">Drawing Text on Canvas</h3>
      <p>
<?php echo nl2br(
"Drawing text on the canvas is straightforward and allows you to use any font loaded on the page.
This flexibility means you can use any of the standard web-safe fonts as well as any fonts that have
been loaded via @font-face onto the page.

The declarations for @font-face take some care because depending on the browsers that need to be
supported, four different file formats need to be available. Luckily, if you aren't going to install the
files locally, but rather serve them off an online service such as the free Google web fonts, all that's
needed is a single linked style sheet. (You can browse the fonts available for free use at Google web
fonts at (www.google.com/webfonts.)

For Alien Invasion, the font Bangers gives the game a nice retro “Invasion of the Body Snatchers”
feel. Add the following line to your HTML (not your JavaScript) below the base.css link tag:
"); ?>
      </p>
	  
	  <pre><code class="html"><?php echo htmlentities('
<head>
	<meta charset="UTF-8"/>
	<title>Alien Invasion</title>
	<link rel="stylesheet" href="base.css" type="text/css" />
	<link href=\'http://fonts.googleapis.com/css?family=Bangers\' rel=\'stylesheet\' type=\'text/css\'>
</head>
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"Next, the game needs a TitleScreen class to display some text centered on the screen. To do this
you must use a new canvas method that hasn’t been discussed yet, fillText, and two new canvas
properties, font and textAlign.

The current font used is set by passing a CSS style to context.font, for example:

ctx.font = \"bold 25px Arial\";

This declaration would set the current font used by both measureText and fillText to 25 pixels
high, make it bold, and use the Arial font family.

To make sure the text is centered on a specific location horizontally, you’ll need to set the context
.textAlign property to center.

ctx.textAlign = \"center\";

After you calculate the location for the text and set the font style appropriately, you can use
fillText to draw solid text onto the canvas:

fillText(string, x, y);

fillText takes the string to draw and an x and y location for the top-left corner.

Armed with these text-drawing methods, you now have the tools to draw a title screen that shows a
title and a subtitle and calls an optional callback when the user presses the fire key.

Listing 1-8 shows the code to get that done. Add the TitleScreen class to the bottom of your
engine.js file.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// LISTING 1-8: The TitleScreen (titlescreen/engine.js)
var TitleScreen = function TitleScreen(title,subtitle,callback) {
	this.step = function(dt) {
		if(Game.keys[\'fire\'] && callback) callback();
	};
	this.draw = function(ctx) {
		ctx.fillStyle = "#FFFFFF";
		ctx.textAlign = "center";
		ctx.font = "bold 40px bangers";
		ctx.fillText(title,Game.width/2,Game.height/2);
		ctx.font = "bold 20px bangers";
		ctx.fillText(subtitle,Game.width/2,Game.height/2 + 40);
	};
};
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Similar to the Starfield object, TitleScreen defines a step and a draw method. The step method
has only one task: to check if the fire key is pressed, and if so, call the callback that was passed in.

The draw does the majority of the actual work. First, it sets a fillStyle (white) that will be used
on both the title and subtitle. Next, it sets the font for the title. You can horizontally center the title
on the page by moving x to half the width of the canvas. Next is a call to fillText with this calculated
x location and half the height of the canvas.

To draw the subtitle, the same calculation is repeated with a new font, and then the vertical position
is offset by 40 pixels to place it below the title.

You now need to add the title screen onto the page as a new board above the background starfields.
Modify your startGame method as shown, and add in a new callback called playGame:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
var startGame = function() {
	Game.setBoard(0,new Starfield(20,0.4,100,true))
	Game.setBoard(1,new Starfield(50,0.6,100))
	Game.setBoard(2,new Starfield(100,1.0,50));
	Game.setBoard(3,new TitleScreen("Alien Invasion", "Press space to start playing", playGame));
}

var playGame = function() {
	Game.setBoard(3,new TitleScreen("Alien Invasion", "Game Started..."));
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"If you reload the browser, you should see a title screen, and after you press the spacebar, the title
screen should update the subtitle to say “Game Started.” The playGame function will be replaced
with code to actually start to play the game in the next section.
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
