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
        <h1 class="page-title">Section 1.4</h1>
      </div>

      <h3 class="section-header">GETTING STARTED WITH CANVAS</h3>
      <p>
<?php echo nl2br(htmlentities(
"You hopefully noticed a canvas tag in the middle of the HTML on the page (as shown in
Listing 1-2):

<canvas id='game' width='320' height='480'></canvas>

This is where all the action for the game takes place—so much exciting stuff you can do in such an
unassuming tag.

The tag has an id for easy reference along with a width and height. Unlike most HTML elements,
you generally never want to add a CSS width and height onto canvas elements. Those styles visually
resize your canvas but do not affect the pixel dimensions of the canvas, which is controlled by
the width and height on the element. Most of the time you should leave these alone.
")); ?>
      </p>
	  
	  <h3 class="section-header">Accessing the Context</h3>
	  <p>
<?php echo nl2br(htmlentities(
"Before you can do any drawing onto canvas, you need to fetch the context from the canvas element.
The context is the object that you actually make API calls against (not the canvas element itself.)
For 2-D canvas games, you can pull out the 2-D context, as shown in Listing 1-3.
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
// LISTING 1-3: Accessing the rendering context
var canvas = document.getElementById('game');

var ctx = canvas.getContext && canvas.getContext('2d');
if(!ctx) {
	// No 2d context available, let the user know
	alert('Please upgrade your browser');
} else {
	startGame();
}

function startGame() {
	// Let's get to work
}
"); ?>
	  </code>
	  </pre>
	  
	  <p>
<?php echo nl2br(htmlentities(
"First, grab the element from the document. These initial chapters use built-in browser methods for
all DOM (Document Object Model) interaction; later you are introduced to how to do the same
things more concisely using jQuery.

Next, call getContext on the canvas element. A double-ampersand (&&) short circuit operator protects
you from calling a nonexistent method. This is used in the next if statement in case the visiting
browser doesn’t support the canvas element. You always want to “fail loudly” in this case, so
the players correctly blame their browser instead of your code. “Failing loudly” means that instead
of “failing silently” with a white screen and an error hiding on the JavaScript console, the game
explicitly pops up with a message that tells the user that something went wrong.

There is a 3-D WebGL-powered rendering context available on desktop browsers (excluding
Internet Explorer), but it is called glcanval and is available only on mobile Nokia devices at the
time of this writing. WebGL is another standard, separate from HTML5, that allows you to use
hardware-accelerated 3-D graphics in the browser.

Add the code from Listing 1-3 to a file named game.js. You now can start playing with the canvas
element.
")); ?>
	  </p>
	  
	  <h3 class="section-header">Drawing on Canvas</h3>
	  <p>
<?php echo nl2br(htmlentities(
"This initial tutorial doesn’t use any of the vector-based drawing routines, but for the sake of getting
something up on the screen quickly, you can draw a rectangle on the page. Modify the startGame()
method of your game.js file to read as follows:
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
function startGame() {
	ctx.fillStyle = '#FFFF00';
	ctx.fillRect(50,100,380,400);
}
"); ?>
	  </code>
	  </pre>
	  
	  <p>
<?php echo nl2br(htmlentities(
"To draw a filled rectangle, you use the fillRect method on the ctx object, but first you need to set
a fill style. You can pass in standard CSS color representations as strings to fillStyle, including
hexadecimal colors, RGB triples, or RGBA quads.

To layer a semitransparent rectangle on top of the existing one, add the following:
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
function startGame() {
	ctx.fillStyle = '#FFFF00';
	ctx.fillRect(50,100,380,400);
	// Second, semi-transparent blue rectangle
	ctx.fillStyle = 'rgba(0,0,128,0.5);';
	ctx.fillRect(0,50,380,400);
}
"); ?>
	  </code>
	  </pre>

	  <p>
<?php echo nl2br(htmlentities(
"If you add the preceding code and reload your index.html file, you see a nice, big blue rectangle
smack dab in the middle of your black canvas.
")); ?>
	  </p>
	  
	  <h3 class="section-header">Drawing Images</h3>
	  <p>
<?php echo nl2br(htmlentities(
"Alien Invasion is an old-school, top-down 2-D shooter game with retro-looking bitmap graphics.
Luckily canvas provides an easy method called drawImage that comes in a couple of flavors, depending
upon whether you want to draw an entire image or just a portion of an image.

The only complication is that, to draw those graphics, the game needs to load the image first. This
isn’t a huge deal because browsers are handy at loading images; however, they load them asynchronously,
so you need to wait for a callback to let you know that the image is ready to go.

Make sure you have copied the sprites.png file over from the book assets for Chapter 1 into an
images/ directory underneath your current game, and then add the code from Listing 1-4 to the
bottom of your startGame function.
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
// LISTING 1-4: Drawing images with canvas (canvas/game.js)
function startGame() {
	ctx.fillStyle = '#FFFF00';
	ctx.fillRect(50,100,380,400);
	// Second, semi-transparent blue rectangle
	ctx.fillStyle = 'rgba(0,0,128,0.8);';
	ctx.fillRect(25,50,380,400);
	var img = new Image();
	img.onload = function() {
		ctx.drawImage(img,100,100);
	}
	img.src = 'images/sprites.png';
}
"); ?>
	  </code>
	  </pre>
	  
	  <p>
<?php echo nl2br(htmlentities(
"If you reload the page, you should now see the sprite sheet layered
on top of your rectangles. See canvas/game.js in the chapter
code for the complete code. You can see the code first waits
for the onload callback before trying to draw the image onto the
context and then sets the src after setting up the callback. The
order is important because Internet Explorer does not trigger the
onload callback if the image is cached if you reverse the order of
the two lines. You can see the results—admittedly not pretty—in
Figure 1-2.

This first example uses the simplest drawImage method—one
that takes an image and an x and y coordinate and then draws
the entire image on the canvas.

Modify the drawImage line to read as follows:
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
var img = new Image();
img.onload = function() {
	ctx.drawImage(img,100,100,200,200);
}
img.src = 'images/sprites.png';
"); ?>
	  </code>
	  </pre>
	  
	  <p>
<?php echo nl2br(htmlentities(
"The image has now shrunk down to the size of the extra parameters that you passed in which are
the destination width and height. This is a second form of drawImage that enables you to scale
images up or down to any dimensions.

The last form of drawImage, however, is the one that you'll use the most often with bitmapped
games. It is also the most complicated and takes a total of nine parameters:

drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)

This form enables you to specify a source rectangle in the image using parameters sx, sy, sWidth,
and sHeight and a destination rectangle on the canvas using parameters dx, dy, dWidth, and
dHeight. As you’ve probably figured out, to pull out an individual frame from one of the sprites
in the sprite sheet, this is the format you want to use. Now give it a shot by changing the call to
drawImage to:
")); ?>
	  </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
var img = new Image();
img.onload = function() {
	ctx.drawImage(img,18,0,18,25,100,100,18,25);
}
img.src = 'images/sprites.png';
"); ?>
	  </code>
	  </pre>
	  
	  <p>
<?php echo nl2br(htmlentities(
"If you reload the page, you see there’s now a single instance of the player ship on the canvas. So far
so good. In the next section, you start to build out the structure for an actual game.
")); ?>
	  </p>

	  <br>
	  
      <div class="panel panel-code-text">
		<div class="panel-heading">IMMEDIATE VERSUS RETAINED MODE</div>
        <div class="panel-body">

<p><?php echo nl2br(
"Canvas is a tool for creating games in what’s commonly referred to as Immediate
mode. When you use canvas, all you are doing is drawing pixels onto the page.
Canvas doesn’t know anything about your spaceships or missiles that fly around.
All it cares about are pixels, and most canvas games clear the canvas completely
between frames and redraw everything at an updated position.

Contrast this with using the DOM to create a game. Using the DOM would be
equivalent to creating a game in Retained mode, as the browser keeps track of the
“scene graph” for you. This scene graph keeps track of the position and hierarchy
of objects. Instead of starting from scratch in each frame, you need to adjust only
the elements that have changed and the browser takes care of rendering everything
correctly. Which is better? Well, it depends on your game. See the discussion in
Chapter 12, “Building Games in CSS3,” to learn when to use which method.
"); ?>
</p>
		</div>
	  </div>		  
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
