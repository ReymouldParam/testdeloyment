<?php
$_SESSION['job_apply_return_url'] = $this->params->url;
?>
<style>
    .det_imv ul, .det_imv ol{
        padding-left: 20px !important;
    }
    .det_imv ul li {
        list-style-type: circle;
    }


    .det_imv ol li {
        list-style-type:decimal;
    }
</style>
<?php echo $this->Html->script('facebox.js'); ?>
<?php echo $this->Html->css('facebox.css'); ?>
<script type="text/javascript">
    $(document).ready(function ($) {
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: '<?php echo HTTP_IMAGE ?>/loading.gif',
            closeImage: '<?php echo HTTP_IMAGE ?>/close.png'
        })
    })

//    $(document).ready(function () {
//        $(".compDetail").hide();
//        $("#compTitle").click(function () {
//            $(".compDetail").toggle('slow');
//        });
//    });

</script>
<script>
    function jobApplyConfitm() {
        swal({
            title: "<?php echo __d('user', 'Are you sure', true); ?>?",
            text: "<?php echo __d('user', 'You want to share your resume and other account details with this employer', true); ?> ?",
            type: "success",
            showCancelButton: true,
            confirmButtonColor: "#fccd13",
            confirmButtonText: "Confirm",
            closeOnConfirm: false
        },
                function () {
                    window.location.href = "<?php echo HTTP_PATH; ?>/jobs/jobApply/<?php echo $jobdetails['Job']['slug']; ?>";
                                    });
                        }
</script>    
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<?php ClassRegistry::init('Job')->updateJobView($jobdetails['Job']['id']); ?>
<?php
$image_path = HTTP_PATH.'/app/webroot/img/front/no_image_user.png';
if ($jobdetails['Job']['job_logo_check']) {
    $logo_image = ClassRegistry::init('User')->field('profile_image', array('User.id' => $jobdetails['Job']['user_id']));
    $path = UPLOAD_FULL_PROFILE_IMAGE_PATH . $logo_image;
    if (file_exists($path) && !empty($logo_image)) {
        $image_path = DISPLAY_THUMB_PROFILE_IMAGE_PATH . $logo_image;
    }
} else {
    $path = UPLOAD_JOB_LOGO_PATH . $jobdetails['Job']['logo'];
    if (file_exists($path) && !empty($jobdetails['Job']['logo'])) {
        $image_path = DISPLAY_JOB_LOGO_PATH . $jobdetails['Job']['logo'];
    }
}

if($refer_url == '/jobs/savedjob'){
	$this->Html->addCrumb('Saved job', $refer_url);
}elseif($refer_url == '/jobs/applied'){
	$this->Html->addCrumb('Applied job', $refer_url);
}else{
	$url_arr = explode('/',$refer_url);
	$prev_url = ucwords($url_arr[count($url_arr)-1]);
	$this->Html->addCrumb($prev_url, $refer_url);
}

$this->Html->addCrumb('Job Detail');
?>
<meta property="og:url"                content="<?php echo HTTP_PATH . '/' . $jobdetails['Category']['slug'] . '/' . $jobdetails['Job']['slug'] . '.html' ?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="<?php echo $jobdetails['Job']['title']; ?>" />
<meta property="og:description"        content="<?php echo strip_tags(nl2br($jobdetails['Job']['description'])); ?>" />
<meta property="og:image"              content="<?php echo $image_path; ?>" />
<div class="clear"></div>

<div class="my_accnt">
   <?php //echo $this->element('topbar'); ?>
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
				<div class="col-lg-12">
					<?php echo $this->element('session_msg'); ?>
					<div class="col-md-12 row job-div_button" style="display:block;">
						<div class="job_button_p">
						<?php
						if ($this->Session->read('user_id')) {
							if($jobdetails['Job']['user_id']!=$this->Session->read('user_id')){
								if ($jobdetails['Job']['expire_time'] < time()) {
													
									$short_status = classregistry::init('ShortList')->find('first', array('conditions' => array('ShortList.user_id' => $this->Session->read('user_id'), 'ShortList.job_id' => $jobdetails['Job']['id'])));
									if (empty($short_status)) {
										echo $this->Html->link('<i class="fa fa-star-o"></i> ' . __d('user', 'Save', true), array('controller' => 'jobs', 'action' => 'JobSave', 'slug' => $jobdetails['Job']['slug']), array('class' => 'save active jobSave', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$jobdetails['Job']['slug'],'data-jobId'=>$jobdetails['Job']['id']));
									} 
									else 
									{
										echo $this->Html->link('<i class="fa fa-star"></i> ' . __d('user', 'Saved', true), 'javascript:void(0);', array('class' => 'active Apply already-saved', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$jobdetails['Job']['slug'],'data-jobId'=>$jobdetails['Job']['id']));
									}
									echo '&nbsp;&nbsp;';
									echo $this->Html->link(__d('user', 'Job Expired', true), 'javascript:void(0);', array('class' => 'Apply active'));
								} 
								elseif ($this->Session->read('user_type') && $this->Session->read('user_type') != 'recruiter') {
									$short_status = classregistry::init('ShortList')->find('first', array('conditions' => array('ShortList.user_id' => $this->Session->read('user_id'), 'ShortList.job_id' => $jobdetails['Job']['id'])));
									if (empty($short_status)) {
										echo $this->Html->link('<i class="fa fa-star-o"></i> ' . __d('user', 'Save', true), 'javascript:void(0);', array('class' => 'save active jobSave', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$jobdetails['Job']['slug'],'data-jobId'=>$jobdetails['Job']['id']));
									} 
									else 
									{
										echo $this->Html->link('<i class="fa fa-star"></i> ' . __d('user', 'Saved', true), 'javascript:void(0);', array('class' => 'active Apply already-saved', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$jobdetails['Job']['slug'],'data-jobId'=>$jobdetails['Job']['id']));
									}
									?>&nbsp;&nbsp;
									<?php
									
									$apply_status = classregistry::init('JobApply')->find('first', array('conditions' => array('JobApply.user_id' => $this->Session->read('user_id'), 'JobApply.job_id' => $jobdetails['Job']['id'])));
									if (empty($apply_status)) {
										$isAbleToJob = classregistry::init('Plan')->checkPlanFeature($this->Session->read('user_id'), 4);
										if($isAbleToJob['status'] == 0) {
											echo '<a id="upgradePlanBtn' . $jobdetails["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active upgradePlanBtn" data-jobId="' . $jobdetails["Job"]["id"] . '" data-jobSlug="' . $jobdetails["Job"]["slug"].'">' . __d('user', 'Upgrade Plan', true) . '</a>';
											
											echo '<a id="applybtn' . $jobdetails["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active disable">' . __d('user', 'Apply', true) . '</a>';
										}
										else
										{
											echo '<a id="applybtn' . $jobdetails["Job"]["id"] . '" onclick="applyNow(' . $jobdetails["Job"]["id"] . ')" href="javascript:void(0);" class = "Apply active">' . __d('user', 'Apply', true) . '</a>';
										}
										
									} 
									else 
									{
										echo $this->Html->link(__d('user', 'Already Applied', true), 'javascript:void(0);', array('class' => 'Apply active'));
									}
								} 
								
							}
							else
							{
								echo $this->Html->link(__d('user', 'Job posted by you', true), 'javascript:void(0);', array('class' => 'Apply active'));
							}
						}
						?>
						<div class="share_icons addthis_button"> <a href="#" title="Share"><?php echo $this->Html->image('front/home/share-icon.png', array('alt' => '')); ?></a></div> 
						</div>
					</div>
					<div class="row job_listing col-md-12">
						<div class="single-job-detail">
							<div class="job-meta-detail">
								<div class="title">
									<h4> <a href="#"><?php echo $jobdetails['Job']['title']; ?></a> </h4>
								</div>
								<div class="meta-info">
									<p><i class="fa fa-users" aria-hidden="true"></i>
									<?php echo __d('user', '<b>Company Name:</b>', true); ?>: <span><?php echo $jobdetails['Job']['company_name'] ? $jobdetails['Job']['company_name'] : 'N/A'; ?></p>
									<p><i class="fa fa-tasks" aria-hidden="true"></i>
									<?php echo __d('user', '<b>Company Job Id:</b>', true); ?>: <span><?php echo $jobdetails['Job']['jobID'] ? $jobdetails['Job']['jobID'] : 'N/A'; ?></p>
									<p><i class="fa fa-briefcase" aria-hidden="true"></i><?php
										if (isset($jobdetails['Job']['min_exp']) && isset($jobdetails['Job']['max_exp'])) {
											echo $jobdetails['Job']['min_exp'] . "-" . $jobdetails['Job']['max_exp'] . ' ' . __d('user', 'yrs', true);
										} else {
											echo "N/A";
										}
										?></p>
									<p><i class="fa fa-map-marker" aria-hidden="true"></i><a href="#"><?php
											if (!empty($jobdetails['Job']['job_city']) && isset($jobdetails['Job']['job_city'])) {
												echo $jobdetails['Job']['job_city'];
											} else {
												echo 'N/A';
											}
											?></a></p>
									<p><i class="fa fa-calendar" aria-hidden="true"></i>
										<?php
										$now = time(); // or your date as well
										$your_date = strtotime($jobdetails['Job']['created']);
										$datediff = $now - $your_date;
										$day = round($datediff / (60 * 60 * 24));
										echo $day == 0 ? __d('user', 'Today', true) : $day . ' ' . __d('user', 'Days ago', true);
										?>
									</p>

								</div>
							</div>
						</div>
					</div>
					<div class="row job_listing">
						<div class="col-md-12">
							<div class="job-post-wrapper">
								<div class="entry-content">
									<h3><?php echo __d('user', 'Job Description', true); ?></h3>
									<div class="clear"></div>
									<?php
									$specification = 1;
									if (trim($jobdetails['Job']['selling_point1']) == '' && trim($jobdetails['Job']['selling_point2']) == '' && trim($jobdetails['Job']['selling_point3']) == '') {
										$specification = 0;
										?>
										<div class="det_imv">
											<span><?php echo ($jobdetails['Job']['description']); ?></span>
										</div>

										<?php 			
									} 
									else 
									{ ?>
										<div class="det_imv"><span><?php echo ($jobdetails['Job']['description']); ?></span> </div>
										<?php 
									} ?>
									<div class="clear"></div><br/>
									<h3><?php echo __d('user', 'Designation', true); ?></h3>
									<div class="show_skills_sc">
										<ul>
											<?php
											$jobDesignation = ClassRegistry::init('Job')->field('designation', array('Job.id' => $jobdetails['Job']['id']));
											// pr($jobDesignation);
											$designation = ClassRegistry::init('Skill')->field('name', array('Skill.id' => $jobDesignation, 'Skill.type' => 'Designation'));
											if (!empty($designation)) {
												echo '<li>' . $designation . '</li>';
											} else {
												echo 'N/A';
											}
											?>
										</ul>    
									</div>
									<div class="clear"></div><br/>
									<h3><?php echo __d('user', 'Key skill Required', true); ?></h3>
									<div class="show_skills_sc">
										<ul>
											<?php
											$jobskill = ClassRegistry::init('Job')->field('skill', array('Job.id' => $jobdetails['Job']['id']));
											$jobId = explode(',', $jobskill);
											$i = 1;
											foreach ($jobId as $id) {
												$skill = ClassRegistry::init('Skill')->field('name', array('Skill.id' => $id));

												if (!empty($skill)) {
													if ($i == 1) {
														echo '<li>' . $skill . '</li>';
													} else {
														//echo " , " . $skill;
														echo '<li>' . $skill . '</li>';
													}
													$i = $i + 1;
												} else {
													echo"N/A";
												}
											}
											?>
										</ul>    
									</div>

									<div class="clear"></div><br/>
									<h3><?php echo __d('user', 'Job Overview', true) ?></h3>
									<div class="show_skills_sc">
										<ul>
											<li><b><?php echo __d('user', 'Date Posted', true) ?>:</b><?php echo date('d F Y', strtotime($jobdetails['Job']['created'])); ?></li>
											<li><b><?php echo __d('user', 'Category', true) ?>:</b><?php echo $jobdetails['Category']['name']; ?></li>
											<li><b><?php echo __d('user', 'Sub Category', true) ?>:</b><?php
													$condition = array();
													$subcategory_id = $jobdetails['Job']['subcategory_id'] ? $jobdetails['Job']['subcategory_id'] : 0;
													$condition[] = " (Category.id IN ($subcategory_id ))";
													$subcategory = ClassRegistry::init('Category')->find('list', array('conditions' => $condition));

													echo $subcategory ? implode(', ', $subcategory) : 'N/A'
													?>
											</li>
											<li><b><?php echo __d('user', 'Job Type', true) ?>:</b>
													<?php
													global $worktype;
													echo $worktype[$jobdetails['Job']['work_type']];
													?>
											</li>
											<li><b><?php echo __d('user', 'Salary', true) ?>:</b><?php
														if (isset($jobdetails['Job']['min_salary']) && isset($jobdetails['Job']['max_salary'])) {
															echo CURRENCY . ' ' . intval($jobdetails['Job']['min_salary']) . " - " . CURRENCY . ' ' . intval($jobdetails['Job']['max_salary']);
														} else {
															echo "N/A";
														}
														?> /year
											</li>
											<li><b><?php echo __d('user', 'Company Website', true) ?>:</b><?php
														if (trim($jobdetails['Job']['url']) != '') {
															echo $this->Text->autoLink(trim($jobdetails['Job']['url']), array('target' => '_blank', 'rel' => 'nofollow'));
														} else {
															echo 'N/A';
														}
														?>
											</li>
										</ul>    
									</div>
									<div class="clear"></div><br/>
								</div>
							</div>
							<div class="job-post-list">
								<div class="sidebar-title inner-section ">
									<h3><?php echo __d('user', 'Related Jobs', true) ?></h3>
								</div>
								<div class="related-job-bx">
									<div class="row col-md-12">
										<?php
										global $monthName;
										if (isset($relevantJobList) && !empty($relevantJobList)) {
											foreach ($relevantJobList as $key => $job) {
												?>
												<div class="col-lg-12">
													<div class="single-job " data-aos="fade-left">
														<div class="job_button_re">
												<?php
												if ($this->Session->read('user_id')) {
													
													if($job['Job']['user_id']!=$this->Session->read('user_id')){
														if ($job['Job']['expire_time'] < time()) {
																			
															$short_status = classregistry::init('ShortList')->find('first', array('conditions' => array('ShortList.user_id' => $this->Session->read('user_id'), 'ShortList.job_id' => $job['Job']['id'])));
															if (empty($short_status)) {
																echo $this->Html->link('<i class="fa fa-star-o"></i> ' . __d('user', 'Save', true), array('controller' => 'jobs', 'action' => 'JobSave', 'slug' => $job['Job']['slug']), array('class' => 'save active jobSave', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id']));
															} 
															else 
															{
																echo $this->Html->link('<i class="fa fa-star"></i> ' . __d('user', 'Saved', true), 'javascript:void(0);', array('class' => 'active Apply already-saved', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id']));
															}
															echo '&nbsp;&nbsp;';
															echo $this->Html->link(__d('user', 'Job Expired', true), 'javascript:void(0);', array('class' => 'Apply active'));
														} 
														elseif ($this->Session->read('user_type') && $this->Session->read('user_type') != 'recruiter') {
															$short_status = classregistry::init('ShortList')->find('first', array('conditions' => array('ShortList.user_id' => $this->Session->read('user_id'), 'ShortList.job_id' => $job['Job']['id'])));
															if (empty($short_status)) {
																echo $this->Html->link('<i class="fa fa-star-o"></i> ' . __d('user', 'Save', true), 'javascript:void(0);', array('class' => 'save active jobSave', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id']));
															} 
															else 
															{
																echo $this->Html->link('<i class="fa fa-star"></i> ' . __d('user', 'Saved', true), 'javascript:void(0);', array('class' => 'active Apply already-saved', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id']));
															}
															?>
															&nbsp;&nbsp;
															<?php
															
															$apply_status = classregistry::init('JobApply')->find('first', array('conditions' => array('JobApply.user_id' => $this->Session->read('user_id'), 'JobApply.job_id' => $job['Job']['id'])));
															if (empty($apply_status)) {
																$isAbleToJob = classregistry::init('Plan')->checkPlanFeature($this->Session->read('user_id'), 4);
																if($isAbleToJob['status'] == 0) {
																	echo '<a id="upgradePlanBtn' . $jobdetails["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active upgradePlanBtn" data-jobId="' . $jobdetails["Job"]["id"] . '" data-jobSlug="' . $jobdetails["Job"]["slug"].'">' . __d('user', 'Upgrade Plan', true) . '</a>';
																	echo '&nbsp;&nbsp;';
																	echo '<a id="applybtn' . $job["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active disable">' . __d('user', 'Apply', true) . '</a>';
																}
																else
																{
																	echo '<a id="applybtn' . $job["Job"]["id"] . '" onclick="applyNow(' . $job["Job"]["id"] . ')" href="javascript:void(0);" class = "Apply active">' . __d('user', 'Apply', true) . '</a>';
																}
																
															} 
															else 
															{
																echo $this->Html->link(__d('user', 'Already Applied', true), 'javascript:void(0);', array('class' => 'Apply active'));
															}
														} 
														
													}
													else
													{
														echo $this->Html->link(__d('user', 'Job posted by you', true), 'javascript:void(0);', array('class' => 'Apply active'));
													}
												}
												?>
		
											</div>
														<div class="job-meta">
															<div class="title">
																<h4><?php echo $this->Html->link($job['Job']['title'], array('controller' => 'jobs', 'action' => 'detail', 'cat' => $job['Category']['slug'], 'slug' => $job['Job']['slug'], 'ext' => 'html')); ?></h4>
															</div>
															<div class="meta-info">
																<div class="job-experience"><label>Experience: </label>
																	<span><?php
																	if ($job['Job']['max_exp'] > 15) {
																		echo $job['Job']['min_exp'] . ' - ' . 'more than 15 years';
																	} else {
																		echo $job['Job']['min_exp'] . ' - ' . $job['Job']['max_exp'] . ' ' . __d('user', 'yrs', true);
																	}
																	?></span>
																</div>
															   <div class="job-salary-package"> <?php if (isset($job['Job']['min_salary']) && isset($job['Job']['max_salary'])) {
																		echo CURRENCY . ' ' . intval($job['Job']['min_salary']) . " - " . CURRENCY . ' ' . intval($job['Job']['max_salary']);
																	} else {
																		echo "N/A";
																	} ?> /year
																</div>
																
																
															</div>
															<div class="job-salary-package">
																<p><i><?php echo $this->Html->image('front/home/location-icon.png', array('alt' => '')); ?></i>
																<a href="<?php echo HTTP_PATH . '/' . $job['Category']['slug'] . '/' . $job['Job']['slug'] . '.html' ?>"><?php echo $job['Job']['job_city'] ? $job['Job']['job_city'] : 'N/A'; ?></a>
																</p>
															
															</div>
															<div class="job-salary-package"><p><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;<?php
																$now = time(); // or your date as well
																$your_date = strtotime($job['Job']['created']);
																$datediff = $now - $your_date;
																$day = round($datediff / (60 * 60 * 24));
																echo $day == 0 ? __d('user', 'Today', true) : $day . ' ' . __d('user', 'Days ago', true);
																?></p>
															</div>
															<div class="job-salary-package">
																<a class="time-btn-new" href="<?php echo HTTP_PATH . '/' . $job['Category']['slug'] . '/' . $job['Job']['slug'] . '.html' ?>"><?php
																global $worktype;
																echo $job['Job']['work_type'] ? $worktype[$job['Job']['work_type']] : 'N/A';
																?></a>
															
															</div>
														</div>
														
										<div class="clear"></div>
										<div class="job-salary-package">
											<h5 style="font-size: 18px;font-weight: normal;color: #25242a;margin: 0;">Job Description:</h5>
											<p style="font-size: 13px;">
												<?php 
												$description = strip_tags($job["Job"]["description"]);
												if (strlen($description) > 180) {
													$stringCut = substr($description, 0, 180);
													$endPoint = strrpos($stringCut, ' ');
													//if the string doesn't contain any space then it will cut without word basis.
													$description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
													$description .= '... <a href="'.HTTP_PATH. '/' . $job['Category']['slug'] . '/' . $job['Job']['slug'] . '.html">Read More</a>';
												}
												echo $description;
												?>
											</p>
										</div>
									</div>
                                </div>
								<?php
                            }
                        } 
						else 
						{
                            ?>
                            <h6><?php echo __d('home', 'No record found', true); ?></h6>
							<?php 
						} ?>

									</div>
								</div>
							</div>
						</div>
	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
	<link href="<?php echo HTTP_PATH; ?>/css/front/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
<div id="myApplyModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Apply Job</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'applyJobForm', 'class' => "form_trl_box_show2", 'name' => 'applyJobForm')); ?>
				<?php echo $this->Form->hidden('Job.id', array('value' =>$jobdetails['Job']['id']));?>
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
				<div class="form_list_education">
					<label class="lable-acc"><?php echo __d('user', 'CV Document/Certificates', true); ?> <span class="star_red"></span><span class="subcat_help_text"></span></label>
					<div class="form_input_education">
					<div id="mulitplefileuploaderApply"><?php echo __d('user', 'Choose File', true); ?> 
					</div>
					<div class="supported-types"><p>- <?php echo __d('user', 'Supported File Types', true); ?>: pdf, doc and docx, gif, jpg, jpeg, png (Max. 4 MB).<br> - <?php echo __d('user', 'Min file size', true); ?> 150 X 150 <?php echo __d('user', 'pixels', true) . ' ' . __d('user', 'for image', true); ?></p></div>
					<input type="hidden" id="Applyimages" name="data[Certificate][document]" value="" >

					<div class="hmdnd no-margin-row">
						<label>&nbsp;</label>
						<?php
						$showOldImages = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'image')));
						$showOldDocs = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'doc')));
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
												<input type="radio" name="chooseCv" value="<?php echo $doc;?>" <?php echo $radioChecked;?> required>
												<span class="temp-image-section">
												
													<?php echo $this->Html->link(substr($doc, 6), array('controller' => 'candidates', 'action' => 'downloadDocCertificate', $doc), array('class' => 'dfasggs', 'target' => '_blank')); ?>    
													<span class="close_icon_for" alt="<?php echo $doc; ?>"  onclick="deleteOldImage('<?php echo $showOldDoc['Certificate']['slug']; ?>')">X
													</span>
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
											<input type="radio" name="chooseCv" value="<?php echo $image;?>" <?php echo $radioChecked1;?> required>
												<span class="temp-image-section">
													<a href="<?php echo $this->Html->url(array('controller' => 'candidates', 'action' => 'downloadImage', $image)); ?>" class="dfasggs" target="_blank"><?php echo $image;?></a>
													<span class="close_icon_for" alt="<?php echo $image; ?>"  onclick="deleteOldImage('<?php echo $showOldImage['Certificate']['slug']; ?>')">X
													</span>
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
						//echo $this->Form->hidden('Certificate.images', array('id' => 'images1', 'value' => implode(',', $new_slug_arry)));
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
<div id="upgradePlanModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Purchase Membership Plan</h5>
				 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				
			</div>
		</div>
	</div>
</div>
<style type="text/css">
.single-job .job-meta{
width:60% !important;	
}
.job-meta-detail{
	padding-left:2px !important;
}
.job_button_re{
width: 40%;
float: right;
}
.job_button_re a {
  float: right;
	
}

.job-salary-package p i {
  display: inline-block;
  width: 14px;
  opacity: 0.6;
  vertical-align: top;
  margin-top: 4px;
}
.job-locations{
	width:auto; !important;
}
.job-locations a{
	width:auto; !important;
}
</style>

<link href='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.min.css' rel='stylesheet'>
<script src='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.all.min.js'></script> 

<script>
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
					$('input[name="chooseCv"]').prop('checked', false);
                    if (data.type == 'image') {
						 html += "<div id='delete_" + id1 + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' checked required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a><span class='close_icon_for' alt='" + data.image + "' slug='" + data.slug + "'>X </span></span></div>";
                        
                    } else if (data.type == 'doc') {
                       html += "<div id='delete_" + id1 + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' checked required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a><span class='close_icon_for' alt='" + data.image + "' slug='" + data.slug + "'>X </span></span></div>";						
                       
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
$('body').on('click', '.jobSave', function(e){
	var jobSlug = $(this).attr('data-slug');
		var jobId = $(this).attr('data-jobId');
		var saveJobReference = $(this);
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/ajaxJobSave" ?>",
			data:'jobId='+jobId+'&jobSlug='+jobSlug,
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
						saveJobReference.removeClass('save active jobSave');
						saveJobReference.addClass('active Apply already-saved');
						saveJobReference.html('<i class="fa fa-star"></i> Saved');
						
					})
					
				}
			}
		});
		
	});
	$('body').on('click', '.already-saved', function(e){
	
		console.log('removed');
		var jobSlug = $(this).attr('data-slug');
		var jobId = $(this).attr('data-jobId');
		var saveJobReference = $(this);
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/ajaxJobUnSave" ?>",
			data:'jobId='+jobId+'&jobSlug='+jobSlug,
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
						saveJobReference.removeClass('active Apply already-saved');
						saveJobReference.addClass('save active jobSave');
						saveJobReference.html('<i class="fa fa-star-o"></i> Save');
						
					})
					
				}
			}
		});
		
	});
	
	function applyNow(id) {
		//$('.header').css({'z-index':'0'});
		$('#myApplyModal').modal('show');
		$('#myApplyModal').css({'z-index':'9999'});
		$("#JobId").val(id);
	}
	$( "#myApplyModal" ).on('hidden.bs.modal', function(){
		//$('.header').css({'z-index':'9999'});
		$('.ajax-upload-dragdrop').remove();
	});
	
	$('#myApplyModal').on('shown.bs.modal', function (e) {
		  $("#mulitplefileuploaderApply").uploadFile(settingsApply);
		  
	})
	
	$('#applyJobForm').on('submit', function(e){
        e.preventDefault();
        var dataString = $("#applyJobForm").serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/ajaxApplyJob" ?>",
			data: dataString,
			dataType: "json",
			success: function(response)
			{
				if(response.status=='error'){
					$('#myApplyModal').css({'z-index':'0'});
					Swal.fire({
						title: "Error!",
						html: response.message,
						allowOutsideClick: true
					}).then((result) => {
						$('#myApplyModal').css({'z-index':'9999'});
					})
					
					return false;
				}
				else
				{
					$('#myApplyModal').css({'z-index':'0'});
					Swal.fire({
						title: 'Success',
						html: response.message,
						allowOutsideClick: false
		
					}).then((result) => {
						$('#myApplyModal').css({'z-index':'9999'});
						//location.reload();
						$("#applybtn"+response.jobId).text('Already Applied');
						$('#myApplyModal').modal('hide');
					})
					
				}
			}
		});
    });
	
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
           
			
        })
		
	$('body').on('click', '.upgradePlanBtn', function(e){
		var jobId = $(this).attr('data-jobId');
		var jobSlug = $(this).attr('data-jobSlug');
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/plans/ajaxPlan" ?>",
			data:'jobId='+jobId+'&jobSlug='+jobSlug+'&page=detail',
			success: function(response)
			{
				$('.modal-body').html(response);
				$('#upgradePlanModal').modal('show'); 
				$('#upgradePlanModal').css({'z-index':'9999'});
			}
		});
		return false;
	});
</script>
