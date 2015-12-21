<html>
    <head></head>
    <body>
	<h3>
	    <?php echo lang('label_mail_message'); ?>.
	</h3> 
	<p>
	    <strong><?php echo lang('label_date'); ?>:</strong>
	    <br />
	    <?php echo date('l jS \of F Y H:i:s'); ?>
	</p>
	<p>
	    <strong><?php echo lang('label_message'); ?>:</strong>
	    <br />
	    <?php echo $message; ?>
	</p>
	
    </body>
</html>