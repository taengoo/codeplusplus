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
        <h1 class="page-title">Section 1.7</h1>
      </div>

      <h3 class="section-header">CREATING THE GAME OBJECT</h3>
      <p>
<?php echo nl2br(
"The main game object is a one-off object called, perhaps not surprisingly, Game. Its main purpose is
to initialize the game engine for Alien Invasion and run the game loop as well as provide a mechanism
for changing the main scene that displays.

Because Alien Invasion doesn’t have an input subsystem, the Game class is also responsible for setting
up listeners for keyboard and touch input. To start, only keyboard input is handled; touch input
is added in the next chapter.

Now that the game starts to take shape, a few additional considerations are necessary. Instead of
just executing code willy-nilly when it is evaluated, it generally makes sense to wait for the page to
finish downloading before initializing the game. The Game class takes this into consideration and
listens for a “load” event from the window before booting up the game.

The code for the Game class will be added at the top of engine.js.
"); ?>
      </p>

      <h3 class="section-header">Implementing the Game Object</h3>
      <p>
<?php echo nl2br(
"Now walk through the 40+ lines of code that make up the Game object a section at a time. (See the
full listing at the top of game_class/engine.js in the chapter code.) The class starts off much like
the SpriteSheet, as a one-time class instance:

var Game = new function() {

Next is the initialization routine, called with the ID of the canvas element to fill, the sprite data that
is passed to the SpriteSheet, and the callback when the game is ready to start.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// Game Initialization
this.initialize = function(canvasElementId,sprite_data,callback) {
	this.canvas = document.getElementById(canvasElementId);
	this.width = this.canvas.width;
	this.height= this.canvas.height;
	
	// Set up the rendering context
	this.ctx = this.canvas.getContext && this.canvas.getContext(\'2d\');
	if(!this.ctx) { 
		return alert("Please upgrade your browser to play"); 
	}
	
	// Set up input
	this.setupInput();
	
	// Start the game loop
	this.loop();
	
	// Load the sprite sheet and pass forward the callback.
	SpriteSheet.load(sprite_data,callback);
};
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"Much of this code should be familiar from earlier in the chapter. The parts where you grab the
canvas element and check for a 2d context are straightforward. Next is a call to setupInput(),
which is discussed next. Finally, the game loop starts, and the data for the sprite sheet passes
through to SpriteSheet.load.

The next section sets up input:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// Handle Input
var KEY_CODES = { 37:\'left\', 39:\'right\', 32 :\'fire\' };
this.keys = {};
this.setupInput = function() {
	window.addEventListener(\'keydown\',function(e) {
		if(KEY_CODES[event.keyCode]) {
			Game.keys[KEY_CODES[event.keyCode]] = true;
			e.preventDefault();
		}
	},false);
	window.addEventListener(\'keyup\',function(e) {
		if(KEY_CODES[event.keyCode]) {
			Game.keys[KEY_CODES[event.keyCode]] = false;
			e.preventDefault();
		}
	},false);
};
'); ?>
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The main point of this block is to add event listeners for keydown and keyup events for those keys
that you care about: specifically the left arrow, the right arrow, and the spacebar. For those events,
the listeners translate a numeric Keycode to a friendlier identifier and update a hash called Game.keys
to represent the current state of the user input. The player uses the Game.keys hash to control the
ship. For keys used by the game, the event handlers also call e.preventDefault(), which prevents
the browser from performing any default behavior in response to the key presses. (For the arrow keys
and the spacebar, the browser would normally try to scroll the page.)

One more point about the preceding event handler code: It uses the W3C event model
addEventListener method. This code is supported in current versions of the Chrome,
Safari, and Firefox browsers, but only Internet Explorer (IE) versions 9 and above. This is
not a huge deal because canvas isn’t supported pre-IE9 in any case, but if you want to add
compatibility for older browsers, it’s something you need to be careful with. (The engine built
starting in Chapter 9, “Bootstrapping the Quintus Engine Part I,” uses jQuery’s on method to
enable easy browser-independent event attachment.)

The last section of the Game class is relatively short:
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// Game Loop
var boards = [];
this.loop = function() {
	var dt = 30/1000;
	for(var i=0, len = boards.length;i<len;i++) {
		if(boards[i]) {
			boards[i].step(dt);
			boards[i] && boards[i].draw(Game.ctx);
		}
	}
	setTimeout(Game.loop,30);
};
// Change an active game board
this.setBoard = function(num,board) { boards[num] = board; };
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"The boards are the pieces of the game updated and drawn onto the canvas. An example of a board
might be a background or a title screen. (In the next chapter, you create a special board for handling
sprites.) The Game.loop function loops through all the boards, checks if there is a board at
that index, and if so, calls that board’s step method with the approximate number of seconds that
have passed, followed by calling the board’s draw method, passing in the rendering context. For the
draw call, the step call may have removed the board, so checking again that the board exists with
boards[i] && keeps the code from blowing up. Finally, setTimeout is used in the loop function
to ensure that the loop runs again in 30 milliseconds. Using setTimout instead of setInterval
ensures that timer events don’t back up if the game slows down, which could lead to strange warplike
behavior. Because setTimeout doesn’t retain the context of the called function, Game.loop
needs to explicitly refer to the Game object instead of using the this keyword.
"); ?>
      </p>

	  <br>
	  
      <div class="panel panel-code-text">
		<div class="panel-heading">TIMER METHODS</div>
        <div class="panel-body">

<p><?php echo nl2br(
"There’s more to JavaScript timers for game development than just setTimeout
or setInterval. Chapter 9 discusses the requestAnimationFrame method that
enables the browser to sync calls to your game with screen updates. Also, hard
coding the amount of time that has passed to a fixed number is generally a bad
idea as the timer may be called at different intervals depending on browser performance,
but it should be okay for this simple type of game.
"); ?>
</p>
		</div>
	  </div>

      <p>
<?php echo nl2br(
"Because boards drop from index 0 to the highest index, background boards (such as the starfield in
the next section) should be added to lower indexes, whereas elements added at the end, such as the
score and HUDs, should be drawn last.

Finally, the only method on the Game object that is called regularly during the game, Game.setBoard, is
defined. All this method does is set one of the game boards used in the loop method. It is used to switch
active GameBoards, which are used for title screens as well as the main section of the game.
"); ?>
      </p>
	  
      <h3 class="section-header">Refactoring the Game Code</h3>
      <p>
<?php echo nl2br(
"As you build games in the browser, you’ll want to keep attention on the structure of what you’re
building. JavaScript is a very flexible language, and without some discipline in how your game is
structured, things can fall apart quickly. A common pattern in this book will be to show you how
to use an API or technique quickly and simply and then take some time to structure that code into a
library or module.

The initial code for displaying a sprite on the screen in game.js is going to be replaced with code
that does the same but is structured in a way to be usable in a more complicated game.

Update game.js to use the Game class. Remove anything you have in game.js and add the code
shown in Listing 1-6.
"); ?>
      </p>
	  
	  <pre><code class="javascript"><?php echo htmlentities('
// LISTING 1-6: A refactored game.js method (game_class/game.js)
var sprites = {
	ship: { sx: 0, sy: 0, w: 18, h: 35, frames: 3 }
};

var startGame = function() {
	SpriteSheet.draw(Game.ctx,"ship",100,100,1);
}

window.addEventListener("load", function() {
	Game.initialize("game",sprites,startGame);
});
'); ?>
	  </code>
	  </pre>

      <p>
<?php echo nl2br(
"All this code does is set up the available sprites, create a dummy startGame function that draws a
ship on the canvas to make sure everything is working correctly, and then listen for the load event
on the window object to call the Game.initialize function with the appropriate arguments.

Reload your index.html file (or run the code example game_class/index.html) to see a lonesome
ship hanging out near the canvas element.
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
