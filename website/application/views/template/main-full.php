<?php echo $header ?>
<!-- Page Content -->
 <section>
    <div id="page-wrapper" style="min-height: 473px;">
	<div class="container-fluid">
	    <div class="row">
		<div class="col-lg-12">
		    <h2 class="page-header"><?php echo $title; ?></h2>
		</div>
	    </div>
	    <!-- /.row -->
		<div class="row">
		    <div class="col-lg-12">
			<div class="panel panel-default">
			    <div class="panel-heading">
				<h3 class="panel-title"><?php echo $subtitle; ?></h3>
			    </div>
			    <!-- /.panel-heading -->
			    <div class="panel-body">
				<div class="dataTable_wrapper">
				    <?php echo $content_body ?>
				</div>
				<!-- /.table-responsive -->
			    </div>
			    <!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		    </div>
		    <!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
    </div>
</section>
<?php echo $footer ?>
