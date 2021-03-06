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
        <h1 class="page-title">Section 4.2</h1>
      </div>

      <h3 class="section-header">JSON</h3>
      <p><?php echo nl2br(
"NPM uses JSON files for configuring modules. Before we delve deeper into NPM, let’s take a look at JSON.
"); ?></p>

      <h3 class="section-header">Beginner’s Introduction to JSON</h3>
      <p><?php echo nl2br(
"JSON is a standard format used to transfer data over the network. It can be considered a subset of JavaScript object literals for most purposes. It basically restricts what JavaScript object literals are considered valid. JSON objects to make it easier to implement the specification and shield users from edge cases they need to worry about. We will take a practical look at JSON in this section.

One of restrictions enforced by the JSON spec is that you must use quotation marks for JavaScript object keys. This allows you to avoid cases where you cannot have JavaScript keywords as keys for an object literal. For example, the JavaScript in Listing 4-10 was a syntax error in ECMA Script 3 (an older version of JavaScript) because for is a JavaScript keyword.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-10. Invalid JS in Old Browsers (Pre ECMAScript 5)
var foo = { for : 0 }
      </code>
      </pre>

      <p><?php echo nl2br(
"Instead, a valid representation of the same object compatible with all version of JavaScript would be what is shown in Listing 4-11.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-11. Valid JS Even in Old Browsers (Pre ECMAScript 5)
var foo = { "for" : 0 }
      </code>
      </pre>

      <p><?php echo nl2br(
"Additionally, the JSON spec limits what you can have as a value for a given key to be a safe subset of JavaScript objects. The values can only be a string, number, boolean (true or false), array, null, or another valid JSON object. A JSON object that demonstrates all of these is shown in Listing 4-12.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-12. Sample JSON
{
    "firstName": "John",
    "lastName": "Smith",
    "isAlive": true,
    "age": 25,
    "height_cm": 167.64,
    "address": {
        "streetAddress": "21 2nd Street",
        "city": "New York",
        "state": "NY",
    },
    "phoneNumbers": [
        { "type": "home", "number": "212 555-1234" },
        { "type": "fax",  "number": "646 555-4567" }
    ],
    "additionalInfo": null
}
      </code>
      </pre>

      <p><?php echo nl2br(
"The firstName value is a string, age is a number, isAlive is a boolean, phoneNumbers is an array of valid JSON objects, additionalInfo is null, and address is another valid JSON object. The reason for this restriction of types is to simplify the protocol. If you need to pass arbitrary JavaScript objects as JSON, you can try and serialize/deserialize them to a string (common for dates) or a number (common for enums).

Another restriction is that the last property must not have an extra comma. Again this is because of old browsers (for example, IE8) being restrictive about what is and isn’t a valid JavaScript literal. For example, in Listing 4-13, although the first example is a valid JavaScript object literal in Node.js and modern browsers, it is not valid JSON.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-13. Trailing Command after Last Value
// Invalid JSON
{
    "foo": "123",
    "bar": "123",
}
// Valid JSON
{
    "foo": "123",
    "bar": "123"
}
      </code>
      </pre>

      <p><?php echo nl2br(
"To reiterate, JSON is pretty much just JavaScript object literals with a few reasonable restrictions that only serve to increase the ease of implementing the specification and that have been instrumental in its popularity as a data transfer protocol.
"); ?></p>

      <h3 class="section-header">Loading JSON in Node.js</h3>
      <p><?php echo nl2br(
"Since JSON is such an important part of the web, Node.js has fully embraced it as a data format, even locally. You can load a JSON object from the local file system the same way you load a JavaScript module. Every single time within the module loading sequence, if a file.js is not found, Node.js looks for a file.json. If it is found, it returns a JavaScript object representing the JSON object. Let’s work on a simple example. Create a file config.json with a single key foo and a string value (shown in Listing 4-14).
"); ?></p>

      <pre><code class="javascript">
// Listing 4-14. json/filebased/config.js
{
    "foo": "this is the value for foo"
}
      </code>
      </pre>

      <p><?php echo nl2br(
"Now, let’s load this file as a JavaScript object in app.js and log out the value for the key foo (shown in Listing 4-15).
"); ?></p>

      <pre><code class="javascript">
// Listing 4-15. json/filebased/app.js
var config = require('./config');
console.log(config.foo); // this is the value for foo
      </code>
      </pre>

      <p><?php echo nl2br(
"This simplicity of loading JSON explains why so many libraries in the Node.js community rely on using a JSON file as a configuration mechanism.
"); ?></p>

      <h3 class="section-header">The JSON Global</h3>
      <p><?php echo nl2br(
"Data transfer over the wire takes place in the form of bytes. To write a JavaScript object from memory onto the wire or to save to a file, you need a way to convert this object into a JSON string. There is a global object in JavaScript called JSON that provides utility functions for converting a string representation of JSON to JavaScript objects and converting JavaScript objects into a JSON string ready to be sent over the wire or written to the file or anything else you want to do with it. This JSON global is available in Node.js as well all modern browsers.

To convert a JavaScript object to a JSON string, you simply call JSON.stringify passing in the JavaScript object as an argument. This function returns the JSON string representation of the JavaScript object. To convert a JSON string into a JavaScript object, you can use the JSON.parse function, which simply parses the JSON string and returns a JavaScript object matching the information contained in the JSON string, as shown in Listing 4-16 and Listing 4-17.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-16. json/convert/app.js
var foo = {
    a: 1,
    b: 'a string',
    c: true
};

// convert a JavaScript object to a string
var json = JSON.stringify(foo);
console.log(json);
console.log(typeof json); // string

// convert a JSON string to a JavaScript object
var backToJs = JSON.parse(json);
console.log(backToJs);
console.log(backToJs.a); // 1

// Listing 4-17. Output from app.js
$ node app.js
{"a":1,"b":"a string","c":true}
string
{ a: 1, b: 'a string', c: true }
1
      </code>
      </pre>

      <p><?php echo nl2br(
"This rudimentary understanding of JSON and how it relates to JavaScript object literals will go a long way in making you a successful Node.js developer
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
