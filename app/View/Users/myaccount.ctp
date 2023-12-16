<div class="my_accnt">
	 <?php //echo $this->element('topbar'); 
	 	$this->Html->addCrumb('Profile');
	 ?>
	<div class="account_cntn">
        <div class="container">
            <div class="my_acc">
                <div class="col-lg-12">
					<?php echo $this->element('session_msg'); ?>
                    <div class="my-profile-boxes" id="myProfileTab">
                        <div class="my-profile-boxes-top">
                            <h2><i><?php echo $this->Html->image('front/home/profile-icon.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Profile', true);?></span></h2>
							<a href="javascript:;" class="editProfileLNK"><i class="fa fa-pencil"></i>Edit</a>
                        </div>
                        <div class="my-profile-boxes-mddel">
							<div class="my-profile-boxes-detail">
								<?php $info = Classregistry::init('User')->findById($this->Session->read('user_id'));?>  
								<div class="my-profile-img"><?php
									$path = UPLOAD_FULL_PROFILE_IMAGE_PATH . $info['User']['profile_image'];
									if (file_exists($path) && !empty($info['User']['profile_image'])) {
										?>

										<?php
										echo $this->Html->image(PHP_PATH . "timthumb.php?src=" . DISPLAY_FULL_PROFILE_IMAGE_PATH . $info['User']['profile_image'] . "&w=200&zc=1&q=100", array('escape' => false));

									} else {
										echo $this->Html->image('front/no_image_user.png');
									}
										?>
								</div>
								<div class="my-profile-names"><?php echo $userdetail['User']['first_name']; ?> <?php echo $userdetail['User']['last_name']; ?>
								<?php
								if(!empty($userdetail['User']['emp_verification_status'])){
									if(!empty($userdetail['User']['emp_verification_status']=='Verified') && ($userdetail['User']['total_exp'] > 0)){
										echo '<font style="color:green;"><b>(Verified)</b></font>';
									}
								}?>
								
								
								</div>
							</div>
                            <div class="users-informetion-detal con-left-bx"><i><?php echo $this->Html->image('front/home/phone-icon.png', array('alt' => '')); ?></i> <span><?php echo $userdetail['User']['contact']; ?></span></div>
                            <div class="users-informetion-detal con-left-bx" style="padding-left: 20px;"><i><?php echo $this->Html->image('front/home/massege-icon.png', array('alt' => '')); ?></i> <span><?php echo $userdetail['User']['email_address']; ?></span></div>
                            <div class="users-informetion-detal"><i><?php echo $this->Html->image('front/home/user-location-icon.png', array('alt' => '')); ?></i> <span><?php echo $userdetail['User']['location']; ?></span></div>


							<table class="table table-borderless user-info-tbl">
								<thead>
									<tr>
										<th width = 23%></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<tr>
									<th>Skills:</th>
									<td><?php echo $userdetail['User']['skills']; ?></td>
								</tr>
								<tr>
									<th>About Your Self:</th>
									<td><?php echo $userdetail['User']['company_about']; ?></td>
								</tr>
								<tr>
									<th>Experiance:</th>
									<td><?php 
											if($userdetail['User']['total_exp'] >0){
												echo $userdetail['User']['total_exp'] .' Years'; 
											}
											else if($userdetail['User']['total_exp'] === '0')
											{
												echo 'Fresher';
											}
										?>
									</td>
								</tr>
								<tr>
									<th>CV Document/Certificates:</th>
									<td>
										<?php 
											if ($showOldCVImages) { 
												foreach ($showOldCVImages as $showOldImage) {
													$img = $showOldImage['Certificate']['document'];
													if (!empty($img) && file_exists(UPLOAD_CERTIFICATE_PATH . $img)) {?>
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadImage', $img)); ?>" title="<?php echo strtoupper(substr($img,6));?>" class="profile-cvlist"><i class="fa fa-lg fa-file-image-o"></i><span> </span></a></span>
														<?php
													} 
												} 
											}
											if ($showOldCVImages || $showOldCVDocs) { 
												foreach ($showOldCVDocs as $showOldDoc) {
													$doc = $showOldDoc['Certificate']['document'];
													if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
														$docs_array = ['doc','docx'];
														$pdf = ['pdf'];
														if(in_array(pathinfo($doc, PATHINFO_EXTENSION),$pdf)){
													?>	
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc)); ?>" title="<?php echo strtoupper(substr($doc,6));?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-pdf-o" aria-hidden="true"></i><span> </span></a></span>
													<?php }else{?>  
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc)); ?>" title="<?php echo strtoupper(substr($doc,6));?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-text"></i><span> </span></a></span>
													<?php }
													} 
												} 
											}
											if ($showOldImages) { 
												foreach ($showOldImages as $showOldImage) {
													$img = $showOldImage['Certificate']['document'];
													if (!empty($img) && file_exists(UPLOAD_CERTIFICATE_PATH . $img)) {?>
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadImage', $img)); ?>" title="<?php echo strtoupper(substr($img,6));?>" class="profile-cvlist"><i class="fa fa-lg fa-file-image-o"></i><span> </span></a></span>
														<?php
													} 
												} 
											}
											if ($showOldImages || $showOldDocs) { 
												foreach ($showOldDocs as $showOldDoc) {
													$doc = $showOldDoc['Certificate']['document'];
													if (!empty($doc) && file_exists(UPLOAD_CERTIFICATE_PATH . $doc)) {
														$docs_array = ['doc','docx'];
														$pdf = ['pdf'];
														if(in_array(pathinfo($doc, PATHINFO_EXTENSION),$pdf)){
													?>	
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc)); ?>" title="<?php echo strtoupper(substr($doc,6));?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-pdf-o" aria-hidden="true"></i><span> </span></a></span>
													<?php }else{?>  
														<span><a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc)); ?>" title="<?php echo strtoupper(substr($doc,6));?>" class="profile-cvlist" target="_blank"><i class="fa fa-lg fa-file-text"></i><span> </span></a></span>
													<?php }
													} 
												} 
											}
										?>
									</td>
								</tr>
								</tbody>
							</table>
                        </div>
                    </div>
                    <?php echo $this->element('edit_profile'); ?>
					<?php
					if(!empty($userdetail['User']['emp_verification_status']) && ($userdetail['User']['total_exp'] > 0)){
						if(!empty($userdetail['User']['emp_verification_status']=='Pending')){?>
							<div class="my-profile-boxes" id="myEmpVerficationTab">
								<div class="my-profile-boxes-top my-education-boxes">
									 <h2><i><?php echo $this->Html->image('front/home/profile-icon.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Employment Verification', true);?></span></h2>
									<a href="javascript:;" class="editEmpVerficationLNK"><i class="fa fa-pencil"></i>Edit</a>
								</div>
                        
								
							</div>
							<?php
							echo $this->element('employee_verification');
						}
					}?>
                    
                    <div class="my-profile-boxes" id="myEducationTab">
                        <div class="my-profile-boxes-top my-education-boxes">
                            <h2><i><?php echo $this->Html->image('front/home/education-icon.png', array('alt' => '')); ?></i><span>Education</span></h2>
							<a href="javascript:;" class="editEducationLNK"><i class="fa fa-pencil"></i>Edit</a>
                        </div>
                        
                        <div class="my-profile-boxes-mddel information_cntn information_cntn_cv">
							<?php 
								if(!empty($educationDetails)){ 
									foreach($educationDetails as $educationDetail){?>
										<ul>
											<li><b><?php echo $educationDetail['Course']['name']; ?></b> 
												<ul class="ntydd">
													<li class="asdasd">
														<?php echo (!empty($educationDetail['Specialization']['name'])? '('.$educationDetail['Specialization']['name'].')':' '); ?>
													</li>  
													<li class="asdasd">
														<?php echo $educationDetail['Education']['basic_university']; ?>
													</li> 
													<li class="asdasd">
														Completion Year <?php echo $educationDetail['Education']['basic_year']; ?>
													</li>
												</ul>     
											</li>
										</ul>	
										<?php 
									} 
								}
								else
								{?>
                                    <ul class="condidet-skills">
                                        <li> No Record Found.</li>
                                    </ul>
                                <?php 
								}?>
							
                            
                        </div>
                    </div>
                    <?php echo $this->element('edit_education'); ?>
                    
                    <?php if($this->request->data['User']['total_exp'] != 0){ ?>
						<div class="my-profile-boxes" id="myExperienceTab">
							<div class="my-profile-boxes-top my-experience-boxes">
								<h2><i><?php echo $this->Html->image('front/home/experience-icon.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Experience', true);?></span></h2>
								<a href="javascript:;" class="editExperienceLNK"><i class="fa fa-pencil"></i>Edit</a>
								
							
							</div>
							<div class="my-profile-boxes-mddel information_cntn information_cntn_cv">
								<?php if(!empty($experienceDetails)){ 
									foreach($experienceDetails as $experienceDetail){
										$fromMonthNum  = $experienceDetail['Experience']['from_month'];
										if($experienceDetail['Experience']['current_company']=='1'){
											$toMonth  ='Present';
											$toYear  ='Present';
										}
										else
										{
											$toMonthNum  = $experienceDetail['Experience']['to_month'];
											$dateObj  = DateTime::createFromFormat('!m', $toMonthNum);
											$toMonth = $dateObj->format('F'); // March
											$toYear = $experienceDetail['Experience']['to_year'];
										}
										$dateObj  = DateTime::createFromFormat('!m', $fromMonthNum);
										$fromMonth = $dateObj->format('F'); // March
										?>
										<ul>
											<li><b><?php echo $experienceDetail['Experience']['company_name']; ?>, <?php echo $experienceDetail['Experience']['from_year']; ?> to <?php echo $toYear;?></b> 
												<ul class="ntydd">
													<li class="asdasd">
														<label>Designation : </label> <?php echo $experienceDetail['Experience']['designation']; ?>
													</li>  
													<li class="asdasd">
														<label>Industry : </label> <?php echo $experienceDetail['Experience']['industry']; ?>
													</li> 
													<li class="asdasd">
														<label>Job Profiles : </label> <?php echo $experienceDetail['Experience']['job_profile']; ?>
													</li>
												</ul>     
											</li>
										</ul>	
					
								<?php } }else{
									?>
										<ul class="condidet-skills">
											<li> No Record Found.</li>
										</ul>
									<?php }?>
							</div>
						</div>
						<?php echo $this->element('edit_experience'); ?>
					<?php } ?>
                    
                    <div class="account-servise-btn">
                        <?php echo $this->Html->link(''.__d('common', 'Delete Account', true), array('controller' => 'candidates', 'action' => 'deleteAccount'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?>
                    <?php echo $this->Html->link(''.__d('user','Change Password',true), array('controller' => 'candidates', 'action' => 'changePassword'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.asdasd label{
	display:contents !important;
	font-weight:bold;
}
</style>
<link href="<?php echo HTTP_PATH; ?>/css/front/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
<script type="text/javascript">
var settings_cv = {
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
                        $(".check_cv").after(html);
                    } else if (data.type == 'doc') {
                        $(".check_doc_cv").after(html);
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
       
$('.editProfileLNK').on('click', function (e) {
	$("#myProfileTab").hide();
	$("#editProfileTab").show();
	$("#UserSkills_chosen").css("width","100%");
	$("#UserInterestCategories_chosen").css("width","100%");
	 $("#mulitplefileuploader").uploadFile(settings);
	 $("#mulitplefileuploader_cv").uploadFile(settings_cv);
});
$('.closeProfileLNK').on('click', function (e) {
	$("#myProfileTab").show();
	$("#editProfileTab").hide();
	
});
$('.editEducationLNK').on('click', function (e) {
	$("#myEducationTab").hide();
	$("#editEducationTab").show();
	
});
$('.closeEducationLNK').on('click', function (e) {
	$("#myEducationTab").show();
	$("#editEducationTab").hide();
	
});

$('.editExperienceLNK').on('click', function (e) {
	$("#myExperienceTab").hide();
	$("#editExperienceTab").show();
	
});
$('.closeExperienceLNK').on('click', function (e) {
	$("#myExperienceTab").show();
	$("#editExperienceTab").hide();
	
});
$('.editEmpVerficationLNK').on('click', function (e) {
	$("#myEmpVerficationTab").hide();
	$("#editEmpVerficationTab").show();
	
	$('#emailDiv').show();
	$("#emailemployeeDiv").show();
	$("#otpemployeeDiv").hide();
	$("#radio_1").prop("checked", true);
	$('#documentDiv').hide();
	
	
});
$('.closeEmpVerficationLNK').on('click', function (e) {
	$("#myEmpVerficationTab").show();
	$("#editEmpVerficationTab").hide();
	$('#emailDiv').show();
	$("#emailemployeeDiv").show();
	$("#otpemployeeDiv").hide();
	$("#radio_1").prop("checked", true);
	$('#documentDiv').hide();
	
});

</script>

<script>
	

        $(document).on("click", ".delete_image , .close_icon_for", function () {

            var id = $(this).attr('alt');
            var id1 = id.replace('.', '-');
            $("#delete_" + id1).hide();
			var slug = $(this).attr('slug');
			$.ajax({
				type: 'POST',
				url: "<?php echo HTTP_PATH; ?>/candidates/deleteCertificacte/" + slug,
				cache: false,
				success: function (result) {

				}
			});
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