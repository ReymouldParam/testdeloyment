<?php //echo $this->Html->script('jquery/jquery.pstrength-min.1.2.js');          ?>
<?php
    if($this->Session->check('deactivated_user') && !empty($_SESSION['deactivated_user'])){
    ?>
<link href='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.min.css' rel='stylesheet'>
<script src='<?php echo HTTP_PATH; ?>/sweetalert2/dist/sweetalert2.all.min.js'></script> 
<script type="text/javascript">

    Swal.fire({
        title: "Your account has been deactivated!",
        html: 'Do you want to create a new account or activate the existing account?',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "New Account",
        cancelButtonText: "Activate Existing Account"
        }).then((result) => {
        if (result.value) {
            window.location.href = '<?= HTTP_PATH ?>/users/recreate-account';
        } else {
            window.location.href = '<?= HTTP_PATH ?>/users/reactive-account';
        }
    });

</script>

   <?php }        
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $.validator.addMethod("email", function (value, element) {
            return  this.optional(element) || (/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s+)?$/.test(value));
        }, "<?php echo __d('user', 'Email Address is not valid', true); ?>");

        jQuery("#userlogin1").validate();
    });
</script>
<section class="slider_abouts">
    <div class="breadcrumb-container">
       <nav class="breadcrumbs page-width breadcrumbs-empty">
            <h3 class="head-title" style="text-transform:none !important;"><?php echo __d('user', 'Sign in', true); ?></h3>
            <a href="<?php echo $this->Html->url(array("controller" => "homes", "action" => 'index','')); ?>" title="Back to the frontpage"><?php echo __d('user', 'Home', true) ?></a>
            <span class="divider">/</span>
            <span> <?php echo __d('home', 'Login', true) ?> </span>
        </nav>
    </div>
</section>
<section class="login">
    <div class="login-form-area pb-100 pt-100">
        <div class="container">
            <div class="use">
                <div class="content login_cnter">
<!--                    <div class="upper_hd_dv">  
                        <?php //echo __d('user', 'Jobseeker Sign In', true); ?>
                    </div>-->
                    <div class="login_form_container">
                        <?php echo $this->element('session_msg'); ?>
                        <?php // echo $this->Session->flash(); ?>
                        <!--------social starts------------>
                        <?php
                        $displaySocial = '';

                        $para['0'] = 'jobseeker';
                        $userType = 'candidate';

                        if (isset($para['0']) && !empty($para['0']) && $para['0'] == 'jobseeker') {
                            $displaySocial = 'block';
                        } else {
                            $displaySocial = 'none';
                        }
                        ?>
                       
                        <!--------social ends------------>
                        <div class="login-form form-bg">
                            <h3><?php echo __d('home', 'Login', true) ?></h3>
                            <?php echo $this->Form->create(Null, array('class' => 'cssForm', 'name' => 'userlogin', 'id' => 'userlogin1')); ?>
                            <div class="form_contnrd">
                                <?php // echo $this->element('session_msg'); ?>
                                <?php // echo $this->Session->flash(); ?>
                                <?php if ($this->Session->read('resend_link')) { ?>
                                    <div class="resend_act"><?php echo $this->Html->link(__d('user', 'Click here', true), array('controller' => 'users', 'action' => 'resendEmail'), array()); ?> <?php echo __d('user', 'to resend activation email', true); ?>.</div>
                                <?php }
                                ?>
                                <div class="form_lst">
                                    
                                    <div class="rltv">
                                        <div class="info-field">
                                            <?php echo $this->Form->text('User.email_address', array('class' => "required email form-control", 'placeholder' => __d('user', 'Email Address', true))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_lst">
                                   
                                    <div class="rltv">
                                        <div class="info-field">
                                            <?php echo $this->Form->password('User.password', array('class' => "required form-control", 'id' => "password", 'placeholder' => __d('user', 'Password', true))); ?>
                                            <i class="fa fa-lg fa-eye" style="margin-left: -10%;display:inline; vertical-align: middle" id="togglePassword"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($this->Session->read('Userloginstatus') > 1) { ?>
                                    <div class="form_lst captcha dotno">
                                       
                                        <div class="rltv">
                                            <div class="captcha_img">
                                                <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'captcha'), true), array('style' => '', 'id' => 'captcha', 'vspace' => 2)); ?>
                                                <a href="javascript:void(0);" onclick="document.getElementById('captcha').src = '<?php echo $this->Html->url('/users/captcha'); ?>?' + Math.round(Math.random(0) * 1000) + 1" title='Change Text'>
                                                    <?php echo $this->Html->image('front/captcha_refresh.gif'); ?></a>
                                            </div>
                                            <div class="login_input login_input_shwow">
                                                <div id="customer_captcha_wrap" class="input_bx lonin box_relative">

                                                    <?php echo $this->Form->text('User.captcha', array('autocomplete' => 'off', 'id' => 'user_password', 'class' => "required", 'placeholder' => __d('user', 'Security Code', true))); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>   
                                <div class="form_lst dotno">
                                
                                    <span class="rmmr_me">
                                        <div class="checkbox2">
                                            <?php
                                            $checked = '';
                                            if (isset($_COOKIE["cookname"]) && isset($_COOKIE["cookpass"])) {
                                                $checked = 'checked';
                                            }
                                            echo $this->Form->checkbox('User.rememberme', array('class' => 'css-checkbox', 'id' => 'checkboxG1', $checked));
                                            ?>
                                            <label for="checkboxG1" ><?php echo __d('user', 'Remember me', true); ?></label>
                                        </div> 
                                    </span>
<!--                                <span class="fg_lk" data-toggle="modal" data-target="#forgotpassword">
                                    <?php //echo $this->Html->link('Forgot your password?', array('controller' => 'users', 'action' => 'forgotPassword'), array('escape' => false,'rel'=>'nofollow')); ?>
                                    <a class="" onclick="offpop()">Forgot your password?</a>
                                </span>-->
                                    <span class="fg_lk" data-toggle="modal">
                                        <?php echo $this->Html->link(__d('user', 'Forgot your password?', true), array('controller' => 'users', 'action' => 'forgotPassword'), array('escape' => false, 'rel' => 'nofollow')); ?>
                                        <!--                                    <a class="" onclick="offpop()">Forgot your password?</a>-->
                                    </span>
                                </div>
                                <div class="form_lst dotno">
                                    <div class="btn-green login-buttons curtainup mb-1 mt-2">
                                        <?php echo $this->Form->hidden('User.user_type', array('value' => "candidate", 'id' => "user_type", 'placeholder' => 'Password')); ?>
                                        <?php echo $this->Form->submit(__d('user', 'Login', true), array('div' => false, 'label' => false, 'class' => 'btn_same btn btn-primary')); ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
							<div class="row_defaultt">
                                <div class="col_devide_full reun_takine">
									<a class="btn btn-default google" href="<?php echo $googleLoginUrl; ?>"> <i class="fa fa-google-plus modal-icons"></i> Sign in with Google </a>
									<?php echo $this->Html->link('<i class="fa fa-linkedin modal-icons"></i> Sign in with Linkedin', array('controller' => 'users', 'action' => 'linkedinlogin'), array('class' => 'btn btn-default google', 'escape' => false)); ?>
									
									
								</div>
                            </div>
							<div class="row_defaultt">
                                    <div class="col_devide_full reun_takine">
                                        <?php
										$site_title = $this->requestAction(array('controller' => 'App', 'action' => 'getSiteConstant', 'title'));
											echo __d('user', 'New to ', true) . ' ' . $site_title;
										?>
										<?php echo $this->Html->link('Join Now', array('controller' => 'users', 'action' => 'signup'), array('class' => 'term_cond link_color', 'escape' => false)); ?>
										
                                          
                                    </div>
                                </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const togglePassword =  document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
  
    togglePassword.addEventListener('click', function (e) {
        // Toggle the type attribute
        const type = password.getAttribute(
            'type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // Toggle the eye slash icon
       if($("#togglePassword").hasClass("fa-eye")){
           $("#togglePassword").removeClass("fa-eye").addClass("fa-eye-slash");
       }
       else{
            $("#togglePassword").removeClass("fa-eye-slash").addClass("fa-eye");
       }
    });
</script>
