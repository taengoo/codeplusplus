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
        <h1 class="page-title">Section 4.1</h1>
      </div>

      <h3 class="section-header">REVISITING NODE MODULES</h3>
      <p><?php echo nl2br(
"In the previous chapter, we learned that there are three kinds of Node.js modules: file-based modules, core modules, and external node_modules. We discussed file-based modules and core modules, and now we will look at node_modules. To understand them better, let’s take a deeper look at the file system scanning order of the Node.js require function.
- If the module name passed into the require function is prefixed with ‘./’ or ‘../’ or ‘/’, then it is assumed to be a file-based module and the file is loaded, as we saw in the Chapter 3. Some sample calls: require('./bar), require('../bar/bar'), require('/full/path/to/a/node/module/file')
- Otherwise, we look for core modules with the same name, for example, 'bar' if the call was require('bar'). If no core module matching this name is found, we look for a node_module called 'bar'.
"); ?>
      </p>

      <h3 class="section-header">Scanning for node_modules</h3>
      <p><?php echo nl2br(
"Let’s just look at an example first. If a file /home/ryo/project/foo.js has a require call require('bar'), Node.js scans the file system for node_modules in the following order. The first bar.js that is found is returned.
-    /home/ryo/project/node_modules/bar.js
-    /home/ryo/node_modules/bar.js
-    /home/node_modules/bar.js
-    /node_modules/bar.js

In other words, Node.js looks for 'node_modules/bar.js' in the current folder followed by every parent folder until it reaches the root of the file system tree for the current file or until a bar.js is found. A simple example of this is a module foo.js that loads a module node_modules/bar.js, as shown in Listing 4-1 and Listing 4-2.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 4-1. hello/foo.js
var bar = require('bar');
bar(); // hello node_modules!

Listing 4-2. hello/node_modules/bar.js
module.exports = function () {
    console.log('hello node_modules!');
}
      </code>
      </pre>
    
      <p><?php echo nl2br(
"As you can see, our module bar.js looks exactly the same as it would if we were simply using file-based modules. And that is intentional. The only difference between file-based modules and node_modules is the way in which the file system is scanned to load the JavaScript file. All other behavior is the same.
"); ?>
      </p>

      <h3 class="section-header">Folder-Based Modules</h3>
      <p><?php echo nl2br(
"Before we discuss all the advantages of node_modules mechanism, we need to learn one final code organization trick supported by the Node.js require function. It is not uncommon to have a several files working toward a singular goal. It makes sense to organize these files into a single module that can be loaded with a single require call. We discussed organizing such files into a single folder and having an index.js to represent the folder in Chapter 3.

This is such a common scenario that Node.js has explicit support for this mechanism. That is, if a path to the module resolves to a folder (instead of a file), Node.js will look for an index.js file in that folder and return that as the module file. This is demonstrated in a simple example (chapter4/folderbased/indexbased1) where we export two modules bar1.js and bar2.js using an index.js and load the module bar (and implicitly bar/index.js) in a module foo, as shown in Listing 4-3 (run node folderbased/indexbased1/foo.js).
"); ?>
      </p>

      <pre><code class="javascript">
// Listing 4-3. Implicit Loading of index.js from a Folder (Code: folderbased/indexbased1)
// bar/bar1.js
module.exports = function () {
    console.log('bar1 was called');
}

// bar/bar2.js
module.exports = function () {
    console.log('bar2 was called');
}

// bar/index.js
exports.bar1 = require('./bar1');
exports.bar2 = require('./bar2');

// foo.js
var bar = require('./bar');
bar.bar1();
bar.bar2();
      </code>
      </pre>

      <p><?php echo nl2br(
"As we stated earlier, the only difference between file-based modules and node_modules is the way in which the file system is scanned. So for a call like require('./bar'), the same code for node_modules would be a simple move of the bar folder into node_modules/bar folder and the require call changed from require('./bar') to require('bar').

This example is present in the chapter4/folderbased/indexbased2 folder (run node folderbased/indexbased2/foo.js). Since the call now resolves to node_modules/bar folder, Node.js looks for node_modules/bar/index.js and since it is found, that is what is returned for require('bar'). (See Listing 4-4.)
"); ?>
      </p>

      <pre><code class="javascript">
// Listing 4-4. Implicit Loading of index.js from a node_modules/module Folder (Code: folderbased/indexbased2)
// node_modules/bar/bar1.js
module.exports = function () {
    console.log('bar1 was called');
}

// node_modules/bar/bar2.js
module.exports = function () {
    console.log('bar2 was called');
}

// node_modules/bar/index.js
exports.bar1 = require('./bar1');
exports.bar2 = require('./bar2');

// foo.js
var bar = require('bar'); // look for a node_modules module named bar
bar.bar1();
bar.bar2();
      </code>
      </pre>

      <p><?php echo nl2br(
"The require call semantics look exactly the same for node_modules as they do for core modules (compare require('fs') to require('bar') function call). This is intentional. You get the feeling of expanding the built in Node.js functionality when using node_modules.

Using folder-based code organization when working with node_modules is a common strategy and what you should do whenever possible. In other words, refrain from making top-level JavaScript files in the node_modules folder if all you want is a single file. Then, instead of node_modules/bar.js, use a node_modules/bar/index.js file.
"); ?></p>

      <h3 class="section-header">Advantages of node_modules</h3>
      <p><?php echo nl2br(
"We now understand that node_modules are the same as file-based modules with just a different file system scanning mechanism used on loading the module JavaScript file. The obvious question at this point is, “What are the advantages?”
"); ?></p>

      <h4 class="section-header">Simplify Long File Relative Paths</h4>
      <p><?php echo nl2br(
"Say you have a module foo/foo.js that provides a number of utilities that you need to use at a variety of different places in your application. In a section bar/bar.js, you would have a require call require('../foo/foo.js'), and in a section bas/nick/scott.js, you would have a require call like require('../../../foo/foo.js'). At this point, you should ask yourself, “Is this foo module self-contained?” If so, it is a great candidate to move into node_modules/foo/index.js in the root of your project folder. This way you can simplify your calls to be just require('foo') throughout your code.
"); ?></p>
      
      <h4 class="section-header">Increasing Reusability</h4>
      <p><?php echo nl2br(
"If you want to share a module foo with another project, you only need to copy node_modules/foo to that project. In fact, if you are working on two similar sub projects, you can move node_modules/foo to a folder that contains both your projects, as shown in Listing 4-5. This makes it easier for you to maintain foo from a single place.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-5. Sample Code Organization for Sub Projects Using Shared node_modules
projectroot
   |-- node_modules/foo
   |-- subproject1/project1files
   |-- subproject2/project2files
      </code>
      </pre>

      <h4 class="section-header">Decreasing Side Effects</h4>
      <p><?php echo nl2br(
"Because of the way the node_modules are scanned, you can limit the availability of a module to a particular section of your codebase. This allows you to safely do partial upgrades, assuming that your original code organization was as shown in Listing 4-6.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-6. Demo Project Using a Module foo
projectroot
   |-- node_modules/foo/fooV1Files
   |-- moduleA/moduleAFiles
   |-- moduleB/moduleBFiles
   |-- moduleC/moduleCFiles
      </code>
      </pre>

      <p><?php echo nl2br(
"Now, when you are working on a new module (say moduleD) that needs a new (and backward incompatible) version of module foo, you can simply organize your code as shown in Listing 4-7.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-7. Partial Upgrade of Module foo
projectroot
   |-- node_modules/foo/fooV1Files
   |-- moduleA/moduleAFiles
   |-- moduleB/moduleBFiles
   |-- moduleC/moduleCFiles
   |-- moduleD
          |-- node_modules/foo/fooV2Files
          |-- moduleDFiles
      </code>
      </pre>

      <p><?php echo nl2br(
"In this way, moduleA, moduleB, and moduleC continue to function as always and you get to use the new version of foo in moduleD.
"); ?></p>

      <h4 class="section-header">Overcoming Module Incompatibility</h4>
      <p><?php echo nl2br(
"Node.js does not suffer from the module dependency/incompatibility hell that is present in a number of traditional systems. In many traditional module systems, a moduleX cannot work with moduleY because they depend on different (and incompatible) versions of moduleZ. In Node.js, each module can have its own node_modules folder and different versions of moduleZ can coexist. Modules do not need to be global in Node.js!
"); ?></p>

      <h3 class="section-header">Module Caching and node_modules</h3>
      <p><?php echo nl2br(
"You might recall from our discussion in Chapter 3 that require caches the result of a require call after the first time. The reason is the performance boost you get from not needing to load JavaScript and run it from the file system again and again. We said that require returns the same object each time the path resolves to the same file.

As we have already shown, node_modules are just a different way of scanning for file-based modules. Therefore, they follow the same module caching rule. If you have two folders where moduleA and moduleB require module foo i.e require('foo'), which is present in some parent folder as shown in Listing 4-8, they get the same object (as exported from node_modules/foo/index.js in the given example).
"); ?></p>

      <pre><code class="javascript">
// Listing 4-8. Both Modules Get the Same foo Module
projectroot
    |-- node_modules/foo/index.js
    |-- moduleA/a.js
    |-- moduleB/b.js
      </code>
      </pre>

      <p><?php echo nl2br(
"However, consider the code organization as shown in Listing 4-9. Here moduleB’s require('foo') call will resolve to moduleB/node_modules/foo/index.js, whereas moduleA’s require call will resolve to node_modules/foo/index.js and therefore they do not get the same object.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-9. Module A and B Get Different foo Module
projectroot
    |-- node_modules/foo/index.js
    |-- moduleA/a.js
    |-- moduleB
         |-- node_modules/foo/index.js
         |-- b.js
      </code>
      </pre>

      <p><?php echo nl2br(
"This is a good thing as we have already seen that it prevents you from going into a dependency problem. But this disconnection is something you should be conscious of.
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
