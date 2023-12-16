<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<?php ClassRegistry::init('Job')->updateJobView($jobdetails['Job']['id']); ?>
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
							echo '<a id="upgradePlanBtn' . $jobdetails["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active upgradePlanBtn" data-jobId="' . $jobdetails["Job"]["id"].'" data-jobSlug="' . $jobdetails["Job"]["slug"].'">' . __d('user', 'Upgrade Plan', true) . '</a>';
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
		else{
			echo '<a id="applybtn' . $jobdetails["Job"]["id"] . '" onclick="loginNow(' . $jobdetails["Job"]["id"] . ')"  href="javascript:void(0)" class = "Apply active">' . __d('user', 'Apply', true) . '</a>';

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
						<?php //var_dump($jobdetails) ;
							if(!empty($jobdetails['Job']['description_url'])){ ?>
								<a href="<?= $jobdetails['Job']['description_url'] ?>" target="_blank"><?= $jobdetails['Job']['description_url'] ?></a><br>
								<iframe src="<?= $jobdetails['Job']['description_url'] ?>" width="97%"   style="height: 40vh;"></iframe>

							<?php }

							if(!empty($jobdetails['Job']['description_document'])){ 
								$ext_arr = explode(".",basename($jobdetails['Job']['description_document']));
								$extension = strtolower($ext_arr[count($ext_arr)-1]);
								if($extension == "pdf"){ ?>
									<embed src="<?= DISPLAY_JOB_DESCRIPTION_PATH . $jobdetails['Job']['description_document'] ?>"  width="95%" style="height: 50vh" />
								<?php }elseif($extension == "doc" || $extension == "docx"){ 
									$document_docx = DISPLAY_JOB_DESCRIPTION_PATH . $jobdetails['Job']['description_document'];
								?>

<div id="documentViewer"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
<script>
	var documentDocx = '<?= $document_docx ?>';
	fetch(documentDocx)
	.then(response => response.blob())
	.then(blob => {
		var reader = new FileReader();
		reader.onload = function(e) {
			var docArrayBuffer = e.target.result;
			mammoth.convertToHtml({ arrayBuffer: docArrayBuffer })
				.then(displayResult)
				.catch(handleError);
		};
		reader.readAsArrayBuffer(blob);
	})
	.catch(error => {
		console.error('Error fetching the file:', error);
	});


function displayResult(result) {
    var newDiv = $('<div>');
    newDiv.attr('style', 'max-height:40vh; overflow-y:scroll; margin:1rem 0px; border: 1px solid gray; padding:1rem;');
    newDiv.html(result.value);
    $('#documentViewer').html(newDiv);
}

function handleError(error) {
    console.log(error);
    alert('Error occurred while converting the Word document.');
} 

</script> 


								<?php }else{
									echo $this->Html->image(DISPLAY_JOB_DESCRIPTION_PATH . $jobdetails['Job']['description_document'] , array('escape' => false,)); 
								}
							}
						?>
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
							echo '<a id="upgradePlanBtn' . $job["Job"]["id"] . '" href="javascript:void(0);" class = "Apply active upgradePlanBtn" data-jobId="' . $jobdetails["Job"]["id"] . '" data-jobSlug="' . $jobdetails["Job"]["slug"].'">' . __d('user', 'Upgrade Plan', true) . '</a>';
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

				<?php 
					$showOldCVImages = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'image','is_cv' => 1)));
					$showOldCVDocs = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'doc','is_cv' => 1)));

					$showOldImages = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'image','is_cv' => 0)));
					$showOldDocs = classregistry::init('Certificate')->find('all', array('conditions' => array('Certificate.user_id' => $this->Session->read('user_id'), 'type' => 'doc','is_cv' => 0)));
					$new_slug_arry = array();
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
										} ?>
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
										<?php  $d++;  
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
													<span class="close_icon_for" alt="<?php echo $image; ?>"  onclick="deleteOldImage('<?php echo $showOldImage['Certificate']['slug']; ?>')">X
													</span>
													
												</span>
										</div>
										<?php $im++;
									}
								}  ?>
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

<div id="myLoginModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Login</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				
			<div id="loginModalForm"></div>
				
			</div>
		
		</div>
	</div>
</div>

<script type="text/javascript">
	function applyNow(id) {
		//$('.header').css({'z-index':'0'});
		$('#myApplyModal').modal('show');
		$('#myApplyModal').css({'z-index':'9999'});
		$("#JobId").val(id);
	}

	function loginNow(jobid){
		$.ajax({
			async:true, 
			type:'get', 
			complete:function(request, json) {
				$('#myLoginModal').modal('show');
				$('#myLoginModal').css({'z-index':'9999'});
				$('#loginModalForm').html(request.responseText);
			},
			url: '<?= HTTP_PATH ?>/users/login',
			data:{ job_id: jobid }
        });

	}

	$( "#myApplyModal" ).on('hidden.bs.modal', function(){
		//$('.header').css({'z-index':'9999'});
		$('.ajax-upload-dragdrop').remove();
	});
	
	$('#myApplyModal').on('shown.bs.modal', function (e) {
		  $("#mulitplefileuploaderApply").uploadFile(settingsApply);
		  $("#mulitplefileuploaderApply_cv").uploadFile(settingsApply_cv);
		  
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
				}else if(response.status=='pending'){

					$('#myApplyModal').css({'z-index':'0'});
					Swal.fire({
						title: "Pending!",
						html: response.message,
						allowOutsideClick: true
						
					}).then((result) => {
						$('#myApplyModal').css({'z-index':'9999'});
					})

					Swal.fire({
						title: "Are you sure?",
						html: response.message,
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "Yes",
						cancelButtonText: "No"
						}).then((result) => {
						if (result.value) {
							var forceApplyInput = $('<input>')
								.attr({
									type: 'hidden',
									name: 'forceApply',
									id: 'forceApply',
									value: '1'
							});
							$('#applyJobForm').append(forceApplyInput);
							$('#applyJobForm').submit();

						} else {
							$('#myApplyModal').css({'z-index':'9999'});
							$('#myApplyModal').modal('hide');
						}
					});

				}else
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

	

</script>

<div  id="applypop"></div>
<style type="text/css">
.job-meta-detail{
	padding-left:0px !important;
}
.single-job .job-meta{
width:60% !important;	
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
.modal-header{
	background: var(--card-background) !important;
}
.right-sidebar .single-overview, .right-sidebar .contact-details {
  margin-bottom: 0px !important;
}
.sidebar-details{
padding:0px !important;	
}
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