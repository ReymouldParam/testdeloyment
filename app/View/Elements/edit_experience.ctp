<script>
    $(document).ready(function () {
        $("#editExperience").validate();
    });
	
</script>
<style>
	.chosen-container.chosen-container-single{
		width: 100% !important;
	}
</style>

<script>

    $(document).ready(function () {

        $("#addexperience").click(function () {
            var cc = ($('#experiencecounter').val() * 1) + 1;
            $('#experiencecounter').val(cc);
            $("#loader1").show();
            $.ajax({
                type: "POST",
                url: "<?php echo HTTP_PATH; ?>/candidates/openexperience/" + cc,
                cache: false,
                success: function (responseText) {
                    $("#loader1").hide();
                    $('#experienceElement').append(responseText);
                    $("#loader1").hide();
                }
            });
        });
		
		
		
		$('.current_company').change(function(ev) {
			console.log($(this). prop("checked"));
			$(".showEndDuration").show();
			var resultIndex = $(this).attr('data-resultindex');
			if($(this). prop("checked") == true){
				$("#showEndDuration"+resultIndex).hide();
				//$('input.current_company').not(this).attr("disabled", true);
			}
			else if($(this). prop("checked") == false){
				//$('input.current_company').not(this).attr("disabled", false);
				$("#showEndDuration"+resultIndex).show();
			}
			
			$('input.current_company').not(this).prop('checked', false);
			
		
		});

    });
	
	

    function removeCC(cc, id) {
        if (id) {
            $("#loader1").show();
            $.ajax({
                type: "POST",
                url: "<?php echo HTTP_PATH; ?>/candidates/deleteexperience/" + id,
                cache: false,
                success: function (responseText) {
                    $('#dynamic' + cc).remove();
                    $("#loader1").hide();

                    window.location.href = "<?php echo HTTP_PATH; ?>/users/myaccount";
                }
            });
        } else {
            $('#dynamic' + cc).remove();
        }
    }


   

    $(document).on("change", ".upperyear", function (e) {
        var opt = '';
        var i = '';
        var upperValue = $(this).val();
        var count = $(this).attr("data-value");
        var currentYear = new Date().getFullYear();
        if (upperValue == currentYear) {
            var date_cur = new Date();
            var current_month = date_cur.getMonth();
            var fromMonth = $("#fromMonth" + count).val();
            if (current_month < fromMonth) {
                $("#fromMonth" + count).val(current_month);
                $("#toMonth" + count).val(current_month);
            }
            $("#fromMonth" + count+" > option").each(function () {
                var new_str1 = $(this).val();     
                if (parseInt(new_str1) > parseInt(current_month)) {
                    $(this).prop("disabled", true);
                }
            })
            $("#toMonth" + count+" > option").each(function () {
                var new_str1 = $(this).val();     
                if (parseInt(new_str1) > parseInt(current_month)) {
                    $(this).prop("disabled", true);
                }
            })
            
        }else{
            $("#fromMonth" + count+" > option").removeProp('disabled');
            $("#toMonth" + count+" > option").removeProp('disabled');
        }
        //alert(upperValue);
        //alert(count);
        $(".loweryear" + count).empty();

        if (upperValue !== '') {
            for (i = upperValue; i <= currentYear; i++)
            {
                opt += '<option value="' + i + '">' + i + '</option>';
            }

            //console.log(opt);
            $(".loweryear" + count).removeAttr('disabled');
            $(".loweryear" + count).append(opt);
        } else {
            opt += '<option value=""> Select Year </option>';
            $(".loweryear" + count).prop('disabled', 'disabled');
            $(".loweryear" + count).append(opt);
        }

    });

    $(document).on("change", ".loweryear_cmn", function (e) {
        var opt = '';
        var i = '';
        var upperValue = $(this).val();
        var count = $(this).attr("data-value");
        var currentYear = new Date().getFullYear();
        if (upperValue == currentYear) {
            var date_cur = new Date();
            var current_month = date_cur.getMonth();
            var fromMonth = $("#toMonth" + count).val();
            if (current_month < fromMonth) {
                $("#toMonth" + count).val(current_month);
            }
          
            $("#toMonth" + count+" > option").each(function () {
                var new_str1 = $(this).val();     
                if (parseInt(new_str1) > parseInt(current_month)) {
                    $(this).prop("disabled", true);
                }
            })
            
        }else{
            $("#toMonth" + count+" > option").removeProp('disabled');
        }

    });

    $(document).ready(function () {
        //$("#editExperience").onsubmit(function (e) {
        $("#editExperience").on("submit", function (e) {
			

            var durationData = $('.expDuration').length;
			
            for (i = 0; i < durationData; i++) {
                //  var divId = $('#expDuration'+ i).html();
                //alert(durationData);
                var fromMonth = $('#duration' + i).find('#fromMonth' + i).val();
                var fromYear = $('#duration' + i).find('#Experience' + i + 'FromYear').val();
                var toMonth = $('#duration' + i).find('#toMonth' + i).val();
                var toYear = $('#duration' + i).find('#Experience' + i + 'ToYear').val();

                //alert(fromMonth);
                //alert(fromYear);
                //alert(toMonth);
                //alert(toYear);



                var currentYear = new Date().getFullYear()
                var currentMonth = (new Date).getMonth() + 1;

                // if (fromYear == toYear) {
                if ((parseInt(fromMonth) > parseInt(toMonth)) && ((fromYear > toYear) || (fromYear == toYear))) {

                    $('#durError' + i).text("<?php echo __d('user', 'From month should be less than to month', true); ?>");

                    $('#fromMonth' + i).addClass('error');
                    $('#Experience' + i + 'FromYear').addClass('error');
                    $('#toMonth' + i).addClass('error');
                    $('#Experience' + i + 'ToYear').addClass('error');

                    e.preventDefault();
                } else if ((parseInt(fromMonth) == parseInt(toMonth)) && ((parseInt(fromYear) > parseInt(toYear)))) {

                    $('#durError' + i).text("<?php echo __d('user', 'From month should be less than to month', true); ?>");

                    $('#fromMonth' + i).addClass('error');
                    $('#Experience' + i + 'FromYear').addClass('error');
                    $('#toMonth' + i).addClass('error');
                    $('#Experience' + i + 'ToYear').addClass('error');

                    e.preventDefault();
                } else if ((parseInt(fromYear) == parseInt(currentYear)) && (parseInt(toYear) == parseInt(currentYear))) {

                    if ((parseInt(fromMonth) > parseInt(currentMonth)) || (parseInt(toMonth) > parseInt(currentMonth))) {
                        $('#durError' + i).text("<?php echo __d('user', 'Please check months, it should be less than or equal to current month if you choose current year.', true); ?>");

                        $('#fromMonth' + i).addClass('error');
                        $('#Experience' + i + 'FromYear').addClass('error');
                        $('#toMonth' + i).addClass('error');
                        $('#Experience' + i + 'ToYear').addClass('error');

                        e.preventDefault();
                    } else {
                        $('#durError' + i).empty();
                        $('#fromMonth' + i).removeClass('error');
                        $('#Experience' + i + 'FromYear').removeClass('error');
                        $('#toMonth' + i).removeClass('error');
                        $('#Experience' + i + 'ToYear').removeClass('error');
                    }

                } else if ((parseInt(fromMonth) > parseInt(currentMonth) && parseInt(fromYear) >= parseInt(currentYear)) && (parseInt(toMonth) > parseInt(currentMonth) && parseInt(toYear) <= parseInt(currentYear))) {


                    $('#durError' + i).text("<?php echo __d('user', 'Please check months, it should be less than or equal to current month if you choose current year.', true); ?>");

                    $('#fromMonth' + i).addClass('error');
                    $('#Experience' + i + 'FromYear').addClass('error');
                    $('#toMonth' + i).addClass('error');
                    $('#Experience' + i + 'ToYear').addClass('error');

                    e.preventDefault();


                } else {
                    $('#durError' + i).empty();
                    $('#fromMonth' + i).removeClass('error');
                    $('#Experience' + i + 'FromYear').removeClass('error');
                    $('#toMonth' + i).removeClass('error');
                    $('#Experience' + i + 'ToYear').removeClass('error');
                }
                //}

            }

        });

    });

    function removeError(count) {
        $('#durError' + count).text('');
        $('#fromMonth' + count).removeClass('error');
        $('#Experience' + count + 'FromYear').removeClass('error');
        $('#toMonth' + count).removeClass('error');
        $('#Experience' + count + 'ToYear').removeClass('error');
    }

</script>


<?php
$monthNums = range(1, 12);
foreach ($monthNums as $monthNum) {
    $dateObj = DateTime::createFromFormat('!m', $monthNum);
    $month[$dateObj->format('F')] = $dateObj->format('F');
}

?>


	<div class="my-profile-boxes" id="editExperienceTab" style="display:none;">
		<div class="my-profile-boxes-top my-experience-boxes-top"><h2><i><?php echo $this->Html->image('front/home/experience-icon-top.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Experience Information', true); ?></span></h2> <a href="javascript:;" class="closeExperienceLNK"><i class="fa fa-close"></i>Close</a></div>
		<div class="information_cntn" style="position:inherit !important;">
			<?php echo $this->element('session_msg'); ?>

			<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'editExperience')); ?>


			<div id="experienceElement"  class="experienceElement">

				<?php
				if (isset($expDetails) && !empty($expDetails)) {
					$count = 0;
					foreach ($expDetails as $expDetail) {
						?>
				<div class="colify-title"><?php echo __d('user', 'Experience', true); ?> <?php echo $count + 1; ?></div>

						<div id="dynamic<?php echo $count; ?>" class="dynamiccc">

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Industry', true); ?> <span class="star_red">*</span></label>
								<div class="form_input_education">
									<?php echo $this->Form->text('Experience.' . $count . '.industry', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Industry', true))) ?>
									<?php echo __d('user', 'Please do not use abbreviations or short-forms', true); ?>
								</div>

							</div>
							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Functional Area', true); ?> </label>
								<div class="form_input_education">
									<?php echo $this->Form->text('Experience.' . $count . '.functional_area', array('label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => __d('user', 'Functional Area', true))) ?>
									<?php echo __d('user', 'Please do not use abbreviations or short-forms', true); ?>
								</div>
							</div>
							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Role', true); ?> <span class="star_red">*</span></label>
								<div class="form_input_education">
									<?php echo $this->Form->text('Experience.' . $count . '.role', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Role', true))) ?>
								</div>
							</div>

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Company Name', true); ?> <span class="star_red">*</span></label>
								<div class="form_input_education">
									<?php echo $this->Form->text('Experience.' . $count . '.company_name', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Company Name', true))) ?>
								</div>
							</div>

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Designation', true); ?> <div class="star_red">*</div></label>
								<div id="cust_skl" class="form_input_education rel_Skills" >
									<?php echo $this->Form->select('Experience.'. $count .'.designation', $designationList, array('data-placeholder' => __d('user', 'Choose a designation', true), 'class' => "form-control select2",'data-type' => 'Designation')); ?>

									<label id="skillss1"></label>
								</div>
							</div>

							<div class="form_input_education">
								<?php 
								/*if($expDetail['Experience']['current_company']){
									echo $this->Form->checkbox('Experience.' . $count . '.current_company', array('class' => "required",'id'=>'checkboxG'.$count,'class'=>'css-checkbox current_company','data-resultIndex'=> $count));
								}
								else
								{
									echo $this->Form->checkbox('Experience.' . $count . '.current_company', array('class' => "required",'id'=>'checkboxG'.$count,'class'=>'css-checkbox current_company','data-resultIndex'=> $count,'disabled'=>true));
								}*/
								echo $this->Form->checkbox('Experience.' . $count . '.current_company', array('class' => "required",'id'=>'checkboxG'.$count,'class'=>'css-checkbox current_company','data-resultIndex'=> $count));
								?>
								<label for="checkboxG<?php echo $count;?>" style="display:inline-block !important;font-size: 16px;font-weight: 300;color: #737373;">I am currently working in this role</label>
							</div>
							

							<div class="form_list_education">
								<label class="lable-acc-add"><span class="lsdd-title"><?php echo __d('user', 'Duration', true); ?> <span class="star_red">*</span></span></label>

								<div id="duration<?php echo $count ?>" class="form_input_education rltv1 expDuration">  
									<div class="row">
										<div class="col-sm-6 col-xs-12">  
											<label class="lable-acc lable-acc-month">Start Month</label>
											<div class="qualification-select">
												<span>
													<?php global $monthName;?>
													<?php echo $this->Form->input('Experience.' . $count . '.from_month', array('id' => 'fromMonth' . $count, 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(' . $count . ')')) ?>
												</span>
											</div>
										</div>
										<div class="col-sm-6 col-xs-12">   
											<label class="lable-acc lable-acc-month">Start Year</label>
											<div class="qualification-select">
												<span>
													<?php echo $this->Form->input('Experience.' . $count . '.from_year', array('data-value' => $count, 'type' => 'select', 'options' => array_combine(range(date("Y"), 1950), range(date("Y"), 1950)), 'label' => false, 'div' => false, 'class' => "form-control upperyear required", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(' . $count . ')')) ?>
												</span>
											</div>
										</div>
										<?php
										$displayEndDuration="";
										if($expDetail['Experience']['current_company']){
											$displayEndDuration ='style="display:none;"';
											
										}
										?>
										<div class="row col-sm-12 col-xs-12 text-center showEndDuration" id="showEndDuration<?php echo $count;?>" <?php echo $displayEndDuration;?>>
											<div class="col-sm-12 col-xs-12 text-center">    
												<b class="totag"><?php echo __d('user', 'TO', true); ?></b>
											</div>
											<div class="col-sm-6 col-xs-12"> 
												<label class="lable-acc lable-acc-month">End Month</label>
												<div class="qualification-select">
													<span>
														<?php global $monthName;?>
														<?php echo $this->Form->input('Experience.' . $count . '.to_month', array('id' => 'toMonth' . $count, 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(' . $count . ')')) ?>
													</span>
												</div>
											</div>
											<div class="col-sm-6 col-xs-12 loweryeardiv">
												<label class="lable-acc lable-acc-month">End Year</label>
												<div class="qualification-select">
													<span>
														
														<?php
														if (isset($expDetail['Experience']['to_year']) && !empty($expDetail['Experience']['to_year'])) {
															$option = array();
															$curYear = date("Y");
															for ($i = $expDetail['Experience']['to_year']; $i <= $curYear; $i++) {
																$option[$i] = $i;
															}
														} else {
															$option = array();
														}
														echo $this->Form->input('Experience.' . $count . '.to_year', array('data-value' => $count, 'options' => $option, 'type' => 'select', 'label' => false, 'div' => false, 'class' => "form-control loweryear_cmn loweryear$count", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(' . $count . ')'))
														?>
													</span>
												</div>
											</div>
										</div>
										<div id="durError<?php echo $count ?>" class="col-sm-12 col-xs-12" style="color:#f3665c;">    

										</div>


									</div>
								</div>

							</div>

							<div class="form_list_education">
								<label class="lable-acc"><?php echo __d('user', 'Job Profile', true); ?></label>
								<div class="form_input_education">                                   
									<?php echo $this->Form->input('Experience.' . $count . '.job_profile', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => 'Job Profile')) ?>
								</div>
							</div>
							<?php echo $this->Form->hidden('Experience.' . $count . '.id'); ?>
							<div class="wewa">
								<div class="wewain">
									<?php echo $this->Html->link('<i class="fa fa-trash"></i>'.__d('user', 'Remove', true), 'javascript:removeCC("' . $count . '","' . $expDetail['Experience']['id'] . '");', array('confirm' => __d('user', 'Are you sure you want to delete this row ?', true), 'escape' => false, 'rel' => 'nofollow')); ?>
								</div>
							</div>


						</div>
						<?php
						$count++;
					}
					?>
				<?php } else { ?>

					<div id="dynamic0" class="dynamiccc">
						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Industry', true); ?> <span class="star_red">*</span></label>
							<div class="form_input_education"> 
								<?php echo $this->Form->text('Experience.0.industry', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Industry', true))) ?>
								<?php echo __d('user', 'Please do not use abbreviations or short-forms', true); ?>
							</div>

						</div>
						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Functional Area', true); ?> </label>
							<div class="form_input_education"> 
								<?php echo $this->Form->text('Experience.0.functional_area', array('label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => __d('user', 'Functional Area', true))) ?>
								<?php echo __d('user', 'Please do not use abbreviations or short-forms', true); ?>
							</div>
						</div>
						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Role', true); ?> <span class="star_red">*</span></label>
							<div class="form_input_education"> 
								<?php echo $this->Form->text('Experience.0.role', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Role', true))) ?>
							</div>
						</div>

						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Company Name', true); ?> <span class="star_red">*</span></label>
							<div class="form_input_education"> 
								<?php echo $this->Form->text('Experience.0.company_name', array('label' => false, 'div' => false, 'class' => "form-control required", 'placeholder' => __d('user', 'Company Name', true))) ?>
							</div>
						</div>

						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Designation', true); ?> <div class="star_red">*</div></label>
							<div id="cust_skl" class="form_input_education rel_Skills" >
								<?php echo $this->Form->select('Experience.0.designation', $designationList, array('data-placeholder' => __d('user', 'Choose a designation', true), 'class' => "form-control select2",'data-type' => 'Designation')); ?>
								<label id="skillss1"></label>
							</div>
						</div>
						<div class="form_input_education">
							<?php 
							
							echo $this->Form->checkbox('Experience.0.current_company', array('class' => "required",'id'=>'checkboxG09','class'=>'css-checkbox current_company','data-resultIndex'=> 0)); ?>
							<label for="checkboxG0" style="display:inline-block !important;font-size: 16px;font-weight: 300;color: #737373;">I am currently working in this role</label>
						</div>

						<div class="form_list_education">
							<label class="lable-acc-add"><span class="lsdd-title"><?php echo __d('user', 'Duration', true); ?></span></label>
							<span id="duration0" class="form_input_education rltv1 expDuration">  
								<div class="row">
									<div class="col-sm-6 col-xs-12">  
										<label class="lable-acc lable-acc-month">Start Month</label>
										<div class="qualification-select">
										<span>
										<?php
										global $monthName;
										echo $this->Form->input('Experience.0.from_month', array('id' => 'fromMonth0', 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(0)'))
										?>
										</span>
									</div>
									</div>
									<div class="col-sm-6 col-xs-12"> 
										<label class="lable-acc lable-acc-month">Start Year</label>
										<div class="qualification-select">
										<span>
										<?php echo $this->Form->input('Experience.0.from_year', array('data-value' => '0', 'type' => 'select', 'options' => array_combine(range(date("Y"), 1950), range(date("Y"), 1950)), 'label' => false, 'div' => false, 'class' => "form-control upperyear required", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(0)')) ?>
										</span>
										</div>
									</div>
									<div class="row col-sm-12 col-xs-12 text-center" id="showEndDuration0">
										<div class="col-sm-12 col-xs-12 text-center">    
											<b class="totag"><?php echo __d('user', 'TO', true); ?></b>
										</div>
										<div class="col-sm-6 col-xs-12"> 
											<label class="lable-acc lable-acc-month">End Month</label>
											<div class="qualification-select">
											<span>
											<?php
											global $monthName;

											echo $this->Form->input('Experience.0.to_month', array('id' => 'toMonth0', 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(0)'))
											?>
											</span>
											</div>
										</div>
										<div class="col-sm-6 col-xs-12 loweryeardiv">
											<label class="lable-acc lable-acc-month">End Year</label>
											<div class="qualification-select">
											<span>
											<?php echo $this->Form->input('Experience.0.to_year', array('data-value' => '0', 'type' => 'select', 'label' => false, 'div' => false, 'class' => "form-control loweryear0 required", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(0)')) ?>
											</span>
											</div>
										</div>
									</div>
									<div id="durError0" class="col-sm-12 col-xs-12" style="color:#f3665c;">    

									</div>

								</div>
							</span>
						</div>

						<div class="form_list_education">
							<label class="lable-acc"><?php echo __d('user', 'Job Profile', true); ?></label>
							<div class="form_input_education">                                     
								<?php echo $this->Form->input('Experience.0.job_profile', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => __d('user', 'Job Profile', true))) ?>

							</div>
						</div>
					</div>    
				<?php } ?>



				<div class="clear"></div><br/>

			</div>
			<div class="experienceElement">
				<div class="wewain-add">
					<div id="loader1" class="loader" style="display:none; left: 50%;   position:absolute"><?php echo $this->Html->image("loading.gif"); ?></div>
					<?php echo $this->Html->link(__d('user', '+ Add More', true), 'javascript:void(0);', array('id' => 'addexperience', 'class' => 'add_btn', 'escape' => false, 'rel' => 'nofollow')); ?>
				</div>
			</div>




			<div class="form_lst sssss">
				<span class="rltv">
					<div class="pro_row_left">
						<?php //echo $this->Form->hidden('User.old_cv');   ?>
						<?php
						if (isset($expDetails) && !empty($expDetails)) {
							echo $this->Form->input('Candidate.cc', array('type' => 'hidden', 'id' => 'experiencecounter', 'value' => (count($expDetails) - 1)));
						} else {
							echo $this->Form->input('Candidate.cc', array('type' => 'hidden', 'id' => 'experiencecounter', 'value' => '0'));
						}
						?>
						<?php echo $this->Form->submit(__d('user', 'Update', true), array('div' => false, 'label' => false, 'class' => 'input_btn')); ?>
						<?php echo $this->Html->link(__d('user', 'Cancel', true), array('controller' => 'users', 'action' => 'myaccount'), array('class' => 'input_btn rigjt', 'escape' => false, 'rel' => 'nofollow')); ?>
					</div> 
				</span>
			</div>
			<?php echo $this->Form->end(); ?> 
		</div>        
	</div>

<script>
	
    $('.select2').select2({
		dropdownPosition: 'below',
        tags: true,
        createTag: function (tag) {
            return {
                id: tag.term,
                text: tag.term,
                isNew : true
            };
        }
    }).on("select2:select", function(e) {
        if(e.params.data.isNew){
			var type = $(this).data('type');
			var userConfirmed = window.confirm("Are you sure you want to save "+ e.params.data.text +" as new "+ type +"?");

			if(userConfirmed){
				var $select = $(this);
				
				if(type == 'Category'){
					postData = { "data[Category][name]" : e.params.data.text};
					postUrl = "<?php echo HTTP_PATH . "/categories/add" ?>";
				}
				else{
					postData = { "data[Skill][name]" : e.params.data.text, "data[Skill][type]":type };
					postUrl = "<?php echo HTTP_PATH . "/skills/add" ?>";
				}
				
				// store the new term
				$.ajax({
					type: "POST",
					url: postUrl, 
					data: postData,
					dataType: "json",
					success: function(response) {
						if(response.status=='error'){
							Swal.fire({
								title: "Error!",
								html: response.message,
								allowOutsideClick: true
							}).then((result) => {
								$select.find('[value="'+e.params.data.id+'"]').remove();
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
								if(type == 'Category'){
									$select.find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+ response.id +'">'+ response.name +'</option>');
								}else{
									$select.find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+ response.name +'">'+ response.name +'</option>');
								}
							})
						}
					}
				});
			}
			else{
				$(this).find('[value="'+e.params.data.id+'"]').remove();
			}
        }
    });

</script>