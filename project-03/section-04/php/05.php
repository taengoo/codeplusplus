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
        <h1 class="page-title">Section 4.5</h1>
      </div>

      <h3 class="section-header">GLOBAL NODE JS PACKAGES</h3>
      <p><?php echo nl2br(
"It is really simple to make command line utilities in Node.js. One of the most common motivations for learning Node.js nowadays is the fact that a lot of management utilities for front-end projects are written in Node.js. There are projects to test your web front ends, compile various new programming languages like CoffeeScript and TypeScript into JavaScript and Sass, stylus, and less into CSS, minify your JavaScript and CSS and so on. Popular front-end JavaScript projects such as jQuery, AngularJS, Ember.js, and React depend on Node.js scripts to manage their projects.

The objective of global Node.js packages is to provide command line utilities that you can use from (surprise) the command line. All of the NPM commands we have seen take an optional -g flag to indicate that you are working with global modules.

Remember in Chapter 3 we used a utility Browserify to convert Node.js code into browser AMD compatible code. Browserify is a Node.js package we installed globally (npm install -g browserify). This put browserify on the command line, which we used in the previous chapter.

Similarly, you can update global packages (npm update -g package-name), list global packages (npm ls -g), and uninstall packages (npm rm -g package-name). For example, to uninstall Browserify, you would run npm rm -g browserify.

When installing modules globally, NPM does not modify your system configuration. The reason the command line utility suddenly becomes available is because global modules are placed in a location (for example, /usr/local/bin on Mac OSX and the user roaming profile’s NPM folder on Windows) where they become available on the command line.
"); ?></p>

      <h3 class="section-header">Using require with Global Modules</h3>
      <p><?php echo nl2br(
"Modules installed globally are not meant to be used with a require function call in your code, although many packages that support the global flag also support being installed locally in your project (the node_modules folder). If installed locally, that is, without the –g flag, you can use them with the require function as we have already seen. A good and simple example of this is the rimraf module (www.npmjs.org/package/rimraf).

If rimraf is installed globally (npm install -g rimraf), it provides a command line utility that you can use cross platform for recursively and forcefully removing a directory (effectively rm -rf in Unix command line lingo). To remove a directory foo after installing rimraf globally, simply run rimraf foo.

To do the same from your Node.js code, install rimraf locally (npm install rimraf), create an app.js as shown in Listing 4-28, and run it (node app.js).
"); ?></p>

      <pre><code class="javascript">
// Listing 4-28. global/rimrafdemo/app.js
var rimraf = require('rimraf');
rimraf('./foo', function (err) {
    if (err) console.log('Error occured:', err);
    else console.log('Directory foo deleted!');
});
      </code>
      </pre>

      <p><?php echo nl2br(
"For the sake of completeness, it is worth mentioning that there is a way to load modules from a global location if you set the NODE_PATH environment variable. But this is strongly discouraged when consuming modules and you should use dependencies locally (package.json and node_modules).
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
