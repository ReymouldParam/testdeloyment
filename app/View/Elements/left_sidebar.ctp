<?php
if (!isset($editprofile)) {
    $editprofile = '';
}
if (!isset($mailhistory)) {
    $mailhistory = '';
}
if (!isset($myaccount)) {
    $myaccount = '';
}
if (!isset($changepassword)) {
    $changepassword = '';
}
if (!isset($uploadPhoto)) {
    $uploadPhoto = '';
}
if (!isset($employee)) {
    $employee = '';
}
if (!isset($income)) {
    $income = '';
}
if (!isset($jobsActive)) {
    $jobsActive = '';
}
if (!isset($transactionActive)) {
    $transactionActive = '';
}
if (!isset($favoriteList)) {
    $favoriteList = '';
}
if (!isset($jobsCreate)) {
    $jobsCreate = '';
}
if (!isset($importList)) {
    $importList = '';
}
if (!isset($shortList)) {
    $shortList = '';
}
if (!isset($appList)) {
    $appList = '';
}
if (!isset($alertManage)) {
    $alertManage = '';
}
if (!isset($makecv)) {
    $makecv = '';
}
if (!isset($transactionCreditActive)) {
    $transactionCreditActive = '';
}
if (!isset($jobs_list)) {
    $jobs_list = '';
}
?>
<div class="col-lg-3 col-sm-3"> 
    <div class="left_lnks">
        <div class="my_hd mobile_sh"><?php echo __d('user', 'Seek Jobs', true);?><span class="menu-icons"><?php echo $this->Html->image('front/home/menu-icon.png', array('alt' => '')); ?></span></div>
        <div class="my_hd quickbx2"><span><?php echo __d('user', 'Seek Jobs', true);?></span></div>
       <ul class="quickdiv2">
			 <li class="my-search-tab <?php echo $jobs_list; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/search-icon.png', array('alt' => '')).'</i><span>'.__d('user','Job Search',true).'</span>', array('controller' => 'jobs', 'action' => 'listing'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-savedjob-tab <?php echo $shortList; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/seved-icon.png', array('alt' => '')).'</i><span>'.__d('user','Saved Jobs',true).'</span>', array('controller' => 'jobs', 'action' => 'shortList'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-applied-tab <?php echo $appList; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/applied-icon.png', array('alt' => '')).'</i><span>'.__d('user','Applied Jobs',true).'</span>', array('controller' => 'jobs', 'action' => 'applied'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			 <li class="my-manage-tab <?php echo $alertManage; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/manage-icon.png', array('alt' => '')).'</i><span>'.__d('user','Manage Alerts',true).'</span>', array('controller' => 'alerts', 'action' => 'index'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>

        </ul>
    </div>
	<div class="left_lnks">
        <div class="my_hd mobile_sh"><?php echo __d('user', 'Refer Jobs', true);?></div>
        <div class="my_hd quickbx"><span><?php echo __d('user', 'Refer Jobs', true);?></span></div>
		<ul class="quickdiv">
			<li class="my-creat-tab <?php echo $jobsCreate; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/creat-job-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Post Job', true).'</span>', array('controller' => 'jobs', 'action' => 'createJob'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-manage-job-tab <?php echo $jobsActive; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/manage-job-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Manage Jobs', true).'</span>', array('controller' => 'jobs', 'action' => 'management'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-favorites-tab <?php echo $favoriteList; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/seved-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Favorites List', true).'</span>', array('controller' => 'candidates', 'action' => 'favorite'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-change-logo-tab <?php echo $importList; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/paper.png', array('alt' => '')).'</i><span>'.__d('user', 'Bulk Job Upload', true).'</span>', array('controller' => 'jobs', 'action' => 'importjob'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>

        </ul>
    </div>
	<div class="left_lnks">
        <div class="my_hd mobile_sh"><?php echo __d('user', 'Profile Section', true);?></div>    
        <div class="my_hd dashboardsbx"><span><?php echo __d('user', 'Profile Section', true);?></span></div>
        <ul class="dashboardsdiv">
            <li class="my-profiles-tab <?php echo $myaccount; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/my-profile-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'My Profile', true).'</span>', array('controller' => 'users', 'action' => 'myaccount'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?> </li>
			<li class="my-mackcv-tab <?php echo $makecv; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/make-v-icon.png', array('alt' => '')).'</i><span>'.__d('user','Make a CV',true).'</span>', array('controller' => 'candidates', 'action' => 'makecv'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?> </li> 
			<li class="my-changephoto-tab <?php echo $uploadPhoto; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/change-photo-icon.png', array('alt' => '')).'</i><span>'.__d('user','Manage Photo</span>',true).'</span>', array('controller' => 'candidates', 'action' => 'uploadPhoto'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?></li>
			<li class="my-mailhistory-tab <?php echo $mailhistory; ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/mail-history-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Mail History', true).'</span>', array('controller' => 'candidates', 'action' => 'mailhistory'), array('class' => '', 'escape' => false, 'rel' => 'nofollow')); ?> </li> 
        </ul>
    </div>
	<div class="left_lnks">
        <div class="my_hd mobile_sh"><?php echo __d('user', 'Memberships', true);?></div>    
        <div class="my_hd sattingbx"><span><?php echo __d('user', 'Memberships', true);?></span></div>
        <ul class="sattingsdiv">
			 <li class="my-paypanethistory-tab <?php echo $transactionCreditActive;  ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/member-purchase-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Credits & Plans', true).'</span>',array('controller'=>'plans','action'=>'purchase'),array('class'=>'', 'escape' => false,'rel'=>'nofollow'));  ?></li>
            <li class="my-paypanethistory-tab <?php echo $transactionActive;  ?>"><?php echo $this->Html->link('<i>'.$this->Html->image('front/home/payment-icon.png', array('alt' => '')).'</i><span>'.__d('user', 'Payment History', true).'</span>',array('controller'=>'payments','action'=>'history'),array('class'=>'', 'escape' => false,'rel'=>'nofollow'));  ?></li>
        </ul>
    </div>

    
</div>

<script>
    $(document).ready(function () {

        $('.quickbx2').click(function () {

            if ($('.quickbx2').hasClass('quicklinkopen2')) {
                $('.quickbx2').removeClass('quicklinkopen2');
            } else {
                $('.quickbx2').addClass('quicklinkopen2');
            }
            $(".quickdiv2").slideToggle();
        });
		
		$('.quickbx').click(function () {

            if ($('.quickbx').hasClass('profileopen')) {
                $('.quickbx').removeClass('profileopen');
            } else {
                $('.quickbx').addClass('profileopen');
            }
            $(".quickdiv").slideToggle();
        });

        $('.dashboardsbx').click(function () {

            if ($('.dashboardsbx').hasClass('dashboardsopen')) {
                $('.dashboardsbx').removeClass('dashboardsopen');
            } else {
                $('.dashboardsbx').addClass('dashboardsopen');
            }

            $(".dashboardsdiv").slideToggle();
        });
		
		$('.sattingbx').click(function () {

			if ($('.sattingbx').hasClass('sattingsopen')) {
				$('.sattingbx').removeClass('sattingsopen');
			} else {
				$('.sattingbx').addClass('sattingsopen');
			}

			$(".sattingsdiv").slideToggle();
		});

    });
</script>