
<h3><?php echo lang('subtitle_menu_add_change'); ?>:</h3>
<br />

<?php
    $count = 2;
    foreach ($menus as $menu) {
	if($count % 2 == 0){
	    echo '<div class="row">';
	}
?>

    <div class="col-md-6">
	<!-- Example -->
	<div class="panel panel-default">
	    <div class="panel-heading">
		<h3 class="panel-title">
		    <?php echo $menu->name_menu; ?>
		</h3>
	    </div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
		<div class="dataTable_wrapper">
		    <div class="text-center">
			<?php
			    
			    $modelo_menu = array(
				'src' => 'media/menu/'.$menu->image,
				'class' => 'mb-lg img-thumbnail',
				'alt' => lang('alt_modelo_menu'), 
				'style' => 'height: 200px'
			    );
			    echo img($modelo_menu); 
			    echo '<br />';
			    echo anchor(base_url("sample/{$menu->id_menu}/"), '<i class="fa fa-search fa-fw"></i>'.lang('btn_menu_view'), 'class="btn btn-primary mr-lg"'); 

			    echo anchor('dashboard/menu_change/'.encode_url($menu->id_menu), '<i class="fa fa-check fa-fw"></i>'.lang('btn_menu_select'), 'class="btn btn-primary ml-lg"'); 
			?>
		    </div>
		</div>
		<!-- /.table-responsive -->
	    </div>
	    <!-- /.panel-body -->
	</div>
    </div>

<?php 
	if($count % 2 == 1){
	    echo  "</div>\n";
	}
	$count++;
    }
    
    if($count % 2 == 1){
	echo '</div>';
    }
?>


