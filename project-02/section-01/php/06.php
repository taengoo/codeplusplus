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
        <h1 class="page-title">Section 1.6</h1>
      </div>

      <h3 class="section-header">LOADING THE SPRITESHEET</h3>
      <p>
<?php echo nl2br(
"You have already seen most of the code necessary to load a sprite sheet and display sprites on the page.
All that remains is to extract the functionality into a package. One enhancement puts in a map of
sprite names to their locations to make it easier to draw the sprites on the screen. A second enhancement
encapsulates the onload callback functionality to hide the details from any calling classes.

Listing 1-5 shows the entire class.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities("
// LISTING 1-5: The SpriteSheet class
var SpriteSheet = new function() {
	this.map = { };
	this.load = function(spriteData,callback) {
		this.map = spriteData;
		this.image = new Image();
		this.image.onload = callback;
		this.image.src = 'images/sprites.png';
	};
	this.draw = function(ctx,sprite,x,y,frame) {
		var s = this.map[sprite];
		if(!frame) frame = 0;
		ctx.drawImage(this.image,
			s.sx + frame * s.w,
			s.sy,
			s.w, s.h,
			x, y,
			s.w, s.h
		);
	};
}
"); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"Although the class is short and has only two methods, it does have a number of things to note. First,
because there can be only one SpriteSheet object, the object is created with

new function() { ... }

This puts the constructor function and the new operator on the same line, ensuring that only one
instance of this class is ever created.

Next, two parameters pass into the constructor. The first parameter, spriteData, passes in sprite
data linking the rectangles of sprites to names. The second parameter, callback, passes as a callback
to the image onload method.

The second method, draw, is the main workhorse of the class because it does the actual drawing of
sprites onto a context. It takes as parameters the context, the string specifying the name of a sprite
from the spriteData map, an x and y location to draw the sprite, and an optional frame for sprites
with multiple frames.

The draw method uses those parameters to look up the spriteData in the map to get the source
location of the sprite as well as the width and height. (For this simple SpriteSheet class, every
frame of the sprite is expected to be the same size and on the same line.) It uses that information to
figure out the parameters to the more complicated drawImage method, discussed in the “Drawing
Images” section earlier in this chapter.

Although this code is designed to be a one-off and only useful for this specific game, you still need
to separate the game data, such as the sprite data and levels, from the game engine to make it easier
to test and build in pieces.

Add in the SpriteSheet to the top of a new file called engine.js file and replace the startGame
function in game.js with the following code:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
function startGame() {
	SpriteSheet.load({
		ship: { sx: 0, sy: 0, w: 18, h: 35, frames: 3 }
	},function() {
		SpriteSheet.draw(ctx,"ship",0,0);
		SpriteSheet.draw(ctx,"ship",100,50);
		SpriteSheet.draw(ctx,"ship",150,100,1);
	});
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Here the StartGame function calls SpriteSheet.load and passes in the details for a couple of
sprites. Next, in the callback function (after the images/sprites.png file loads) to test out the
drawing function, it draws three sprites on the canvas.

Modify the bottom of your index.html file to load engine.js first and then game.js:
"); ?>
      </p>
	  
	  <pre><code class="html"><?php echo htmlentities("
<body>
	<div id='container'>
		<canvas id='game' width='480' height='600'></canvas>
	</div>
	<script src='engine.js'></script>
	<script src='game.js'></script>
</body>
"); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Check out sprite_sheet/index.html in the chapter code for the preceding example in a
working form.

Now that the game can draw sprites on the page, you can set up the main game object to orchestrate
everything else.
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
