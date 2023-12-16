<?php
$site_title = $this->requestAction(array('controller' => 'App', 'action' => 'getSiteConstant', 'title'));
$site_phone = $this->requestAction(array('controller' => 'App', 'action' => 'getSiteConstant', 'phone'));
$site_info_mail = $this->requestAction(array('controller' => 'App', 'action' => 'getMailConstant', 'site_info_mail'));
$userdetail = classregistry::init('User')->find('first', array('conditions' => array('User.id' => $this->Session->read('user_id'))));

$job_alerts = ClassRegistry::init('AlertJob')->find('count', array('conditions' => array('AlertJob.view_status' => 1, 'AlertJob.user_id' => $this->Session->read('user_id'))));
?>  
<?php
if (!isset($loginA)) {
    $loginA = '';
}
if (!isset($loginB)) {
    $loginB = '';
}

if (!isset($registerA)) {
    $registerA = '';
}
if (!isset($registerB)) {
    $registerB = '';
}

if (!isset($how_it_works)) {
    $how_it_works = '';
}
if (!isset($find_a_job)) {
    $find_a_job = '';
}

if (!isset($jobs_list)) {
    $jobs_list = '';
}
if (!isset($candidates_list)) {
    $candidates_list = '';
}
if (!isset($blogs)) {
    $blogs = '';
}

if (!isset($faq_active)) {
    $faq_active = '';
}
if (!isset($homepage)) {
    $homepage = '';
}
if (!isset($about_active)) {
    $about_active = '';
}
if (!isset($contact_us)) {
    $contact_us = '';
}
?>

<?php
if ($this->Session->read('user_id')) {
    $extra_class = "";
} else {
    $extra_class = 'header_new';
}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=false&key=<?php echo AUTO_SUGGESTION; ?>"></script> 
<script>
var autocompleteTop;
   function initializeHeader() {
	   
        autocompleteTop = new google.maps.places.Autocomplete((document.getElementById('job_topcity')));
        google.maps.event.addListener(autocompleteTop, 'place_changed', function () {
            fillInAddressHeader();
        });
    }
    function fillInAddressHeader() {
        var placeTop = autocompleteTop.getPlace();
		
        $('#JobLatTop').val(placeTop.geometry.location.lat());
        $('#JobLongTop').val(placeTop.geometry.location.lng());
    }
</script>
<header>
 

    <div class="header header-inner">
          <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <div class="logo">
                        <!--<a href="javascript:void(0)"><?php echo $this->Html->image('front/logo.png',array('alt'=>'')); ?> </a>-->
                        <?php 
                        $logoImage = classRegistry::init('Admin')->field('Admin.logo', array('id' => 1));
                        // pr($logoImage);
                        if (isset($logoImage) && !empty($logoImage)) {
                            $logo = DISPLAY_FULL_WEBSITE_LOGO_PATH . $logoImage;
                        } else {
                            $logo = ' ';
                        }

                        echo $this->Html->link($this->Html->image($logo, array('alt' => $site_title, 'title' => $site_title)), '/', array('escape' => false, 'rel' => 'nofollow', 'class' => ''));
//                        ?>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-9">
                   
                       
                        <nav role="navigation" class="navbar navbar-expand-sm bg-faded navbar-light sticky-top first-nav">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button class="navbar-toggler navbar-toggler-left collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <div class="toggle position-relative">
                                        <div class="line top position-absolute"></div>
                                        <div class="line middle cross1 position-absolute"></div>
                                        <div class="line middle cross2 position-absolute"></div>
                                        <div class="line bottom position-absolute"></div>
                                    </div>
                                </button>
								
                            </div>
                            <!-- Collection of nav links and other content for toggling -->
                            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                                <ul class="navbar-nav ml-auto mr-6">
								<?php
								
								if ($this->Session->read('user_id')){?>
									<?php echo $this->Form->create("Job", array('url' => array('controller' => 'jobs', 'action' => 'listing'), "method" => "Post", 'id' => 'topSearch', 'name' => 'topSearch', 'autocomplete' => 'off','class'=>"topSearch form-inline my-2 my-lg-0")); ?>  
									<?php echo $this->Form->text('Job.keyword', array('maxlength' => '255', 'label' => '', 'autocomplete' => 'off', 'label' => false, 'div' => false, 'class' => "mr-sm-2 form-control", 'placeholder' => __d('user', 'Keyword', true))); ?>  
									<?php echo $this->Form->text('Job.location', array('maxlength' => '255', 'label' => '', 'autocomplete' => 'off', 'label' => false, 'div' => false, 'class' => "mr-sm-2 form-control",'id'=>'job_topcity', 'placeholder' => __d('user', 'Location', true))); 
									echo $this->Form->hidden('Job.lat',array("id"=>"JobLatTop")); 
									echo $this->Form->hidden('Job.long',array("id"=>"JobLongTop"));
									
									?>
									<button type="submit" class="btn" style="background:transparent;margin-top:-8px;">
									<i class="fa fa-search" style="font-size: 20px;"></i></button>
									<?php echo $this->Form->end(); ?>
									<?php
									$path = UPLOAD_FULL_PROFILE_IMAGE_PATH . $userdetail['User']['profile_image'];
									if (file_exists($path) && !empty($userdetail['User']['profile_image'])) {
										?>

										<?php
										$userProfileImage = $this->Html->image(DISPLAY_FULL_PROFILE_IMAGE_PATH . $userdetail['User']['profile_image'], array('escape' => false,'class'=>'rounded-circle'));

									} else {
										$userProfileImage = $this->Html->image('front/no_image_user.png',array('escape' => false,'class'=>'rounded-circle'));
									}
									?>
									<li class="nav-item" style="text-align:center;"> 
										<a href="<?php echo HTTP_PATH;?>/users/myaccount" class=" nav-link" style="padding-bottom:0px !important;"><?php echo $userProfileImage;?> <br> <span style="font-size:12px;text-align: center;width: 100%;">Me</span></a>											
										
                                        <?php
                                        //echo $this->Html->link(substr($userdetail['User']['first_name'],0,7), array('controller' => 'users', 'action' => 'myaccount'), array('class' => $loginA . ' nav-link','style'=>'padding-bottom:0px !important;'));
										
                                        if(($userdetail['User']['total_exp'] > 0)){
                                            if(!empty($userdetail['User']['emp_verification_status'])){
                                                if(!empty($userdetail['User']['emp_verification_status']=='Pending')){
                                            ?>
                                                <span style="font-size: 12px;text-align: center;font-family: 'Roboto', sans-serif;padding-left: 10px;padding-right: 10px;vertical-align: top;color: red;cursor: pointer;" class="verifyEmp">Verfiy now</span>
                                            <?php
                                                }
                                                else if($userdetail['User']['emp_verification_status']=='Verified')
                                                {?>
                                                    <span style="font-size: 12px;text-align: center;font-family: 'Roboto', sans-serif;padding-left: 10px;padding-right: 10px;vertical-align: top;color: green;cursor: pointer;">Verified</span>
                                                <?php
                                                }
                                                else if($userdetail['User']['emp_verification_status']=='Approval Pending')
                                                {?>
                                                    <span style="font-size: 12px;text-align: center;font-family: 'Roboto', sans-serif;padding-left: 10px;padding-right: 10px;vertical-align: top;color: rgb(180, 95, 6);cursor: pointer;">Approval Pending</span>
                                                <?php
                                                }
                                            }
                                            else
                                            {?>
                                                <span style="font-size: 12px;text-align: center;font-family: 'Roboto', sans-serif;padding-left: 10px;padding-right: 10px;vertical-align: top;color: red;cursor: pointer;" class="verifyEmp">Verfiy now</span>
                                            <?php
                                            
                                            }
                                        }
                                        ?>
                                    </li>
                                    <li class="nav-item login_link">
										<?php echo $this->Html->link(__d('home', 'Logout', true), array('controller' => 'users', 'action' => 'logout'), array('class' => $registerA . ' nav-link signup')); ?>
                                    </li>
									<li class="nav-item">
										<?php echo $this->Html->link('Post Job', array('controller' => 'jobs', 'action' => 'createJob'), array('class' => 'nav-link','style'=>"box-shadow: 0 0 0 1px var(--card-background) !important;color:var(--card-background) !important;border-radius:24px;")); ?>
									</li>
									<li class="newbell nav-item" id="bells">
                                        <?php
                                            if($job_alerts > 0 ){
                                                $job_alerts = "<span class=\"badge badge-pill badge-info\" style=\" position: absolute;top: 0px;left: 22px;\">$job_alerts</span>";
                                            }
                                            else{
                                                $job_alerts = '';
                                            }
                                            echo $this->Html->link("<i class=\"fa fa-bell\"></i> $job_alerts", array('controller' => 'alerts', 'action' => 'index'), array('escape' => false, 'class' => ' nav-link '));
                                        ?>            
									</li>
								<?php
								}
								else
								{?>
									<li class="nav-item <?php echo $homepage; ?>"> 
										<?php echo $this->Html->link('' . __d('user', 'Home', true), '/', array('class' => 'nav-link ' . $homepage, 'escape' => false)); ?>
									</li>
									<?php
									$about_us = classregistry::init('Page')->field('status', array('Page.static_page_heading' => 'about-us'));
									if ($about_us == 1) {
										echo '<li class="nav-item ' . $about_active . '">' . $this->Html->link('' . __d('home', 'About Us', true), array('controller' => 'pages', 'action' => 'about_us'), array('rel' => 'nofollow', 'class' => 'nav-link ' . $about_active, 'escape' => false)) . '</li>';
									}
									$how_it_works_page = classregistry::init('Page')->field('status', array('Page.static_page_heading' => 'how-it-works'));
									if ($how_it_works_page == 1) {
										echo '<li class="nav-item ' . $how_it_works . '" id="how_it_work_div">' . $this->Html->link('' . __d('home', 'How it works', true), array('controller' => 'pages', 'action' => 'staticpage', 'how-it-works'), array('class' => 'nav-link ' . $how_it_works, 'data-toggle' => 'modal', 'data-target' => '#howworksModal', 'escape' => false)) . '</li>';
									}
									?>
									<li class="nav-item <?php echo $blogs ?>"> 
										<?php echo $this->Html->link('' . __d('home', 'Blog', true), array('controller' => 'blogs', 'action' => 'index'), array('class' => 'nav-link ' . $blogs, 'escape' => false)); ?>
									</li>
									<?php
									$faq = classregistry::init('Page')->field('status', array('Page.static_page_heading' => 'faq'));
									if ($faq == 1) {
										echo '<li class="nav-item ' . $faq_active . '">' . $this->Html->link('' . __d('home', 'FAQ', true), array('controller' => 'pages', 'action' => 'staticpage', 'faq'), array('rel' => 'nofollow', 'class' => 'nav-link ' . $faq_active, 'escape' => false)) . '</li>';
									}
									?>
									<li class="nav-item">
										<?php echo $this->Html->link('Sign In', array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link')); ?>
									</li>
									<li class="nav-item">
										<?php echo $this->Html->link('Join Now', array('controller' => 'users', 'action' => 'signup'), array('class' => 'nav-link', 'escape' => false)); ?>
									</li>
								<?php
								}
								?>
								
                            </ul>

                            </div>
                        </nav>
                </div>
            </div>
        </div>
		<?php 
		if ($this->Session->read('user_id')){
			echo $this->element('topbar');
		}
		?>
		
    </div>
	
</header>
<style type ="text/css">
.rounded-circle {
  border-radius: 50% !important;
  width: 24px;
  height: 24px;
  overflow: hidden;
  display: inline-block;
  vertical-align: middle;
}
.pac-container{
z-index:9999 !important;	
}
.container{margin:auto;padding:0px !important;}
.topSearch input.form-control {
  outline: 0;
  font-size: 15px;
  height: 45px;
  background: transparent;
  color: #333;
  border-color: #ddd;
  border-radius: 40px;
  box-shadow: none;
}
.topSearch .btn.btn-secondary {

	background: #fff;

	border-color: var(--header-background);

	color: var(--header-background);
	border-radius: 40px;

	font-family: 'Roboto', sans-serif;

	font-weight: 600;

	font-size: 21px; float: right

}

.topSearch .btn.btn-secondary:hover {

	background: var(--header-background);

	border-color: var(--header-background);

	color: #fff;

}
</style>
<div id="howworksModal" class="modal fade howwork_header" role="dialog">
    <div class="modal-dialog howwork_dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <div class="modal-body">
<?php echo $this->Html->image('front/Job_portal.jpg'); ?>
            </div>

        </div>

    </div>
</div>
<div id="toTop"><?php echo __d('home', 'Top', true); ?></div>
	
<script type="text/javascript">
	 $(window).scroll(function () {
        if ($(this).scrollTop() > 5) {
            $(".header").addClass("fixed-me");
        } else {
            $(".header").removeClass("fixed-me");
        }
    });
	initializeHeader();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });
	
	
</script>
