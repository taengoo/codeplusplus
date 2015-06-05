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
        <h1 class="page-title">Section 1.8</h1>
      </div>

      <h3 class="section-header">ADDING A SCROLLING BACKGROUND</h3>
      <p>
<?php echo nl2br(
"Are you crying out for something more interesting than boilerplate setup code? Here’s the good
news: From here on it gets much more interesting. Start by adding an animated starfield onto the
page to give the game some space-like qualities.

You can create a scrolling starfield in a few ways, but in this case you need to be a little careful with
the number of objects that get drawn on the screen because drawing too many sprites per frame
slows down the game on mobile devices. One way around this is to create an offscreen canvas buffer,
draw a bunch of random stars on that buffer, and then simply draw that starfield moving slowly
down the canvas. You’ll be limited to a few different layers of moving stars, but this effect should be
good enough for a retro shooter.
"); ?>
      </p>

	  <br>
	  
      <div class="panel panel-code-text">
		<div class="panel-heading">THE VAGARIES OF HTML5 PERFORMANCE</div>
        <div class="panel-body">

<p><?php echo nl2br(
"The performance question isn’t straightforward. One of the truisms of HTML5 is
that you never know what method has better performance without trying it out.
When deciding which way to implement a feature, your best bet is to go right to
the source: Test it out! You can see the performance for different numbers of stars
and ways to draw starfields at http://jsperf.com/prerendered-starfield.
JSPerf.com is a great place to test your intuition. To see the results of the starfield
test, scroll down the page and hit “Run Tests” to see the performance of the different
runs. In this case, the answer isn't so cut and dry. Most desktops do better
drawing individual stars, whereas iOS mobiles do better drawing the offscreen
buffer, at the time of this writing at least. As canvas will get better hardware
acceleration across the board in the near future, it seems like a safe bet that the
fillrate limited offscreen buffer (as described in this section) will be substantially
faster in the months and years to come.
"); ?>
</p>
		</div>
	  </div>

      <p>
<?php echo nl2br(
"Now break down a few of the necessary pieces before looking at the class as a whole. (You can skip
to the end of the section to see the full class if you want to peek ahead.)

The StarField class needs to do three main things. The first is to create an offscreen canvas. This
is actually quite easy because canvas is just a regular DOM element with two attributes, width and
height, and can be created the same way as any other DOM elements:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
var stars = document.createElement("canvas");

stars.width = Game.width;
stars.height = Game.height;

var starCtx = stars.getContext("2d");
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Because the stars field needs to be the same size as the game’s canvas, you can set the size by pulling
out the width and height properties that were set in the Game.initialize method.

After you create the canvas, you can start drawing stars (or rectangles) onto it. The easiest way to
do this is to call fillRect once for each star that needs to be drawn. A for loop combined with
using Math.random() to generate a random x and y location gets the job done:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
starCtx.fillStyle = "#FFF";
starCtx.globalAlpha = opacity;

for(var i=0;i<numStars;i++) {
	starCtx.fillRect(Math.floor(Math.random()*stars.width),
	Math.floor(Math.random()*stars.height), 2, 2);
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"The only piece that hasn’t been mentioned is the globalAlpha property. This property sets the
level of opacity for the canvas element. Because there are multiple layers of stars moving at different
speeds, a nice effect is to have the slower stars be slightly less bright than the faster moving ones to
simulate their being farther away.

Next is the draw method. The Starfield needs to draw the entire canvas element containing the
stars onto the game’s canvas; however, because it will scroll constantly, it needs to be drawn twice:
once for the top half and once for the bottom half. The method uses the starfield’s offset, a number
between zero and the height of the game to first draw whatever part of the starfield has been shifted
off the bottom of the game back at the top, and then draws the bottom part.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
this.draw = function(ctx) {
	var intOffset = Math.floor(offset);
	var remaining = stars.height - intOffset;
	if(intOffset > 0) {
		ctx.drawImage(stars,
			0, remaining,
			stars.width, intOffset,
			0, 0,
			stars.width, intOffset
		);
	}
	if(remaining > 0) {
		ctx.drawImage(stars,
			0, 0,
			stars.width, remaining,
			0, intOffset,
			stars.width, remaining
		);
	}
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"The code looks slightly confusing because it uses the nine-parameter version of drawImage to draw
the slices, but it’s actually just slicing the starfield into a top half and a bottom half, and drawing the
top half at the bottom of the game canvas and the bottom half at the top of the canvas.

Listing 1-7 shows the Starfield class in its entirety, which should go into the game.js file.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// LISTING 1-7: The Starfield (starfield/game.js)
var Starfield = function(speed,opacity,numStars,clear) {
	// Set up the offscreen canvas
	var stars = document.createElement("canvas");
	
	stars.width = Game.width;
	stars.height = Game.height;
	
	var starCtx = stars.getContext("2d");
	var offset = 0;
	
	// If the clear option is set,
	// make the background black instead of transparent
	if(clear) {
		starCtx.fillStyle = "#000";
		starCtx.fillRect(0,0,stars.width,stars.height);
	}
	
	// Now draw a bunch of random 2 pixel
	// rectangles onto the offscreen canvas
	starCtx.fillStyle = "#FFF";
	starCtx.globalAlpha = opacity;
	for(var i=0;i<numStars;i++) {
		starCtx.fillRect(Math.floor(Math.random()*stars.width),
		Math.floor(Math.random()*stars.height), 2, 2);
	}
	
	// This method is called every frame
	// to draw the starfield onto the canvas
	this.draw = function(ctx) {
		var intOffset = Math.floor(offset);
		var remaining = stars.height - intOffset;
		// Draw the top half of the starfield
		if(intOffset > 0) {
			ctx.drawImage(stars,
				0, remaining,
				stars.width, intOffset,
				0, 0,
				stars.width, intOffset
			);
		}
		
		// Draw the bottom half of the starfield
		if(remaining > 0) {
			ctx.drawImage(stars,
				0, 0,
				stars.width, remaining,
				0, intOffset,
				stars.width, remaining
			);
		}
	}
	
	// This method is called to update
	// the starfield
	this.step = function(dt) {
		offset += dt * speed;
		offset = offset % stars.height;
	}
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Only two parts haven’t been discussed. The step function at the bottom gets called with the fraction
of a second that has elapsed since the last call to step. All it needs to do is update the offset
variable based on the elapsed time and the speed, and then use the modulus (%) operator to make
sure the offset is between zero and the height of the Starfield.

There's also a conditional to check if the clear parameter is set. This parameter is used to fill the
first layer of stars with a black fill. (Later layers need to be transparent so that they overlay over each
other correctly.) This prevents the need to explicitly clear the canvas between frames and saves some
processing time.

To see the starfield in action, you need to modify your startGame function in game.js to add some
starfields. Modify it to add three starfields of varying opacity by setting it to the following:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
var startGame = function() {
	Game.setBoard(0,new Starfield(20,0.4,100,true));
	Game.setBoard(1,new Starfield(50,0.6,100));
	Game.setBoard(2,new Starfield(100,1.0,50));
}
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"Only the first starfield has the clear parameter set to true. Each starfield has a higher speed combined
with a higher opacity than the last. This gives an effect of stars at different distances speeding by.
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
