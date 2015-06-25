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
        <h1 class="page-title">Section 2.4</h1>
      </div>

      <h3 class="section-header">REFACTORING THE SPRITE CLASSES</h3>
      <p><?php echo nl2br(
"At this point the game has three different sprite classes that all share a lot of the same boilerplate
code. This means it’s time to apply the Rule of Three.

As described by Wikipedia, the rule is:

Rule of three is a code refactoring rule of thumb to decide when a replicated piece
of code should be replaced by a new procedure. It states that the code can be copied
once, but that when the same code is replicated three times, it should be extracted
into a new procedure. The rule was introduced by Martin Fowler in Refactoring and
attributed to Don Roberts.

http://en.wikipedia.org/wiki/Rule_of_three_(computer_programming)

Even though Alien Invasion is a one-off game engine that isn’t intended to be turned into a generalpurpose
engine, it still pays to put in a little bit of time to refactor the code when it makes sense to
clean up any rampant duplication and make the game easier to fix and extend.

No one writes perfect code the first time, especially when prototyping and trying out new features.
When that code works, however, failing to refactor and clean up code during development leads
to technical debt. The more technical debt you have on a project, the more painful it is to make
changes and add new features. Refactoring can clean up technical debt by removing unused code,
reducing code duplication, and cleaning up abstractions, all things that don’t make your game better
necessarily but make your life as a game developer better.

In Alien Invasion, the main culprits of duplication in these three sprite classes are the boilerplate
setup code and the draw method, which is the same across all three methods. It’s time to extract
those into a base object called Sprite, which can handle initialization given a set of setup parameters
as well as a sprite to use. Inside the Enemy constructor, the three loops to copy one object into
another is also a good opportunity for refactoring.

If you haven’t done a lot of prototypical inheritance in JavaScript, the syntax may look strange.
Because JavaScript doesn’t have the idea of classes, instead of defining a class that represents the
inherited properties, you create a prototype object where JavaScript will look when a parameter isn’t
defined on the actual object.
"); ?></p>

      <h3 class="section-header">Creating a Generic Sprite Class</h3>
      <p><?php echo nl2br(
"In this section you create the Sprite object that all other sprites inherit from. Open up engine.js
and add the following code shown in Listing 2-4:
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-4: A Generic Sprite Object
var Sprite = function() { }

Sprite.prototype.setup = function(sprite,props) {
  this.sprite = sprite;
  this.merge(props);
  this.frame = this.frame || 0;
  this.w = SpriteSheet.map[sprite].w;
  this.h = SpriteSheet.map[sprite].h;
}

Sprite.prototype.merge = function(props) {
  if(props) {
    for (var prop in props) {
      this[prop] = props[prop];
    }
  }
}

Sprite.prototype.draw = function(ctx) {
  SpriteSheet.draw(ctx,this.sprite,this.x,this.y,this.frame);
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This code goes into engine.js because it’s generic engine code versus game-specific code. The constructor
function is empty because each sprite has its own constructor function, and the Sprite
object is created only once for each of the descendant sprite object definitions. Constructor functions
in JavaScript don’t work the same as constructors in other OO languages such as C++. To get
around this, you need a separate setup function to be called explicitly in the descendant objects.

This setup method takes in the name of the sprite in the SpriteSheet and a properties object. The
sprite is saved in the object, and then properties are copied over into the Sprite. The width and
height are also set here as well.

Because copying over properties into an object is such a common need, Sprite also defines a merge
method that does just that. This method is used in the setup method.

Finally, the draw method, which is nearly identical in every sprite so far, can be defined once here
and then will be available in every other sprite.
"); ?></p>

      <h3 class="section-header">Refactoring PlayerShip</h3>
      <p><?php echo nl2br(
"Armed with the Sprite class, the PlayerShip object can be refactored to simplify setup. The new
code is marked in bold in Listing 2-5:
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-5: A Refactored PlayerShip
var PlayerShip = function() {
  this.setup('ship', { vx: 0, frame: 1, reloadTime: 0.25, maxVel: 200 });
  this.reload = this.reloadTime;
  this.x = Game.width/2 - this.w / 2;
  this.y = Game.height - 10 - this.h;

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
      this.reload = this.reloadTime;
      this.board.add(new PlayerMissile(this.x,this.y+this.h/2));
      this.board.add(new PlayerMissile(this.x+this.w,this.y+this.h/2));
    }
  }
}

PlayerShip.prototype = new Sprite();
      </code>
      </pre>
    
      <p><?php echo nl2br(
"At the top of the constructor function, the setup method is called, wiping out some boilerplate
code. A few of the properties are set when setup is called, but a few are set afterward because they
depend on the values of the other properties such as the object’s width and height, which isn’t available
until after setup is called. Next, the draw method is removed because it is handled by Sprite.

Finally, the code to actually set up PlayerShip’s prototype comes after the PlayerShip constructor
function is defined.
"); ?></p>

      <h3 class="section-header">Refactoring PlayerMissile</h3>
      <p><?php echo nl2br(
"The PlayerMissile object was already compact, but refactoring helps make it even shorter. See
Listing 2-6.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-6: Refactored PlayerMissile
var PlayerMissile = function(x,y) {
  this.setup('missile',{ vy: -700 });
  this.x = x - this.w/2;
  this.y = y - this.h;
};

PlayerMissile.prototype = new Sprite();
PlayerMissile.prototype.step = function(dt) {
  this.y += this.vy * dt;
  
  if(this.y < -this.h) { 
    this.board.remove(this); 
  }
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The constructor method still needs to explicitly set the x and y location because these are dependent on
the width and height of the sprite (which aren’t available until after setup is called). The step method
is unaffected by the refactoring, and the draw method can be removed as it’s handled by Sprite.
"); ?></p>

      <h3 class="section-header">Refactoring Enemy</h3>
      <p><?php echo nl2br(
"The Enemy object benefits the most from the refactoring, particularly in the constructor method.
Instead of using a number of loops to copy parameters into the object, a few calls to merge simplify
the method down to three lines. See Listing 2-7.
"); ?></p>

      <pre><code class="javascript">
// LISTING 2-7: Refactored Enemy Object (Partial Code)
var Enemy = function(blueprint,override) {
  this.merge(this.baseParameters);
  this.setup(blueprint.sprite,blueprint);
  this.merge(override);
}

Enemy.prototype = new Sprite();
Enemy.prototype.baseParameters = { 
  A: 0, B: 0, C: 0, D: 0,
  E: 0, F: 0, G: 0, H: 0,
  t: 0 
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"The step method is unaffected (and so isn't shown in Listing 2-7) and the draw method can be
removed. Notice that merge is called explicitly to merge in the set of baseParameters and the
override parameters. The predefined baseParameters object is also pulled out of the constructor
and put into the prototype. Although not a huge optimization, it prevents the need for the static
baseParameters object to be re-created each time a new Enemy is created just for the sake of being
copied over into the object. Because baseParameters isn’t going to be modified, one copy of the
object will do.
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
