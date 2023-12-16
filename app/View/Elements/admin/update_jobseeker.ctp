<?php
	 $adminLId = $this->Session->read('adminid');
	 $checkSubRols = ClassRegistry::init('Admin')->getAdminRolesSub($this->Session->read('adminid'));
?>

<td data-title=""><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $user['User']['id']; ?>" /></td>
<td data-title="Full Name"><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></td>
<td data-title="Email"><?php echo $user['User']['email_address']; ?></td>
<td data-title="Email"><?php echo $user['User']['contact'] ? $this->Text->usformat($user['User']['contact']) : 'N/A'; ?></td>
<td data-title="Email"><?php echo $user['User']['emp_verification_status']; ?></td>
<td data-title="Email">
	<?php

	$doc = $user['User']['verification_document'];
	if (!empty($doc) && file_exists(UPLOAD_EMPLOYEE_VERIFICATION_PATH . $doc)) {
		$image_extensions =  ["jpg", "jpeg", "png", "gif"];
		$docs_array = ['doc', 'docx'];
		$pdf = ['pdf'];
		if (in_array(pathinfo($doc, PATHINFO_EXTENSION), $pdf)) {
	?>
			<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadVerificationDocument', $doc)); ?>" title="<?php echo strtoupper(substr($doc, 6)); ?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-pdf-o" aria-hidden="true"></i><span> </span></a></span>
		<?php
		} else if (in_array(pathinfo($doc, PATHINFO_EXTENSION), $docs_array)) {
		?>
			<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadVerificationDocument', $doc)); ?>" title="<?php echo strtoupper(substr($doc, 6)); ?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-text"></i><span> </span></a></span>
		<?php
		} else if (in_array(pathinfo($doc, PATHINFO_EXTENSION), $image_extensions)) {
		?>
			<a href="<?php echo DISPLAY_EMPLOYEE_VERIFICATION_PATH . $doc; ?>" title="<?php echo strtoupper(substr($doc, 6)); ?>" target="_blank">
				<i class="fa fa-lg fa-file-image-o"></i><span> </span>
			</a>
	<?php }
	}
	?>
</td>
<td data-title="Email">
	<?php
		echo $user['User']['verification_source'];
	?>
</td>
<td data-title="Email">
	<?php
	if ($user['User']['emp_verification_status'] == 'Verified') {
		echo $user['User']['verification_date'];
	}
	?>
</td>
<td data-title="Email"><?php echo $user['User']['location'] ? $user['User']['location'] : 'N/A'; ?></td>
<td data-title="Created"><?php echo date('M d,Y', strtotime($user['User']['created'])); ?></td>

<td data-title="Action">
	<?php if (ClassRegistry::init('Admin')->getCheckRolesSub($adminLId, $checkSubRols, 2, 2)) { ?>
		<div id="loaderIDAct<?php echo $user['User']['id']; ?>" style="display:none;position:absolute;margin:0px 0 0 4px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
		<span id="status<?php echo $user['User']['id']; ?>">
			<?php
			if ($user['User']['status'] == '1' && $user['User']['activation_status'] == '1') {
				echo $this->Ajax->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'candidates', 'action' => 'deactivateuser', $user['User']['slug']), array('update' => 'status' . $user['User']['id'], 'indicator' => 'loaderIDAct' . $user['User']['id'], 'confirm' => 'Are you sure you want to Deactivate ?', 'escape' => false, 'title' => 'Deactivate'));
			} else {
				echo $this->Ajax->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', array('controller' => 'candidates', 'action' => 'activateuser', $user['User']['slug']), array('update' => 'status' . $user['User']['id'], 'indicator' => 'loaderIDAct' . $user['User']['id'], 'confirm' => 'Are you sure you want to Activate ?', 'escape' => false, 'title' => 'Activate'));
			}
			?>
		</span>

	<?php
		echo $this->Html->link('<i class="fa fa-pencil"></i>', array("controller" => "candidates", "action" => 'editcandidates', $user['User']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Edit'));
	}
	if (ClassRegistry::init('Admin')->getCheckRolesSub($adminLId, $checkSubRols, 2, 3)) {
		echo $this->Html->link('<i class="fa fa-trash-o "></i>', array('controller' => 'candidates', 'action' => 'deletecandidates', $user['User']['slug']), array('update' => 'deleted' . $user['User']['id'], 'indicator' => 'loaderID', 'class' => 'btn btn-primary btn-xs', 'confirm' => 'Are you sure you want to Delete ?', 'escape' => false, 'title' => 'Delete'));
	}
	?>

	<a href="#info<?php echo $user['User']['id']; ?>" rel="facebox" title="View" class="btn btn-info btn-xs"><i class="fa fa-eye "></i></a>
	<div id="loaderIDEmail<?php echo $user['User']['id']; ?>" style="display:none;position:absolute;margin:-30px -1px 0px 124px;z-index: 9999;"><?php echo $this->Html->image("loading.gif"); ?></div>
	<?php echo $this->Html->link('<i class="fa fa-file"></i>', array("controller" => "candidates", "action" => 'certificates', $user['User']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Manage Certificates')); ?>
	<?php echo $this->Html->link('<i class="fa fa-adn"></i>', array("controller" => "jobs", "action" => 'applied', $user['User']['slug']), array('escape' => false, 'class' => "btn btn-warning btn-xs", 'title' => 'Applied Job List')); ?>

	<?php
	if ($user['User']['emp_verification_status'] != 'Verified') {

		echo $this->Ajax->link('<button class="btn btn-info btn-xs"><i class="fa fa-check"></i></button>', array('controller' => 'candidates', 'action' => 'verifyuser', $user['User']['slug']), array('update' => 'varificationstatus' . $user['User']['id'], 'indicator' => 'loaderIDAct' . $user['User']['id'], 'confirm' => 'Are you sure you want to Verify this user?', 'escape' => false, 'title' => 'Verify'));
	}
	?>
</td>