<?php
// Load Menu
//$this->template->menu('users');
$this->javascript = ['js/dataTables.bootstrap.min.js', 'js/jquery.dataTables.min.js'];
$this->javascript_inline = '$(document).ready(function() {
    $(#"dataTables-example").DataTable({
	    responsive: true
    });
});';
?>
    <?php if(isset($users)) { ?>
    <table class="table table-striped table-bordered table-hover" id="dataTables-user">
        <thead>
	    <tr>
		<th>ID</th>
		<th>Name</th>
		<th>E-mail</th>
		<th>Level</th>
		<th>Date Created</th>
		<th>Actions</th>
	    </tr>
	</thead>
	<tbody>
    <?php foreach ($users as $user) { ?>
	    <tr>
		<td><?php echo $user->id_user; ?></td>
		<td><?php echo $user->name_user; ?></td>
		<td><?php echo $user->email; ?></td>
		<td><?php echo $level_list[$user->level]; ?></td>
		<td><?php echo date("d/m/Y h:i:s", strtotime($user->date_created)); ?></td>
		<td class="text-center">
		    <?php echo anchor('user/edit/'.$user->id_user, '<i class="fa fa-pencil "></i>', 'class="btn btn-warning btn-circle"'); ?>
		    <?php echo anchor('user/remove/'.$user->id_user, '<i class="fa fa-trash-o"></i>', 'class="btn btn-danger btn-circle"'); ?>
		</td>
	    </tr>
    <?php } ?>
	</tbody>
	
    </table>
    <?php } ?>
