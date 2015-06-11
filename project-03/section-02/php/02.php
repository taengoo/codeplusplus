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

      <h3 class="section-header">FUNCTIONS</h3>
      <p>
<?php echo nl2br(
"Functions are really powerful in JavaScript. Most of the power of JavaScript comes from the way it handles the function type. We will examine functions in JavaScript in progressively more involved examples that follow.
"); ?>
      </p>
	  
      <h3 class="section-header">Functions 101</h3>
      <p>
<?php echo nl2br(
"A normal function structure in JavaScript is defined in Listing 2-10.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-10.. functionBody.js
function functionName() {
    // function body
    // optional return;
}
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"All functions return a value in JavaScript. In the absence of an explicit return statement, a function returns undefined. When you execute the code in Listing 2-11, you get undefined on the console.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-11. functionReturn.js
function foo() { return 123; }
console.log(foo()); // 123

function bar() { }
console.log(bar()); // undefined
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"We will discuss undefined functions more in this chapter when we look at default values.
"); ?>
      </p>
	  
      <h3 class="section-header">Immediately Executing Function</h3>
      <p>
<?php echo nl2br(
"You can execute a function immediately after you define it. Simply wrap the function in parentheses () and invoke it, as shown in Listing 2-12.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-12. ief1.js
(function foo() {
    console.log('foo was executed!');
})();
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The reason for having an immediately executing function is to create a new variable scope. An if, else, or while does not create a new variable scope in JavaScript. This fact is demonstrated in Listing 2-13.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-13. ief2.js
var foo = 123;
if (true) {
    var foo = 456;
}
console.log(foo); // 456;
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"The only recommended way of creating a new variable scope in JavaScript is using a function. So, in order to create a new variable scope, we can use an immediately executing function, as shown in Listing 2-14.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-14. ief3.js
var foo = 123;
if (true) {
    (function () { // create a new scope
        var foo = 456;
    })();
}
console.log(foo); // 123;
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"Notice that we choose to avoid needlessly naming the function. This is called an anonymous function, which we will explain next.
"); ?>
      </p>
	  
      <h3 class="section-header">Anonymous Function</h3>
      <p>
<?php echo nl2br(
"A function without a name is called an anonymous function. In JavaScript, you can assign a function to a variable. If you are going to use a function as a variable, you don’t need to name the function. Listing 2-15 demonstrates two ways of defining a function inline. Both of these methods are equivalent.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-15. anon.js
var foo1 = function namedFunction() { // no use of name, just wasted characters
    console.log('foo1');
}
foo1(); // foo1

var foo2 = function () {              // no function name given i.e. anonymous function
    console.log('foo2');
}
foo2(); // foo2
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"A programming language is said to have first-class functions if a function can be treated the same way as any other variable in the language. JavaScript has first-class functions.
"); ?>
      </p>
	  
      <h3 class="section-header">Higher-Order Functions</h3>
      <p>
<?php echo nl2br(
"Since JavaScript allows us to assign functions to variables, we can pass functions to other functions. Functions that take functions as arguments are called higher-order functions. A very common example of a higher-order function is setTimeout. This is shown in Listing 2-16.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-16. higherOrder1.js
setTimeout(function () {
    console.log('2000 milliseconds have passed since this demo started');
}, 2000);
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"If you run this application in Node.js, you will see the console.log message after two seconds and then the application will exit. Note that we provided an anonymous function as the first argument to setTimeout. This makes setTimeout a higher-order function.

It is worth mentioning that there is nothing stopping us from creating a function and passing that in. An example is shown in Listing 2-17.
"); ?>
      </p>
	  
	  <pre><code class="javascript">
// Listing 2-17. higherOrder2.js
function foo() {
    console.log('2000 milliseconds have passed since this demo started');
}
setTimeout(foo, 2000);
	  </code>
	  </pre>
	  
      <p>
<?php echo nl2br(
"Now that we have a firm understanding of object literals and functions, we can examine the concept of closures.
"); ?>
      </p>
	  
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
