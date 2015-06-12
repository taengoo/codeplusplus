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
        <h1 class="page-title">Section 3.4</h1>
      </div>

      <h3 class="section-header">REUSING NODE JS IN THE BROWSER</h3>
      <p>
<?php echo nl2br(
"Before we learn how to reuse Node.js code in the browser, we need to learn a bit more about the various module systems. We need to understand the need for AMD and what differentiates it from CommonJS.
"); ?>
      </p>

      <h3 class="section-header">Introducing AMD</h3>
      <p>
<?php echo nl2br(
"As we discussed in the beginning of this chapter, Node.js follows the CommonJS module specification. This module system is great for the server environment when we have immediate access to the file system. We discussed that loading a module from the file system in Node.js is a blocking call for the first time. Consider the simple case of loading two modules, as shown in Listing 3-45.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-45. Code Snippet to Show Loading Two Modules Using CommonJS
var foo = require('./foo');
var bar = require('./bar');
// continue code here
      </code>
      </pre>

      <p>
<?php echo nl2br(
"In this example bar.js is not parsed until all of foo.js has been loaded. In fact, Node.js doesn’t even know that you will need bar.js until foo.js is loaded and the line require('./bar') is parsed. This behavior is acceptable in a server environment where it is considered a part of the bootstrap process for your application. You mostly require things when starting your server and afterward these are returned from memory.

However, if the same module system is used in the browser, each require statement would need to trigger an HTTP request to the server. This is an order of magnitude slower and less reliable than a file system access call. Loading a large number of modules can quickly degrade the user experience in the browser. The solution is async, in-parallel, and upfront loading of modules. To support this async loading, we need a way to declare that this file will depend upon ./foo and ./bar upfront and continue code execution using a callback. There is already a specification for exactly this called async module definition (AMD). The same example from Listing 3-45 in AMD format is shown in Listing 3-46.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-46. code snippet to show loading two modules using AMD
define(['./foo', './bar'], function(foo, bar){
    // continue code here
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"The define function is not native to the browser. These must be provided by a third-party library. The most popular of these for the browser is RequireJS (http://requirejs.org/).

To reiterate, the browser has different latency requirements from a server startup. This necessitates a different syntax for loading modules in an async manner. The different nature of the require call is what makes reusing Node.js code in the browser slightly more involved. Before we dig deeper, let’s set up a RequireJS bootstrap application.
"); ?>
      </p>

      <h3 class="section-header">Setting Up RequireJS</h3>
      <p>
<?php echo nl2br(
"Since we need to serve HTML and JavaScript to a web browser, we need to create a basic web server. We will be using Chrome as our browser of choice as it is available on all platforms and has excellent developer tools support. The source code for this sample is available in the chapter3/amd/base folder.
"); ?>
      </p>

      <h4 class="section-header">Starting the Web Server</h4>
      <p>
<?php echo nl2br(
"We will be using server.js, which is a very basic HTTP web server that we will write ourselves in Chapter 6. Start the server using Node.js (node server.js). The server will start listening for incoming requests from the browser on port 3000. If you visit http://localhost:3000, the server will try to serve index.html from the same folder as server.js if it is available.
"); ?>
      </p>

      <h4 class="section-header">Download RequireJS</h4>
      <p>
<?php echo nl2br(
"You can download RequireJS from the official web site (http://requirejs.org/docs/download.html). It is a simple JavaScript file that you can include in your project. It is already present in chapter3/amd/base folder.
"); ?>
      </p>

      <h4 class="section-header">Bootstrapping RequireJS</h4>
      <p>
<?php echo nl2br(
"Create a simple index.html in the same folder as server.js with the contents shown in Listing 3-47.
"); ?>
      </p>
    
      <pre><code class="html"><?php echo htmlentities('
<!-- Listing 3-47. amd/base/index.html -->
<html>
<script
    src="./require.js"
    data-main="./client/app">
</script>
<body>
    <p>Press Ctrl + Shift + J (Windows) or Cmd + Opt + J (MacOSX) to open up the console</p>
</body>
</html>
') ?>
      </code>
      </pre>

      <p>
<?php echo nl2br(
"We have a simple script tag to load require.js. When RequireJS loads, it looks at the data-main attribute on the script tag that loaded RequireJS and considers that as the application entry point. In our example, we set the data-main attribute to ./client/app and therefore RequireJS will try and load http://localhost:3000/client/app.js.
"); ?>
      </p>

      <h4 class="section-header">Client-Side Application Entry Point</h4>
      <p>
<?php echo nl2br(
"As we set up RequireJS to load /client/app.js, let’s create a client folder and an app.js inside that folder that simply logs out something to the console, as shown in Listing 3-48.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-48. amd/base/client/app.js
console.log('Hello requirejs!');
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Now if you open up the browser http://localhost:3000 and open the dev tools (press F12), you should see the message logged to the console, as shown in Figure 3-1.

Figure 3-1. basic AMD sample

That is the basics of setting up RequireJS. This setup will be used in the remaining demos in this section. You only need to copy this server.js + index.html + require.js + client/app.js combination and start hacking to your heart's content.

There are a lot more configuration options for RequireJS and you are encouraged to explore the API documentation that is available online at http://requirejs.org/docs/api.html.
"); ?>
      </p>

      <h3 class="section-header">Playing with AMD</h3>
      <p>
<?php echo nl2br(
"Now that we know how to start a RequireJS browser application, let’s see how we can import/export variables in modules. We will create three modules: app.js, foo.js, and bar.js. We will use foo.js and bar.js from app.js using AMD. This demo is available in chapter3/amd/play folder.

To export something from a module, you can simply return it from the define callback. For example, let’s create a file foo.js that exports a simple function, as shown in Listing 3-49.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-49. amd/play/client/foo.js
define([], function () {
    var foo = function () {
        console.log('foo was called');
    };
    return foo; // function foo is exported
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"To be upfront about all the modules we need in a file, the root of the file contains a call to define. To load  modules ./foo and ./bar in app.js in the same folder, the define call will be as shown in Listing 3-50.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-50. amd/play/client/app.js
define(['./foo', './bar'], function (foo, bar) {
    // use foo and bar here
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"The function define can take a special argument called exports, which behaves similar to the exports variable in Node.js. Let’s create the module bar.js using this syntax, as shown in Listing 3-51.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-51. amd/play/client/bar.js
define(['exports'], function (exports) {
    var bar = exports.log = function () {
        console.log('bar.log was called');
    };
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Note that you can only use exports to attach variables you want to export (for example, exports.log = /*something*/), but you cannot assign it to something else (exports = /*something*/) as that would break the reference the exports variable monitored by RequireJS. This is conceptually quite similar to the exports variable in Node.js. Now, let’s complete app.js and consume both of these modules, as shown in Listing 3-52.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-52. amd/play/client/app.js
define(['./foo', './bar'], function (foo, bar) {
    foo();
    bar.log();
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"If you run this application, you get the desired result shown in Figure 3-2.

Figure 3-2. foo and bar used from app.js

The real benefit of using this alternate (AMD) syntax for modules becomes evident when we look at the network tab within the chrome debug tools, as shown in Figure 3-3.

Figure 3-3. basic AMD sample

You can see that foo.js and bar.js were downloaded in parallel as soon as app.js was downloaded, and RequireJS found that app.js needs foo.js and bar.js to function because of the call to define.
"); ?>
      </p>

      <h4 class="section-header">More about AMD</h4>
      <p>
<?php echo nl2br(
"Here are a few useful and interesting facts that you should know about AMD to complete your knowledge:
- Modules are cached. This is similar to how modules are cached in Node.js—that is, the same object is returned every time.
- Many of these arguments to define are optional and there are various ways to configure how modules are scanned in RequireJS.
- You can still do conditional loading of specific modules using a require call, which is another function provided by RequireJS as shown in Listing 3-53. This function is also async and is different from the Node.js version of require.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-53. Snippet to show how you can conditionally load a module in AMD
define(['./foo', './bar'], function(foo, bar){
    if(iReallyNeedThisModule){
        require(['./bas'], function(bas){
            // continue code here.
        });
    }
});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"The objective here was to give a quick overview of how you can use RequireJS and understand that the browser is different from Node.js.
"); ?>
      </p>

      <h3 class="section-header">Converting Node.js Code into Browser Code</h3>
      <p>
<?php echo nl2br(
"As you can see, there are significant differences between the browser module systems (AMD) and the Node.js module system (CommonJS). However, the good news is that the Node.js community has developed a number of tools to take your CommonJS / Node.js code and transform it to be AMD / RequireJS compatible. The most commonly used one (and the one on which other tools rely) is Browserify (http://browserify.org/).

Browserify is a command line tool that is available as an NPM module. NPM modules are discussed in great detail in the next chapter. For now, it is sufficient to know that if you have Node.js installed as specified in Chapter 1, you already have npm available. To install Browserify as on the command line tool, simply execute the command shown in Listing 3-54. (Note: On Mac OS X you need to run this as root (sudo npm install –g browserify).

Listing 3-54. Installing Browserify
npm install -g browserify

This installs Browserify globally (a concept that will become clear in the next chapter) and makes it further available on the command line. Now if you run browserify, you should see output as shown in Figure 3-4 to indicate a successful installation.

Figure 3-4. Using Browserify on the command prompt

The most common way to use browserify is to specify an entry point for your Node.js module and convert that file and all of its dependencies files into a single AMD compatible file using the –o (--outfile) parameter. As always, let’s jump into a demo to get some hands-on experience.
"); ?>
      </p>

      <h4 class="section-header">Browserify Demo</h4>
      <p>
<?php echo nl2br(
"In this section, we will create a few simple Node.js modules and then use Browserify to convert them to AMD syntax and run them in the browser. All of the code for this example is present in the chapter3/amd/browserify folder.

First off, we will create three files that follow the Node.js / CommonJS module specification (code is in the chapter3/amd/browserify/node folder). We are using foo.js (Listing 3-55) and bar.js (Listing 3-56) from app.js (Listing 3-57) using CommonJS. You can run this code in Node.js to see that it works as expected.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-55. amd/browserify/node/foo.js
module.exports = function () {
    console.log('foo was called');
}

// Listing 3-56. amd/browserify/node/bar.js
exports.log = function () {
    console.log('bar.log was called');
}

// Listing 3-57. amd/browserify/node/app.js
var foo = require('./foo');
var bar = require('./bar');

foo();
bar.log();
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Now let’s convert this code so that it is an AMD compatible module. On the command line, run the command as shown in Listing 3-58.

Listing 3-58. Command Line Arguments to Convert app.js into an AMD Module
browserify app.js -o amdmodule.js

This takes app.js and all its dependencies (foo.js and bar.js) and converts them into a single AMD compatible module amdmodule.js in the same folder. As a final step, we simply load this module from our client app.js (Listing 3-59) to show that it works in the browser.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-59. amd/browserify/client/app.js
define(['../node/amdmodule'], function (amdmodule) {

});
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Now if we start the server (server.js) and open up the web browser (http://localhost:3000), you will see the console.log messages in the chrome dev tools, as shown in Figure 3-5. We have successfully ported the Node.js code to the browser.

Figure 3-5. Reusing Node.js/CommonJS code in the browser

One thing to note is that it is not possible to convert every Node.js module into a browser module. Specifically, Node.js modules that depend on features only available on the server (such as the file system) will not work in the browser.

Browserify has a lot of options and is also able to navigate NPM packages (node_modules). You can learn more about Browserify online at http://browserify.org/.
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
