<?php
$seekJobMenu="";$referJobMenu="";$profileMenu="";$memberShipMenu="";
if (!isset($jobs_list)) {
    $jobs_list = '';
}
else 
{
    $seekJobMenu = 'font-weight-bold';
}
if (!isset($shortList)) {
   $shortList = '';
}
else 
{
    $seekJobMenu = 'font-weight-bold';
}
if (!isset($appList)) {
    $appList = '';
}
else 
{
    $seekJobMenu = 'font-weight-bold';
}
if (!isset($alertManage)) {
    $alertManage = '';
}
else 
{
    $seekJobMenu = 'font-weight-bold';
}
if (!isset($jobsCreate)) {
    $jobsCreate = '';
}
else
{
	$referJobMenu="font-weight-bold";
}
if (!isset($jobsActive)) {
    $jobsActive = '';
}
else
{
	$referJobMenu="font-weight-bold";
}
if (!isset($favoriteList)) {
    $favoriteList = '';
}
else
{
	$referJobMenu="font-weight-bold";
}
if (!isset($importList)) {
    $importList = '';
}
else
{
	$referJobMenu="font-weight-bold";
}
if (!isset($myaccount)) {
    $myaccount = '';
}
else
{
	$profileMenu="font-weight-bold";
}
if (!isset($makecv)) {
    $makecv = '';
}
else
{
	$profileMenu="font-weight-bold";
}
if (!isset($uploadresume)) {
    $uploadresume = '';
}
else
{
	$profileMenu="font-weight-bold";
}
if (!isset($mailhistory)) {
    $mailhistory = '';
}
else
{
	$profileMenu="font-weight-bold";
}
if (!isset($uploadPhoto)) {
    $uploadPhoto = '';
}
else
{
	$profileMenu="font-weight-bold";
}
if (!isset($transactionCreditActive)) {
    $transactionCreditActive = '';
}
else
{
	$memberShipMenu="font-weight-bold";
}
if (!isset($transactionActive)) {
    $transactionActive = '';
}
else
{
	$memberShipMenu="font-weight-bold";
}
if (!isset($creditHistory)) {
    $creditHistory = '';
}
else
{
	$memberShipMenu="font-weight-bold";
}

$new_applicants_count = classRegistry::init('JobApply')->find('count', array('conditions' => array('Job.user_id' => $this->Session->read('user_id'), 'JobApply.global_new_status' => 1)));
if(!empty($new_applicants_count)){
	$new_applicants_count = "(". $new_applicants_count . ")";
}
else{
	$new_applicants_count = '';
}
?>
<nav id="subNav" class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
		
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-products" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
    <div class="navbar-collapse collapse justify-content-end" id="navbar-products">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link <?php echo $seekJobMenu;?>" href="#" id="subnav-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo __d('user', 'SEEK JOBS', true);?>
                </a>
				
                <div class="dropdown-menu" aria-labelledby="subnav-dropdown">
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/search-icon.png', array('alt' => '')).'</i><span>'.__d('user','Job Search',true).'</span>', array('controller' => 'jobs', 'action' => 'listing'), array('class' => 'dropdown-item my-search-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/seved-icon.png', array('alt' => '')).'</i><span>'.__d('user','Saved Jobs',true).'</span>', array('controller' => 'jobs', 'action' => 'shortList'), array('class' => 'dropdown-item my-savedjob-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
                   <?php echo $this->Html->link('<i>'.$this->Html->image('front/home/applied-icon.png', array('alt' => '')).'</i><span>'.__d('user','Applied Jobs',true).'</span>', array('controller' => 'jobs', 'action' => 'applied'), array('class' => 'dropdown-item my-applied-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
                    <?php echo $this->Html->link('<i>'.$this->Html->image('front/home/manage-icon.png', array('alt' => '')).'</i><span>'.__d('user','Alerts & Notifications',true).'</span>', array('controller' => 'alerts', 'action' => 'index'), array('class' => 'dropdown-item my-manage-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link <?php echo $referJobMenu;?>" href="#" id="subnav-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo __d('user', 'REFER JOBS '. $new_applicants_count, true);?>
                </a>
				<div class="dropdown-menu" aria-labelledby="subnav-dropdown">
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/creat-job-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Post Job', true).'</span>', array('controller' => 'jobs', 'action' => 'createJob'), array('class' => 'dropdown-item my-creat-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/manage-job-icon.png', array('alt' => '')).'</i><span>'.__d('user', "Manage Jobs $new_applicants_count", true).'</span>', array('controller' => 'jobs', 'action' => 'management'), array('class' => 'dropdown-item my-manage-job-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/seved-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Favorites List', true).'</span>', array('controller' => 'candidates', 'action' => 'favorite'), array('class' => 'dropdown-item my-favorites-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/paper.png', array('alt' => '')).'</i><span>'.__d('user', 'Bulk Job Upload', true).'</span>', array('controller' => 'jobs', 'action' => 'importjob'), array('class' => 'dropdown-item my-change-logo-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
				</div>
                
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link <?php echo $profileMenu;?>" href="#" id="subnav-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo __d('user', 'PROFILE SECTION', true);?>
                </a>
				<div class="dropdown-menu" aria-labelledby="subnav-dropdown">
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/my-profile-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'My Profile', true).'</span>', array('controller' => 'users', 'action' => 'myaccount'), array('class' => 'dropdown-item my-profiles-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/make-v-icon.png', array('alt' => '')).'</i><span>'.__d('user','Upload Resume',true).'</span>', array('controller' => 'users', 'action' => 'uploadresume'), array('class' => 'dropdown-item my-mackcv-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php //echo $this->Html->link('<i>'.$this->Html->image('front/home/make-v-icon.png', array('alt' => '')).'</i><span>'.__d('user','Make a CV',true).'</span>', array('controller' => 'candidates', 'action' => 'makecv'), array('class' => 'dropdown-item my-mackcv-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/change-photo-icon.png', array('alt' => '')).'</i><span>'.__d('user','Manage Photo</span>',true).'</span>', array('controller' => 'candidates', 'action' => 'uploadPhoto'), array('class' => 'dropdown-item my-changephoto-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/mail-history-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Mail History', true).'</span>', array('controller' => 'candidates', 'action' => 'mailhistory'), array('class' => 'dropdown-item my-mailhistory-tab', 'escape' => false, 'rel' => 'nofollow')); ?>
				</div>
                
            </li>
			<li class="nav-item dropdown">
                <a class="nav-link <?php echo $memberShipMenu;?>" href="#" id="subnav-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo __d('user', 'MEMBERSHIPS', true);?>
                </a>
				<div class="dropdown-menu" aria-labelledby="subnav-dropdown">
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/member-purchase-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Credits & Plans', true).'</span>',array('controller'=>'plans','action'=>'purchase'),array('class'=>'dropdown-item my-paypanethistory-tab', 'escape' => false,'rel'=>'nofollow'));  ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/payment-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Payment History', true).'</span>',array('controller'=>'payments','action'=>'history'),array('class'=>'dropdown-item my-paypanethistory-tab', 'escape' => false,'rel'=>'nofollow'));  ?>
					<?php echo $this->Html->link('<i>'.$this->Html->image('front/home/payment-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Credits Gained Through Job Posts', true).'</span>',array('controller'=>'payments','action'=>'creditHistory'),array('class'=>'dropdown-item my-paypanethistory-tab', 'escape' => false,'rel'=>'nofollow'));  ?>
					
				</div>
                
            </li>
        </ul>
        
    </div>
    </div>
</nav>

<div class="wrapper" style=" padding-top: 0.5rem;">
  <?php 
	  echo $this->Html->getCrumbs(' > ', 'Home'); 
  ?>
</div>

<style type="text/css">
#subNav.navbar{
padding:0px !important;	
}
#navbar-products{
	position:relative;
} 
li.dropdown{
padding-right:40px;	
}
.bg-dark {
  background-color: rgb(16,17,93) !important;
}
.my-search-tab i {
  background: #ff5e00;
}
.my-search-tab:hover,

.my-search-tab.active {border: 1px #ff5e00 solid; color: #ff5e00 }
.my-search-tab:hover, .my-search-tab.active {
  border: 1px #ff5e00 solid !important;
  color: #ff5e00 !important;
}

.my-savedjob-tab i {background: #7c3695;}

.my-savedjob-tab:hover,.my-savedjob-tab.active{border: 1px #7c3695 solid !important; color: #7c3695 !important; }

.my-applied-tab i {background: #f99b1e;}

.my-applied-tab:hover,.my-applied-tab.active {border: 1px #f99b1e solid !important; color: #f99b1e !important;}

.my-manage-tab i {background: #3e5eab;}

.my-manage-tab:hover,

.my-manage-tab.active a {border: 1px #3e5eab solid !important; color: #3e5eab !important; }

.my-creat-tab i {background: var(--header-background);}
.my-creat-tab:hover,.my-creat-tab.active {border: 1px var(--header-background) solid !important;color: var(--header-background) !important;}
.my-manage-job-tab i {background: #3494e6;}
.my-manage-job-tab:hover,.my-manage-job-tab.active a {border: 1px #3494e6 solid !important;color: #3494e6 !important;}
.my-favorites-tab i {background: #62b146;}
.my-favorites-tab:hover,.my-favorites-tab.active a {border: 1px #62b146 solid !important;color: #62b146 !important;}
.my-change-logo-tab i {background: #ff5e00;}
.my-change-logo-tab:hover,.my-change-logo-tab.active a {border: 1px #ff5e00 solid !important;color: #ff5e00 !important;}
.my-profiles-tab i {background: #f15424;}
.my-profiles-tab:hover,.my-profiles-tab.active a {border: 1px #f15424 solid !important; color: #f15424 !important; }
.my-mackcv-tab i {background: #09a7c9;}
.my-mackcv-tab:hover,.my-mackcv-tab.active a {border: 1px #09a7c9 solid !important; color: #09a7c9 !important; }
.my-changephoto-tab i {background: #009687;}
.my-changephoto-tab:hover,.my-changephoto-tab.active a {border: 1px #009687 solid !important; color: #009687 !important; }
.my-mailhistory-tab i {background: #5e7c8b;}
.my-mailhistory-tab:hover,.my-mailhistory-tab.active a {border: 1px #5e7c8b solid !important; color: #5e7c8b !important; }
.my-paypanethistory-tab i {background: #6d49a6;}
.my-paypanethistory-tab:hover,.my-paypanethistory-tab.active a {border: 1px #6d49a6 solid !important;color: #6d49a6 !important;}

#navbar-products ul li a i img {position: absolute;left: 0;right: 0;top: 0;bottom: 0;margin: auto;}
#navbar-products ul li a span {

	display: inline-block;

	vertical-align: middle;

}
#navbar-products ul li a.nav-link{color:#FFF;}
#navbar-products ul li a {display: block;font-size: 16px;color: #25242a;font-family: 'Roboto', sans-serif;text-decoration: none !important;border-radius: 3px;transition: all .5s ease-out; border: 1px transparent solid; }

#navbar-products ul li a i {margin-right: 10px;font-size: 20px;width: 40px;height: 40px;color: #fff;text-align: center;border-radius: 5px;

 line-height: 40px; display: inline-block; vertical-align: middle; position: relative}

#navbar-products ul li a {display: inline-block;transition: all .5s ease-out; width: 100%}

#navbar-products > ul > li > a {
    text-decoration: none;
}
#navbar-products ul li a.nav-link{
    position:relative;
}

#navbar-products ul li a.font-weight-bold{
   bottom:0px; /*Change this to increase/decrease distance*/
    border-bottom: 2px solid var(--header-background);
	
}

#navbar-products ul li.active a { 

-webkit-transition: all 200ms ease-in;

-webkit-transform: scale(1.05);

-ms-transition: all 200ms ease-in;

-ms-transform: scale(1.05);

-moz-transition: all 200ms ease-in;

-moz-transform: scale(1.05);

transition: all 200ms ease-in;

transform: scale(1.05);

}

#navbar-products ul li a:hover i,

#navbar-products ul li.active a i{border-radius: 0}

.dropdown-item{
padding:10px;	
}
.dropdown-menu{ 
min-width:18rem;
padding: 0 0 0.5rem 0 !important;
margin: 0 0.125rem 0 0 !important;
}
.dropdown-item { margin:3px;padding:0px;}

.my_acc {
margin: 0 !important;
padding: 20px 0 !important;	
}
</style>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(){
		
		// make it as accordion for smaller screens
		if (window.innerWidth > 992) {

			document.querySelectorAll('#subNav.navbar .nav-item').forEach(function(everyitem){
				
				everyitem.addEventListener('mouseover', function(e){
					
					let el_link = this.querySelector('a[data-toggle]');

					if(el_link != null){
						let nextEl = el_link.nextElementSibling;
						el_link.classList.add('show');
				 		nextEl.classList.add('show');
					}
					
				});
				everyitem.addEventListener('mouseleave', function(e){
				 	let el_link = this.querySelector('a[data-toggle]');
					
					if(el_link != null){
						let nextEl = el_link.nextElementSibling;
						el_link.classList.remove('show');
				 		nextEl.classList.remove('show');
					}
					

				})
			});

		}
		// end if innerWidth
	}); 
</script>