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
        <h1 class="page-title">Section 1.10</h1>
      </div>

      <h3 class="section-header">ADDING A PROTAGONIST</h3>
	  <p></p>

      <h3 class="section-header">Creating the PlayerShip Object</h3>
      <p>
<?php echo nl2br(
"The first step is to get a ship created and drawn on the page. Open up game.js and add the player
ship class to the bottom:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
var PlayerShip = function() {
	this.w = SpriteSheet.map[\'ship\'].w;
	this.h = SpriteSheet.map[\'ship\'].h;
	this.x = Game.width/2 - this.w / 2;
	this.y = Game.height - 10 - this.h;
	this.vx = 0;
	this.step = function(dt) {
		// TODO – added the next section
	}
	this.draw = function(ctx) {
		SpriteSheet.draw(ctx,\'ship\',this.x,this.y,1);
	}
}
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Much like a game screen, a sprite has the same two external methods: step and draw. Keeping the
interface consistent allows sprites and game screens to be mostly interchangeable. In initializing
the sprite, a few more variables are set that give the sprite a position on the page and a height and
a width. (The next chapter uses the position and height and width to do simple bounding box collision
detection.)

The width and height of the sprite are pulled from the sprite sheet. Although you could hard-code
the width and height here, using the dimensions from the sprite sheet mean there is only one location
that needs to be changed if the dimensions need to be changed.

Next, modify the playGame function to read as follows:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
var playGame = function() {
	Game.setBoard(3,new PlayerShip());
}
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"If you reload the index.html file and press the spacebar, you can see the player ship hanging out at
the bottom of the page.
"); ?>
      </p>

      <h3 class="section-header">Handling User Input</h3>
      <p>
<?php echo nl2br(
"The next task is to accept user input to allow the player to move the ship back and forth across the
game. This is handled in the step function inside of PlayerShip.

The step function has three main parts. The first is to check for user input to update the ship’s movement
direction; the second is to update the x coordinate based on the direction; and finally the function
needs to check that the updated x position is within the bounds of the screen. Replace the TODO
comment in the preceding step method with the following code:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
this.step = function(dt) {
	this.maxVel = 200;
	this.step = function(dt) {
		if(Game.keys[\'left\']) { 
			this.vx = -this.maxVel; 
		} else if(Game.keys[\'right\']) { 
			this.vx = this.maxVel; 
		} else { 
			this.vx = 0; 
		}
		
		this.x += this.vx * dt;
		if(this.x < 0) { 
			this.x = 0; 
		} else if(this.x > Game.width - this.w) {
			this.x = Game.width - this.w;
		}
	}
}
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The first part of the method checks the Game.keys map to see if the user is currently pressing the
left or the right arrow keys, and if so sets the velocity to the correct positive or negative value. The
second part of the code simply updates the x position with the current velocity multiplied by the
fraction of a second since the last update. Finally, the method checks to see if the x position is either
off the left side of the screen (less than zero) or off the right side of the screen (greater than the
width of the screen minus the width of the ship). If either of those conditions is true, the value of x
is modified to be within that range.
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
