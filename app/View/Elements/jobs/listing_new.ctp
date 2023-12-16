 <div class="inbox_msg">
	<?php
	if(!empty($jobs)){?>
		<link href='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.min.css' rel='stylesheet'>
		<script src='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.all.min.js'></script> 
		<div class="inbox_people col-sm-4 col-lg-4 col-xs-12">
			<div class="headind_srch">
				<div class="recent_heading">
				  <h4>Recent</h4>
				</div>
				
			</div>
			<div class="inbox_chat" >
				<?php
				$count = 1;
				foreach ($jobs as $job) {
					$firstjobClassActive = '';
					if($count==1){
						$firstjobClassActive = 'active_chat';
						$jobdetails = $job;
						
					}
					?>
					<div class="chat_list <?php echo $firstjobClassActive;?>">
						<div class="chat_people">
							<div class="chat_img"> 
							<?php
							
							if ($job['Job']['logo']) {
								$path = UPLOAD_JOB_LOGO_PATH . $job['Job']['logo'];
								if (file_exists($path) && !empty($job['Job']['logo'])) {
									echo $this->Html->image(PHP_PATH . "timthumb.php?src=" . DISPLAY_JOB_LOGO_PATH . $job['Job']['logo'] . "&w=200&zc=1&q=100", array('escape' => false, 'rel' => 'nofollow'));
								} 
								else 
								{
									echo $this->Html->image('front/no_image_user.png');
								}
							} 
							else 
							{
								$logo_image = ClassRegistry::init('User')->field('profile_image', array('User.id' => $job['Job']['user_id']));
								$path = UPLOAD_FULL_PROFILE_IMAGE_PATH . $logo_image;
								if (file_exists($path) && !empty($logo_image)) {
									echo $this->Html->image(DISPLAY_THUMB_PROFILE_IMAGE_PATH . $logo_image, array('escape' => false, 'rel' => 'nofollow'));
								} 
								else 
								{
									echo $this->Html->image('front/no_image_user.png');
								}
							}
							?>
							
							
							
							<!--<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> -->
							</div>
							<div class="chat_ib">
								<h5>
								<?php echo $this->Html->link($job['Job']['title'], 'javascript:void(0);', array('class' => 'leftjoblis', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id'])); ?>
								<span class="chat_date">
								<?php
								if($job['Job']['user_id']!=$this->Session->read('user_id')){
									$short_status = classregistry::init('ShortList')->find('first', array('conditions' => array('ShortList.user_id' => $this->Session->read('user_id'), 'ShortList.job_id' => $job['Job']['id'])));
									if (empty($short_status)) {
										echo $this->Html->link('<i class="fa fa-star-o"></i>', 'javascript:void(0);', array('class' => 'jobSavelis', 'escape' => false, 'rel' => 'nofollow','data-slug'=>$job['Job']['slug'],'data-jobId'=>$job['Job']['id']));
									} 
									else 
									{
										echo $this->Html->link('<i class="fa fa-star"></i>', 'javascript:void(0);', array('escape' => false, 'rel' => 'nofollow'));
									}
								}
								?>
								</span></h5>
								<?php
								if(isset($job['Designation']['name'])){
									if(!empty($job['Designation']['name'])){?>
										<span><?php echo $job['Designation']['name'];?></span>
										<?php
									}
								}?>
								<?php
								if(isset($job['Job']['job_city'])){
									if(!empty($job['Job']['job_city'])){?>
										<p><?php echo $job['Job']['job_city'];?></p>
										<?php
									}
								}?>
								<p>
								<?php 
								if (isset($job['Job']['min_salary']) && isset($job['Job']['max_salary'])) {
									echo CURRENCY . ' ' . intval($job['Job']['min_salary']) . " - " . CURRENCY . ' ' . intval($job['Job']['max_salary']);
									} 
									else 
									{
										echo "N/A";
									}?> /year
								</p>
								<h5><span class="chat_date">
									<i class="fa fa-calendar" aria-hidden="true"></i> 
									<?php
									$now = time(); // or your date as well
									$your_date = strtotime($job['Job']['created']);
									$datediff = $now - $your_date;
									$day = round($datediff / (60 * 60 * 24));
									echo $day == 0 ? __d('user', 'Today', true) : $day . ' ' . __d('user', 'Days ago', true);
									?></span></h5>
							</div>
						</div>
					</div>
				<?php
					$count++;
				}?>
			</div>
		</div>
		<div class="mesgs col-sm-8 col-lg-8 col-xs-12">
			<div class="msg_history">
				<?php echo $this->element('jobs/job_details',array('jobdetails' => $jobdetails)); ?>

			</div>
			
		</div>
		<link href="<?php echo HTTP_PATH; ?>/css/front/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo HTTP_PATH; ?>/js/front/jquery.fileuploadmulti.min.js" charset="utf-8"></script>
		<script type="text/javascript">
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
						 html += "<div id='" + data.slug + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";
                        
                    } else if (data.type == 'doc') {
                       html += "<div id='" + data.slug + "' class='doc_fukll_name'><input type='radio' name='chooseCv' value='" + data.image + "' required><span class='temp-image-section'><a href='<?php echo HTTP_PATH; ?>/candidates/downloadDocCertificate/"+ data.image +"' class='dfasggs' target='_blank'>" + data.image + "</a></span></div>";						
                       
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
		$('.leftjoblis').click(function () {
			var jobSlug = $(this).attr('data-slug');
			var jobId = $(this).attr('data-jobId');
			$('.chat_list').removeClass('active_chat');
			$(this).parents('div.chat_list').addClass('active_chat');
			 $.ajax({
				type: 'POST',
				url: "<?php echo HTTP_PATH; ?>/jobs/jobsDetails/",
				cache: false,
				data:'jobId='+jobId+'&jobSlug='+jobSlug,
				beforeSend: function () {
					$('#loaderID').show();
				},
				complete: function () {
					$('#loaderID').hide();
					
				},
				success: function (result) {
					$('.msg_history').html(result);
					
					
					

				}
			});
		});	
	
		$('.jobSavelis').click(function () {
			var jobSlug = $(this).attr('data-slug');
			var jobId = $(this).attr('data-jobId');
			var saveJobReference = $(this);
			Swal.fire({
				title: 'Confirmation',
				html: 'Are you sure you want to save this job',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Done'
			}).then((result) => {
				if (result.value) { 
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
									saveJobReference.html('<i class="fa fa-star"></i>');
								})
								
							}
						}
					});
				}
			})
		
		});
		
		</script>
	<?php
	}
	else
	{?>
		<div class="listing_box_full">
        <div class="listing_full_row listing_full_row_bg no-deta">
            <div class="nomatching"> 
                <h1><?php echo __d('user', 'There are no jobs matching for your search criteria.', true); ?></h1>
                <h3><?php echo __d('user', 'Please searched with other options.', true); ?></h3>
            </div>
        </div>
    </div>
	<?php
	}?>
	
</div>
 
 
 