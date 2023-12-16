<?php
if(!isset($ajax) && $ajax != true){
echo $this->Html->script('jquery/ui/jquery.ui.core.js');
echo $this->Html->script('jquery/ui/jquery.ui.widget.js');
echo $this->Html->script('jquery/ui/jquery.ui.position.js');
echo $this->Html->script('jquery/ui/jquery.ui.menu.js');
echo $this->Html->script('jquery/ui/jquery.ui.autocomplete.js');
echo $this->Html->css('front/themes/base/jquery.ui.all.css');
echo $this->Html->css('front/listing.css');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<?php echo $this->Html->script('jquery.validate.js');?>

<style>
    #selectedDataDisplay{
        display: inline-flex;
        flex-wrap: wrap;
    }
    #selectedDataDisplay div{
        margin: 0.25rem;
        padding: 0.25rem;
        border: 1px solid gray;
        border-radius: 5px;
    }
    .chosen-container-multi .chosen-choices{
       padding:  2px;
       border-radius:40px;
    }
</style>

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
<?php 
$this->Html->addCrumb('Jobs', '/jobs');
?>
<div class="wrapper">
    <div id="selectedDataDisplay"></div>
    <button id="removeSelectedData" class="btn btn-warning btn-sm" style="display: none;">Clear All</button>    
</div>

<div class="my_accnt" id="my_accnt">
    <?php } ?>
    <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
    $(function () {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    });
</script>
    <?php //echo $this->element('user_menu'); ?>
    <div class="account_cntn">
		<?php //echo $this->element('topbar'); ?>
        <div class="wrapper">
			<div class="my_acc">
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->element('session_msg'); ?>
						
						<section class="slider_abouts">
							<div class="search_bar_listing">
								<div class="container">
									<div class="row">
										<div class="col-lg-12">

											<div class="search-bar-inner text-center">
												<?php echo $this->Form->create("Job", array('url' => 'filterSection', 'enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'searchJob1', 'name' => 'searchJob', 'autocomplete' => 'off')); ?>  
												<?php echo $this->Form->hidden('Job.keyword'); ?>   
												<?php echo $this->Form->hidden('Job.lat'); ?>   
												<?php echo $this->Form->hidden('Job.long'); ?>
												<?php echo $this->Form->hidden('Job.location'); ?>
												<div class="searh_new_1">
													<div class="form-row">
														<div class="col-md-2">
															<div class="select-categorys">
															   <span>
															<?php 
															global $worktype;
															echo $this->Form->input('Job.work_type', array('type' => 'select', 'options' => $worktype, 'label' => false, 'div' => false, 'class' => "form-control", 'empty' => __d('user', 'Select Work Type', true)));
															?>  
															</span>
															</div>
														</div>
														<div class="col-md-2">
															<div class="select-categorys">
															   <span>
															<?php 
															global $datePostedSearchArr;
															echo $this->Form->input('Job.date_posted', array('type' => 'select', 'options' => $datePostedSearchArr, 'label' => false, 'div' => false, 'class' => "form-control", 'empty' => __d('user', 'Select Date Posted', true)));
															?>  
															</span>
															</div>
														</div>
														<!--<div class="col-md-2">
															<div class="select-categorys">
															   <span>
															   <?php //echo $this->Form->input('Job.category_id', array('type' => 'select', 'options' => $categories, 'label' => false, 'div' => false, 'class' => "placeholder form-control", 'empty' => __d('user', 'Any Category', true),'onChange' => 'updateSubCat(this.value)'));  ?>
															   </span>
															</div>
														</div>
														<div class="col-md-3">
														   <div class="select-categorys">
														   <span>
														   <?php //echo $this->Form->input('Job.subcategory_id', array('type' => 'select', 'options' => $subcategories, 'label' => false, 'div' => false,'empty' => __d('user', 'Select Job Sub Category', true), 'class' => "placeholder form-control")); //'empty' => __d('user', 'Select Job Sub Category', true) ?>
														   </span>
														   </div>
														</div>-->
														<div class="col-md-2">
															<div class="select-categorys">
														   <span>
															<?php
															global $experienceArray;
															echo $this->Form->input('Job.exp', array('type' => 'select', 'options' => $experienceArray, 'label' => false, 'div' => false, 'class' => "form-control", 'empty' => __d('user', 'Select Experienced Level', true)));
															//echo $this->Form->input('Job.location', array('type' => 'text', 'label' => false, 'div' => false, 'class' => "form-control", 'placeholder' => __d('user', 'Enter Location', true), 'id' => 'job_city')); ?>
															</span>
														   </div>  
														</div>
														<div class="col-md-2">
                                                            <?php 
                                                                echo $this->Form->input('Job.company_name', array('type' => 'select','options' => $companyoption_dd,  'label' => false, 'div' => false, 'class' => "form-control multiple-checkboxes", 'multiple' => true,'data-placeholder' => __d('user', 'Select Company', true)));
                                                                ?>  
														</div>

                                                        <div class="col-md-2">
                                                            <span>
                                                                <?php 
                                                                // echo $this->Form->input('Job.skill', array('type' => 'select', 'options' => $skillList, 'label' => false, 'div' => false, 'class' => "form-control multiple-checkboxes", 'multiple' => true, 'data-placeholder' => __d('user', 'Select Skills', true)));
                                                                ?>  
                                                            </span>
                                                          
                                                            <div  class="rel_Skills">
                                                                <?php echo $this->Form->select('Job.skill', $skillList, array('multiple' => true, 'data-placeholder' => __d('user', 'Choose Skills', true), 'class' => "chosen-select")); ?>
                                                            </div>
                                                           
														</div>
                                                        <div class="col-md-1">
                                                            <span>
                                                                <?php 
                                                                $work_from_options = array('Onsite' => 'Onsite', "Remote" => 'Remote', "Hybrid" => 'Hybrid' );
                                                                echo $this->Form->input('Job.work_place_type', array('type' => 'select', 'options' => $work_from_options, 'label' => false, 'div' => false, 'class' => "form-control multiple-checkboxes", 'multiple' => true, 'data-placeholder' => __d('user', 'Work From', true)));
                                                                ?>  
                                                            </span>
                                                           
														</div>

														<div class="col-md-1">
                                                            <span>
                                                                <?php 
                                                                echo $this->Form->input('Job.job_city', array('type' => 'select', 'options' => $distinctJobCities, 'label' => false, 'div' => false, 'class' => "form-control multiple-checkboxes", 'multiple' => true, 'data-placeholder' => __d('user', 'Location', true)));
                                                                ?>  
                                                            </span>
															<!-- <div class="sr_butn">
																<div id="loaderID" style="display:none;position:absolute;"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
																<?php echo $this->Ajax->submit(__d('user', 'Search', true), array('div' => false, 'url' => array('controller' => 'jobs', 'action' => 'listing'), 'update' => 'my_accnt', 'indicator' => 'loaderID', 'class' => 'currant-upplan pdf-btn')); ?>
															</div> -->
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
						<div class="messaging" id="filterSection">
							<?php echo $this->element('jobs/listing'); ?>
						</div>
		
					</div>
				</div>
		
						
				
			</div>
		</div>
	</div>

    <?php if(!isset($ajax) && $ajax != true){ ?>
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

    <!------------------------------filter starts left side------------------------------------------>
    
    
<style type="text/css">

</style>


<script type="text/javascript">

	$('body').on('change', '#searchJob1', function(e){
        updateSelectedDataDisplay();
        
        $.ajax({
            async:true, 
            type:'post', 
            beforeSend:function(request) {$('#loaderID').show();}, 
            complete:function(request, json) {
                $('#my_accnt').html(request.responseText); 
                $('#loaderID').hide();
            }, 
            url: '<?= HTTP_PATH ?>/jobs/listing', 
            data:$('#searchJob1').serialize()
        }); 
    });
	
    function updateSelectedDataDisplay(){
        var selectedData = [];
            // Get selected values from various form elements
            var workType = ($('#JobWorkType option:selected').val() !== "")? $('#JobWorkType option:selected').text() : "";
            var datePosted = ($('#JobDatePosted option:selected').val() !== "")? $('#JobDatePosted option:selected').text() : "";
            var exp = ($('#JobExp option:selected').val() !== "")? $('#JobExp option:selected').text() : "";
            var companyNames = $('#JobCompanyName option:selected').map(function() {
                return $(this).text();
            }).get().join(', ');
            var skills = $('#JobSkill option:selected').map(function() {
                return $(this).text();
            }).get().join(', ');
            var jobCities = $('#JobJobCity option:selected').map(function() {
                return $(this).text();
            }).get().join(', ');
           
            let selectedWorkTypeElement = createSelectedElement(workType, "Work Type", "JobWorkType");
            let selectedDatePostedElement = createSelectedElement(datePosted, "Date Posted", "JobDatePosted");
            let selectedExperianceElement = createSelectedElement(exp, "Experience", "JobExp");
            let selectedcompanyElement = createSelectedElement(companyNames, "Company Names", "JobCompanyName");
            let selectedSkillsElement = createSelectedElement(skills, "Skills", "JobSkill");
            let selectedCitiesElement = createSelectedElement(jobCities, "Locations", "JobJobCity");

            const wrapperElement = $("<div>");
            wrapperElement.append(selectedWorkTypeElement, selectedDatePostedElement,selectedExperianceElement,selectedcompanyElement,selectedSkillsElement,selectedCitiesElement);
            $('#selectedDataDisplay').html(wrapperElement.html());
           
            if ($("#selectedDataDisplay").html() == "") {
                $('#removeSelectedData').hide();
            } else {
                $('#removeSelectedData').show();
            }
    }

    function createSelectedElement(value, label, selectId) {
        let selectedElement = '';
        if (value) {
            selectedElement = $("<div>").addClass(`selected-${selectId}`).text(`${label}: ${value} `);

            const removeButtonImage = $("<img>").attr("src", "<?= HTTP_IMAGE ?>/close.png");
            const removeSelectedButton = $("<button>").append(removeButtonImage);

            selectedElement.append(removeSelectedButton);
        }
        return selectedElement;
    }

    $('#selectedDataDisplay').on('click', 'button', function() {
        const selectId = $(this).closest('div').attr('class').split('-')[1];
        //$(`#${selectId}`).prop('selectedIndex', 0);
        $(`#${selectId}`).val('');
        $('#JobWorkType').change();

        $(this).closest('div').remove();
    });

    $('#removeSelectedData').click(function() {
        $('#JobWorkType, #JobDatePosted, #JobExp, #JobCompanyName, #JobSkill, #JobJobCity').val('');
        $('#JobWorkType').change();
    });
	
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
						$("#jobchatList"+jobId+" span.chat_date a").removeClass('leftjobsave');
						$("#jobchatList"+jobId+" span.chat_date a").addClass('leftjobunsave');
						$("#jobchatList"+jobId+" span.chat_date a").html('<i class="fa fa-star"></i>');
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
						$("#jobchatList"+jobId+" span.chat_date a").removeClass('leftjobunsave');
						$("#jobchatList"+jobId+" span.chat_date a").addClass('leftjobsave');
						$("#jobchatList"+jobId+" span.chat_date a").html('<i class="fa fa-star-o"></i>');
					})
					
				}
			}
		});
		
	});
	$('body').on('click', '.leftjobsave', function(e){
	
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
						saveJobReference.removeClass('leftjobsave');
						saveJobReference.addClass('leftjobunsave');
						saveJobReference.html('<i class="fa fa-star"></i>');
						$('.leftjoblis [data-jobid=' + jobId + ']').click();
						 $(".msg_history").scrollTop(0);
						//$(".leftjoblis").click();
					})
					
				}
			}
		});
		
	});
	$('body').on('click', '.leftjobunsave', function(e){
		
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
						saveJobReference.removeClass('leftjobunsave');
						saveJobReference.addClass('leftjobsave');
						saveJobReference.html('<i class="fa fa-star-o"></i>');
						$('.leftjoblis [data-jobid=' + jobId + ']').click();
						$(".msg_history").scrollTop(0);
					})
					
				}
			}
		});
		
	});
	$('body').on('click', '.upgradePlanBtn', function(e){
		var jobId = $(this).attr('data-jobId');
		var jobSlug = $(this).attr('data-jobSlug');
		$.ajax({
			type: "POST",
			url: "<?php echo HTTP_PATH . "/plans/ajaxPlan" ?>",
			data:'jobId='+jobId+'&jobSlug='+jobSlug+'&page=listing',
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

<?php } ?>

<script type="text/javascript">
	
    $(document).ready(function() {

        $('.multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
          maxHeight: 200,
          dropUp: true
        });

    });
</script>