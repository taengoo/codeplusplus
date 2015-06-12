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
        <h1 class="page-title">Section 3.3</h1>
      </div>

      <h3 class="section-header">CORE MODULES</h3>
      <p>
<?php echo nl2br(
"The Node.js design philosophy is to ship with a few battle-tested core modules and let the community build on these to provide advanced functionality. In this section, we examine a few of the important core modules.
"); ?>
      </p>

      <h3 class="section-header">Consuming Core Modules</h3>
      <p>
<?php echo nl2br(
"Consuming core modules is very similar to consuming file-based modules that you write yourself. You still use the require function. The only difference is that instead of a relative path to the file, you simply specify the name of the module to the require function. For example, to consume the core path module, you write a require statement like var path = require('path'). As with file-based modules, there is no implicit global namespace pollution and what you get is a local variable that you name yourself to access the contents of the module. For example, in var path = require('path') we are storing it in a local variable called path. Now let’s examine a few core modules that you should be aware of to be successful with Node.js.
"); ?>
      </p>

      <h3 class="section-header">Path Module</h3>
      <p>
<?php echo nl2br(
"Use require('path') to load this module. The path module exports functions that provide useful string transformations common when working with the file system. The key motivation for using the path module is to remove inconsistencies in handling file system paths. For example, path.join uses the forward slash `/` on UNIX-based systems like Mac OS X vs. backward slash `\` on Windows systems. Here is a quick discussion and sample of a few of the more useful functions.
"); ?>
      </p>

      <h4 class="section-header">path.normalize(str)</h4>
      <p>
<?php echo nl2br(
"This function fixes up slashes to be OS specific, takes care of . and .. in the path, and also removes duplicate slashes. A quick example to demonstrate these features is shown in Listing 3-34.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-34. core/path/normalize.js
var path = require('path');

// Fixes up .. and .
// logs on Unix: /foo
// logs on Windows: \foo
console.log(path.normalize('/foo/bar/..'));

// Also removes duplicate '//' slashes
// logs on Unix: /foo/bar
// logs on Windows: \foo\bar
console.log(path.normalize('/foo//bar/bas/..'));
      </code>
      </pre>

      <h4 class="section-header">path.join([str1], [str2], …)</h4>
      <p>
<?php echo nl2br(
"This function joins any number of paths together, taking into account the operating system. A sample is shown in Listing 3-35.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-35. core/path/join.js
var path = require('path');

// logs on Unix: foo/bar/bas
// logs on Windows: foo\bar\bas
console.log(path.join('foo', '/bar', 'bas'));
      </code>
      </pre>

      <h4 class="section-header">dirname, basename, and extname</h4>
      <p>
<?php echo nl2br(
"These functions are three of the most useful functions in the path module. path.dirname gives you the directory portion of a specific path string (OS independent), and path.basename gives you the name of the file. path.extname gives you the file extension. An example of these functions is shown in Listing 3-36.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-36. core/path/dir_base_ext.js
var path = require('path');

var completePath = '/foo/bar/bas.html';

// Logs : /foo/bar
console.log(path.dirname(completePath));

// Logs : bas.html
console.log(path.basename(completePath));

// Logs : .html
console.log(path.extname(completePath));
      </code>
      </pre>

      <p>
<?php echo nl2br(
"You should now have an understanding of how to use path and what its design goals are. Path has a few other useful functions that you can explore online using the official Node.js documentation (http://nodejs.org/api/path.html).
"); ?>
      </p>

      <h3 class="section-header">fs Module</h3>
      <p>
<?php echo nl2br(
"The fs module provides access to the filesystem. Use require('fs') to load this module. The fs module has functions for renaming files, deleting files, reading files, and writing to files. A simple example to write to the file system and read from the file system is shown in Listing 3-37.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-37. core/fs/create.js
var fs = require('fs');

// write
fs.writeFileSync('test.txt', 'Hello fs!');

// read
console.log(fs.readFileSync('test.txt').toString());
      </code>
      </pre>

      <p>
<?php echo nl2br(
"One of the great things about the fs module is that it has asynchronous as well as synchronous functions (using the -Sync postfix) for dealing with the file system. As an example, to delete a file you can use unlink or unlinkSync. A synchronous version is shown in Listing 3-38, and an asynchronous version of the same code is shown in Listing 3-39.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-38. core/fs/deleteSync.js
var fs = require('fs');
try {
    fs.unlinkSync('./test.txt');
    console.log('test.txt successfully deleted');
}
catch (err) {
    console.log('Error:', err);
}

// Listing 3-39. core/fs/delete.js
var fs = require('fs');
fs.unlink('./test.txt', function (err) {
    if (err) {
        console.log('Error:', err);
    }
    else {
        console.log('test.txt successfully deleted');
    }
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"The main difference is that the async version takes a callback and is passed the error object if there is one. We discussed this convention of error handling using a callback and an error argument in Chapter 2.

We also saw in Chapter 2 that accessing the file system is an order of magnitude slower than accessing RAM. Accessing the filesystem synchronously blocks the JavaScript thread until the request is complete. It is better to use the asynchronous functions whenever possible in busy processes such as in a web server scenario.

More information about the fs module can be found online in the official Node.js documentation (http://nodejs.org/api/fs.html).
"); ?>
      </p>

      <h3 class="section-header">os Module</h3>
      <p>
<?php echo nl2br(
"The os module provides a few basic (but vital) operating-system related utility functions and properties. You can access it using a require('os') call. For example, if we want to know the current system memory usage, we can use os.totalmem() and os.freemem() functions. These are demonstrated in Listing 3-40.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-40. core/os/memory.js
var os = require('os');
var gigaByte = 1 / (Math.pow(1024, 3));
console.log('Total Memory', os.totalmem() * gigaByte, 'GBs');
console.log('Available Memory', os.freemem() * gigaByte, 'GBs');
console.log('Percent consumed', 100 * (1 - os.freemem() / os.totalmem()));
      </code>
      </pre>

      <p>
<?php echo nl2br(
"A vital facility provided by the os module is information about the number of CPUs available, as shown in Listing 3-41.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-41. core/os/cpus.js
var os = require('os');
console.log('This machine has', os.cpus().length, 'CPUs');
      </code>
      </pre>

      <p>
<?php echo nl2br(
"We will learn how to take advantage of this fact in Chapter 13 when we discuss scalability.
"); ?>
      </p>

      <h3 class="section-header">util Module</h3>
      <p>
<?php echo nl2br(
"The util module contains a number of useful functions that are general purpose. You can access the util module using a require('util') call. To log out something to the console with a timestamp, you can use the util.log function, as shown in Listing 3-42.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-42. core/util/log.js
var util = require('util');
util.log('sample message'); // 27 Apr 18:00:35 - sample message
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Another extremely useful feature is string formatting using the util.format function. This function is similar to the C/C++ printf function. The first argument is a string that contains zero or more placeholders. Each placeholder is then replaced using the remaining arguments based on the meaning of the placeholder. Popular placeholders are %s (used for strings) and %d (used for numbers). These are demonstrated in Listing 3-43.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-43. core/util/format.js
var util = require('util');
var name = 'nate';
var money = 33;

// prints: nate has 33 dollars
console.log(util.format('%s has %d dollars', name, money));
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Additionally, util has a few functions to check if something is of a particular type (isArray, isDate, isError). These functions are demonstrated in Listing 3-44.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-44. core/util/isType.js
var util = require('util');
console.log(util.isArray([])); // true
console.log(util.isArray({ length: 0 })); // false

console.log(util.isDate(new Date())); // true
console.log(util.isDate({})); // false

console.log(util.isError(new Error('This is an error'))); // true
console.log(util.isError({ message: 'I have a message' })); // false
      </code>
      </pre>
	  
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
