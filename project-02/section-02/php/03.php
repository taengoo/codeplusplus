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
    <link href="../../dist/css/test.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/test-theme.css" rel="stylesheet">

    <link href="../../dist/css/highlight-default.css" rel="stylesheet">
    <link href="../../dist/css/highlight-theme.css" rel="stylesheet">
  
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
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="page-heading">
        <h1 class="page-title">Section 2.3</h1>
      </div>

      <h3 class="section-header">ADDING ENEMIES</h3>
      <p><?php echo nl2br(
"A space shooter isn’t any fun without enemies, so next you will add some enemies into the game
by creating an Enemy sprite class. Although there will be multiple types of enemies, they are all
represented by the same class and differentiated only by different templates for their image and
movement.
"); ?></p>

      <h3 class="section-header">Calculating Enemy Movement</h3>
      <p><?php echo nl2br(
"You define the movement for enemies with an equation that contains a few pluggable parameters
that enable enemies to exhibit relatively complex behavior without a lot of code. The equation sets
the velocity of an enemy at a given time since it was added to the board:

vx = A + B * sin(C * t + D)
vy = E + F * sin(G * t + H)

All the letters A through H represent constant numbers. Don’t let these equations intimidate you.
All they say is that the velocity of an enemy is based on a constant value plus a value that repeats
cyclically. (Using a sine enables the cyclical value.) Using an equation such as this allows the game
to add enemies that twirl around the screen in interesting patterns and adds some dynamism to
the game that a bunch of enemies flying in a straight line wouldn’t. Sines and cosines are used
often in game development for animation because they provide a mechanism for smooth movement
transitions. See Table 2.1 for a description of the effect each parameter A–H has on the
movement of an enemy.

NOTE Parabolas created with quadratic equations ( a + bx + cx*x ) are also useful
for this but don't provide periodic behavior, so they aren’t quite as useful in
this situation.

TABLE 2-1: Parameter Descriptions
PARAMETER DESCRIPTION
A Constant horizontal velocity
B Strength of horizontal sinusoidal velocity
C Period of horizontal sinusoidal velocity
D Time shift of horizontal sinusoidal velocity
E Constant vertical velocity
F Strength of vertical sinusoidal velocity
G Period of vertical sinusoidal velocity

A number of different combinations of values produce different behaviors. If B and F are set to zero,
then the enemy flies straight because the sinusoidal component in both directions is zero. If F and A
are set to zero, then the enemy flies with a constant y velocity but moves back and forth smoothly in
the x direction.

You create a variety of different enemies in the section “Setting Up the Enemies” by setting different
variations of parameters.

In a production game, if you don’t want to worry about handling the math yourself, you could consider
using a tweening engine such as TweenJS (www.createjs.com/TweenJS), which can handle
smoothly moving objects from one position to another in a number of interesting manners.
"); ?></p>

      <h3 class="section-header">Constructing the Enemy Object</h3>
      <p><?php echo nl2br(
"You can create enemies from a blueprint that sets the sprite image used, the initial starting location,
and the values for the movement of constants A–H. The constructor also enables an override object
to be passed in to override the default blueprint settings.

Much like PlayerMissile, the Enemy object adds methods onto the prototype to speed object creation
and reduce the memory footprint.

This initial version of Enemy looks much like the previous two sprite classes that have been built
(PlayerShip and PlayerMissile), with a constructor function shown in in Listing 2-2 that initializes
some state; a step method that updates the position and checks if the sprite is out of bounds;
and a draw function that renders the sprite. Because of the need to copy over from the blueprint and
any override parameters and set up the velocity equation parameters, the constructor function is a
little more complicated than previous ones.

JavaScript doesn’t have a built-in method to easily copy attributes over from another object, so you
need to roll your own loop over the attributes to do it. To prevent the need for the blueprint to set
each of the parameters A–H, each of those are also be initialized to zero.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-2: The Enemy Constructor
var Enemy = function(blueprint,override) {
  var baseParameters = { 
    A: 0, B: 0, C: 0, D: 0,
    E: 0, F: 0, G: 0, H: 0 
  }

  // Set all the base parameters to 0
  for (var prop in baseParameters) {
    this[prop] = baseParameters[prop];
  }

  // Copy of all the attributes from the blueprint
  for (prop in blueprint) {
    this[prop] = blueprint[prop];
  }

  // Copy of all the attributes from the override, if present
  if(override) {
    for (prop in override) {
      this[prop] = override[prop];
    }
  }

  this.w = SpriteSheet.map[this.sprite].w;
  this.h = SpriteSheet.map[this.sprite].h;
  this.t = 0;
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The constructor first copies three sets of objects into the this object: the base parameters, the blueprint,
and the override. Because the enemy can have different sprites depending on the blueprint,
the width and the height are set afterward based on the sprite property of the object. Finally, a
t parameter is initialized to 0 to keep track of how long this sprite has been alive.
If the repetition in this code bothers you, don’t worry! You clean it up in the section “Refactoring
the Sprite Classes” later in this chapter.
"); ?></p>

      <h3 class="section-header">Stepping and Drawing the Enemy Object</h3>
      <p><?php echo nl2br(
"The step function (see Listing 2-3) for the enemy should update the velocity based on the aforementioned
equation. The this.t property needs to be incremented by dt to keep track of how long the
sprite has been alive. Next, the equation from earlier in this chapter can be plugged directly into the
step function to calculate the x and y velocity. From the x and y velocity, the x and y location are
updated. Finally, the sprite needs to check if it’s gone off the board to the right or the left, in which
case the enemy can remove itself from the page.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-3: The Enemy Step and Draw Methods
Enemy.prototype.step = function(dt) {
  this.t += dt;
  this.vx = this.A + this.B * Math.sin(this.C * this.t + this.D);
  this.vy = this.E + this.F * Math.sin(this.G * this.t + this.H);
  this.x += this.vx * dt;
  this.y += this.vy * dt;

  if(this.y > Game.height ||
     this.x < -this.w ||
     this.x > Game.width) {
    this.board.remove(this);
  }
}
Enemy.prototype.draw = function(ctx) {
  SpriteSheet.draw(ctx,this.sprite,this.x,this.y);
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The draw function is a near duplicate of the PlayerMissile object; the only difference is that it
must look up which sprite to draw in a property called sprite.
"); ?></p>

      <h3 class="section-header">Adding Enemies on the Board</h3>
      <p><?php echo nl2br(
"Now you add some initial enemy sprites to the top of game.js along with a simple enemy blueprint
for one enemy that can fly down the page:
"); ?></p>

      <pre><code class="javascript">
var sprites = {
  ship: { sx: 0, sy: 0, w: 37, h: 42, frames: 1 },
  missile: { sx: 0, sy: 30, w: 2, h: 10, frames: 1 },
  enemy_purple: { sx: 37, sy: 0, w: 42, h: 43, frames: 1 },
  enemy_bee: { sx: 79, sy: 0, w: 37, h: 43, frames: 1 },
  enemy_ship: { sx: 116, sy: 0, w: 42, h: 43, frames: 1 },
  enemy_circle: { sx: 158, sy: 0, w: 32, h: 33, frames: 1 }
};

var enemies = {
  basic: { x: 100, y: -50, sprite: 'enemy_purple', B: 100, C: 2 , E: 100 }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Next, modify playGame to add a pair of enemies to the top of the page:
"); ?></p>

      <pre><code class="javascript">
var playGame = function() {
  var board = new GameBoard();

  board.add(new Enemy(enemies.basic));
  board.add(new Enemy(enemies.basic, { x: 200 }));
  board.add(new PlayerShip());

  Game.setBoard(3,board);
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Using the enemies object as a blueprint for the enemy makes adding an enemy onto the page as
simple as calling new Enemy() with that blueprint. To make the second enemy appear to the right of
the first, an override object is passed in setting x to 200.

Reload the file, and when the game starts, you should have a couple of bad guys snake their way
down the screen and then disappear off the bottom. You can also take a look at http://mh5gd.
com/ch2/enemies to see the effect this code has. These enemies aren’t doing any collision detection,
so they won’t interact with the player.

The basic enemy has only three of the enemy movement parameters defined: B (horizontal sinusoidal
movement), C (horizontal sinusoidal period), and E (vertical fixed movement). Play with these
parameters to affect the movement. Increasing C, for example, increases the frequency with which
the enemies bounce back and forth.
"); ?></p>

      <br>
      <br>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/test.min.js"></script>
    <script src="../../dist/js/highlight.pack.js"></script>
    <script>
    hljs.configure({ tabReplace: '  ' });
    hljs.initHighlightingOnLoad();
    </script>
  </body>
</html>
