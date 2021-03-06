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
        <h1 class="page-title">Section 3.2</h1>
      </div>

      <h3 class="section-header">IMPORTANT GLOBALS</h3>
      <p>
<?php echo nl2br(
"Node.js provides a fair number of globally available utility variables. Some of these variables are true globals (shared between all modules) and some are local globals (variables specific to the current module). We have already seen an example of a few true globals, the require function. And we have seen a few module-level implicitly defined variables—module (used by module.exports) and exports. Let us examine a few more important globals.
"); ?>
      </p>

      <h3 class="section-header">console</h3>
      <p>
<?php echo nl2br(
"console is one of the most useful globals available. Since it is so easy to start and restart a Node.js application from the command line, the console plays an important part in quickly showing what is happening in your application when you need to debug it. We have been using console.log throughout our examples for the same exact purpose. console has a lot more o functions, which we discuss in Chapter 11.
"); ?>
      </p>

      <h3 class="section-header">Timers</h3>
      <p>
<?php echo nl2br(
"We’ve seen setTimeout before when we were discussing the Node.js event loop in Chapter 2. It sets up a function to be called after a specified delay in milliseconds. Note that this delay is the minimum interval after which the specified function is called. The actual duration after which it will be called depends upon the availability of the JavaScript thread as we saw in the section on thread starvation in Chapter 2. It also depends upon when the operating system schedules the Node.js process to execute (normally not an issue). A quick example of setTimeout, which calls a function after 1,000 milliseconds (in other words, one second) is shown in Listing 3-23.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-23. globals/timers/setTimeout.js
setTimeout(function () {
    console.log('timeout completed');
}, 1000);
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Similar to the setTimeout function is the setInterval function. setTimeout only executes the callback function once after the specified duration. But setInterval calls the callback repeatedly after every passing of the specified duration. This is shown in Listing 3-24 where we print out second passed after every second. Similar to setTimeout, the actual duration may exceed the specified value depending on the availability of the JavaScript thread.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-24. globals/timers/setInterval.js
setInterval(function () {
    console.log('second passed');
}, 1000);
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Both setTimeout and setInterval return an object that can be used to clear the timeout/interval using the clearTimeout/clearInterval functions. Listing 3-25 demonstrates how to use clearInterval to call a function after every second for five seconds, and then clear the interval after which the application will exit.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-25. globals/timers/clearInterval.js
var count = 0;
var intervalObject = setInterval(function () {
    count++;
    console.log(count, 'seconds passed');
    if (count == 5) {
        console.log('exiting');
        clearInterval(intervalObject);
    }
}, 1000);
      </code>
      </pre>

      <h3 class="section-header">__filename and __dirname</h3>
      <p>
<?php echo nl2br(
"These variables are available in each file and give you the full path to the file and directory for the current module. Being full paths means that they include everything right up to the root of the current drive this file resides on. Use the code in Listing 3-26 to see these values change as you move the file to different locations on your filesystem and run it.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-26. globals/fileAndDir/app.js
console.log(__dirname);
console.log(__filename);
      </code>
      </pre>

      <h3 class="section-header">process</h3>
      <p>
<?php echo nl2br(
"process is one of the most important globals provided by Node.js. In addition to a few useful member functions and properties that we will examine in the next section, it is a source of a few critical events that we examine in Chapter 5 when we take a deeper look at events.
"); ?>
      </p>

      <h4 class="section-header">Command Line Arguments</h4>
      <p>
<?php echo nl2br(
"Since Node.js does not have a main function in the traditional C/C++/JAVA/C# sense, you use the process object to access the command line arguments. The arguments are available as the process.argv member property, which is an array. The first element is node (that is, the node executable), the second element is the name of the JavaScript file passed into Node.js to start the process, and the remaining elements are the command line arguments. As an example, consider a simple file argv.js, which simply logs these out to the console as shown in Listing 3-27. If you run it as node argv.js foo bar bas, you will get output similar to what is shown in Listing 3-28.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-27. globals/process/argv.js
// argv.js
console.log(process.argv);

// Listing 3-28. Sample Output from argv.js
 ['node',
  '/path/to/file/on/your/filesystem/argv.js',
  'foo',
  'bar',
  'bas']
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Some excellent libraries exist for processing the command line arguments in a meaningful way in Node.js. We will examine one such library when we learn more about NPM in the next chapter.
"); ?>
      </p>

      <h4 class="section-header">process.nextTick</h4>
      <p>
<?php echo nl2br(
"process.nextTick is a simple function that takes a callback function. It is used to put the callback into the next cycle of the Node.js event loop. It is designed to be highly efficient, and it is used by a number of Node.js core libraries. Its usage is simple enough to demonstrate, and an example is shown in Listing 3-29. The output from this sample is shown in Listing 3-30.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-29. globals/process/nexttick.js
// nexttick.js
process.nextTick(function () {
    console.log('next tick');
});
console.log('immediate');

// Listing 3-30. Sample nexttick.js output
immediate
next tick
      </code>
      </pre>

      <p>
<?php echo nl2br(
"As you can see, the immediate call is executed first, whereas the nextTick callback is executed in the next run of the event loop. The reason why you should be aware of this function is because, due to the async nature of Node.js, this function will show up in the call stack quite commonly as this will be the starting point of a Node.js event loop. Everything before this function is in C. Everything after this function in the call stack is in JavaScript.
"); ?>
      </p>

      <h3 class="section-header">Buffer</h3>
      <p>
<?php echo nl2br(
"Buffer World! Pure JavaScript is great for Unicode strings. However, to work with TCP streams and the file system, the developers added native and fast support to handle binary data. The developers did this in Node.js using the Buffer class, which is available globally.

As a Node.js developer working on applications, your main interaction with buffer will most likely be in the form of converting Buffer instances to string or strings to Buffer instances. In order to do either of these conversions, you need to need to tell the Buffer class about what each character means in terms of bytes. This information is called character encoding. Node.js supports all the popular encoding formats like ASCII, UTF-8, and UTF-16.

Converting strings to buffers is really simple. You just call the Buffer class constructor (see prototype discussion in Chapter 2 to review classes in JavaScript) passing in a string and an encoding. Converting a Buffer instance to a string is just as simple. You call the Buffer instance’s toString method passing in an encoding scheme. Both of these are demonstrated in Listing 3-31.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-31. globals/buffer/buffer.js
// a string
var str = "Hello Buffer World!";

// From string to buffer
var buffer = new Buffer(str, 'utf-8');

// From buffer to string
var roundTrip = buffer.toString('utf-8');
console.log(roundTrip); // Hello
      </code>
      </pre>

      <h3 class="section-header">global</h3>
      <p>
<?php echo nl2br(
"The variable global is our handle to the global namespace in Node.js. If you are familiar with front-end JavaScript development, this is somewhat similar to the window object. All the true globals we have seen (console, setTimeout, and process) are members of the global variable. You can even add members to the global variable to make it available everywhere, as shown in Listing 3-32. The fact that this makes the variable something available everywhere is demonstrated in Listing 3-33.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-32. globals/global/addToGlobal.js
global.something = 123;

// Listing 3-33. globals/global/app.js
console.log(console === global.console);       // true
console.log(setTimeout === global.setTimeout); // true
console.log(process === global.process);       // true

// Add something to global
require('./addToGlobal');
console.log(something); // 123
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Even though adding a member to global is something that you can do, it is strongly discouraged. The reason is that it makes it extremely difficult to know where a particular variable is coming from. The module system is designed to make it easy to analyze and maintain large codebases. Having globals all over the place is not maintainable, scalable, or reusable without risk. It is, however, useful to know the fact that it can be done and, more importantly, as a library developer you can extend Node.js any way you like.
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
