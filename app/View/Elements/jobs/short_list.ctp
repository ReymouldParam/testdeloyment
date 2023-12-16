<?php
if ($jobs) {
    $this->Paginator->_ajaxHelperClass = "Ajax";
    $this->Paginator->Ajax = $this->Ajax;
    $this->Paginator->options(array('update' => 'listID',
        'url' => array('controller' => 'jobs', 'action' => 'shortList', $separator),
        'indicator' => 'loaderID'));
    ?>
<div class="over_flow_auto_sigr">
    <div class="job_content" >
        <ul class="job_heading">
            <li><?php echo __d('user', 'Sr. No.', true);?></li>
            <li><?php echo __d('user', 'Job Title', true);?></li>
            <li><?php echo __d('user', 'Job Type', true);?></li>
            <li><?php echo __d('user', 'Last Date', true);?></li>
            <li><?php echo __d('user', 'Action', true);?></li>
        </ul>
        <?php
        $srNo = 1;
        foreach ($jobs as $job) {
            ?>
            <ul class="job_list">
                <li><?php echo $srNo++; ?></li>
                <li class="jobdi"><?php echo $job['Job']['title']; ?></li>
                <li>
                    <?php
                    if ($job['Job']['work_type'] == 1) {
                        echo __d('user', 'Full Time', true);
                    } else {
                        echo __d('user', 'Part Time', true);
                    }
                    ?>
                </li>
                <li><?php echo date('jS F,Y', $job['Job']['expire_time']); ?></li>
                <li><?php echo $this->Html->link(__d('user', 'Details', true), array('controller' => 'jobs', 'action' => 'detail', 'cat' => $job['Category']['slug'], 'slug' => $job['Job']['slug'], 'ext' => 'html'), array('class' => 'saved-details-btn','escape'=>false)); ?>
				<?php echo $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i> '.__d('user', 'Delete', true), array('controller' => 'jobs', 'action' => 'deleteShortList', $job['ShortList']['id']), array('class' => 'delete-trash-btn','escape'=>false,)); ?>
				<?php
				echo ' | ';
				if($job['Job']['user_id']!=$this->Session->read('user_id')){
					$apply_status = classregistry::init('JobApply')->find('first', array('conditions' => array('JobApply.user_id' => $this->Session->read('user_id'), 'JobApply.job_id' => $job['Job']['id'])));
					if (empty($apply_status)) {
						$isAbleToJob = classregistry::init('Plan')->checkPlanFeature($this->Session->read('user_id'), 4);
						if($isAbleToJob['status'] == 0) {
							echo $this->Html->link(__d('user', 'Upgrade Plan', true), array('controller' => 'plan', 'action' => 'purchase'), array('class' => 'Apply active', 'escape' => false, 'rel' => 'nofollow'));
						}
						else
						{
							echo '<a id="applybtn' . $job["Job"]["id"] . '" onclick="applyNow(' . $job["Job"]["id"] . ')" href="javascript:void(0);" class = "Apply active">' . __d('user', 'Apply Now', true) . '</a>';
						}
						
					} 
					else 
					{
						echo $this->Html->link(__d('user', 'Already Applied', true), 'javascript:void(0);', array('class' => 'Apply active'));
					}
				}
				?>
                </li>
				
            </ul>
            <?php
        }
        ?>
    </div>
</div>
    <div class="paging">
        <div class="noofproduct">
            <?php
            echo $this->Paginator->counter(
                    '<span>'.__d('user', 'No. of Records', true).' </span><span class="">{:start}</span><span> - </span><span class="">{:end}</span><span> '.__d('user', 'of', true).' </span><span class="">{:count}</span>'
            );
            ?> 
        </div>

        <div class="paginations">
            <?php //echo $this->Paginator->first('<i class="fa fa-arrow-circle-o-left"></i>', array('escape' => false,'rel'=>'nofollow', 'class' => 'first')); ?> 
            <?php if ($this->Paginator->hasPrev('ShortList')) echo $this->Paginator->prev(__d('home', 'Previous', true), array('class' => 'prev disabled', 'escape' => false,'rel'=>'nofollow')); ?> 
            <?php echo $this->Paginator->numbers(array('separator' => ' ', 'class' => 'badge-gray', 'escape' => false,'rel'=>'nofollow')); ?> 
            <?php if ($this->Paginator->hasNext('ShortList')) echo $this->Paginator->next(__d('home', 'Next', true), array('class' => 'next', 'escape' => false,'rel'=>'nofollow')); ?> 
            <?php //echo $this->Paginator->last('<i class="fa fa-arrow-circle-o-right"></i>', array('class' => 'last', 'escape' => false,'rel'=>'nofollow')); ?> 
        </div>	
    </div>
	<?php
	$userDetails = classregistry::init('User')->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id'))));
	?>
	
<div id="myApplyModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Apply Job</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'applyJobForm', 'class' => "form_trl_box_show2", 'name' => 'applyJobForm')); ?>
				<?php echo $this->Form->hidden('Job.id', array('value' =>""));?>
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'First Name', true); ?> <span class="star_red">*</span></label>
					<div class="form_input_education">
						<?php echo $this->Form->text('User.first_name', array('maxlength' => '20','value'=>$userDetails['User']['first_name'], 'label' => '', 'div' => false, 'class' => "form-control required validname", 'placeholder' => __d('user', 'First Name', true),'readonly'=>true)) ?>
					</div>
				</div>
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'Last Name', true); ?> <span class="star_red">*</span></label>
					<div class="form_input_education">
						<?php echo $this->Form->text('User.last_name', array('maxlength' => '20','value'=>$userDetails['User']['last_name'], 'label' => '', 'div' => false, 'class' => "form-control required validname", 'placeholder' => __d('user', 'Last Name', true),'readonly'=>true)) ?>
					</div>
				</div>
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'Email Address', true); ?> <span class="star_red">*</span></label>
					<div class="form_input_education">
						<?php echo $this->Form->text('User.email_address', array('class' => "required email form-control",'value'=>$userDetails['User']['email_address'], 'placeholder' => __d('user', 'Email Address', true))) ?>
					</div>
				</div>
				<div class="form_list_education">
				   <label class="lable-acc"><?php echo __d('user', 'Contact Number', true); ?> <span class="star_red">*</span></label>
					<div class="form_input_education"><?php echo $this->Form->text('User.contact', array('maxlength' => '10', 'minlength' => '10','value'=>$userDetails['User']['contact'], 'class' => "form-control required contact", 'placeholder' => __d('user', 'Contact Number', true))) ?>
						<label id="showerror1"></label>
					</div>
				</div>
				<?php 
					$showOldCVImages = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'image','is_cv' => 1)));
					$showOldCVDocs = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'doc','is_cv' => 1)));

					$showOldImages = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'image','is_cv' => 0)));
					$showOldDocs = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'doc','is_cv' => 0)));
				?>
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'CV Document', true); ?> <span class="star_red">*</span><span class="subcat_help_text"></span></label>
					<div class="form_input_education">
					<div id="mulitplefileuploaderApply_cv"><?php echo __d('user', 'Choose File', true); ?> 
					</div>
					<div class="supported-types"><p>- <?php echo __d('user', 'Supported File Types', true); ?>: pdf, doc and docx, gif, jpg, jpeg, png (Max. 4 MB).<br> - <?php echo __d('user', 'Min file size', true); ?> 150 X 150 <?php echo __d('user', 'pixels', true) . ' ' . __d('user', 'for image', true); ?></p></div>
					<input type="hidden" id="Applyimages" name="data[Certificate][document]" value="" >

					<div class="hmdnd no-margin-row">
						<label>&nbsp;</label>
						<?php
						$new_slug_arry = array();
						if ($showOldCVImages || $showOldCVDocs) {
							?>
							<div class="all-uploaded-images">
								<div class="check_doc_cv"> </div>
								<?php
								$d=0;
								foreach ($showOldCVDocs as $showOldDoc) {
									$doc = $showOldDoc['Certificate']['document'];
									if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
										$new_slug_arry [] = $showOldDoc['Certificate']['document'];
										$radioChecked = '';
										if($d==0){
											$radioChecked = 'checked';
										}
										?>
										<div id="<?php echo $showOldDoc['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
											<div class="doc_files_border">
												<input type="radio" name="chooseCv" value="<?php echo $doc;?>" <?php echo $radioChecked;?> required>
												<span class="temp-image-section">
												
													<?php echo $this->Html->link(substr($doc, 6), array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc), array('class' => 'dfasggs', 'target' => '_blank')); ?>    
													
												</span>

											</div>
										</div>
										<?php
										$d++;
									}
									
								}
								?>

								<div class="check_cv"> </div>

								<?php
								$im=0;
								foreach ($showOldCVImages as $showOldImage) {
									$image = $showOldImage['Certificate']['document'];
									if (!empty($image) && file_exists(UPLOAD_CERTIFICATE_PATH . $image)) {
										$new_slug_arry [] = $showOldImage['Certificate']['document'];
										$radioChecked1 = '';
										if($im==0 && $d==0){
											$radioChecked1 = 'checked';
										}
										?>
										<div id="<?php echo $showOldImage['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
											<input type="radio" name="chooseCv" value="<?php echo $image;?>" <?php echo $radioChecked1;?> required>
												<span class="temp-image-section">
													<a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadImage', $image)); ?>" class="dfasggs" target="_blank"><?php echo $image;?></a>
													
													
												</span>
										</div>
										<?php
										$im++;
									}
									
								}
								?>
							</div>
					<?php
						} 
						else 
						{
							?>
						<div class="all-uploaded-images">
								<div class="check_doc_cv"> </div>
								<div class="check_cv"> </div>
						</div>
						<?php
						}
						echo $this->Form->hidden('Certificate.images', array('id' => 'images1', 'value' => implode(',', $new_slug_arry)));
						?>
					</div>
				</div>
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'Certificates', true); ?> <span class="star_red"></span><span class="subcat_help_text"></span></label>
					<div class="form_input_education">
					<div id="mulitplefileuploaderApply"><?php echo __d('user', 'Choose File', true); ?> 
					</div>
					<div class="supported-types"><p>- <?php echo __d('user', 'Supported File Types', true); ?>: pdf, doc and docx, gif, jpg, jpeg, png (Max. 4 MB).<br> - <?php echo __d('user', 'Min file size', true); ?> 150 X 150 <?php echo __d('user', 'pixels', true) . ' ' . __d('user', 'for image', true); ?></p></div>
					<input type="hidden" id="Applyimages" name="data[Certificate][document]" value="" >

					<div class="hmdnd no-margin-row">
						<label>&nbsp;</label>
						<?php
						$new_slug_arry = array();
						if ($showOldImages || $showOldDocs) {
							?>
							<div class="all-uploaded-images">
								<div class="check_doc"> </div>
								<?php
								$d=0;
								foreach ($showOldDocs as $showOldDoc) {
									$doc = $showOldDoc['Certificate']['document'];
									if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
										$new_slug_arry [] = $showOldDoc['Certificate']['document'];
										$radioChecked = '';
										if($d==0){
											$radioChecked = 'checked';
										}
										?>
										<div id="<?php echo $showOldDoc['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
											<div class="doc_files_border">
												<span class="temp-image-section">
												
													<?php echo $this->Html->link(substr($doc, 6), array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc), array('class' => 'dfasggs', 'target' => '_blank')); ?>    
													
												</span>

											</div>
										</div>
										<?php
										$d++;
									}
									
								}
								?>

								<div class="check"> </div>

								<?php
								$im=0;
								foreach ($showOldImages as $showOldImage) {
									$image = $showOldImage['Certificate']['document'];
									if (!empty($image) && file_exists(UPLOAD_CERTIFICATE_PATH . $image)) {
										$new_slug_arry [] = $showOldImage['Certificate']['document'];
										$radioChecked1 = '';
										if($im==0 && $d==0){
											$radioChecked1 = 'checked';
										}
										?>
										<div id="<?php echo $showOldImage['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
												<span class="temp-image-section">
													<a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadImage', $image)); ?>" class="dfasggs" target="_blank"><?php echo $image;?></a>
													
													
												</span>
										</div>
										<?php
										$im++;
									}
									
								}
								?>
							</div>
					<?php
						} 
						else 
						{
							?>
						<div class="all-uploaded-images">
								<div class="check_doc"> </div>
								<div class="check"> </div>
						</div>
						<?php
						}
						echo $this->Form->hidden('Certificate.images', array('id' => 'images1', 'value' => implode(',', $new_slug_arry)));
						?>
					</div>
				</div>
			</div>
			<?php echo $this->Form->submit(__d('user', 'Apply Job', true), array('div' => false, 'label' => false, 'class' => 'input_btn')); ?>
				</form>
			</div>
		</div>
	</div>
</div>



<?php }else { ?>
    <div class="no_found"><?php echo __d('user', 'No record found.', true);?></div>
<?php } ?>
<link href="<?php echo HTTP_PATH; ?>/css/front/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
<link href='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.min.css' rel='stylesheet'>
<script src='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.all.min.js'></script> 
<script type="text/javascript">
var settingsApply_cv = {
            url: "<?php echo HTTP_PATH . "/candidates/uploadmultipleimages" ?>",
            method: "POST",
            dragDropStr: "<span><b></b></span>",
            allowedTypes: "jpg,png,gif,jpeg,doc,docx,pdf",
            fileName: "data[Certificate][cv]",
            multiple: true,
            maxFileSize: 1049 * 1000 * 4,
            // maxFileCount:<?php //echo UPLOAD_MAX_IMAGE;                                                             ?>,
            onSelect: function (response, data_re)
            {
                var input = $("#Applyimages");
                if (input.val())
                    var array = input.val().split(",");
                else
                    var array = [];
            },
            onSuccess: function (response, data_re, xhr)
            {
                var status = $("#status");
                status.html('');
                var data = $.parseJSON(data_re);
                if (data.status == 'success') {

                    var counter = 0;

                    var html = '';
                    var image_arr = [];

                    var input = $("#Applyimages");
                    if (input.val())
                        var array = input.val().split(",");
                    else
                        var array = [];

                    var image = '<?php echo DISPLAY_CERTIFICATE_PATH; ?>' + data.image;
                    var imagename = data.image;
                    var id1 = imagename.replace('.', '-');
                    if (data.type == 'image') {
						 html += "<div id='" + data.slug + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";
                        
                    } else if (data.type == 'doc') {
                       html += "<div id='" + data.slug + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";						
                       
                    }

                    array.push(data.image);

                    $("#Applyimages").val();

                    input.val(array);
                    if (data.type == 'image') {
                        $(".check_cv").after(html);
                    } else if (data.type == 'doc') {
                        $(".check_doc_cv").after(html);
                    }
                } else {
                    alert(data.message);
                }
            }
            ,
            afterUploadAll: function ()
            {
                $(".upload-statusbar").remove();
            },
            onError: function (files, status, errMsg)
            {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
var settingsApply = {
            url: "<?php echo HTTP_PATH . "/candidates/uploadmultipleimages" ?>",
            method: "POST",
            dragDropStr: "<span><b></b></span>",
            allowedTypes: "jpg,png,gif,jpeg,doc,docx,pdf",
            fileName: "data[Certificate][document]",
            multiple: true,
            maxFileSize: 1049 * 1000 * 4,
            // maxFileCount:<?php //echo UPLOAD_MAX_IMAGE;                                                             ?>,
            onSelect: function (response, data_re)
            {
                var input = $("#Applyimages");
                if (input.val())
                    var array = input.val().split(",");
                else
                    var array = [];
            },
            onSuccess: function (response, data_re, xhr)
            {
                var status = $("#status");
                status.html('');
                var data = $.parseJSON(data_re);
                if (data.status == 'success') {

                    var counter = 0;

                    var html = '';
                    var image_arr = [];

                    var input = $("#Applyimages");
                    if (input.val())
                        var array = input.val().split(",");
                    else
                        var array = [];

                    var image = '<?php echo DISPLAY_CERTIFICATE_PATH; ?>' + data.image;
                    var imagename = data.image;
                    var id1 = imagename.replace('.', '-');
                    if (data.type == 'image') {
						 html += "<div id='" + data.slug + "' class='doc_fukll_name'><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";
                        
                    } else if (data.type == 'doc') {
                       html += "<div id='" + data.slug + "' class='doc_fukll_name'><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";						
                       
                    }

                    array.push(data.image);

                    $("#Applyimages").val();

                    input.val(array);
                    if (data.type == 'image') {
                        $(".check").after(html);
                    } else if (data.type == 'doc') {
                        $(".check_doc").after(html);
                    }
                    //$(".loading-image").hide();

                } else {
                    alert(data.message);
                    //$(".loading-image").hide();
                }
            }
            ,
            afterUploadAll: function ()
            {
                $(".upload-statusbar").remove();
            },
            onError: function (files, status, errMsg)
            {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
    
function applyNow(id) {
		Swal.fire({
			title: 'Confirmation',
			html: 'Are you sure you want to apply this job',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Done'
		}).then((result) => {
			if (result.value) {
				$('.header').css({'z-index':'0'});
				$('#myApplyModal').modal('show');
				$("#JobId").val(id);
			}
			
		})
	}
	$( "#myApplyModal" ).on('hidden.bs.modal', function(){
		$('.header').css({'z-index':'9999'});
		$('.ajax-upload-dragdrop').remove();
	});
	
	$('#myApplyModal').on('shown.bs.modal', function (e) {
		$("#mulitplefileuploaderApply").uploadFile(settingsApply);
		$("#mulitplefileuploaderApply_cv").uploadFile(settingsApply_cv);
	})
	
	$('#applyJobForm').on('submit', function(e){
        e.preventDefault();
		var jobUniqueId = $("#JobId").val();
		var dataString = $("#applyJobForm").serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/ajaxApplyJob" ?>",
			data: dataString,
			dataType: "json",
			success: function(response)
			{
				if(response.status=='error'){
					Swal.fire({
						title: "Error!",
						html: response.message,
						allowOutsideClick: true
						
					})
					
					return false;
				}
				else
				{
					Swal.fire({
						title: 'Success',
						html: response.message,
						allowOutsideClick: false
		
					}).then((result) => {
						//location.reload();
						$("#applybtn"+jobUniqueId).text('Already Applied');
						//$(".Apply").text('Already Applied');
						$('#myApplyModal').modal('hide');
					})
					
				}
			}
		});
    });
	
</script>