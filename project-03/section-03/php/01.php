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
        <h1 class="page-title">Section 3.1</h1>
      </div>

      <h3 class="section-header">NODE JS FILE-BASED MODULE SYSTEM</h3>
      <p>
<?php echo nl2br(
"Kevin Dongaoor created CommonJS in 2009 with the goal to specify an ecosystem for JavaScript modules on the server. Node.js follows the CommonJS module specification. Following are a few salient points of the module system:
- Each file is its own module.
- Each file has access to the current module definition using the module variable.
- The export of the current module is determined by the module.exports variable.
- To import a module, use the globally available require function.

As always, it is best to jump right into the code. Let’s consider a simple example where we want to share a function in file foo.js with various parts of our application. To export the function from the file, we simply assign it to module.exports, as shown in Listing 3-1.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-1. intro/base/foo.js
module.exports = function () {
    console.log('a function in file foo');
};
      </code>
      </pre>

      <p>
<?php echo nl2br(
"In order to use this function from a file bar.js, we simply import foo using the globally available require function and store the returned value in a local variable, as shown in Listing 3-2.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-2. intro/base/bar.js
var foo = require('./foo');
foo(); // logs out : "a function in file foo"
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Node.js was designed to be simple, and this shows in its module system. Now that we have seen a simple example, let’s dig deeper into various details, starting with the require function.
"); ?>
      </p>

      <h3 class="section-header">Node.js require Function</h3>
      <p>
<?php echo nl2br(
"The Node.js require function is the main way of importing a module into the current file. There are three kinds of modules in Node.js: core modules, file modules, and external node_modules, all of which use the require function. We are discussing file modules at the moment.

When we make a require call with a relative path—for example, something like require('./filename') or require('../foldername/filename')—Node.js runs the destination JavaScript file in a new scope and returns whatever was the final value for module.exports in that file. This is the basis of file modules. Let’s look at the ramifications of this design.
"); ?>
      </p>

      <h4 class="section-header">Node.js Is Safe</h4>
      <p>
<?php echo nl2br(
"Modules in many programming environments are not safe and pollute the global scope. A simple example of this is PHP. Say you have a file foo.php that simply defines a function foo, as shown in Listing 3-3.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-3. foo.php
function foo($something){
        return $something;
}
      </code>
      </pre>

      <p>
<?php echo nl2br(
"If you want to reuse this function in a file bar.php, you can simply include foo.php using the include function, and then everything from the file foo.php becomes a part of the (global) scope of bar.php. This allows you to use the function foo, as shown in Listing 3-4.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-4. include Function in PHP
include('foo.php');
foo();
      </code>
      </pre>

      <p>
<?php echo nl2br(
"This design has quite a few negative implications. For example, what a variable foo means in a current file may change based on what you import. As a result, you cannot safely include two files, foo1 and foo2, if there is a chance that they have some variable with the same name. Additionally, everything gets imported, so you cannot have local only variables in a module. You can overcome this in PHP using namespaces, but Node.js avoids the potential of namespace pollution altogether.

Using the require function only gives you the module.exports variable, and you need to assign the result to a variable locally in order to use it in scope, as shown in Listing 3-5.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-5. Code Snippet to Show That You Control the Name
var yourChoiceOfLocalName = require('./foo');
      </code>
      </pre>

      <p>
<?php echo nl2br(
"There is no accidental global scope—there are explicit names and files with similar internal local variable names that can coexist peacefully.
"); ?>
      </p>

      <h4 class="section-header">Conditionally Load a Module</h4>
      <p>
<?php echo nl2br(
"require behaves just like any other function in JavaScript. It has no special properties. This means that you can choose to call it based on some condition and therefore load the module only if you need it, as shown in Listing 3-6.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-6. Code Snippet to Lazy Load a Module
if(iReallyNeedThisModule){
     var foo = require('./foo');
}
      </code>
      </pre>

      <p>
<?php echo nl2br(
"This allows you to lazy load a module only on first use, based on your requirements.
"); ?>
      </p>

      <h4 class="section-header">Blocking</h4>
      <p>
<?php echo nl2br(
"The require function blocks further code execution until the module has been loaded. This means that the code following the require call is not executed until the module has been loaded and executed. This allows you to avoid providing an unnecessary callback like you need to do for all async I/O in Node.js, which was discussed in Chapter 2. (See Listing 3-7.)
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-7. Code Snippet to Demonstrate That Modules Are Loaded Synchronously
// Blocks execution till module is loaded
var foo = require('./foo');

// Continue execution after it is loaded
console.log('loaded foo');
foo();
      </code>
      </pre>

      <h4 class="section-header">Cached</h4>
      <p>
<?php echo nl2br(
"As you know from Chapter 2, reading something from the file system is an order of magnitude slower than reading it from RAM. Hence, after the first time a require call is made to a particular file, the module.exports is cached. The next time a call is made to require that resolves to the same file (in other words, it does not matter what the original relative file path passed to the require call is as long as the destination file is the same), the module.exports variable of the destination file is returned from memory, keeping things fast. Listing 3-8 shows this speed difference with a simple example.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-8. intro/cached/bar.js
var t1 = new Date().getTime();
var foo1 = require('./foo');
console.log(new Date().getTime() - t1); // > 0

var t2 = new Date().getTime();
var foo2 = require('./foo');
console.log(new Date().getTime() - t2); // approx 0
      </code>
      </pre>

      <h4 class="section-header">Shared State</h4>
      <p>
<?php echo nl2br(
"Having some mechanism to share state between modules is useful in various contexts. Since modules are cached, every module that require’s foo.js will get the same (mutable) object if we return an object foo from a module foo.js. Listing 3-9 demonstrates this process with a simple example in which we export an object. This object is modified in app.js, as shown in Listing 3-10. This modification affects what is returned by require in bar.js, as shown in Listing 3-11. This allows you to share in-memory objects between modules that are useful for things like using modules for configuration. A sample execution is shown in Listing 3-12.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-9. intro/shared/foo.js
module.exports = {
    something: 123
};

// Listing 3-10. intro/shared/app.js
var foo = require('./foo');
console.log('initial something:', foo.something); // 123

// Now modify something:
foo.something = 456;

// Now load bar:
var bas = require('./bar');

// Listing 3-11. intro/shared/bar.js
var foo = require('./foo');
console.log('in another module:', foo.something); // 456

// Listing 3-12. Sample Run of intro/shared/app.js
$ node app.js
initial something: 123
in another module: 456
      </code>
      </pre>

      <h4 class="section-header">Object Factories</h4>
      <p>
<?php echo nl2br(
"As we have shown, the same object is returned each time a require call resolves to the same file in a Node.js process. If you want some form of new object creation mechanism for each require function call, you can export a function from the source module that returns a new object. Then require the module at your destination and call this imported function to create a new object. An example is shown in Listing 3-13 where we export a function and then use this function to create a new object, as shown in Listing 3-14.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-13. intro/factory/foo.js
module.exports = function () {
    return {
        something: 123
    };
};

// Listing 3-14. intro/factory/app.js
var foo = require('./foo');

// create a new object
var obj = foo();

// use it
console.log(obj.something); // 123
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Note that you can even do this in one step (in other words, require('./foo')();)
"); ?>
      </p>

      <h3 class="section-header">Node.js Exports</h3>
      <p>
<?php echo nl2br(
"Now that we understand require a bit more, let’s take a deeper look at module.exports.
"); ?>
      </p>

      <h4 class="section-header">module.exports</h4>
      <p>
<?php echo nl2br(
"As stated earlier, each file in Node.js is a module. The items that we intend to export from a module should be attached to the module.exports variable. It is important to note that module.exports is already defined to be a new empty object in every file. That is, module.exports = {} is implicitly present. By default, every module exports an empty object, in other words, {}. (See Listing 3-15.)
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-15. intro/module.exports/app.js
console.log(module.exports); // {}
      </code>
      </pre>
    
      <h4 class="section-header">Exports Alias</h4>
      <p>
<?php echo nl2br(
"So far, we have only been exporting a single object from a module. This can be done quite simply by assigning the object we need exported to module.exports. However, it is a common requirement to export more than one variable from a module. One way of achieving this is to create a new object literal and assign that to module.exports, as shown in Listing 3-16.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-16. intro/exports/foo1.js
var a = function () {
    console.log('a called');
};

var b = function () {
    console.log('b called');
};

module.exports = {
    a: a,
    b: b
};
      </code>
      </pre>

      <p>
<?php echo nl2br(
"However, this is slightly cumbersome to manage because what the module returns can potentially be distant in terms of lines from what a module contains. In Listing 3-16, function a is defined a lot earlier than the point at which we actually export it to the outside world. So a common convention is to simply attach the objects we want to export to module.exports inline, as shown in Listing 3-17. This is possible because module.exports is implicitly set to {} by Node.js, as we saw earlier in Listing 3-15.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-17. intro/exports/foo2.js
module.exports.a = function () {
    console.log('a called');
};

module.exports.b = function () {
    console.log('b called');
};
      </code>
      </pre>

      <p>
<?php echo nl2br(
"However, typing module.exports all the time becomes cumbersome as well. So Node.js helps us by creating an alias for module.exports called exports so instead of typing module.exports.something every time, you can simply use exports.something. This is shown in Listing 3-18.
"); ?>
      </p>

      <pre><code class="javascript">
// Listing 3-18. intro/exports/foo3.js
exports.a = function () {
    console.log('a called');
};

exports.b = function () {
    console.log('b called');
};
      </code>
      </pre>

      <p>
<?php echo nl2br(
"It is important to note that exports is just like any other JavaScript variable; Node.js simply does exports = module.exports for us. If we add something  for example, foo to exports, that is exports.foo = 123, we are effectively doing module.exports.foo = 123 since JavaScript variables are references, as discussed in Chapter 2.

However, if you do exports = 123, you break the reference to module.exports; that is, exports no longer points to module.exports. Also, it does not make module.exports = 123. Therefore, it is very important to know that you should only use the exports alias to attach stuff and not assign stuff to it directly. If you want to assign a single export, use module.exports =  as we have been doing until this section.

Finally, you can run the code sample shown in Listing 3-19 to demonstrate that all of these methods are equivalent from consumption (import) point of view.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-19. intro/exports/app.js
var foo1 = require('./foo1');
foo1.a();
foo1.b();

var foo2 = require('./foo2');
foo2.a();
foo2.b();

var foo3 = require('./foo3');
foo3.a();
foo3.b();
      </code>
      </pre>
    
      <h3 class="section-header">Modules Best Practices</h3>
      <p>
<?php echo nl2br(
"Now that we understand the technology behind the Node.js file-based module system, let’s look at a few best practices followed by the community. Node.js and JavaScript are quite resilient to programming errors and try to be flexible, which is why there are various ways that work. However, you should follow some conventions, and we highlight a few that are common in the community.
"); ?>
      </p>
    
      <h4 class="section-header">Do Not Use the .js Extension</h4>
      <p>
<?php echo nl2br(
"It is better to do require('./foo') instead of require('./foo.js') even though both work fine for Node.js.

Reason: For browser-based module systems (such as RequireJS, which we look at later in this chapter), it is assumed that you do not provide the .js extension since we cannot look at the server filesystem to see what you meant. For the sake of consistency, avoid adding the .js extension in all your require calls.
"); ?>
      </p>
    
      <h4 class="section-header">Relative Paths</h4>
      <p>
<?php echo nl2br(
"When using file-based modules, you need to use relative paths (in other words, do require('./foo') instead of require('foo')).

Reason: Non-relative paths are reserved for core modules and node_modules. We discuss core modules in this chapter and node_modules in the next chapter.
"); ?>
      </p>
    
      <h4 class="section-header">Utilize exports</h4>
      <p>
<?php echo nl2br(
"Try and use the exports alias when you want to export more than one thing.

Reason: It keeps what is exported close to its definition. It is also conventional to have a local variable for each thing you export so that you can easily use it locally. Do this all in a single line, as shown in Listing 3-20.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-20. Create a Local Variable and Also Export
var foo = exports.foo = /* whatever you want to export as `foo` from this module */ ;
      </code>
      </pre>
    
      <h4 class="section-header">Export an Entire Folder</h4>
      <p>
<?php echo nl2br(
"If you have too many modules that go together that you keep importing into other files, try to avoid repeating the import, as shown in Listing 3-21.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-21. Avoid Repeating Huge Import Blocks
var foo = require('../something/foo');
var bar = require('../something/bar');
var bas = require('../something/bas');
var qux = require('../something/qux');
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Instead, create a single index.js in the something folder. In index.js, import all the modules once and then export them from this module, as shown in Listing 3-22.
"); ?>
      </p>
    
      <pre><code class="javascript">
// Listing 3-22. Sample index.js
exports.foo = require('./foo');
exports.bar = require('./bar');
exports.bas = require('./bas');
exports.qux = require('./qux');
      </code>
      </pre>

      <p>
<?php echo nl2br(
"Now you can simply import this index.js whenever you need all these things:

var something = require('../something/index');

Reason: It is more maintainable. On the export side, individual modules (individual files) remain smaller—you do not need to put everything into a single file just so you can import it easily elsewhere. You just need to create an index.js file. On the import side, you have fewer require calls to write (and maintain).
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
