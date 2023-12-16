<div class="my_accnt">
     <?php //echo $this->element('topbar'); 
        $this->Html->addCrumb('Saved Jobs');
     ?>
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
                <?php //echo $this->element('left_sidebar'); ?>
                <div class="col-lg-12">
					<?php echo $this->element('session_msg'); ?> 
                    <div class="my-profile-boxes">
                        <div class="my-profile-boxes-top my-experience-boxes"><h2><i><?php echo $this->Html->image('front/home/seved-icon2.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Saved Jobs', true);?></span></h2></div>
                        <div class="information_cntn payment-history-bx">
                               

                            <div class="listing_page">
                                <div class="job_scroll">
                                    <div id="loaderID" style="display:none;position:absolute;margin-left:100px;margin-top:250px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
                                    <div id='listID'>
                                        <?php echo $this->element('jobs/short_list'); ?>    
                                    </div>

                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>