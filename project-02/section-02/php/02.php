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
        <h1 class="page-title">Section 2.2</h1>
      </div>

      <h3 class="section-header">FIRING MISSILES</h3>
      <p><?php echo nl2br(
"Now it’s time to give the player something to do besides just fly left and right across the screen. You
are going to bind the spacebar to fire off a pair of projectiles.
"); ?></p>
    
      <h3 class="section-header">Adding a Bullet Sprite</h3>
      <p><?php echo nl2br(
"The first step to giving the player some destructive capacity is to create a blueprint for the player
missile object. This object is added to the game at the player’s location whenever the player presses
the fire key.

The PlayerShip object didn’t use the object prototype to create methods because in general there
is only one player in the game at a time so it’s unnecessary to optimize for object creation speed
or memory footprint. To contrast, there are going to be a lot of PlayerMissiles added to the
game over the course of a level, so making sure they are quick to create and small from a memory
usage standpoint is a good idea. (The JavaScript garbage collector can cause noticeable hiccups in
game performance, so making its job easier is in your best interest.) Because of the frequency with
which PlayerMissile objects are going to be created, using object prototypes makes a lot of sense.
Functions created on an object’s prototype need to be created and stored in memory only once.
Add the following highlighted text to the top of game.js to put in the sprite definition for the
missile (don’t forget the comma on the previous line):
"); ?></p>

      <pre><code class="javascript">
var sprites = {
  ship: { sx: 0, sy: 0, w: 37, h: 42, frames: 1 },
  missile: { sx: 0, sy: 30, w: 2, h: 10, frames: 1 }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Next add the full PlayerMissile object (see Listing 2-1) to the bottom of game.js:
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-1: The PlayerMissile Object
var PlayerMissile = function(x,y) {
  this.w = SpriteSheet.map['missile'].w;
  this.h = SpriteSheet.map['missile'].h;

  // Center the missile on x
  this.x = x - this.w/2;

  // Use the passed in y as the bottom of the missile
  this.y = y - this.h;
  this.vy = -700;
};

PlayerMissile.prototype.step = function(dt) {
  this.y += this.vy * dt;

  if(this.y < -this.h) { 
    this.board.remove(this); 
  }
};

PlayerMissile.prototype.draw = function(ctx) {
  SpriteSheet.draw(ctx,'missile',this.x,this.y);
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The initial version of the PlayerMissile class clocks in at a mere 14 lines and much of it is boilerplate
you’ve seen before. The constructor function simply sets up a number of properties on the
sprite, pulling the width and height from the SpriteSheet. Because the player fires missiles vertically
upward from a turret location, the constructor uses the passed-in y location for the location of
the bottom of the missile by subtracting the height of the missile to determine its starting y location.
It also centers the missile on the passed-in x location by subtracting half the width of the sprite.

As discussed previously, the step and draw methods are created on the prototype to be efficient.
Because the player’s missile moves only vertically up the screen, the step function needs to adjust
only the y property and check if the missile has moved completely off the screen in the y direction.
If the missile has moved more than its height off the screen (that is, this.y < -this.h), it removes
itself from the board.

Finally, the draw method just draws the missile sprite at the missile’s x and y locations using the
SpriteSheet object.
"); ?></p>

      <h3 class="section-header">Connecting Missiles to the Player</h3>
      <p><?php echo nl2br(
"To actually get a missile onto the screen, the PlayerShip needs to be updated to respond to the fire
key and add a pair of missiles onto the screen for each of its two turrets. You also need to add in a
reloading period to limit the speed at which missiles are fired.

To put in this limit, you must add a new property called reload, which represents the remaining
time before the next pair of missiles can be fired. You also must add another property called
reloadTime, which represents the full reloading time. Add the following two initialization lines to
the top of the PlayerShip constructor method:
"); ?></p>

      <pre><code class="javascript">
var PlayerShip = function() {
  this.w = SpriteSheet.map['ship'].w;
  this.h = SpriteSheet.map['ship'].h;
  this.x = Game.width / 2 - this.w / 2;
  this.y = Game.height - 10 - this.h;
  this.vx = 0;
  this.reloadTime = 0.25; // Quarter second reload
  this.reload = this.reloadTime;
      </code>
      </pre>
    
      <p><?php echo nl2br(
"reload is set to reloadTime to prevent the player from immediately firing a missile when they press
fire to start the game.

Next, modify the step method to read as follows:
"); ?></p>

      <pre><code class="javascript">
this.step = function(dt) {
  if(Game.keys['left']) { 
    this.vx = -this.maxVel; 
  } else if(Game.keys['right']) { 
    this.vx = this.maxVel; 
  } else { 
    this.vx = 0; 
  }

  this.x += this.vx * dt;

  if(this.x < 0) { 
    this.x = 0; 
  } else if(this.x > Game.width - this.w) {
    this.x = Game.width - this.w
  }

  this.reload-=dt;
  
  if(Game.keys['fire'] && this.reload < 0) {
    Game.keys['fire'] = false;
    this.reload = this.reloadTime;
    this.board.add(new PlayerMissile(this.x,this.y+this.h/2));
    this.board.add(new PlayerMissile(this.x+this.w,this.y+this.h/2));
  }
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This code adds two new player missiles on the left and right sides of the ship if the player presses
the fire key and is not in the process of reloading. Firing a missile simply consists of adding it to
the board at the right location. The reload property is also reset to reloadTime to add in a delay
between missiles being fired. To ensure the player needs to press and release the spacebar to fire and
can’t just hold it down, the key is set to false. (This doesn’t quite have the intended effect because
keydown events are fired on repeat)

Reload the game (or fire up http://mh5gd.com/ch2/missiles/) and test out firing some missiles.
You can adjust reloadTime to see the effect it has on the speed missiles are fired.
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
