<script>
//    $(document).on("change", ".upperyear", function (e) {
//
//                var opt = '';
//        var i = '';
//        var upperValue = $(this).val();
//        var count = $(this).attr("data-value");
//        var currentYear = new Date().getFullYear()
//        //alert(upperValue);
//        //alert(count);
//        for (i = upperValue; i <= currentYear; i++)
//        {
//            opt += '<option value="' + i + '">' + i + '</option>';
//        }
//        console.log(opt);
//        $(".loweryear" + count).append(opt);
//    });
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
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php
$monthNums = range(1, 12);
foreach ($monthNums as $monthNum) {
    $dateObj = DateTime::createFromFormat('!m', $monthNum);
    $month[$dateObj->format('F')] = $dateObj->format('F');
}
?>
<div id="dynamic<?php echo $cc; ?>" class="dynamiccc">
    <span class="colify-title"><?php echo __d('user', 'Add Another Experience', true);?></span> 

    <div class="form_list_education">
       <label class="lable-acc"><?php echo __d('user', 'Industry', true);?> <span class="star_red">*</span></label>
       <div class="form_input_education"> 
            <?php echo $this->Form->text('Experience.' . $cc . '.industry', array('label' => false, 'div' => false, 'class' => "form-control required",'placeholder'=>__d('user', 'Industry', true))) ?>
            <?php echo __d('user', 'Please do not use abbreviations or short-forms', true);?>
       </div>

    </div>
    <div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Functional Area', true);?> </label>
        <div class="form_input_education"> 
            <?php echo $this->Form->text('Experience.' . $cc . '.functional_area', array('label' => false, 'div' => false, 'class' => "form-control",'placeholder'=>__d('user', 'Functional Area', true))) ?>
            <?php echo __d('user', 'Please do not use abbreviations or short-forms', true);?>
        </div>
    </div>
    <div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Role', true);?> <span class="star_red">*</span></label>
        <div class="form_input_education"> 
            <?php echo $this->Form->text('Experience.' . $cc . '.role', array('label' => false, 'div' => false, 'class' => "form-control required",'placeholder'=>__d('user', 'Role', true))) ?>
        </div>
    </div>

    <div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Company Name', true);?> <span class="star_red">*</span></label>
        <div class="form_input_education"> 
            <?php echo $this->Form->text('Experience.' . $cc . '.company_name', array('label' => false, 'div' => false, 'class' => "form-control required",'placeholder'=>__d('user', 'Company Name', true))) ?>
        </div>
    </div>

	<div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Designation', true); ?> <div class="star_red">*</div></label>
        <div id="cust_skl" class="form_input_education rel_Skills" >
            <?php echo $this->Form->select('Experience.' . $cc . '.designation', $designationList, array('data-placeholder' => __d('user', 'Choose a designation', true), 'class' => "form-control select2 required select-designation",'data-type' => 'Designation')); ?>
            <label id="skillss1"></label>
        </div>
    </div>
	<div class="form_input_education">
		<?php echo $this->Form->checkbox('Experience.' . $cc . '.current_company', array('class' => "required",'id'=>'checkboxG'.$cc,'class'=>'css-checkbox current_company','data-resultIndex'=> $cc)); ?>
		<label for="checkboxG<?php echo $cc;?>" style="display:inline-block !important;font-size: 16px;font-weight: 300;color: #737373;">I am currently working in this role</label>
	</div>
	<br /><br />
    <div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Duration', true);?> <span class="star_red">*</span></label>
        <span id="duration<?php echo $cc ?>" class="form_input_education rltv1 expDuration">  
            <div class="row">
                <div class="col-sm-6 col-xs-12">    
                    <div class="qualification-select">
                     <span>
                    <?php
                    global $monthName;

                    echo $this->Form->input('Experience.' . $cc . '.from_month', array('id' => 'fromMonth' . $cc, 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(' . $cc . ')'))
                    ?>
                     </span>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12"> 
                    <div class="qualification-select">
                     <span>
                    <?php echo $this->Form->input('Experience.' . $cc . '.from_year', array('data-value' => $cc, 'type' => 'select', 'options' => array_combine(range(date("Y"), 1950), range(date("Y"), 1950)), 'label' => false, 'div' => false, 'class' => "form-control upperyear required", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(' . $cc . ')')) ?>
                     </span>
                    </div>
                </div>
				<div class="row col-sm-12 col-xs-12 text-center" id="showEndDuration<?php echo $cc;?>">
					<div class="col-sm-12 col-xs-12 text-center">    
						<b><?php echo __d('user', 'TO', true);?></b>
					</div>
					<div class="col-sm-6 col-xs-12">   
						<div class="qualification-select">
						 <span>
						<?php
						global $monthName;
						echo $this->Form->input('Experience.' . $cc . '.to_month', array('id' => 'toMonth' . $cc, 'type' => 'select', 'options' => $monthName, 'label' => false, 'div' => false, 'class' => "form-control required", 'empty' => __d('user', 'Select Month', true), 'onchange' => 'removeError(' . $cc . ')'))
						?>
						 </span>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 loweryeardiv">    
						<div class="qualification-select">
						 <span>
						<?php //echo $this->Form->input('Experience.' . $cc . '.to_year', array('type' => 'select', 'label' => false, 'div' => false, 'class' => "loweryear required", 'empty' => 'Select Year')) ?>
						<?php
						if (isset($expDetail['Experience']['to_year']) && !empty($expDetail['Experience']['to_year'])) {
							$option = array();
							$curYear = date("Y");
							for ($i = $expDetail['Experience']['to_year']; $i < $curYear; $i++) {
								$option[$i] = $i;
							}
						} else {
							$option = array();
						}
						echo $this->Form->input('Experience.' . $cc . '.to_year', array('data-value' => $cc, 'options' => $option, 'type' => 'select', 'label' => false, 'div' => false, 'class' => "form-control loweryear$cc required", 'empty' => __d('user', 'Select Year', true), 'onchange' => 'removeError(' . $cc . ')'))
						?>
						 </span>
						</div>
					</div>
				</div>
                <div id="durError<?php echo $cc ?>" class="col-sm-12 col-xs-12" style="color:#f3665c;">    

                </div>
            </div>
        </span>

    </div>

    <div class="form_list_education">
        <label class="lable-acc"><?php echo __d('user', 'Job Profile', true);?></label>
        <div class="form_input_education">                                     
            <?php echo $this->Form->input('Experience.' . $cc . '.job_profile', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => "form-control",'placeholder'=>__d('user', 'Job Profile', true))) ?>

        </div>
    </div>

    <div class="wewa">
        <div class="wewain">
            <?php echo $this->Html->link('<i class="fa fa-trash"></i>'.__d('user', 'Remove', true), 'javascript:removeCC("' . $cc . '");', array('confirm' => 'Are you sure you want to delete this row ?', 'escape' => false,'rel'=>'nofollow')); ?>
        </div>
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
                
                postData = { "data[Skill][name]" : e.params.data.text, "data[Skill][type]":type };
                postUrl = "<?php echo HTTP_PATH . "/skills/add" ?>";
                
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
                                $select.find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+ response.name +'">'+ response.name +'</option>');
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