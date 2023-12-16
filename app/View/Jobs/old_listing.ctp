<?php
echo $this->Html->script('jquery/ui/jquery.ui.core.js');
echo $this->Html->script('jquery/ui/jquery.ui.widget.js');
echo $this->Html->script('jquery/ui/jquery.ui.position.js');
echo $this->Html->script('jquery/ui/jquery.ui.menu.js');
echo $this->Html->script('jquery/ui/jquery.ui.autocomplete.js');
echo $this->Html->css('front/themes/base/jquery.ui.all.css');

?>
<?php echo $this->Html->script('jquery.validate.js'); ?>
<style type="text/css">
.search_bar_listing{
	padding: 20px 0 !important;
}
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=false&key=<?php echo AUTO_SUGGESTION; ?>"></script> 
<script>

    var autocomplete;
    function initialize() {
        autocomplete = new google.maps.places.Autocomplete((document.getElementById('job_city')));
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress();
        });
    }
    function fillInAddress() {
        var place = autocomplete.getPlace();
        $('#JobLat').val(place.geometry.location.lat());
        $('#JobLong').val(place.geometry.location.lng());
    }
</script>
<script type="text/javascript">

    $(function () {
        var availableTags = [<?php echo ClassRegistry::init('Skill')->searchKeyword(); ?>];
        var availableDesignation = [<?php echo ClassRegistry::init('Skill')->searchKDesignation(); ?>];

        $(function () {

            function split(val) {
                return val.split(/,\s*/);
            }
            function extractLast(term) {
                return split(term).pop();
            }

            $("#JobSkill")
                    // don't navigate away from the field on tab when selecting an item
                    .bind("keydown", function (event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                                $(this).autocomplete("instance").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 1,
                        source: function (request, response) {
                            // delegate back to autocomplete, but extract the last term
                            response($.ui.autocomplete.filter(
                                    availableTags, extractLast(request.term)));
                        },
                        focus: function () {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function (event, ui) {
                            var terms = split(this.value);
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.label);

                            //$('#JobTotalSkillSearch').val(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(",");
                            return false;
                        }
                    });
            $("#JobDesignation")
                    // don't navigate away from the field on tab when selecting an item
                    .bind("keydown", function (event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                                $(this).autocomplete("instance").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 1,
                        source: function (request, response) {
                            // delegate back to autocomplete, but extract the last term
                            response($.ui.autocomplete.filter(
                                    availableDesignation, extractLast(request.term)));
                        },
                        focus: function () {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function (event, ui) {
                            var terms = split(this.value);
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.label);

                            //$('#JobTotalSkillSearch').val(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(",");
                            return false;
                        }
                    });
        });
    });



</script>
<?php
//for error issue Document Expired after back button
header("Cache-Control: max-age=300, must-revalidate");
$_SESSION['job_apply_return_url'] = $this->params->url;
?>

<script>
    function updateCity(stateId) {
        $('#loaderID').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo HTTP_PATH; ?>/jobs/getStateCity/Job/" + stateId,
            cache: false,
            success: function (result) {
                $("#updateCity").html(result);
                $('#loaderID').hide();
            }
        });
    }

      function updateSubCat(catId) {
//      alert(catId);
     if(catId){
        $('#loaderID').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo HTTP_PATH; ?>/jobs/getSubCategory/" + catId,
            cache: false,
            success: function (result) {
                $("#JobSubcategoryId").html(result);
                $('#loaderID').hide();
            }
        });
    }
    }

    function getMaxiExpList(id) {
        var opt = '';
        var i = '';
        if (id !== '') {
            for (i = id; i <= 30; i++)
            {
                opt += '<option value="' + i + '">' + i + '</option>';
            }
            $('#JobMaxExp').html(opt);
        } else {
            opt += '<option value=""><?php echo __d('user', 'Max Exp(Year)', true); ?></option>';
            $('#JobMaxExp').html(opt);
        }
    }

    function getMaxSalaryList(id) {
        var opt = ''
        id = id * 1;
        $("#JobMinSalary option").each(function ()
        {
            var ff = $(this).val() * 1;
            if (ff >= id) {
                opt += '<option value="' + ff + '"><?php echo CURRENCY; ?> ' + ff + 'K</option>';
            }
        });
        $('#JobMaxSalary').html(opt);
    }
</script>
<script type="text/javascript">

    jQuery(document).ready(function ($) {

<?php
$searchDeskeyArrCount = 0;
if (isset($searchkey) && !empty($searchkey)) {
    $searchDeskeyArr = explode("-", $searchkey);
    //$desKeyCount = '';
    foreach ($searchDeskeyArr as $key) {
        $desKeyArr = classregistry::init('Skill')->field('type', array('Skill.id' => $key));
        //pr($skillKeyArr);
        if ($desKeyArr == 'Designation') {
            $desKeyCount[] = $desKeyArr;
        }
    }

    if (!empty($desKeyCount)) {
        $searchDeskeyArrCount = count($desKeyCount);
    } else {
        $searchDeskeyArrCount = 0;
    }

    if ($searchDeskeyArrCount) {
        ?>
                var designation_checked = '<?php echo $searchDeskeyArrCount; ?>';
                var designationStr = '<?php echo $searchkey; ?>';
                var designation_arr = designationStr.split("-");
                $('#JobTotalDesignation').val(designation_checked + ' Designations selected');
                if (designation_arr) {
                    designation_arr.forEach(markDesChecked);
                }
        <?php
    }
} else {
    $searchkey = '';
}
?>

        function markDesChecked(element, index, array) {
            $('#JobDesignation' + element).attr('checked', 'checked');
        }

        // For Desgination
        $(document).mouseup(function (e)
        {
            var containerdesignation = $("#designation-dropdown");

            if (!containerdesignation.is(e.target) // if the target of the click isn't the container...
                    && containerdesignation.has(e.target).length === 0) // ... nor a descendant of the container
            {
                containerdesignation.hide();
            }
        });
        $('.test-designation').click(function () {
            var designation_checked = $(".test-designation input:checked").length;
            if (designation_checked == 0) {
                $('#JobTotalDesignation').val('<?php echo __d('user', 'All Designations', true) ?>');
            } else {
                $('#JobTotalDesignation').val(designation_checked + ' Designations selected');
            }
        });

        // For Desgination
        $(document).mouseup(function (e)
        {
            var containerdesignation = $("#worktype-dropdown");

            if (!containerdesignation.is(e.target) // if the target of the click isn't the container...
                    && containerdesignation.has(e.target).length === 0) // ... nor a descendant of the container
            {
                containerdesignation.hide();
            }
        });
        $('.test-worktype').click(function () {
            var wtype_checked = $(".test-worktype input:checked").length;
            if (wtype_checked == 0) {
                $('#JobTotalWorkType').val('<?php echo __d('user', 'All Worktype', true) ?>');
            } else {
                $('#JobTotalWorkType').val(wtype_checked + ' <?php echo __d('user', 'Worktype selected', true) ?>');
            }
        });

<?php
$searchkeyArrCount = 0;
if (isset($searchkey) && !empty($searchkey)) {

    $searchkeyArr = explode("-", $searchkey);

    foreach ($searchkeyArr as $key) {
        $skillKeyArr = classregistry::init('Skill')->field('type', array('Skill.id' => $key));
        //pr($skillKeyArr);
        if ($skillKeyArr == 'Skill') {
            $keyCount[] = $skillKeyArr;
        }
    }

    if (!empty($keyCount)) {
        $searchkeyArrCount = count($keyCount);
    } else {
        $searchkeyArrCount = 0;
    }


    if ($searchkeyArrCount) {
        ?>
                var skill_checked = '<?php echo $searchkeyArrCount; ?>';
                var skillStr = '<?php echo $searchkey; ?>';
                var skill_arr = skillStr.split("-");
                $('#JobTotalSkill').val(skill_checked + ' Skills selected');
                if (skill_arr) {
                    skill_arr.forEach(markChecked);
                }
        <?php
    }
} else {
    $searchkey = '';
}
?>
        function markChecked(element, index, array) {
            $('#JobSkill' + element).attr('checked', 'checked');
        }
        $(document).mouseup(function (e)
        {
            var containerskill = $("#skill-dropdown");

            if (!containerskill.is(e.target) // if the target of the click isn't the container...
                    && containerskill.has(e.target).length === 0) // ... nor a descendant of the container
            {
                containerskill.hide();
            }
        });
        $('.test-skill').click(function () {
            var skill_checked = $(".test-skill input:checked").length;
            if (skill_checked == 0) {
                $('#JobTotalSkill').val('All Skill');
            } else {
                $('#JobTotalSkill').val(skill_checked + ' <?php echo __d('user', 'Skills selected', true); ?>');
            }
        });


<?php
$searchLockeyArrCount = 0;
if (isset($location) && !empty($location)) {

    //pr($location);

    $searchLockeyArr = explode("-", $location);
    $searchLockeyArrCount = count($searchLockeyArr);
    if ($searchLockeyArrCount) {
        ?>
                var location_checked = '<?php echo $searchLockeyArrCount; ?>';
                var locationStr = '<?php echo $location; ?>';
                var location_arr = locationStr.split("-");
                $('#JobTotalLocation').val(location_checked + ' <?php echo __d('user', 'Locations selected', true); ?>');
                if (location_arr) {
                    location_arr.forEach(markLocChecked);
                }
        <?php
    }
} else {

    $location = '';
}
?>

        function markLocChecked(element, index, array) {
            $('#JobLocation' + element).attr('checked', 'checked');
        }
        // For Location
        $(document).mouseup(function (e)
        {
            var containerlocation = $("#location-dropdown");

            if (!containerlocation.is(e.target) // if the target of the click isn't the container...
                    && containerlocation.has(e.target).length === 0) // ... nor a descendant of the container
            {
                containerlocation.hide();
            }
        });
        $('.test-location').click(function () {

            var location_checked = $(".test-location input:checked").length;

            if (location_checked == 0) {
                $('#JobTotalLocation').val('All Locations');

            } else {
                $('#JobTotalLocation').val(location_checked + ' <?php echo __d('user', 'Locations selected', true); ?>');
            }
        });


    });

</script>
<div class="my_accnt">
    <?php //echo $this->element('user_menu'); ?>
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
				<?php echo $this->element('left_sidebar'); ?>
				<div class="col-sm-9 col-lg-9 col-xs-12">
					 <?php echo $this->element('session_msg'); ?>
					<?php
					//echo '<pre>';
					//print_r($userDetails);
					if(!empty($userDetails['User']['emp_verification_status'])){
						if(!empty($userDetails['User']['emp_verification_status']=='Pending')){?>
							<div class="col-xs-12 col-sm-12 col-lg-12 mb-5">
								<div class="float-right">
									<a href="javascript:;" rel="nofollow" class="input_btn rigjt verifyEmp">Verify Your Employment</a>
								</div>
							</div>
						<?php
						}
					}
					else
					{?>
						<div class="col-xs-12 col-sm-12 col-lg-12 mb-5">
							<div class="float-right">
								<a href="javascript:;" rel="nofollow" class="input_btn rigjt verifyEmp">Verify Your Employment</a>
							</div>
						</div>	
					<?php
					}?>
					<div class="my-profile-boxes info_dv_esdit_pre">
						<section class="slider_abouts">
							<div class="search_bar_listing">
								<!--------header search starts------------->
							 
									<div class="container">
										<div class="row">
											<div class="col-lg-12">

												<div class="search-bar-inner text-center">
													<?php echo $this->Form->create("Job", array('url' => 'filterSection', 'enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'searchJob1', 'name' => 'searchJob', 'autocomplete' => 'off')); ?>  
													<?php echo $this->Form->hidden('Job.lat'); ?>   
													<?php echo $this->Form->hidden('Job.long'); ?>
													<div class="searh_new_1">
														<div class="form-row">
															<div class="col-md-3">
															
																<?php echo $this->Form->text('Job.keyword', array('maxlength' => '255', 'label' => '', 'autocomplete' => 'off', 'data-suggesstion' => 'jobkeyword-box', 'data-search' => 'Search', 'label' => '', 'div' => false, 'class' => "keyword-box form-control", 'placeholder' => __d('user', 'Search by Keyword', true))); ?>  
																<div id="jobkeyword-box" class="common-serach-box" style="display: none"></div>
															</div>
															<div class="col-md-2">
																<div class="select-categorys">
																   <span>
																   <?php echo $this->Form->input('Job.category_id', array('type' => 'select', 'options' => $categories, 'label' => false, 'div' => false, 'class' => "placeholder form-control", 'empty' => __d('user', 'Any Category', true),'onChange' => 'updateSubCat(this.value)'));  ?>
																   </span>
																</div>
															</div>
															<div class="col-md-3">
															   <div class="select-categorys">
															   <span>
															   <?php echo $this->Form->input('Job.subcategory_id', array('type' => 'select', 'options' => $subcategories, 'label' => false, 'div' => false,'empty' => __d('user', 'Select Job Sub Category', true), 'class' => "placeholder form-control")); //'empty' => __d('user', 'Select Job Sub Category', true) ?>
															   </span>
															   </div>
															</div>
															<div class="col-md-2">
																<?php
																$locationid = "";
																if (isset($_SESSION['locationid']) && $_SESSION['locationid'] > 0) {
																	$locationid = $_SESSION['locationid'];
																}
																echo $this->Form->input('Job.location', array('type' => 'text', 'label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => __d('user', 'Enter Location', true), 'id' => 'job_city')); ?>
																  
															</div>
															<div class="col-md-2">
																<div class="sr_butn">
																	<div id="loaderID" style="display:none;position:absolute;"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
																	<?php echo $this->Ajax->submit(__d('user', 'Find Jobs', true), array('div' => false, 'url' => array('controller' => 'jobs', 'action' => 'listing'), 'update' => 'filterSection', 'indicator' => 'loaderID', 'class' => 'currant-upplan pdf-btn')); ?>
															   
																</div>
															</div>
													 
														</div>
													</div>
													<?php echo $this->Form->input('Job.created', array('type' => 'hidden', 'value' => '')); ?>
													<?php echo $this->Form->end(); ?>
												</div>
											</div>
										</div>
									</div>
								</div>

						</section> 
						<section class="jovb_list-overfellow" id="filterSection">
							<div id="myModal" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Verify Your Employment</h5>
											 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											
										   
										</div>
										<div class="modal-body">
											<div class="container">
												<div class="row">
													<div class="col-sm-12">
														<p class="mb-3"><b>Welcome to ReyferJobs. Verifying your employment will provide an opportunity to earn credits during job posting’. Would you like to verify now?</b></p>
														<button type="button" class="btn btn-secondary empbtnyesno" data-dismiss="modal">Later</button>
														<button type="button" class="btn btn-primary yesOption empbtnyesno">Yes</button>
														
													</div>
													<div class="col-sm-12 mb-3 mt-3" id="optionDiv" style="display:none;">
														<label class="radio-inline">
														  <input type="radio" name="optradio" onclick="showEmail();" id="radio_1" checked> Email
														</label>
														<label class="radio-inline">
														  <input type="radio" name="optradio" onclick="showDocument();" id="radio_2"> Official Document
														</label>
														
														<div class="form_list_education mt-5" id="emailDiv">
															
															<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'empEmailVerfication', 'class' => "form_trl_box_show2", 'name' => 'empEmailVerfication')); ?>
															<div class="form_input_education" id="emailemployeeDiv">
																<label class="lable-acc"><?php echo __d('user', 'Email Address', true); ?> <span class="star_red">*</span></label>
																<?php echo $this->Form->text('User.email_address', array('class' => "required email form-control", 'placeholder' => __d('user', 'Email Address', true))) ?>
															</div>
															<div class="form_input_education" id="otpemployeeDiv" style="display:none;">
															<label class="lable-acc"><?php echo __d('user', 'OTP', true); ?> <span class="star_red">*</span></label>
																<?php echo $this->Form->text('User.email_otp', array('class' => "required form-control", 'placeholder' => __d('user', 'OTP', true))) ?>
															</div>
															<br /><br />
															<?php echo $this->Form->submit(__d('user', 'Submit', true), array('div' => false, 'label' => false,'class' => 'input_btn emailempSubmit')); ?>
															</form>
														</div>
														<div class="form_list_education mt-5" id="documentDiv" style="display:none;">
															<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'empDocVerfication', 'class' => "form_trl_box_show2", 'name' => 'empEmailVerfication')); ?>
															<p><b>For us to verify your employment at your current organization,please upload any one of the following documents: Offer letter,Appointment letter, Corporate ID card, Any other authorised document to our firm. (Note: Uploaded document will strictly be used for validation purpose only)</b></p><br />
															<div class="form_input_education">
																<?php echo $this->Form->file('User.verification_document', array('class' => "required form-control", 'placeholder' => __d('user', 'Official Document', true))) ?>
															</div><br /><br />
															<?php echo $this->Form->submit(__d('user', 'Submit', true), array('div' => false, 'label' => false, 'class' => 'input_btn docempSubmit')); ?>
															</form>
														</div>
														
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php echo $this->element('jobs/old_listing'); ?>

						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <!------------------------------filter starts left side------------------------------------------>
    
    
<style type="text/css">

.modal-header{
	background: var(--card-background) !important;
}
.radio-inline {
  position: relative;
  display: inline-block;
  padding-right: 20px;
  margin-bottom: 0;
  font-weight: 400;
  vertical-align: middle;
  cursor: pointer;
}
</style>
<link href='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.min.css' rel='stylesheet'>
<script src='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.all.min.js'></script> 
<script type="text/javascript">
    window.onload = function () {
        initialize();
		<?php
		if(!empty($userDetails['User']['emp_verification_status'])){
			if(!empty($userDetails['User']['emp_verification_status']=='Pending')){?>
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('.empbtnyesno').show();
				$('#optionDiv').hide();
				$('#emailDiv').show();
				$("#emailemployeeDiv").show();
				$("#otpemployeeDiv").hide();
				$("#radio_1").prop("checked", true);
				$('#documentDiv').hide();
				$('#empEmailVerfication')[0].reset();
				$('#empDocVerfication')[0].reset();
				<?php
			}
		}
		else
		{?>
			$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('.empbtnyesno').show();
				$('#optionDiv').hide();
				$('#emailDiv').show();
				$("#emailemployeeDiv").show();
				$("#otpemployeeDiv").hide();
				$("#radio_1").prop("checked", true);
				$('#documentDiv').hide();
				$('#empEmailVerfication')[0].reset();
				$('#empDocVerfication')[0].reset();
		<?php
		}?>
		
	};
	$( "#myModal" ).on('shown.bs.modal', function(){
		$("#empEmailVerfication").validate();
		$('#empEmailVerfication')[0].reset();
		$('#empDocVerfication')[0].reset();
		$('.header').css({'z-index':'0'});
	});
	$( "#myModal" ).on('hidden.bs.modal', function(){
		$('.header').css({'z-index':'9999'});
	});
	$('.verifyEmp').click(function () {
		//$('#myModal').modal('show');
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('.empbtnyesno').show();
		$('#optionDiv').hide();
		$('#emailDiv').show();
		$("#emailemployeeDiv").show();
		$("#otpemployeeDiv").hide();
		$("#radio_1").prop("checked", true);
		$('#documentDiv').hide();
		$('#empEmailVerfication')[0].reset();
		$('#empDocVerfication')[0].reset();
	});
	$('.yesOption').click(function () {
		$('.empbtnyesno').hide();
		$('#optionDiv').show();
	});
	function showEmail(){
		$('#emailDiv').show();
		$('#documentDiv').hide();
		$("#emailemployeeDiv").show();
		$("#otpemployeeDiv").hide();
		
	}
	function showDocument(){
		$('#documentDiv').show();
		$('#emailDiv').hide();
	}
	
	$('#empEmailVerfication').on('submit', function(e){
        e.preventDefault();
        var dataString = $("#empEmailVerfication").serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/employeeEmailVerfication" ?>",
			data: dataString,
			dataType: "json",
			success: function(response)
			{
				console.log(response);
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
					if(response.type=='email'){
						Swal.fire({
							title: 'Success',
							html: response.message,
							allowOutsideClick: false
			
						}).then((result) => {
							$("#emailemployeeDiv").hide();
							$("#otpemployeeDiv").show();
							
						})
					}
					else
					{
						Swal.fire({
							title: 'Success',
							html: response.message,
							allowOutsideClick: false
			
						}).then((result) => {
							location.reload();
							
						})
					}
					
				}
			}
		});
    });
	
	$('#empDocVerfication').on('submit', function(e){
		 e.preventDefault();
        //var dataString = $("#empDocVerfication").serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/jobs/employeeDocumentVerfication" ?>",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
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
						location.reload();
						
					})
					
				}
			}
		});
	});	
	
</script> 