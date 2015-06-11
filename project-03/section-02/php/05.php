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

      <h3 class="section-header">MORE NODE JS INTERNALS</h3>
      <p>
<?php echo nl2br(
"It is not terribly important to understand the internals of how Node.js works, but a bit more discussion make you more aware of the terminology when you discuss Node.js with your peers. At the heart of Node.js is an event loop.

Event loops enable any GUI application to work on any operating system. The OS calls a function within your application when something happens (for example, the user clicks a button), and then your application executes the logic contained inside this function to completion. Afterward, your application is ready to respond to new events that might have already arrived (and are there on the queue) or that might arrive later (based on user interaction).
"); ?>
      </p>

      <h3 class="section-header">Thread Starvation</h3>
      <p>
<?php echo nl2br(
"Generally during the duration of a function called from an event in a GUI application, no other events can be processed. Consequently, if you do a long-running task within something like a click handler, the GUI will become unresponsive. This is something every computer user I have met has experienced at one point or another. This lack of availability of CPU resources is called starvation.

Node.js is built on the same event loop principle as you find in GUI programs. Therefore, it too can suffer from starvation. To understand it better, let’s go through a few code examples. Listing 2-22. shows a small snippet of code that measures the time passed using console.time and console.timeEnd functions.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 2-22. timeit.js
console.time('timer');
setTimeout(function(){
   console.timeEnd('timer');
},1000)
      </code>
      </pre>
    
      <p>
<?php echo nl2br(
"If you run this code, you should see a number quite close to what you would expect—in other words, 1000ms. This callback for the timeout is called from the Node.js event loop.

Now let’s write some code that takes a long time to execute, for instance, a nonoptimized method of calculating the nth Fibonacci number as shown in Listing 2-23.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 2-23. largeOperation.js
console.time('timeit');
function fibonacci(n) {
    if (n < 2)
        return 1;
    else
        return fibonacci(n - 2) + fibonacci(n - 1);
}
fibonacci(44);             // modify this number based on your system performance
console.timeEnd('timeit'); // On my system it takes about 9000ms (i.e. 9 seconds)
      </code>
      </pre>
    
      <p>
<?php echo nl2br(
"Now we have an event that can be raised from the Node.js event loop (setTimeout) and a function that can keep the JavaScript thread busy (fibonacci). We can now demonstrate starvation in Node.js. Let’s set up a time-out to execute. But before this time-out completes, we execute a function that takes a lot of CPU time and therefore holds up the CPU and the JavaScript thread. As this function is holding on to the JavaScript thread, the event loop cannot call anything else and therefore the time-out is delayed, as demonstrated in Listing 2-24.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 2-24. starveit.js
// utility funcion
function fibonacci(n) {
    if (n < 2)
        return 1;
    else
        return fibonacci(n - 2) + fibonacci(n - 1);
}

// setup the timer
console.time('timer');
setTimeout(function () {
    console.timeEnd('timer'); // Prints much more than 1000ms
}, 1000)

// Start the long running operation
fibonacci(44);
      </code>
      </pre>
    
      <p>
<?php echo nl2br(
"One lesson here is that Node.js is not the best option if you have a high CPU task that you need to do on a client request in a multiclient server environment. However, if this is the case, you will be very hard-pressed to find a scalable software solution in any platform. Most high CPU tasks should take place offline and are generally offloaded to a database server using things such as materialized views, map reduce, and so on. Most web applications access the results of these computations over the network, and this is where Node.js shines—evented network I/O.

Now that you understand what an event loop means and the implications of the fact that JavaScript portion of Node.js is single-threaded, let’s take another look at why Node.js is great for I/O applications.
"); ?>
      </p>

      <h3 class="section-header">Data-Intensive Applications</h3>
      <p>
<?php echo nl2br(
"Node.js is great for data-intensive applications. As we have seen, using a single thread means that Node.js has an extremely low-memory footprint when used as a web server and can potentially serve a lot more requests. Consider the simple scenario of a data intensive application that serves a dataset from a database to clients via HTTP. We know that gathering the data needed to respond to the client query takes a long time compared to executing code and/or reading data from RAM. Figure 2-6 shows how a traditional web server with a thread pool would look while it is responding to just two requests.

Figure 2-6. How a traditional server handles two requests

The same server in Node.js is shown in Figure 2-7. All the work is going to be inside a single thread, which results in lesser memory consumption and, due to the lack of thread context switching, lesser CPU load. Implementation-wise, the handleClientRequest is a simple function that calls out to the database (using a callback). When that callback returns, it completes the request using the request object it captured with a JavaScript closure. This is shown in the pseudocode in Listing 2-25.

Figure 2-7. How a Node.js server handles two requests
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 2-25. handleClientRequest.js
function handleClientRequest(request) {
    makeDbCall(request.someInfo, function (result) {
        // The request corresponds to the correct db result because of closure
        request.complete(result);
    });
}
      </code>
      </pre>
    
      <p>
<?php echo nl2br(
"Note that the HTTP request to the database is also managed by the event loop. The advantage of having async IO and why JavaScript + Node.js is a great fit for data-intensive applications should now be clear.
"); ?>
      </p>

      <h3 class="section-header">The V8 JavaScript Engine</h3>
      <p>
<?php echo nl2br(
"It is worth mentioning that all the JavaScript inside Node.js is executed by the V8 JavaScript engine. V8 came into being with the Google Chrome project. V8 is the part of Chrome that runs the JavaScript when you visit a web page.

Anybody who has done any web development knows how amazing Google Chrome has been for the web. The browser usage statistics reflect that quite clearly. According to w3schools.org (www.w3schools.com/browsers/browsers_stats.asp), nearly 56% of Internet users who visit their web site are now using Google Chrome. There are lots of reasons for this, but V8 and its speed is a very important factor. Besides speed, another reason for using V8 is that the Google engineers made it easy to integrate into other projects, and that it is platform independent.
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
