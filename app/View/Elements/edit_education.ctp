<script>
	
    $(document).ready(function () {
		$('#updateBTNEducation').on('click', function() {
			$("#editEducation").validate();
		});
        
    });
</script>


<script>

    $(document).ready(function () {

        $("#addeducation").click(function () {
            var cc = ($('#educationcounter').val() * 1) + 1;
            $('#educationcounter').val(cc);
            $("#loader1").show();
            $.ajax({
                type: "POST",
                url: "<?php echo HTTP_PATH; ?>/candidates/openeducation/" + cc,
                cache: false,
                success: function (responseText) {
                    $("#loader1").hide();
                    $('#educationElement').append(responseText);
                    $("#loader1").hide();
                }
            });
        });



    });

    function removeCC(cc, id) {
        if (id) {
            $("#loader1").show();
            $.ajax({
                type: "POST",
                url: "<?php echo HTTP_PATH; ?>/candidates/deleteeducation/" + id,
                cache: false,
                success: function (responseText) {
                    $('#dynamic' + cc).remove();
                    $("#loader1").hide();
                    $(".success_msg").text("Education deleted successfully");

                    window.location.href = "<?php echo HTTP_PATH; ?>/users/myaccount";
                }
            });
        } else {
            $('#dynamic' + cc).remove();
        }
    }


    $(document).on("change", ".in_year", function (e) {
        //$('.in_year').change(function(e){
        console.log('from edit');
        var this_value = $(this).val();
        var this_id = $(this).attr('id');
        var element = $(this);
        var is_error = 0;

        $('.in_year').each(function (e) {
            var other_value = $(this).val();
            var other_id = $(this).attr('id');

            if (this_value == other_value && this_id != other_id)
            {
                is_error = 1;
            }
        });
        if (is_error)
        {
            //element.val('').change();
            alert('You have already selected year ' + this_value);
            element.addClass('error');
            $('#addeducation').addClass('disableClick');
            $('input[type="submit"]').attr('disabled', 'disabled');
        } else
        {
            element.removeClass('error');
            $('#addeducation').removeClass('disableClick');
            $('input[type="submit"]').removeAttr('disabled', 'disabled');
        }
    });


    $(document).on("change", ".checkCourse", function (e) {
        //$('.in_year').change(function(e){
        // console.log('from edit');
        var courseValue = $(this).val();
        // alert(courseValue);
        var count = $(this).attr("data-value");
//       / alert(count);
        if (courseValue) {
            $("#loader1").show();
            $.ajax({
                type: "POST",
                url: "<?php echo HTTP_PATH; ?>/candidates/getSpecialization/" + courseValue + "/" + count,
                cache: false,
                success: function (responseText) {
                    $("#loader1").hide();
                    //alert(responseText);
                    if (responseText !== '') {
                        $("#spical" + count).html(responseText);
                    } else {
                        $("#spical" + count).html('');
                    }

                }
            });
        }
    });



</script>
<style>
    .error { color:red; /*border: 1px solid red!important;*/ }
    .already { color:green; /*border: 1px solid green!important;*/}
    .disableClick{
        pointer-events: none;
    }
</style>

<?php

?>
	<div class="my-profile-boxes" id="editEducationTab" style="display:none;">
        <div class="my-profile-boxes-top my-education-boxes-top"><h2><i><?php echo $this->Html->image('front/home/education-icon-top.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Education Information', true);?></span></h2><a href="javascript:;" class="closeEducationLNK"><i class="fa fa-close"></i>Close</a></div>
		<div class="information_cntn" style="position:inherit !important;">
			<?php echo $this->element('session_msg'); ?>
			<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'editEducation')); ?>
		   
			<div id="educationElement"  class="educationElement">
			   <?php
				if (isset($eduDetails) && !empty($eduDetails)) {
					$count = 0;
					foreach ($eduDetails as $eduDetail) {?>
						<span class="colify-title"><?php echo __d('user', 'Qualification', true);?> <?php echo $count + 1; ?></span>
						<div id="dynamic<?php echo $count; ?>" class="dynamiccc">
							<div class="form_list_education">
								<?php echo $this->Form->hidden('Education.' . $count . '.id'); ?>
							</div>

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Course Name', true);?> <span class="star_red">*</span></label>
								<div class="form_input_education qualification-select">
									<span>
									<?php echo $this->Form->input('Education.' . $count . '.basic_course_id', array('id' => 'basic_course_id' . $count, 'data-value' => $count, 'type' => 'select', 'options' => $basicCourseList, 'label' => false, 'div' => false, 'class' => "form-control checkCourse required", 'empty' => __d('user', 'Select Course', true))) ?>
									
									</span>
								</div>
								<div id="error_message<?php echo 'basic_course_id' . $count; ?>"></div>
							</div>

							<div id="specilyListBasic<?php echo $count; ?>">
								<?php
								$specialList = Classregistry::init('Specialization')->getSpecializationListByCourseId($eduDetail['Education']['basic_course_id']);
                                       
								?>
								<div id="spical<?php echo $count ?>">
									<?php if (!empty($specialList)) { ?>

										<div class="form_list_education">
											<label class="lable-acc"><?php echo __d('user', 'Specialization', true);?> <span class="star_red">*</span></label>
											<div class="form_input_education qualification-select">
												<span>
												<?php echo $this->Form->input('Education.' . $count . '.basic_specialization_id', array('type' => 'select', 'options' => $specialList, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Specialization', true))) ?>
												</span>
											</div>
										</div>

									<?php } ?>
								</div>
								<div class="form_list_education">
									<label class="lable-acc"><?php echo __d('user', 'University/Institute', true);?> <span class="star_red">*</span></label>
									<div class="form_input_education">
										<?php echo $this->Form->text('Education.' . $count . '.basic_university', array('label' => false, 'div' => false, 'class' => "form-control required",'placeholder' => __d('user', 'University/Institute', true))) ?>
									</div>
								</div>
								<?php //$year = range(date("Y"), 1950);      ?>
								<div class="form_list_education">
									<label class="lable-acc"><?php echo __d('user', 'Passed in', true);?> <span class="star_red">*</span></label>
									<div class="form_input_education qualification-select">
										<span>
										<?php echo $this->Form->input('Education.' . $count . '.basic_year', array('type' => 'select', 'options' => array_combine(range(date("Y"), 1950), range(date("Y"), 1950)), 'label' => false, 'div' => false, 'class' => "form-control required in_year", 'empty' => __d('user', 'Select Year', true))) ?>
										</span>
									</div>
								</div>



								<div class="wewa">
									<div class="wewain">
										<?php echo $this->Html->link('<i class="fa fa-trash"></i>'.__d('user', 'Remove', true), 'javascript:removeCC("' . $count . '","' . $eduDetail['Education']['id'] . '");', array('confirm' => "'".__d('user', 'Are you sure you want to delete this qualification ?', true)."'", 'escape' => false,'rel'=>'nofollow')); ?>
									</div>
								</div>

							</div>

						</div>

						<?php
						$count++;
					}
				} 
				else 
				{ ?>
					<span class="colify-title"><?php echo __d('user', 'Qualification', true);?></span><br>

					<div id="dynamic0" class="dynamiccc">

						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Course Name', true);?> <span class="star_red">*</span></label>
							<div class="form_input_education qualification-select"> 
							<span>
								<?php echo $this->Form->input('Education.0.basic_course_id', array('id' => 'basic_course_id0', 'data-value' => '0', 'type' => 'select', 'options' => $basicCourseList, 'label' => false, 'div' => false, 'class' => "form-control checkCourse required", 'empty' => __d('user', 'Select Course', true))) ?>
							</span>
							</div>

						</div>

						<div id="specilyListBasic0">
							<?php
							if (!isset($specialList)) {
								$specialList = array();
							}
							?>
							<div id="spical0">
								<div class="form_list_education">
									<label class="lable-acc"><?php echo __d('user', 'Specialization', true);?> <span class="star_red">*</span></label>
									<div class="form_input_education qualification-select"> 
									<span><?php echo $this->Form->input('Education.0.basic_specialization_id', array('type' => 'select', 'options' => $specialList, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Specialization', true))) ?></span>
									</div>
								</div>
							</div>

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'University/Institute', true);?> <span class="star_red">*</span></label>
								<div class="form_input_education qualification-select">     
								   <?php echo $this->Form->text('Education.0.basic_university', array('label' => false, 'div' => false, 'class' => "form-control required",'placeholder' => __d('user', 'University/Institute', true))) ?>
								</div>
							</div>
							<?php //$year = range(date("Y"), 1950);        ?>
							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Passed in', true);?> <span class="star_red">*</span></label>
								<div class="form_input_education qualification-select"> 
									<span ><?php echo $this->Form->input('Education.0.basic_year', array('type' => 'select', 'options' => array_combine(range(date("Y"), 1950), range(date("Y"), 1950)), 'label' => false, 'div' => false, 'class' => "form-control required in_year", 'empty' => __d('user', 'Select Year', true))) ?></span>
								</div>
							</div>
						</div>

					</div>
				<?php } ?>

			</div>

			<div class="educationElement">
				<div class="wewain-add">
					<div id="loader1" class="loader" style="display:none; left: 50%;   position:absolute"><?php echo $this->Html->image("loading.gif"); ?></div>
					<?php echo $this->Html->link(__d('user', '+ Add More', true), 'javascript:void(0);', array('id' => 'addeducation', 'class' => 'add_btn', 'escape' => false,'rel'=>'nofollow')); ?>
				</div>
			</div>

			<div class="form_lst sssss">
				<span class="rltv">
					<div class="pro_row_left">
						<?php //echo $this->Form->hidden('User.old_cv');    ?>
						<?php
						if (isset($eduDetails) && !empty($eduDetails)) {
							echo $this->Form->input('Candidate.cc', array('type' => 'hidden', 'id' => 'educationcounter', 'value' => (count($eduDetails) - 1)));
						} else {
							echo $this->Form->input('Candidate.cc', array('type' => 'hidden', 'id' => 'educationcounter', 'value' => '0'));
						}
						?>
						<?php echo $this->Form->submit(__d('user', 'Update', true), array('div' => false, 'label' => false, 'class' => 'input_btn','id'=>"updateBTNEducation")); ?>
						<?php echo $this->Html->link(__d('user', 'Cancel', true), array('controller' => 'users', 'action' => 'myaccount'), array('class' => 'input_btn rigjt', 'escape' => false,'rel'=>'nofollow')); ?>
					</div> 
				</span>
			</div>

			<?php echo $this->Form->end(); ?> 
		</div>        

	</div>
                

