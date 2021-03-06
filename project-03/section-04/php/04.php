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
        <h1 class="page-title">Section 4.4</h1>
      </div>

      <h3 class="section-header">SEMANTIC VERSIONING</h3>
      <p><?php echo nl2br(
"Good Node.js packages/NPM follow semantic versioning, which is an industry standard and should be followed as a good software development practice. Semantics is the study of meaning. Semantic versioning means versioning your software in a way that the version numbers have significant meaning. There is much that can be said about semantic versioning, but the following is a simplified but practical explanation for a Node.js developer:
-    Put simply, Node.js developers follow a three-digit versioning scheme X.Y.Z where all X, Y, and Z are non-negative integers. X is the major version, Y is the minor, and Z is the patch version.
-    Patch versions must be incremented if backward compatible fixes are introduced.
-    Minor versions must be incremented if backward compatible new features are introduced.
-    Major versions must be incremented if backward incompatible fixes/features/changes are introduced.

Keeping these points in mind, you can see that v1.5.0 of a package should be in-place replaceable by v1.6.1 as the new version should be backward compatible (major version 1 is same). This is something that good packages strive for.

However, the reality is that errors are sometimes inevitably introduced with new versions, or the code was used in a manner that the original authors of the package did not predict. In such a case, some breaking change may be introduced unknowingly.
"); ?></p>

      <h3 class="section-header">Semantic Versioning in NPM / package.json</h3>
      <p><?php echo nl2br(
"NPM and package.json have great support for semantic versioning. You can tell NPM which version of a package you want. For example, the following code installs the exact version 1.0.3 of underscore:

$ npm install underscore@1.0.3

You can tell NPM that you are okay with all patch versions of 1.0 using a tilde “~”:

$ npm install underscore@\"~1.0.0\"

Next up, to tell NPM that you are okay with any minor version changes use “^”:

$ npm install underscore@\"^1.0.0\"

Other version string operators supported include “>=” and “>”, which have intuitive mathematical meanings, such as “>=1.4.2”. Similarly there are “<=” and “<” , for example, “<1.4.2”. There is also a * that can be used at various locations to match any number such as 1.0.* (for example, 1.0.0, 1.0.1, and so on) or 1.* (for example, 1.1.0, 1.3.4, and so on) and simply *, which will get you the latest version every time.

You can use these semantic version strings in package.json as well. For example, the following package.json tells NPM that your package is compatible with any minor upgrade on v1.6.0 of underscore:
"); ?></p>

      <pre><code class="javascript">
"dependencies": {
   "underscore": "^1.6.0"
 }
      </code>
      </pre>

      <h3 class="section-header">Updating Dependencies</h3>
      <p><?php echo nl2br(
"Whenever you use --save flag, the default that NPM uses for updating package.json dependencies section is “^”, preceded by the downloaded version. The reason is that you should always try to use the latest version where the major version number hasn’t changed. This way, you get any new features plus latest bug fixes for free, and there should not be any breaking changes.

As an example, if run the following command, you get a package.json dependencies section:

$ npm install request@1.0.0 -save

Following is the default version string added to package.json:
"); ?></p>

      <pre><code class="javascript">
"dependencies": {
  "request": "^1.0.0"
}
      </code>
      </pre>

      <p><?php echo nl2br(
"However 1.0.0 is not the latest published version of request. To find the latest online version that is compatible with the current semantic version specified in package.json (in this example ^1.0.0), you can run npm outdated, as shown in Listing 4-26.
"); ?></p>

      <pre><code class="javascript">
// Listing 4-26. Check Latest Version of Packages
$ npm outdated
npm http GET https://registry.npmjs.org/request
npm http 304 https://registry.npmjs.org/request
Package  Current  Wanted  Latest  Location
request    1.0.0   1.9.9  2.34.0  request
      </code>
      </pre>

      <p><?php echo nl2br(
"You can see that the latest version compatible with ^1.0.0 is ^1.9.9, which is the wanted version based on the semantic string found in our package.json. It also shows you that there is an even more recent version available.

To update these packages to the newest compatible version and save the results into your package.json (to match the version numbers with what is downloaded), you can simply run the following command. Your updated package.json is shown in Listing 4-27.

$ npm update -save
"); ?></p>

      <pre><code class="javascript">
// Listing 4-27. Updated package.json
"dependencies": {
   "request": "^1.9.9"
}
      </code>
      </pre>

      <p><?php echo nl2br(
"Having this basic knowledge of package.json and the commands npm install, npm rm, npm update, and the --save NPM flag along with a respect for semantic versioning is mostly all you need to know about managing NPM packages in your project.
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
