<?php echo doctype('html5'); ?>
<html lang="pt-br">
<head>
<title><?php echo $title; ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" context="text/html; charset=utf-8">
<?php 

/*meta data*/
echo meta($name = 'viewport', $content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
echo meta('description',$description);
echo meta('keywords',$keywords);
echo meta('author',$author);

/*basic css files */
echo link_tag(base_url('assets/bootstrap/css/bootstrap.min.css'));
echo link_tag(base_url('css/metisMenu.min.css'));
echo link_tag(base_url('css/sb-admin-2.css'));
echo link_tag(base_url('assets/font-awesome/css/font-awesome.min.css'));
echo link_tag(base_url('css/style.css'));

/*extra CSS*/
foreach($css as $c):
     echo link_tag(base_url($c));
 endforeach;

/*extra fonts*/
foreach($fonts as $f):
 echo link_tag("http://fonts.googleapis.com/css?family=".$f);
endforeach;

/*Let fav and touch icons*/
echo link_tag(base_url('images/ico/icon-32x32.min.ico'), 'shortcut icon','image/png');
echo link_tag(base_url('images/ico/icon-128x128.min.ico'), 'apple-touch-icon','image/png');
echo link_tag(base_url('images/ico/icon-57x57.min.ico'), 'apple-touch-icon" sizes="57x57','image/png');
echo link_tag(base_url('images/ico/icon-72x72.min.ico'), 'apple-touch-icon" sizes="72x72','image/png');
echo link_tag(base_url('images/ico/icon-114x114.min.ico'), 'apple-touch-icon" sizes="114x114','image/png');
?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
 <?php echo script_tag('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); ?>
 <?php echo script_tag('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'); ?>
<![endif]-->

</head>
<body class="layout-boxed">
<?php 
    

    // load view data
    echo '<div class="wrapper">';
    echo $body; 
    echo '</div>';
    echo '<!-- /#page-wrapper -->';
    // <!-- jQuery -->
    echo script_tag(base_url('js/jquery-2.1.4.min.js'));
    // <!-- Bootstrap Core JavaScript -->
    echo script_tag(base_url('assets/bootstrap/js/bootstrap.min.js'));
    // <!-- Metis Menu Plugin JavaScript -->
    echo script_tag(base_url('js/metisMenu.min.js'));
    // <!-- Custom Theme JavaScript -->
    echo script_tag(base_url('js/sb-admin-2.js'));
    // <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    echo script_tag(base_url('js/ie10-viewport-bug-workaround.js'));
    // Custmon script
    echo script_tag(base_url('js/scripts.js'));
    // load Extra javascript
    foreach($javascript as $js):
      echo script_tag(base_url($js));
    endforeach;
    
    if(isset($javascript_inline) && !empty($javascript_inline)){
	echo "<script type=\"text/javascript\">\n";
	if(is_array($javascript_inline)){
	    foreach($javascript_inline as $js):
		echo $js . "\n";
	    endforeach;
	}else{
	    echo $javascript_inline;
	}
	echo '</script>';
    }
    
?>

</body>
</html>
