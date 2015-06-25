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
        <h1 class="page-title">Section 2.6</h1>
      </div>

      <h3 class="section-header">REPRESENTING LEVELS</h3>
      <p><?php echo nl2br(
"Alien Invasion now has all the mechanics necessary to play the game. The only missing component
is to put together some level data and a mechanism for adding enemy ships onto the screen.

Before getting into the levels, add a few more enemy types to give some variety to the page.
"); ?></p>

      <h3 class="section-header">Setting Up the Enemies</h3>
      <p><?php echo nl2br(
"You could create an endless number of variations of enemy movement, but for this game you’ll
set up five different types of enemy behavior using the various enemy sprite types as a start. You
can play with the definitions and add more if you like. You could make a number of other variations,
but this set of five is a good start. Replace the enemies definition at the top of game.js with
Listing 2-11.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-11: Enemy Definitions
var enemies = {
  straight: { 
    x: 0, y: -50, sprite: 'enemy_ship', health: 10,
    E: 100 
  },
  ltr: { 
    x: 0, y: -100, sprite: 'enemy_purple', health: 10,
    B: 200, C: 1, E: 200 
  },
  circle: { 
    x: 400, y: -50, sprite: 'enemy_circle', health: 10,
    A: 0, B: -200, C: 1, E: 20, F: 200, G: 1, H: Math.PI/2 
  },
  wiggle: { 
    x: 100, y: -50, sprite: 'enemy_bee', health: 20,
    B: 100, C: 4, E: 100 
  },
  step: { 
    x: 0, y: -50, sprite: 'enemy_circle', health: 10,
    B: 300, C: 1.5, E: 60 
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"With just a variation on the movement parameters, the enemies have wildly differing movement
styles. The straight enemy has only vertical velocity parameter E, so it moves downward at a constant
rate.

The ltr enemy (short for left-to-right) has a constant vertical velocity, but then a sinusoidal horizontal
velocity (parameters B and C) gives it a smooth sweeping motion from left to right.

The circle has primarily sinusoidal motion in both directions, but adds a time shift in the Y direction
with parameter H to give a circular motion to the enemy.

The wiggle and the step enemies have the same parameters set, just to different amounts. With a
smaller B value and larger C and E values, the wiggle enemy just snakes down the screen, while the
step enemy, with a larger B and a smaller C and E, makes its way down the page slowly by sliding
back and forth across the whole screen.
"); ?></p>

      <h3 class="section-header">Setting Up Level Data</h3>
      <p><?php echo nl2br(
"Knowing that levels in Alien Invasion will be populated with strings of enemies of the same type,
the next step is to figure out a good mechanism for encoding the level data in a compact manner.
When that has been figured out, you can work backward and figure out what the level object needs
to do to spawn those enemies onto the page. Working from how you want to use a piece of code
back to the implementation is a good way to end up with code that is easy to work with. It may take
a little bit more work on the implementation, but you’ll be happier in the long run.

One initial impulse you might have would be to encode the starting location of each enemy and each
enemy type in an array. Because a level might have a hundred or more enemies, this would get laborious
quickly. A better option is to encode each string of enemies as a single entry with a start time,
end time, and per-enemy delay. This way each string of enemies is succinctly encoded into the level
data, and you can take one look at the definition and get a good understanding of what's going on.
Add the level data for level 1 to the top of game.js by inserting Listing 2-12.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-12: Level Data
var level1 = [
  // Start, End, Gap, Type, Override
  [ 0, 4000, 500, 'step' ],
  [ 6000, 13000, 800, 'ltr' ],
  [ 12000, 16000, 400, 'circle' ],
  [ 18200, 20000, 500, 'straight', { x: 150 } ],
  [ 18200, 20000, 500, 'straight', { x: 100 } ],
  [ 18400, 20000, 500, 'straight', { x: 200 } ],
  [ 22000, 25000, 400, 'wiggle', { x: 300 }],
  [ 22000, 25000, 400, 'wiggle', { x: 200 }]
];
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Each line gives a start time in milliseconds, an end time in milliseconds, and a gap in milliseconds
between each enemy followed by the enemy type and any override parameters.
"); ?></p>

      <h3 class="section-header">Loading and Finishing a Level</h3>
      <p><?php echo nl2br(
"Defining how the level class is going to consume level data is half the battle; the other half is deciding
on how the Level object will be used by the PlayGame method to start the game. The easiest
solution is to simply create another sprite-like object that is added to the game board and spawns
enemies at the correct time intervals. When the Level is out of enemies, it can make a callback to
indicate success.

Again working backward, you write the way the Level object should be used before tackling the
actual implementation. Replace the existing playGame method with the one shown in Listing 2-13,
and add new winGame and loseGame methods as well.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-13: Modified Game Initialization Methods
var playGame = function() {
  var board = new GameBoard();

  board.add(new PlayerShip());
  board.add(new Level(level1,winGame));

  Game.setBoard(3,board);
}

var winGame = function() {
  Game.setBoard(3,new TitleScreen("You win!","Press fire to play again",playGame));
}

var loseGame = function() {
  Game.setBoard(3,new TitleScreen("You lose!","Press fire to play again",playGame));
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Adding the level becomes as trivial as adding a new Level sprite to the board and passing in the
level data level1 and the success callback winGame.

The winGame method just reuses the TitleScreen object to show a success message and a message
letting the player know they can replay the game.

The loseGame method works the same way as the winGame method but with a less congratulatory
message. Lose game so far isn’t called yet anywhere, but this can be remedied by adding a custom
hit method to the PlayShip object. Add the following definition to game.js under the rest of the
PlayerShip methods (make sure to add it underneath where the prototype is set):
"); ?></p>

      <pre><code class="javascript">
PlayerShip.prototype.hit = function(damage) {
  if(this.board.remove(this)) {
    loseGame();
  }
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The PlayerShip doesn’t get an explosion when it dies; this is just for simplicity’s sake. However,
you could add one in and add a callback to the end of the explosion step to show the loseGame
screen only after the PlayerShip has finished blowing up.
"); ?></p>

      <h3 class="section-header">Implementing the Level Object</h3>
      <p><?php echo nl2br(
"All that’s left now is the implementation of the Level object. This object’s duties have already been
defined by how the level data and playGame and winGame methods were set up. The Level object
has only two methods: the constructor function, which makes a copy of the level data for its own
use (and modification) and the step method, which loops through the level data and adds enemies
onto the board as necessary.

Add the constructor function shown in Listing 2-14 to the bottom of engine.js.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-14: Level Object Constructor
var Level = function(levelData,callback) {
  this.levelData = [];
  for(var i =0; i < levelData.length; i++) {
    this.levelData.push(Object.create(levelData[i]));
  }

  this.t = 0;
  this.callback = callback;
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The one major responsibility of the constructor function is to make a deep copy of the passed-in
level data. Cloning the data is necessary because the method is going to modify the level data as the
level progresses. Because objects are passed by reference in JavaScript, this would prevent the level
from being reused if the player were to play the level a second time.

The cloning is slightly more complicated than it seems because JavaScript doesn’t have a built-in
mechanism for deep cloning a list of objects inside an Array. To get around this, each entry in the
level data is looped over and the built-in Object.create method is called to create a new object
with the existing data as the prototype. That new object is then pushed onto a new Array.

Next is the meat of the Level object, the step method. Even though Level isn’t a normal Sprite,
it’s going to pretend it is and behave like one by responding to the step and draw methods. The step
method in Listing 2-15 has the responsibility to keep track of the current time and dropping enemies
onto the page in sequence.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-15: Level Step Method
Level.prototype.step = function(dt) {
  var idx = 0, remove = [], curShip = null;

  // Update the current time offset
  this.t += dt * 1000;

  // Example levelData
  // Start, End, Gap, Type, Override
  // [[ 0, 4000, 500, 'step', { x: 100 } ]
  while((curShip = this.levelData[idx]) && (curShip[0] < this.t + 2000)) {
    // Check if past the end time
    if(this.t > curShip[1]) {
      // If so, remove the entry
      remove.push(curShip);
    } else if(curShip[0] < this.t) {
      // Get the enemy definition blueprint
      var enemy = enemies[curShip[3]],
      override = curShip[4];
      // Add a new enemy with the blueprint and override
      this.board.add(new Enemy(enemy,override));
      // Increment the start time by the gap
      curShip[0] += curShip[2];
    }
    idx++;
  }

  // Remove any objects from the levelData that have passed
  for(var i=0,len=remove.length;i < len;i++) {
    var idx = this.levelData.indexOf(remove[i]);
    if(idx != -1) this.levelData.splice(idx,1);
  }
  
  // If there are no more enemies on the board or in
  // levelData, this level is done
  if(this.levelData.length == 0 && this.board.cnt[OBJECT_ENEMY] == 0) {
    if(this.callback) this.callback();
  }
}

// Dummy method, doesn't draw anything
Level.prototype.draw = function(ctx) { }
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This is a complex method. The method is broken into three main sections:
- The first section uses a while statement to loop over the beginning of the levelData array
until it gets past any active ships. (This prevents the need to loop over every element in the
array.) For each row in the level data, it checks if it is passed the end value (the second element
of the array). If so, it adds that element to a list of elements to be removed from the
levelData array. If not, it pulls out the enemy blueprint and the override and adds a new
enemy onto the board. It then increments the start value (the first element of the array) by
the length of between-enemy gap. Modifying the start time allows the step method to handle
adding a string of enemies on the page without any additional logic.
- The second section of the step method should look familiar from the GameBoard object. All
it is does is look at all the entries in levelData that have been added to the remove list and
splices them out of the array, much like the finalizeRemoved method in GameBoard did.
- The final section consists of a conditional that checks if there are no more upcoming enemies
in levelData and if the number of enemies on the board is zero. If both of those conditions
are true, then the level is considered over, and the callback, if one is set, is called. This allows
the level to know when it has been completed.
Finally, the Level object needs a draw method so that it can play nicely with GameBoard, but that
method is just a stub that doesn’t actually do anything.
Fire up the game with all the Level pieces in, and you should see the game and enemies in all their
glory.
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
