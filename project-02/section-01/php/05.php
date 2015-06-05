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
        <h1 class="page-title">Section 1.5</h1>
      </div>

      <h3 class="section-header">CREATING YOUR GAME’S STRUCTURE</h3>
      <p>
<?php echo nl2br(
"The code built so far has been a good way to exercise the canvas capabilities you’ll be using, but it
will need to be reorganized to turn it into a useful structure for a game. Now take a step back to
look at some of the patterns you want to use putting together the game.
"); ?>
      </p>

      <h3 class="section-header">Building Object-Oriented JavaScript</h3>
      <p>
<?php echo nl2br(
"JavaScript is an object-oriented (OO) language. As such, most elements in JavaScript are objects
including strings, arrays, functions and, well, objects are objects in the OO sense.

But this doesn’t mean that JavaScript has all the trappings of object-oriented programming (OOP)
that you might expect. First, it doesn't have a classical inheritance model. Second, it doesn't have a
standard constructor mechanism, relying instead on either constructor functions or object literals.

Instead of classical inheritance, JavaScript implements prototypical inheritance, meaning you can
create an object that represents the prototype, or blueprint, for a set of descendant objects that all
share the same base functionality.
"); ?>
      </p>

	  <br>
	  
      <div class="panel panel-code-text">
		<div class="panel-heading">CLASSICAL VERSUS PROTOTYPICAL INHERITANCE</div>
        <div class="panel-body">

<p><?php echo nl2br(
"Most popular object-oriented languages used today, including Java and C++,
rely on classical inheritance, which means object behavior is defined by creating
explicit classes and instantiating objects from those classes. JavaScript has a
much more fluid method of defining classes based on the idea of prototypes, which
means you create an actual object that behaves the way you want and then create
child objects off of that.
"); ?>
</p>
		</div>
	  </div>
	  
      <p>
<?php echo nl2br(
"Because methods are just regular JavaScript objects, many times developers also simply copy
attributes from other objects to fake Java-style interfaces or multiple inheritance. This flexibility
shouldn’t necessarily be viewed as a problem; rather, it means that developers have a lot of flexibility
for how to create objects and can pick the best method for the specific use case.

Alien Invasion uses constructor functions combined with prototypical inheritance where it makes
sense. Using object prototypes can make object creation up to 50 times faster and provides memory
savings, but it is also more restricting because you can’t use closures to access and protect data.
Closures are a feature of JavaScript that allows you to keep variables in a method around for later
use even when a method has finished execution.

Chapter 9, “Bootstrapping the Quintus Engine: Part I,” discusses object-creation patterns in more
detail, but for now just realize that the use of different methods is intentional.
"); ?>
      </p>

      <h3 class="section-header">Taking Advantage of Duck Typing</h3>
      <p>
<?php echo nl2br(
"There’s a famous saying that if it walks like a duck and talks like a duck, then it must be a duck.
When programming in strongly-typed languages, there’s no doubt whether it’s a duck—it must be
an instance of the “Duck” class, or if you program in Java, implement the iDuck interface.

In JavaScript, a dynamically-typed language, parameters, and references are not type-checked,
meaning you can pass any type of object as a parameter to any function, and that function happily
treats that object like the type of whatever object it was expecting until something blows up.

This flexibility can be both a good and a bad thing. It’s a bad thing when you end up with cryptic
error messages or errors during run time. It’s a good thing when you use that flexibility to keep a
shallow inheritance tree but can still share code. The idea of using objects based on their external
interface rather than their type is called duck typing.

Alien Invasion uses this idea in a couple of places: game screens and sprites. The game treats anything
that responds to method calls of step() and draw() as valid game screen objects or valid sprites.
Using duck typing for game screens enables Alien Invasion to treat title screens and in-game screens
as the same type of object, making it easy to switch between levels and title screens. Similarly, using
duck typing for sprites means that the game can be flexible with what can be added to a game board,
including the player, enemies, projectiles, and HUD elements. HUD, which is short for Heads Up
Display, is the term commonly used for elements that sit on top of the game, such as number of lives
left and the player’s score.
"); ?>
      </p>

      <h3 class="section-header">Creating the Three Principle Objects</h3>
      <p>
<?php echo nl2br(
"The game needs three principle, mostly persistent objects: a Game object tying everything together; a
SpriteSheet object for loading and drawing sprites; and a GameBoard object for displaying, updating,
and handling the collision of sprite elements. The game also needs a gaggle of different sprites
such as the player, enemies, missiles, and HUD objects, such as the score and number of remaining
lives, but those are introduced individually later.
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
