<?php
unset($this->request->data['User']['email_address']);
unset($this->request->data['User']['email_otp']);
?>

<div class="my-profile-boxes info_dv_esdit_pre" id="editEmpVerficationTab" style="display:none;">
	<div class="my-profile-boxes-top my-education-boxes"><h2><i><?php echo $this->Html->image('front/home/edit-icon2.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Employment Verification', true); ?></span></h2> <a href="javascript:;" class="closeEmpVerficationLNK"><i class="fa fa-close"></i>Close</a></div>
	<div class="information_cntn" style="position:inherit !important;">
		<div class="container">
												<div class="row">
													<div class="col-sm-12">
														<p class="mb-3"><b>Verifying your employment will provide an opportunity to earn credits during job posting’. You can verify your current employment using one of the below options:</b></p>
														
														
													</div>
													<div class="col-sm-12 mb-3 mt-3" id="optionDiv1">
														<label class="radio-inline">
														  <input type="radio" name="optradio" onclick="showEmail1();" id="radio_1" checked> Email
														</label>
														<label class="radio-inline">
														  <input type="radio" name="optradio" onclick="showDocument1();" id="radio_2"> Official Document
														</label>
														
														<div class="form_list_education mt-5" id="emailDiv1">
															
															
															<div class="form_input_education" id="emailemployeeDiv1">
																<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'empEmailVerfication1', 'class' => "form_trl_box_show2", 'name' => 'empEmailVerfication1')); ?>
																<label class="lable-acc"><?php echo __d('user', 'Email Address', true); ?> <span class="star_red">*</span></label>
																<?php echo $this->Form->text('User.email_address', array('class' => "email form-control", 'placeholder' => __d('user', 'Email Address', true))) ?>
																<?php echo $this->Form->submit(__d('user', 'Submit', true), array('div' => false, 'label' => false,'class' => 'input_btn emailempSubmit mt-4')); ?>
																</form>
															</div>
															<div class="form_input_education" id="otpemployeeDiv1" style="display:none;">
															<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'empEmailOTPVerfication', 'class' => "form_trl_box_show2", 'name' => 'empEmailVerfication')); ?>
															<label class="lable-acc"><?php echo __d('user', 'OTP', true); ?> <span class="star_red">*</span></label>
																<?php echo $this->Form->text('User.email_otp', array('class' => "form-control", 'placeholder' => __d('user', 'OTP', true))) ?>
															<?php echo $this->Form->submit(__d('user', 'Submit', true), array('div' => false, 'label' => false,'class' => 'input_btn emailempSubmit mt-4')); ?>
															</form>
															</div>
															<br /><br />
															
														</div>
														<div class="form_list_education mt-5" id="documentDiv1" style="display:none;">
															<?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'empDocVerfication1', 'class' => "form_trl_box_show2", 'name' => 'empEmailVerfication')); ?>
															<p><b>For us to verify your employment at your current organization,please upload any one of the following documents: Offer letter,Appointment letter, Corporate ID card, Any other authorised document to our firm. (Note: Uploaded document will strictly be used for validation purpose only)</b></p><br />
															<div class="form_input_education">
																<?php echo $this->Form->file('User.verification_document', array('class' =>" form-control", 'placeholder' => __d('user', 'Official Document', true))) ?>
															</div><br /><br />
															<?php echo $this->Form->submit(__d('user', 'Submit', true), array('div' => false, 'label' => false, 'class' => 'input_btn docempSubmit')); ?>
															</form>
														</div>
														
														
													</div>
												</div>
											</div>
	</div>
</div>
<style type="text/css">
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
