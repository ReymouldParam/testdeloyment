<div class="my_accnt">
    <?php //echo $this->element('topbar'); 
    $this->Html->addCrumb('Applied Jobs');
    ?>
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
                <div class="col-lg-12">
					<?php echo $this->element('session_msg'); ?> 
                    <div class="my-profile-boxes">
                        <div class="my-profile-boxes-top my-applied-boxes"><h2><i><?php echo $this->Html->image('front/home/applied-icon2.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Applied Jobs', true);?></span></h2></div>
                        <div class="information_cntn payment-history-bx">
                            <?php echo $this->element('session_msg'); ?>    

                            <div class="listing_page">
                                <div class="job_scroll">
                                    <div id="loaderID" style="display:none;position:absolute;margin-left:100px;margin-top:250px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
                                    <div id='listID' style="overflow: auto;">
                                        <?php echo $this->element('jobs/applied'); ?>    
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