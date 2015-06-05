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
        <h1 class="page-title">Section 1.2</h1>
      </div>

      <h3 class="section-header">BUILDING A COMPLETE GAME IN 500 LINES</h3>
      <p>
<?php echo nl2br(
"To drive home the point of how easy it is to build games in HTML5, the final game you build in the
first three chapters contains fewer than 500 lines of code, all without using any libraries.
"); ?>
      </p>

      <h3 class="section-header">Understanding the Game</h3>
      <p>
<?php echo nl2br(
"Alien Invasion is a top-down 2-D shooter game built in the spirit of the game 1942 (but in space) or
a simplified version of Galaga. The player controls a ship, shown at the bottom of the screen, flying
the ship vertically through an endless space field while defending Earth against an incoming hoard
of aliens.

When played on a mobile device, control is via left and right arrows shown on the bottom left of the
screen, and a Fire button on the right. When played on the desktop, the user can use the keyboard’s
arrow keys to fly and the spacebar to fire.

To compensate for all the different screen sizes of mobile devices, the game resizes the play area to
always play at the size of the device. On the desktop it plays in a rectangular area in the middle of
the browser page.
"); ?>
      </p>

      <h3 class="section-header">Structuring the Game</h3>
      <p>
<?php echo nl2br(
"Nearly every game of this type consists of a few of the same pieces: some asset loading, a title
screen, sprites, user input, collision detection, and a game loop to tie it all together.

The game uses as few formal structures as possible. Instead of building explicit classes, you take
advantage of JavaScript’s dynamic typing (more on this in the section “Building Object-Oriented
JavaScript”). Languages such as C, C++, and Java are called “strongly typed” because you need to
be very explicit about the type of parameters that you pass around to method. This means you need
to explicitly define base classes and interfaces when you want to pass different types of objects to
the same method. JavaScript is weakly (or dynamically) typed because the language doesn’t enforce
the types of parameters. This means you define your objects more loosely, adding methods to each
object as needed, without building a bunch of base classes or interfaces.

Image asset handling is dead simple. You load a single image, called a sprite sheet, that contains all
your game’s sprite images in a single PNG and execute a callback after that image loads. The game
also has a single method for drawing a sprite onto your canvas.

The title screen renders a sprite for the main title and shows the same animated starfield from the
main game moving in the background.

The game loop is also simple. You have an object that you can treat as the current scene, and you
can tell that scene to update itself and then to draw itself. This is a simple abstraction that works for
both title and end game screens as well as the main part of the game.

User input can use a few event listeners for keyboard input and a few “zones” on your canvas to detect
touch input. You can use the HTML standard method addEventListener to support both of these.

Lastly, for collision detection, you punt the hard stuff and just loop over the bounding boxes of each
of the objects to detect a collision. This is a slow and naive way to implement collision detection,
but it’s simple to implement and works reasonably well as long as the number of sprites you check
against is small.
"); ?>
      </p>

      <h3 class="section-header">The Final Game</h3>
      <p>
<?php echo nl2br(
"To get a sense of where the game is headed, check out Figure 1-1,
and visit http://cykod.github.com/AlienInvasion/ on both
a desktop browser and whatever mobile device you have handy.
The game should run on any smartphone that supports HTML5
canvas; however, canvas performance on Android versions
before Ice Cream Sandwich is poor.

Now, it’s time to get started.
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
