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
        <h1 class="page-title">Section 2.1</h1>
      </div>

      <h3 class="section-header">CREATING THE GAMEBOARD OBJECT</h3>
      <p><?php echo nl2br(
"The first step to turning Alien Invasion into a game is to add a mechanism that handles a
bunch of sprites on the page at the same time. The current Game object can handle a stack of
boards, but those boards all act independently of each other. Also, although the Game object
provides a mechanism to swap boards in and out, it doesn't make it easy to add an arbitrary
number of sprites onto the page. Enter the GameBoard object.
"); ?></p>
    
      <h3 class="section-header">Understanding the GameBoard</h3>
      <p><?php echo nl2br(
"The purpose of the GameBoard object is much like the game board in a game of checkers. It provides
a spot to drop all the pieces and dictates their movement. In this section you break down some of
the responsibilities of this object. The responsibilities of the GameBoard can be broken down into
four distinct categories:
- It is responsible for keeping a list of objects and handling adding sprites to and removing
sprites from that list.
- It also needs to handle looping over that list of objects.
- It needs to respond the same way as previous boards. It needs to have a step and a draw
function that calls the appropriate functions on each of the objects in the object list.
- It needs to handle checking of collisions between objects.

The next few sections walk through each of the parts of the GameBoard object, which will behave
like a simple scene graph. Scene graphs are discussed in detail in Chapter 12, “Building Games with
CSS3.” The GameBoard class will be added to the bottom of the engine.js file.
"); ?></p>

      <h3 class="section-header">Adding and Removing Objects</h3>
      <p><?php echo nl2br(
"The first and most important responsibility of the GameBoard class is to keep track of the objects in
play. The easiest way to keep track of a list of objects is simply to use an array, in this case an array
called objects.

The GameBoard class will be described piecemeal, but the whole thing goes at the bottom of the
engine.js file:
"); ?></p>

      <pre><code class="javascript">
var GameBoard = function() {
  var board = this;
  // The current list of objects
  this.objects = [];
  this.cnt = [];
      </code>
      </pre>
    
      <p><?php echo nl2br(
"This array is where objects that show up in the game are added to and removed from.
Next, the class needs the capability to add objects. This is simple enough. Pushing objects onto the
end of the objects’ list gets most of the job done:
"); ?></p>

      <pre><code class="javascript">
// Add a new object to the object list
this.add = function(obj) {
  obj.board = this;

  this.objects.push(obj);
  this.cnt[obj.type] = (this.cnt[obj.type] || 0) + 1;

  return obj;
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"For an object to interact with other objects, however, it needs access to the board it’s a part of. For
this reason when GameBoard.add is called, the board sets a property called board on the object.
The object can now access the board to add additional objects, such as projectiles or explosions, or
remove itself when it dies.

The board also must keep a count of the number of objects of different types that are active at a
given time, so the second-to-last line of the function initializes the count to zero if necessary using a
boolean OR and then increments that count by 1. Objects won’t be assigned types until later in this
chapter, so this is a little bit of forward-looking code.

Next is removal. This process is slightly more complicated than it first might seem because objects
may want to remove themselves or other objects in the middle of a step while the GameBoard loops
over the list of objects. A naive implementation would try to update GameBoard.objects but
because the GameBoard would be in the middle of looping over all the objects, changing them midloop
would cause problems with the looping code.

One option is to make a copy of the list of objects at the beginning of each frame, but this could get
costly to do each frame. The best solution is to first mark objects for removal in a separate array and
then actually remove them from the object list after every object has had its turn. Following is the
solution GameBoard uses:
"); ?></p>

      <pre><code class="javascript">
// Mark an object for removal
this.remove = function(obj) {
	var wasStillAlive = this.removed.indexOf(obj) != -1;

	if(wasStillAlive) { 
		this.removed.push(obj); 
	}

	return wasStillAlive;
};

// Reset the list of removed objects
this.resetRemoved = function() { 
	this.removed = []; 
}

// Remove objects marked for removal from the list
this.finalizeRemoved = function() {
	for(var i=0,len=this.removed.length;i < len;i++) {
		var idx = this.objects.indexOf(this.removed[i]);

		if(idx != -1) {
			this.cnt[this.removed[i].type]--;
			this.objects.splice(idx,1);
		}
	}
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"At the beginning of each step, resetRemoved is called to reset the list of objects to be removed.
The remove method first checks if an object has already been removed and then adds it to the list of
objects to remove only if it’s not already there. It then returns true if the object was added or false
if the object was already dead. After every object has its turn, finalizeRemoved is called. This
method finds the removed objects in the objects list using Array.indexOf and then uses the Array
.splice method to cut those objects out of the list. When an object is removed from the list, it is
effectively dead because it no longer has its step and draw methods called.
"); ?></p>

      <h3 class="section-header">Iterating over the List of Objects</h3>
      <p><?php echo nl2br(
"Because much of what GameBoard does is iterate over a list of objects, it stands to reason that
a couple of helper methods to make that easier would come in handy. Two main methods are
needed. First, a simple iterate method that calls the same function on every object in the object list
is useful for the step and draw methods. Second, a detect method that returns the first object for
which a passed-in function returns true makes collision detection easier. Both of these methods
are listed here:

First up is iterate:
"); ?></p>

      <pre><code class="javascript">
// Call the same method on all current objects
this.iterate = function(funcName) {
	var args = Array.prototype.slice.call(arguments,1);
	for(var i=0,len=this.objects.length;i < len;i++) {
		var obj = this.objects[i];
		obj[funcName].apply(obj,args)
	}
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Although the meat of the function is just a loop over this.objects, the method does have a couple
of interesting JavaScript features.

The first line of the method is a well-known JavaScript hack. The arguments object, which is available
in every method call, contains a list of the arguments passed into that method and is used by
methods that accept varying numbers of arguments. arguments acts in many ways like an array, but
it’s not an actual array. This is a shame because in this case you’d like to get all the arguments out
except for the first, which is the funcName, so that they can be passed on to the function to be called
on every object. arguments doesn’t have the slice method, but because JavaScript enables you to
take methods and apply them to whatever object you like using call or apply, the line

var args = Array.prototype.slice.call(arguments,1);

can do just that and turn the arguments object into a proper array starting at the second element.
Inside of the loop the code looks up the method in the object’s properties using the square bracket
operator and then calls apply to call that method with whatever the passed in arguments are.
Next is the detect method, which will be used later for collision detection. Its job is to run the same
function on all of a board’s objects and return the first object that the function returns true for. In
the abstract this doesn’t seem all that useful, but if you need to do collision detection or find a specific
object based on certain parameters, the detect method is useful.
"); ?></p>

      <pre><code class="javascript">
// Find the first object for which func is true
this.detect = function(func) {
	for(var i = 0,val=null, len=this.objects.length; i < len; i++) {
		if(func.call(this.objects[i])) return this.objects[i];
	}

	return false;
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"detect consists of a loop over the objects and a call to the passed-in function with the object passed
in as the this context. If that function returns true, then the object is returned; otherwise, the
functions returns false after it runs out of objects to compare against.
"); ?></p>

      <h3 class="section-header">Defining the Board Methods</h3>
      <p><?php echo nl2br(
"Next are the standard board functions, step and draw. Using the methods already defined, these
functions have trivial definitions:
"); ?></p>

      <pre><code class="javascript">
// Call step on all objects and then delete
// any objects that have been marked for removal
this.step = function(dt) {
	this.resetRemoved();
	this.iterate('step',dt);
	this.finalizeRemoved();
};

// Draw all the objects
this.draw= function(ctx) {
	this.iterate('draw',ctx);
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Both step and draw use the iterate method to call a specifically named function on each object in
the list, with step also making sure to reset and finalize the list of removed items.
"); ?></p>

      <h3 class="section-header">Handling Collisions</h3>
      <p><?php echo nl2br(
"The last bit of functionality in the purview of GameBoard is the handling of collisions. Alien
Invasion uses a simplified collision model that reduces each of the sprites on the board to a simple
rectangular bounding box. If the bounding boxes of two different objects overlap, then those two
sprites are deemed to be colliding. Because each sprite has an x and a y position in addition to a
width and a height, this box is easy to calculate.

NOTE A bounding box is the smallest rectangle that encompasses the entirety of
an object. Using bounding boxes to do collision detection instead of polygons or
exact pixel data is faster to calculate, but is much less accurate.

GameBoard uses two functions to handle collision detection. The first, overlap, simply checks for
the overlap between two objects’ bounding boxes and returns true if they intersect. The easiest way
to do this detection is clever. Rather than check whether one object is in the other, you simply need
to check if one object couldn’t be in the other and negate the result.
"); ?></p>

      <pre><code class="javascript">
this.overlap = function(o1,o2) {
	return !((o1.y+o1.h-1 < o2.y) || (o1.y > o2.y+o2.h-1) || (o1.x+o1.w-1 < o2.x) || (o1.x > o2.x+o2.w-1));
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"What’s going on here is that the bottom edge of object one is checked against the bottom edge
of object two to see if object one is to the right of object two. Next, the top edge of object one is
checked against the bottom edge of object two and so on through each of the corresponding edges.
If any of these are true, you know object one doesn’t overlap object two. By simply negating the
result of this detection, you can tell if the two objects overlap.

With a function in your pocket to determine overlap, it becomes easy to check one object against all
the other objects in the list.
"); ?></p>

      <pre><code class="javascript">
this.collide = function(obj,type) {
	return this.detect(function() {
		if(obj != this) {
			var col = (!type || this.type & type) && board.overlap(obj,this)
			return col ? this : false;
		}
	});
};
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Collide uses the detect function to match the passed-in object against all the other objects and
returns the first object for which overlap returns true. The only complication is the support for an
optional type parameter. The idea behind this is that different types of objects want to collide with
only certain objects. Enemies, for example, don’t want to collide with themselves, but they do want
to collide with the player and the player’s missiles. By doing a bitwise AND operation, collisions
against objects of multiple types can be performed without the loss of speed that an array or hash
lookup would require. One caveat is that each of the different types must be a power of two to prevent
overlap of different types.

For example, if types were defined as the following:
"); ?></p>

      <pre><code class="javascript">
var OBJECT_PLAYER = 1,
	OBJECT_PLAYER_PROJECTILE = 2,
	OBJECT_ENEMY = 4,
	OBJECT_ENEMY_PROJECTILE = 8;
      </code>
      </pre>
    
      <p><?php echo nl2br(
"an enemy could check if it collides with a player or a player’s missile by doing a bitwise OR of the
two types together:

board.collide(enemy, OBJECT_PLAYER | OBJECT_PLAYER_PROJECTILE)

Objects can also be assigned multiple types, and the collide function would still work as planned.
With that, the GameBoard class is complete. See gameboard/engine.js for the full version of the
object in the code for this chapter.
"); ?></p>

      <h3 class="section-header">Adding GameBoard into the Game</h3>
      <p><?php echo nl2br(
"With the GameBoard class complete, the next step is to add it into the game. A quick modification of
the playGame function from game.js does the trick:
"); ?></p>

      <pre><code class="javascript">
var playGame = function() {
	var board = new GameBoard();
	board.add(new PlayerShip());
	Game.setBoard(3,board);
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"Reload the index.html file, and you should see exactly the same behavior as at the end of Chapter 1.
All that’s been done is to have the GameBoard take over managing the ship sprite. This is less than
impressive because so far the game isn’t putting the GameBoard class to good use because it just has
a single sprite in it. This is remedied in the next section.
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
