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
    <link href="dist/css/test.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="dist/css/test-theme.css" rel="stylesheet">

    <link href="dist/css/highlight-default.css" rel="stylesheet">
    <link href="dist/css/highlight-theme.css" rel="stylesheet">

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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Code++</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="page-heading">
      	<h1 class="page-title">Page Title</h1>
      	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque maximus consectetur. Sed sed diam lobortis, rutrum leo vitae, aliquet nunc.</p>
    	</div>

    	<div class="panel-group">
    		<div class="panel panel-code-text">
    			<div class="panel-heading">
    				<h4 class="panel-title"><a href="#content1" data-toggle="collapse" data-parent="#content">Content 1</a></h4>
    			</div>
    			<div class="panel-collapse collapse in" id="content1">
    				<div class="panel-body">

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed nunc nisl. Maecenas nec arcu a velit dictum pellentesque et fermentum nibh. Nullam congue egestas mi, ac egestas ex consectetur et. Vestibulum sollicitudin interdum ornare. Donec lacus elit, congue id congue non, commodo nec lorem. Nunc finibus pulvinar velit, nec interdum nunc tincidunt porta. Maecenas in tortor orci. </p>
<pre><code class="javascript">
$(document).ready(function(){
	console.log('ready');

	var test = function() {
		console.log('test');
	};

	test();
});

</code>
</pre>

    				</div>
    			</div>
    		</div>

    		<div class="panel panel-code-text">
    			<div class="panel-heading">
    				<h4 class="panel-title"><a href="#content2" data-toggle="collapse" data-parent="#content">Content 2</a></h4>
    			</div>
    			<div class="panel-collapse collapse" id="content2">
    				<div class="panel-body">

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed nunc nisl. Maecenas nec arcu a velit dictum pellentesque et fermentum nibh. Nullam congue egestas mi, ac egestas ex consectetur et. Vestibulum sollicitudin interdum ornare. Donec lacus elit, congue id congue non, commodo nec lorem. Nunc finibus pulvinar velit, nec interdum nunc tincidunt porta. Maecenas in tortor orci. </p>
<pre><code class="html"><?php echo htmlentities('
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Test</title>
	</head>
	<body>
		<h1 class="title">Test</h1>
	</body>
</html>

'); ?>
</code>
</pre>

    				</div>
    			</div>
    		</div>

    		<div class="panel panel-code-text">
    			<div class="panel-heading">
    				<h4 class="panel-title"><a href="#content3" data-toggle="collapse" data-parent="#content">Content 3</a></h4>
    			</div>
    			<div class="panel-collapse collapse" id="content3">
    				<div class="panel-body">

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed nunc nisl. Maecenas nec arcu a velit dictum pellentesque et fermentum nibh. Nullam congue egestas mi, ac egestas ex consectetur et. Vestibulum sollicitudin interdum ornare. Donec lacus elit, congue id congue non, commodo nec lorem. Nunc finibus pulvinar velit, nec interdum nunc tincidunt porta. Maecenas in tortor orci. </p>
<pre><code class="css">
body {
  color: #999;
  padding-top: 70px;
  background-color: #333;
}

.container {
  max-width: 800px
}

pre {
  padding: 0;
  background-color: #333;
  border: none;
}

</code>
</pre>

    				</div>
    			</div>
    		</div>
    	</div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="dist/js/test.min.js"></script>
    <script src="dist/js/highlight.pack.js"></script>
    <script>
    hljs.configure({ tabReplace: '  ' });
    hljs.initHighlightingOnLoad();
    </script>
  </body>
</html>
