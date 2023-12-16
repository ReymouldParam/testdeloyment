<?php echo $this->Html->css('front/sample.css'); ?>
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
    $(function () {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    });

	function displayCompany(experience){
        var selectedExperience = experience.value;
        if(selectedExperience > 0 ){
            $("#ccname").show();
        }
        else{
            $("#ccname").hide();
        }
    }
</script>
<div class="my_accnt">
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
				<?php echo $this->element('left_sidebar'); ?>
				<div class="col-sm-9 col-lg-9 col-xs-12">
					
					<div id="myModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Basic Profile Information</h5>
								   
								</div>
								<div class="modal-body">
									<?php echo $this->element('session_msg'); ?>
									<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'basicProfile', 'class' => "form_trl_box_show2", 'name' => 'basicProfile')); ?>
										
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'First Name', true); ?> <span class="star_red">*</span></label>
											<div class="form_input_education">
												<?php echo $this->Form->text('User.first_name', array('maxlength' => '20', 'label' => '', 'div' => false, 'class' => "form-control required validname", 'placeholder' => __d('user', 'First Name', true))) ?>
											</div>
										</div>
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Last Name', true); ?> <span class="star_red">*</span></label>
											<div class="form_input_education">
												<?php echo $this->Form->text('User.last_name', array('maxlength' => '20', 'label' => '', 'div' => false, 'class' => "form-control required validname", 'placeholder' => __d('user', 'Last Name', true))) ?>
											</div>
										</div>
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Email Address', true); ?> <span class="star_red">*</span></label>
											<div class="form_input_education">
												<?php echo $this->Form->text('User.email_address', array('class' => "required email form-control", 'placeholder' => __d('user', 'Email Address', true),'readonly'=>true)) ?>
											</div>
										</div>
										
										
										<div class="form_list_education">
										   <label class="lable-acc"><?php echo __d('user', 'Contact Number', true); ?> <span class="star_red">*</span></label>
											<div class="form_input_education"><?php echo $this->Form->text('User.contact', array('maxlength' => '10', 'minlength' => '10', 'class' => "form-control required contact", 'placeholder' => __d('user', 'Contact Number', true))) ?>
												<label id="showerror1"></label>
											</div>
										</div>

										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Total Work Experience', true); ?></label>
											<div id="locDiv" class="form_input_education qualification-select">
												<?php 	global $totalexperienceArray;
												echo $this->Form->select('User.total_exp', $totalexperienceArray, array('empty' => __d('user', 'Select Total Experience', true), 'class' => "form-control",'onchange' => 'displayCompany(this);'));  ?>
												<label id="totalexp"></label>
											</div>
										</div>

										<?php
											$display = 'none';
											if($this->request->data['User']['total_exp'] > 0){
												$display = 'block';
											}
										?>

										<div class="form_list_education" id="ccname" style="display:<?= $display ?>">
										   <label class="lable-acc"><?php echo __d('user', 'Company Name', true); ?> <span class="star_red">*</span></label>
											<div class="form_input_education"><?php echo $this->Form->text('User.company_name', array('class' => "form-control required", 'placeholder' => __d('user', 'Company Name', true))) ?>
												<label id="showerror1"></label>
											</div>
										</div>
										
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Skills', true); ?> </label>
											<div id="cust_skl" class="form_input_education rel_Skills">
												<?php echo $this->Form->select('User.skills', $skillList, array('multiple' => true, 'data-placeholder' => __d('user', 'Choose Skills', true), 'class' => "chosen-select required")); ?>
												<label id="skillss1"></label>
											</div>
										</div>
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'CV Document', true); ?> <span class="star_red">*</span><span class="subcat_help_text"></span></label>
											<div class="form_input_education">
												<div id="mulitplefileuploader_cv"><?php echo __d('user', 'Choose File', true); ?> 
												</div>
												<div class="supported-types"><p>- <?php echo __d('user', 'Supported File Types', true); ?>: pdf, doc and docx, gif, jpg, jpeg, png (Max. 4 MB).<br> - <?php echo __d('user', 'Min file size', true); ?> 150 X 150 <?php echo __d('user', 'pixels', true) . ' ' . __d('user', 'for image', true); ?></p></div>
												<input type="hidden" id="images" name="data[Certificate][document]" value="" >

												<div class="hmdnd no-margin-row">
													<label>&nbsp;</label>
													<?php
													$new_slug_arry = array();
													if ($showOldCVImages || $showOldCVDocs) {
														?>
														<div class="all-uploaded-images">
															<div class="check_doc_cv"> </div>
															<?php
															foreach ($showOldCVDocs as $showOldDoc) {
																$doc = $showOldDoc['Certificate']['document'];
																if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
																	$new_slug_arry [] = $showOldDoc['Certificate']['document'];
																	?>
																	<div id="<?php echo $showOldDoc['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
																		<div class="doc_files_border">
																			<span class="temp-image-section">
																				<?php echo $this->Html->link(substr($doc, 6), array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc), array('class' => 'dfasggs', 'rel' => 'nofollow')); ?>    
																				<span class="close_icon_for" alt="<?php echo $showOldDoc['Certificate']['document']; ?>"  onclick="deleteOldImage('<?php echo $showOldDoc['Certificate']['slug']; ?>')">
																					X
																				</span>
																			</span>

																		</div>
																	</div>
																	<?php
																}
															}
															?>

															<div class="check_cv"> </div>

															<?php
															foreach ($showOldCVImages as $showOldImage) {
																$image = $showOldImage['Certificate']['document'];
																if (!empty($image) && file_exists(UPLOAD_CERTIFICATE_PATH . $image)) {
																	$new_slug_arry [] = $showOldImage['Certificate']['document'];
																	?>
																	<div id="<?php echo $showOldImage['Certificate']['slug']; ?>" alt="" class="image_thumb">
																		<span class="temp-image-section">
																			<img src="<?php echo DISPLAY_CERTIFICATE_PATH . $image; ?>">
											 							</span>
																		<span class="delete_image" alt="<?php echo $showOldImage['Certificate']['document']; ?>" onclick="deleteOldImage('<?php echo $showOldImage['Certificate']['slug']; ?>')">
																			X
																		</span>
																	</div>
																	<?php
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
										</div>
										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Certificates', true); ?> <span class="subcat_help_text"></span></label>
											<div class="form_input_education">
												<div id="mulitplefileuploader"><?php echo __d('user', 'Choose File', true); ?> 
												</div>
												<div class="supported-types"><p>- <?php echo __d('user', 'Supported File Types', true); ?>: pdf, doc and docx, gif, jpg, jpeg, png (Max. 4 MB).<br> - <?php echo __d('user', 'Min file size', true); ?> 150 X 150 <?php echo __d('user', 'pixels', true) . ' ' . __d('user', 'for image', true); ?></p></div>
												<input type="hidden" id="images" name="data[Certificate][document]" value="" >

												<div class="hmdnd no-margin-row">
													<label>&nbsp;</label>
													<?php
													$new_slug_arry = array();
													if ($showOldCertificateImages || $showOldDocs) {
														?>
														<div class="all-uploaded-images">
															<div class="check_doc"> </div>
															<?php
															foreach ($showOldDocs as $showOldDoc) {
																$doc = $showOldDoc['Certificate']['document'];
																if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
																	$new_slug_arry [] = $showOldDoc['Certificate']['document'];
																	?>
																	<div id="<?php echo $showOldDoc['Certificate']['slug']; ?>" alt="" class="doc_fukll_name">
																		<div class="doc_files_border">
																			<span class="temp-image-section">
																				<?php echo $this->Html->link(substr($doc, 6), array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc), array('class' => 'dfasggs', 'rel' => 'nofollow')); ?>    
																				<span class="close_icon_for" alt="<?php echo $showOldDoc['Certificate']['document']; ?>"  onclick="deleteOldImage('<?php echo $showOldDoc['Certificate']['slug']; ?>')">
																					X
																				</span>
																			</span>

																		</div>
																	</div>
																	<?php
																}
															}
															?>

															<div class="check"> </div>

															<?php
															foreach ($showOldCertificateImages as $showOldImage) {
																$image = $showOldImage['Certificate']['document'];
																if (!empty($image) && file_exists(UPLOAD_CERTIFICATE_PATH . $image)) {
																	$new_slug_arry [] = $showOldImage['Certificate']['document'];
																	?>
																	<div id="<?php echo $showOldImage['Certificate']['slug']; ?>" alt="" class="image_thumb">
																		<span class="temp-image-section">
																			<img src="<?php echo DISPLAY_CERTIFICATE_PATH . $image; ?>">
											 							</span>
																		<span class="delete_image" alt="<?php echo $showOldImage['Certificate']['document']; ?>" onclick="deleteOldImage('<?php echo $showOldImage['Certificate']['slug']; ?>')">
																			X
																		</span>
																	</div>
																	<?php
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
										<?php echo $this->Form->submit(__d('user', 'Update', true), array('div' => false, 'label' => false, 'class' => 'input_btn')); ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
.header {
z-index:0 !important;
}
#UserSkills_chosen{
		width:100% !important;
}
.modal-header{
	background: var(--card-background) !important;
}
</style>
<link href="<?php echo HTTP_PATH; ?>/css/front/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
<?php echo $this->Html->script('jquery.validate.js'); ?>
<script type="text/javascript">
var settings = {
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
                var input = $("#images");
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

                    var input = $("#images");
                    if (input.val())
                        var array = input.val().split(",");
                    else
                        var array = [];

                    var image = '<?php echo DISPLAY_CERTIFICATE_PATH; ?>' + data.image;
                    var imagename = data.image;
                    var id1 = imagename.replace('.', '-');
                    if (data.type == 'image') {
                        html += "<div class='image_thumb' alt='" + imagename + "' id='delete_" + id1 + "'> <span class='temp-image-section'><img  src='<?php echo DISPLAY_CERTIFICATE_PATH ?>" + data.image + "'/></span><span class='delete_image' alt='" + data.image + "' slug='" + data.slug + "'>X </span></div>";
                    } else if (data.type == 'doc') {
                        //html += "<div class='doc_fukll_name'  alt='" + imagename + "' id='delete_" + id1 + "'><div class='doc_files_border'><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificateTemp/"+ data.image +"' class='dfasggs' >"+imagename.substring(6)+"</a><span class='close_icon_for' alt='" + data.image + "'>X </span></span></div></div>";  
                        html += "<div class='doc_fukll_name'  alt='" + imagename + "' id='delete_" + id1 + "'><div class='doc_files_border'><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/" + data.image + "' class='dfasggs' >" + imagename.substring(6) + "</a><span class='close_icon_for' alt='" + data.image + "' slug='" + data.slug + "'>X </span></span></div></div>";
                    }

                    array.push(data.image);

                    $("#images").val();

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
var settings_cv = {
            url: "<?php echo HTTP_PATH . "/candidates/uploadmultipleimages" ?>",
            method: "POST",
            dragDropStr: "<span><b></b></span>",
            allowedTypes: "jpg,png,gif,jpeg,doc,docx,pdf",
            fileName: "data[Certificate][cv]",
            multiple: true,
            maxFileSize: 1049 * 1000 * 4,
            onSelect: function (response, data_re)
            {
                var input = $("#images");
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
                    var input = $("#images");
                    if (input.val())
                        var array = input.val().split(",");
                    else
                        var array = [];

                    var image = '<?php echo DISPLAY_CERTIFICATE_PATH; ?>' + data.image;
                    var imagename = data.image;
                    var id1 = imagename.replace('.', '-');
                    if (data.type == 'image') {
                        html += "<div class='image_thumb' alt='" + imagename + "' id='delete_" + id1 + "'> <span class='temp-image-section'><img  src='<?php echo DISPLAY_CERTIFICATE_PATH ?>" + data.image + "'/></span><span class='delete_image' alt='" + data.image + "' slug='" + data.slug + "'>X </span></div>";
                    } else if (data.type == 'doc') {
                        html += "<div class='doc_fukll_name'  alt='" + imagename + "' id='delete_" + id1 + "'><div class='doc_files_border'><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/" + data.image + "' class='dfasggs' >" + imagename.substring(6) + "</a><span class='close_icon_for' alt='" + data.image + "' slug='" + data.slug + "'>X </span></span></div></div>";
                    }

                    array.push(data.image);

                    $("#images").val();

                    input.val(array);
                    if (data.type == 'image') {
                        $(".check_cv").after(html);
                    } else if (data.type == 'doc') {
                        $(".check_doc_cv").after(html);
                    }
                } else {
                    alert(data.message);
                }
            },
            afterUploadAll: function ()
            {
                $(".upload-statusbar").remove();
            },
            onError: function (files, status, errMsg)
            {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }


    $(document).ready(function(){
		
        $('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		})
		
		$('#myModal').on('shown.bs.modal', function (e) {
		  $("#mulitplefileuploader").uploadFile(settings);
		  $("#mulitplefileuploader_cv").uploadFile(settings_cv);
		  
		})
    });
	$("#basicProfile").validate();
	function deleteOldImage(slug) {
        $('#' + slug).hide();
        $.ajax({
            type: 'POST',
            url: "<?php echo HTTP_PATH; ?>/candidates/deleteCertificacte/" + slug,
            cache: false,
            success: function (result) {

            }
        });
    }
	$(document).on("click", ".delete_image , .close_icon_for", function () {

            var id = $(this).attr('alt');
            var id1 = id.replace('.', '-');
			var slug = $(this).attr('slug');
			$.ajax({
				type: 'POST',
				url: "<?php echo HTTP_PATH; ?>/candidates/deleteCertificacte/" + slug,
				cache: false,
				success: function (result) {

				}
			});
            $("#delete_" + id1).hide();
            var $input = $("#images");
			
            var arrayOld = $input.val().split(",");
            arrayNew = $.grep(arrayOld, function (image_names, i) {
                //var substr = image_names.split('_');
                //return substr[0] !== id;
                return image_names !== id;
            });
            $input.val(arrayNew);
            $input.val(arrayNew);
            var $input1 = $("#images1");
            var arrayOld = $input1.val().split(",");
            arrayNew = $.grep(arrayOld, function (image_names, i) {
                //var substr = image_names.split('_');
                //return substr[0] !== id;
                return image_names !== id;
            });
            $input1.val(arrayNew);
			
        })
</script>
