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
        <h1 class="page-title">Section 4.6</h1>
      </div>

      <h3 class="section-header">PACKAGE.JSON AND REQUIRE</h3>
      <p><?php echo nl2br(
"Most of package.json we have seen has been for NPM. All it was doing was managing our dependencies and putting them in node_modules. From this point on, require works the way we have already shown. It looks for a JavaScript file/folder in node_modules that matches what we asked require to load, for example, foo in require('foo'). We have already shown that if it resolves to a folder, Node.js tries to load index.js from that folder as the result of the module load.

There is one final thing about the require function that you need to know about. You can use package.json to redirect require to load a different file from a folder instead of the default (which would look for an index.js). This is done using the main property in a package.json. The value of this property is the path to the JavaScript file you want to load. Let’s look at an example and create a directory structure, as shown in Listing 4-29.
"); ?></p>
    
      <pre><code class="javascript">
// Listing 4-29. Project Structure for Demo Code chapter4/mainproperty
|-- app.js
|-- node_modules
    |-- foo
        |-- package.json
        |-- lib
            |-- main.js
      </code>
      </pre>

      <p><?php echo nl2br(
"main.js is a simple file that logs to the console to indicate it was loaded, as shown in Listing 4-30.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-30. mainproperty/node_modules/foo/lib/main.js
console.log('foo main.js was loaded');
      </code>
      </pre>

      <p><?php echo nl2br(
"Within the package.json, simply point main to main.js in the lib folder:
"); ?></p>

      <pre><code class="javascript">
{
    "main" : "./lib/main.js"
}
      </code>
      </pre>

      <p><?php echo nl2br(
"This means that if anybody were to require('foo'), Node.js would look at package.json, see the main property, and run './lib/main.js'. So let’s require this module in our app.js. If you run it (node app.js), you will see that indeed main.js was loaded.

require('foo');

One thing worth mentioning is that “main” is the only property that require and hence the node executable cares about. All other properties in package.json are for NPM / npm executable, which is specifically designed for package management.

The advantage of having this “main” property is that it allows library developers complete freedom on how they want to architect their project and keep the structure as clear as they want.

Quite commonly, people will put simple Node.js packages (ones that can go in a file) into a file name that matches the package name packageName.js and then create a package.json to point to the file name. For example, this is what rimraf does—it has a rimraf.js and that is what the main property of package.json points to, as shown in Listing 4-31.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-31. package.json from the rimraf npm Module Showing the Main Property
{
  "name": "rimraf",
  "version": "2.2.7",
  "main": "rimraf.js",
   ...
}
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
