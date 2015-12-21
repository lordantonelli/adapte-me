
<div class="panel panel-default">
    <div class="panel-heading">
	<h3 class="panel-title"><?php echo lang('subtitle_user'); ?></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
	<div class="dataTable_wrapper">
	    <dl class="dl-horizontal">
		<dt><?php echo lang('dt_name_user'); ?>:</dt>
		<dd><?php echo $user->name_user; ?></dd>

		<dt><?php echo lang('dt_birthdate'); ?>:</dt>
		<dd><?php echo date('d/m/Y', strtotime($user->birthdate)); ?></dd>
		
		<dt><?php echo lang('dt_gender'); ?>:</dt>
		<dd><?php echo ($user->gender == 'F' ? lang('label_gender_female') : lang('label_gender_male')); ?></dd>
		
		<dt><?php echo lang('dt_email'); ?>:</dt>
		<dd><?php echo $user->email; ?></dd>
	    </dl>
	    <div class="text-center">
		<?php echo anchor('dashboard/user_edit/', '<i class="fa fa-pencil fa-fw"></i> '.lang('btn_edit_user'), 'class="mr-lg mb-lg btn btn-primary"'); ?>
		<?php echo anchor('dashboard/alter_password', '<i class="fa fa-key fa-fw"></i> '.lang('btn_password_user'), 'class="mr-lg mb-lg btn btn-primary"'); ?>
		<?php //echo anchor('dashboard/user_delete/', '<i class="fa fa-trash-o fa-fw"></i> '.lang('btn_delete_user'), 'class="mr-lg mb-lg btn btn-danger"'); ?>
	    </div>
	</div>
	<!-- /.table-responsive -->
    </div>
    <!-- /.panel-body -->
</div>


<div class="row">
    <div class="col-md-5">
	<!-- Example -->
	<div class="panel panel-default">
	    <div class="panel-heading">
		<h3 class="panel-title">
		    <?php 
			echo lang('subtitle_example'); 
			if($menu) {
			    echo ': <strong class="text-primary">'.$menu->name_menu.'</strong>';
			}
		    ?>
		</h3>
	    </div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
		<div class="dataTable_wrapper">
		    <div class="text-center">
			<?php
			    if($menu){
				$modelo_menu = array(
				    'src' => 'media/menu/'.$menu->image,
				    'class' => 'mb-lg img-thumbnail',
				    'alt' => lang('alt_modelo_menu'), 
				);
				echo img($modelo_menu); 
				echo '<br />';
				echo anchor('dashboard/menu_change', '<i class="fa fa-bars fa-fw"></i> '.lang('btn_change_menu'), 'class="btn btn-primary "'); 
			    } else{
				echo anchor('dashboard/menu_change', '<i class="fa fa-bars fa-fw"></i> '.lang('btn_add_menu'), 'class="btn btn-primary btn-block"'); 
			    }
			?>
		    </div>
		</div>
		<!-- /.table-responsive -->
	    </div>
	    <!-- /.panel-body -->
	</div>
    </div>
    
    <?php if ($menu_default) { ?>
	<div class="col-md-7">
	    <!-- Preferences -->
	    <div class="panel panel-default">
		<div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('subtitle_config'); ?></h3>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		    <div class="dataTable_wrapper">
			<?php
			$buttons = '';
			if($attributes){
			    echo '<dl class="dl-horizontal user-attributes">';
				foreach ($attributes as $attribute) {
				    echo '<dt>'.$attribute->name_attribute.':</dt>';
				    echo '<dd>'.$attribute->value;
				    echo anchor('dashboard/attribute_delete/'.encode_url($attribute->id_user_menu_attribute), '<i class="fa fa-times fa-fw"></i>', 'class="align-righ btn btn-danger btn-circle" title="'.lang('title_delete_attributes').": {$attribute->name_attribute}\"");
				    echo anchor('dashboard/attribute_edit/'.encode_url($attribute->id_user_menu_attribute), '<i class="fa fa-pencil fa-fw"></i>', 'class="align-righ btn btn-warning btn-circle" title="'.lang('title_edit_attributes').": {$attribute->name_attribute}\"");
				    echo '</dd>';
				}
			    echo '</dl>';
			    
			    if($has_attribute > 0) {
				$buttons .= anchor('dashboard/attribute_add/'.encode_url($menu_default->id_user_menu), '<i class="fa fa-plus fa-fw"></i> '.lang('btn_add_attributes'), 'class="mr-lg btn btn-primary"');
			    }

			    $buttons .= anchor('dashboard/restore_config/'.encode_url($menu_default->id_user_menu), '<i class="fa fa-undo fa-fw"></i> '.lang('btn_restore_config'), 'class="btn btn-primary mr-lg"');
			} else {
			    if($has_attribute > 0) {
				echo '<p>Nenhuma configuração foi selecionada.</p>';
				$buttons .= anchor('dashboard/attribute_add/'.encode_url($menu_default->id_user_menu), '<i class="fa fa-plus fa-fw"></i> '.lang('btn_add_attributes'), 'class="btn btn-primary"');
			    }else{
				echo '<p><i class="fa fa-frown-o fa-3x"></i> Este menu não tem configurações disponíveis.</p>';
			    }
			}
			?>
			<div class="text-center">
			    <?php echo $buttons; ?>
			</div>
		    </div>
		    <!-- /.table-responsive -->
		</div>
		<!-- /.panel-body -->
	    </div>
	</div>
    <?php } ?>
    
</div>




