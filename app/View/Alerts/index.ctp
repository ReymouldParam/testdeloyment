<div class="my_accnt">
    <?php //echo $this->element('topbar');
        $this->Html->addCrumb('Alerts');

        $job_alerts = ClassRegistry::init('AlertJob')->find('count', array('conditions' => array('AlertJob.view_status' => 1, 'AlertJob.user_id' => $this->Session->read('user_id'))));
        
        if($job_alerts > 0 ){
            $job_alerts = "(". $job_alerts . ")";
        }
        else{
            $job_alerts = '';
        }
    ?>
    <div class="account_cntn">
        <div class="wrapper">
            <div class="my_acc">
                <div class="col-lg-12">
					<?php echo $this->element('session_msg'); ?> 
                    <div class="my-profile-boxes">
                        <div class="my-profile-boxes-top my-manage-boxes">
                            <h2><i><?php echo $this->Html->image('front/home/manage-icon2.png', array('alt' => '')); ?></i>
                                <span><?php echo __d('user', "Alerts & Notifications $job_alerts", true);?></span></h2>
                            <div class="add-alert">
                                <?php echo $this->Html->link(__d('user', 'Add Alert', true), array('controller' => 'alerts', 'action' => 'add'), array('class' => '', 'escape' => false,'rel'=>'nofollow')); ?>
                            </div>
                        </div>
                        <div class="information_cntn payment-history-bx">
                           

                            <?php echo $this->element('session_msg'); ?>    

                            <div class="listing_page">
                                <div class="job_scroll">
                                    <div id="loaderID" style="display:none;position:absolute;margin-left:100px;margin-top:250px"><?php echo $this->Html->image("loader_large_blue.gif"); ?></div>
                                    <div id='listID'>
                                        <div class="over_flow_mange">
                                        <?php echo $this->element('alerts/index'); ?>    
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
</div>