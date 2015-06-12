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
        <h1 class="page-title">Section 4.3</h1>
      </div>

      <h3 class="section-header">NPM</h3>
      <p><?php echo nl2br(
"Now we know how to create reusable modules using node_modules. The next piece of the puzzle answers the question, “How do I get what the community has shared with me?”

The answer: Node Package Manger, lovingly called NPM. If you installed Node.js as specified in Chapter 1, it not only added “node” to the command line, but it also added “npm”, which is simply a command line tool that integrates with the online NPM registry (www.npmjs.org/). A screenshot of NPM is shown in Figure 4-1.

Figure 4-1. At its simplest, NPM is a way to share node_modules with the community
"); ?></p>

      <h3 class="section-header">package.json</h3>
      <p><?php echo nl2br(
"An integral part of the NPM ecosystem is a simple JSON file called package.json. This file has special meaning for NPM. It is vital to have it set up properly when you want to share your module with the world, but it is just as useful if you are consuming modules from other people. To create a package.json file in the current folder, just run the code in Listing 4-18 on the command line.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-18. Initializing a package.json File
$ npm init
      </code>
      </pre>

      <p><?php echo nl2br(
"This will ask you a few questions such as the name of the module and its version. I tend to just press enter until the end. This creates a boilerplate package.json in the current folder with the name set to the current folder, version set to 0.0.0, and a few other reasonable defaults as shown in Listing 4-19.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-19. A Default package.json
{
  "name": "foo",
  "version": "0.0.0",
  "description": "",
  "main": "index.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1"
  },
  "author": "",
  "license": "ISC"
}
      </code>
      </pre>

      <h3 class="section-header">Installing an NPM Package</h3>
      <p><?php echo nl2br(
"Let’s install a module, for example, underscore (www.npmjs.org/package/underscore) to a folder. To download the latest version of underscore, you simply run the command shown in Listing 4-20.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-20. Installing an NPM Module
$ npm install underscore
      </code>
      </pre>

      <p><?php echo nl2br(
"This will download the latest version of underscore from npmjs.org and put it into node_modules/underscore in the current folder. TO load this module, all you need to do now is make a require('underscore') call. This is demonstrated in Listing 4-21, where we load the underscore library and simply output the minimum element of an array to the console.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-21. Using an Installed Module
// npm/install/app.js
var _ = require('underscore');
console.log(_.min([3, 1, 2])); // 1
      </code>
      </pre>

      <p><?php echo nl2br(
"We will take a look at underscore and other popular NPM packages later in this chapter; however, at this point the focus is on the NPM command line tool.
"); ?></p>

      <h3 class="section-header">Saving Dependencies</h3>
      <p><?php echo nl2br(
"Whenever you run npm install, you have an optional command line flag available (--save) that tells NPM to write the information about what you installed into package.json, as shown in Listing 4-22.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-22. Installing an NPM Module and Updating package.json
$ npm install underscore --save
      </code>
      </pre>

      <p><?php echo nl2br(
"If you run install with –-save, not only will it download underscore into node_modules, it will also update dependencies inside package.json to point to the installed version of underscore, as shown in Listing 4-23.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-23. Updated Section of package.json
"dependencies": {
    "underscore": "^1.6.0"
  }
      </code>
      </pre>

      <p><?php echo nl2br(
"There are quite a few advantages of keeping track of dependencies this way. For one, it is easy to know which published version of a particular library you are using (depend upon), simply by looking at your package.json. The same holds true when you are browsing the source code of other people’s modules. Just open up their package.json to see what they are relying on.
"); ?></p>

      <h3 class="section-header">Refresh the node_modules Folder</h3>
      <p><?php echo nl2br(
"To refresh the node_modules folder from your package.json, you can run the following command:

$ npm install

This simply looks at your package.json file and downloads a fresh copy of the dependencies specified in your package.json.

Another advantage of using a package.json is that you can now potentially exclude node_modules from your source control mechanism since you can always get a copy from npmjs.org with a simple npm install command.
"); ?></p>

      <h3 class="section-header">Listing All Dependencies</h3>
      <p><?php echo nl2br(
"To see which packages you have installed, you can run npm ls command, as shown in Listing 4-24.

Listing 4-24. Listing Dependencies
"); ?></p>

      <h3 class="section-header">Removing a Dependency</h3>
      <p><?php echo nl2br(
"Remove a dependency using npm rm. For example, npm rm underscore --save deletes the underscore folder from node_modules locally and modifies the dependencies section of your package.json. This command has an intuitive synonym npm uninstall since the command was npm install for installation.
"); ?></p>

      <h3 class="section-header">package.json Online Dependency Tracking</h3>
      <p><?php echo nl2br(
"One more advantage of using package.json for dependency tracking is that if at some later point you decide to share your module with the rest of the world (that is, share at npmjs.org), you do not need to ship the dependencies as your users can download them online.

If your package.json is set up properly and they install your module, NPM will automatically download and install the dependencies of your module. To see a simple example, let’s install a package (request) that has dependencies, as shown in Listing 4-25.

Listing 4-25. Installing a Module with Lots of Dependencies

You can see that NPM not only installed request but also brought down a number of other packages that request depends upon. Each of these packages can, in turn, depend on other packages (for example, form-data depends upon async and combined-stream), and they get their own local copy of the packages they depend upon (and will be downloaded into their own node_modules folder, for example, node_modules/request/node_modules/form-data/node_modules/async). As discussed earlier, because of the way the require function works in Node.js, you can safely use sub modules that depend on different version of the same module since they each get their own copy when set up using NPM.
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
