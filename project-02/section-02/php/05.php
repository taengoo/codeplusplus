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
        <h1 class="page-title">Section 2.5</h1>
      </div>

      <h3 class="section-header">HANDLING COLLISIONS</h3>
      <p><?php echo nl2br(
"Alien Invasion is slowly coming together. It now has a player, missiles, and enemies flying around
the screen. Unfortunately, none of these pieces are interacting by blowing each other up as is
expected in a save-the-planet-from-destruction shooter game.
The good news is that the majority of the hard work for handling collisions has already been done.
The GameBoard object already knows how to take two objects and figure out if they are overlapping
as well as determine if one object is colliding with any others of a specific type. All that’s necessary
now is to add the appropriate calls to those collision functions.
For collisions, Alien Invasion can use two mechanisms. The first is to do proactive checks in every
object’s step function against any objects it has an interaction with. The second would be to have
a general collision phase where objects trigger collision events when they hit each other. The former
is simpler to implement, whereas the latter offers better overall performance and can be better optimized.
Alien Invasion is going to go the simpler route, but the platformer game built in Chapter 18,
“Creating a 2-D Platformer,” uses the more complicated mechanism.
"); ?></p>

      <h3 class="javascript">Adding Object Types</h3>
      <p><?php echo nl2br(
"To ensure that objects collide only with objects that it makes sense for them to collide with, objects
need to be assigned types. This was discussed at the beginning of the chapter but has not yet been
implemented in the game. The first step is to determine the different object types the game has and
add some constants to keep from having to use magic numbers in the code.

Add the code from Listing 2-8 to the top of game.js to define five different types of objects.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-8: Object Types
var OBJECT_PLAYER = 1,
    OBJECT_PLAYER_PROJECTILE = 2,
    OBJECT_ENEMY = 4,
    OBJECT_ENEMY_PROJECTILE = 8,
    OBJECT_POWERUP = 16;
      </code>
      </pre>
    
      <p><?php echo nl2br(
"NOTE Each of these types shown in Listing 2-8 is a power of two, which is an
efficiency optimization to enable the use of bitwise logic as discussed earlier.

Next, add three lines to game.js setting the type of each Sprite at an appropriate spot after each
Sprite’s prototype assignment code:
"); ?></p>

      <pre><code class="javascript">
PlayerShip.prototype = new Sprite();
PlayerShip.prototype.type = OBJECT_PLAYER;
...
PlayerMissile.prototype = new Sprite();
PlayerMissile.prototype.type = OBJECT_PLAYER_PROJECTILE;
...
Enemy.prototype = new Sprite();
Enemy.prototype.type = OBJECT_ENEMY;
Each object now has a type that can be used for collision detection.
      </code>
      </pre>

      <h3 class="section-header">Colliding Missiles with Enemies</h3>
      <p><?php echo nl2br(
"To prevent duplicated effort, instead of objects checking for collisions with every type of object
they might hit, objects check only against objects that they actually “want” to hit. This means that
PlayerMissile objects check if they are colliding with Enemy objects, but Enemy objects won’t
check if they are colliding with PlayerMissile objects. Doing so keeps the number of calculations
down a little bit.

Now that objects can be hit, they need to have a method to deal with what should happen when
they are hit. To begin with, add a method to Sprite that removes an object whenever it gets hit.
This method can be overridden down the road by the various inherited objects.

Add the following function to the bottom of engine.js below the rest of the Sprite object definition:
"); ?></p>

      <pre><code class="javascript">
Sprite.prototype.hit = function(damage) {
  this.board.remove(this);
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This initial version of the hit method just removes the object from the board, regardless of the
amount of damage done.

Add a damage value to the PlayerMissile constructor function:
"); ?></p>

      <pre><code class="javascript">
var PlayerMissile = function(x,y) {
  this.setup('missile',{ vy: -700, damage: 10 });
  this.x = x - this.w/2;
  this.y = y - this.h;
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Next, open up game.js, and edit the PlayerMissile step method to check for collisions:
"); ?></p>

      <pre><code class="javascript">
PlayerMissile.prototype.step = function(dt) {
  this.y += this.vy * dt;
  var collision = this.board.collide(this,OBJECT_ENEMY);

  if(collision) {
    collision.hit(this.damage);
    this.board.remove(this);
  } else if(this.y < -this.h) {
    this.board.remove(this);
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The missile checks to see if it’s colliding with any OBJECT_ENEMY type objects and then calls the
hit method on whatever object it collides with. It then removes itself from the board because its
job is done.

Fire up the game, and you should be able to shoot down the two enemies flying down the screen.
"); ?></p>

      <h3 class="section-header">Colliding Enemies with the Player</h3>
      <p><?php echo nl2br(
"To make it a fair fight, enemies need to have the ability to take down the player as well when they
make contact.

Adding essentially the same chunk of code to the Enemy step method allows the Enemy to take out
the player. Modify the step method to read as follows:
"); ?></p>

      <pre><code class="javascript">
Enemy.prototype.step = function(dt) {
  this.t += dt;
  this.vx = this.A + this.B * Math.sin(this.C * this.t + this.D);
  this.vy = this.E + this.F * Math.sin(this.G * this.t + this.H);
  this.x += this.vx * dt;
  this.y += this.vy * dt;

  var collision = this.board.collide(this,OBJECT_PLAYER);

  if (collision) {
    collision.hit(this.damage);
    this.board.remove(this);
  }

  if (this.y > Game.height || this.x < -this.w || this.x > Game.width) {
    this.board.remove(this);
  }
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This code is identical to the code added to the PlayerMissile object except that it calls collide
with an OBJECT_PLAYER object type.

After making those changes, fire up the game and let your player be taken out by one of the ships.
"); ?></p>

      <h3 class="section-header">Making It Go Boom</h3>
      <p><?php echo nl2br(
"So far the collisions have the correct effect; however, there’s something to be said for a more dramatic
effect to liven things up. The sprites.png file has a nice explosion animation in there for just that
reason. The explosion image was generated using the explosion generator on http://www.positech
.co.uk/.

Add the sprite definition to the top of game.js for the explosion:
"); ?></p>

      <pre><code class="javascript">
var sprites = {
  ship: { 
    sx: 0, sy: 0, w: 37, h: 42, frames: 1 
  },
  missile: { 
    sx: 0, sy: 30, w: 2, h: 10, frames: 1 
  },
  enemy_purple: { 
    sx: 37, sy: 0, w: 42, h: 43, frames: 1 
  },
  enemy_bee: { 
    sx: 79, sy: 0, w: 37, h: 43, frames: 1 
  },
  enemy_ship: { 
    sx: 116, sy: 0, w: 42, h: 43, frames: 1 
  },
  enemy_circle: { 
    sx: 158, sy: 0, w: 32, h: 33, frames: 1 
  },
  explosion: { 
    sx: 0, sy: 64, w: 64, h: 64, frames: 12 
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Now add some health to the blueprint for a basic enemy:
"); ?></p>

      <pre><code class="javascript">
var enemies = {
  basic: { 
    x: 100, y: -50, sprite: 'enemy_purple',
    B: 100, C: 4, E: 100, health: 20 
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Next, you need to override the default hit method from Sprite for the Enemy object. This method
needs to reduce the health of the Enemy, so check if the Enemy has run out of health; if so add an
explosion to the GameBoard at the center of the Enemy, as shown in Listing 2-9.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-9: Enemy Hit Method
Enemy.prototype.hit = function(damage) {
  this.health -= damage;

  if(this.health <=0) {
    if(this.board.remove(this)) {
      this.board.add(new Explosion(
        this.x + this.w/2,
        this.y + this.h/2
      ));
    }
  }
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Finally, the Explosion class needs to be built. The class is a basic sprite that when added onto the
page just flips itself through its frames and then removes itself from the board. See Listing 2-10.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-10: The Explosion Object
var Explosion = function(centerX,centerY) {
  this.setup('explosion', { frame: 0 });
  this.x = centerX - this.w/2;
  this.y = centerY - this.h/2;
  this.subFrame = 0;
};

Explosion.prototype = new Sprite();
Explosion.prototype.step = function(dt) {
  this.frame = Math.floor(this.subFrame++ / 3);

  if (this.subFrame >= 36) {
    this.board.remove(this);
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The Explosion constructor method takes the passed in centerX and centerY position and adjusts
the x and y location by moving the sprite half of its width to the left and half the height up. The
step method doesn’t need to worry about moving the explosion each frame; it just needs to update
the subFrame property to cycle through each of the frames of the explosion animation. Each frame
of the explosion animation plays for three game frames to make it last a little bit longer. When all
36 subFrames of the explosion have played through (12 actual frames), the Explosion removes
itself from the board.

Reload the game, and try to take out the enemies flying down the screen. It should take two missiles
to take out an enemy now, but that enemy should explode in a nice fiery blast.
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
