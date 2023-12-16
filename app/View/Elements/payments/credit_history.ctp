<?php
if ($credits) {
    $this->Paginator->_ajaxHelperClass = "Ajax";
    $this->Paginator->Ajax = $this->Ajax;
    $this->Paginator->options(array('update' => 'listID',
        'url' => array('controller' => 'payments', 'action' => 'creditHistory', $separator),
        'indicator' => 'loaderID'));
    ?>
    <div class="right_child_sec_over">
    <div class="job_content" >
    <ul class="job_heading">
        <li><?php echo __d('user', 'Sr. No.', true);?></li>
        <li><?php echo __d('user', 'Job Title', true);?></li>
        <li><?php echo __d('user', 'Credit', true);?></li>
        <li><?php echo __d('user', 'Created', true);?></li>
        
    </ul>
    <?php
    $srNo = 1;
	foreach ($credits as $credit) {
        ?>
        <ul class="job_list">
            <li><?php echo $srNo++; ?></li>
			
            <li class="jobdi plan-btn"><?php echo $this->Html->link($credit['Job']['title'], array('controller' => 'jobs', 'action' => 'accdetail', $credit['Job']['slug']), array('rel'=>'facebox','class'=>'btn btn-info btn-xs')); ?></li>
			<li class="transaction-payment"><span><?php echo $credit['JobCredit']['credit']; ?></span></li>
            <li><?php echo date('M d, Y H:i A', strtotime($credit['JobCredit']['created'])); ?></li>
           
        </ul>
        <?php
    }
    ?>
     </div>
     </div>
        <div class="paging">
            <div class="noofproduct">
                <?php
                echo $this->Paginator->counter(
                        '<span>'.__d('user', 'No. of Records', true).' </span><span class="">{:start}</span><span> - </span><span class="">{:end}</span><span> '.__d('user', 'of', true).' </span><span class="">{:count}</span>'
                );
                ?> 
            </div>
    
            <div class="pagination">
                <?php echo $this->Paginator->first('<i class="fa fa-arrow-circle-o-left"></i>', array('escape' => false, 'class' => 'first')); ?> 
                <?php if ($this->Paginator->hasPrev('JobCredit')) echo $this->Paginator->prev('<i class="fa fa-arrow-left"></i>', array('class' => 'prev disabled', 'escape' => false)); ?> 
                <?php echo $this->Paginator->numbers(array('separator' => ' ', 'class' => 'badge-gray', 'escape' => false)); ?> 
                <?php if ($this->Paginator->hasNext('JobCredit')) echo $this->Paginator->next('<i class="fa fa-arrow-right"></i>', array('class' => 'next', 'escape' => false,'rel'=>'nofollow')); ?> 
                <?php echo $this->Paginator->last('<i class="fa fa-arrow-circle-o-right"></i>', array('class' => 'last', 'escape' => false)); ?> 
            </div>	
        </div>
<?php }else { ?>
    <div class="no_found"><?php echo __d('user', 'No record found.', true);?></div>
<?php } ?>

    
