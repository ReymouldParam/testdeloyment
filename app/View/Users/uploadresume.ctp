<?php
$this->Html->addCrumb('Upload Resume');
$max_size = $this->requestAction(array('controller' => 'App', 'action' => 'getSiteConstant', 'max_size'));
?> 
<script>
    $().ready(function () {
        $("#editProfile").validate();
    });
</script>
<div class="my_accnt">
    <?php //echo $this->element('topbar'); ?>
    <div class="account_cntn">
        <div class="container">
            <div class="row">
                <div class="my_acc">
                    <?php //echo $this->element('left_sidebar'); ?>
                    <div class="col-lg-12">
						 <?php echo $this->element('session_msg'); ?>    
                        <?php echo $this->Form->create("Null", array('enctype' => 'multipart/form-data', "method" => "Post", 'id' => 'editProfile', 'name' => 'changeprofilepicture')); ?>
                        <div class="my-profile-boxes">
                            <div class="my-profile-boxes-top"><h2><i><?php echo $this->Html->image('front/home/paper-color.png', array('alt' => '')); ?></i><span><?php echo __d('user', 'Upload Resume', true);?></span></h2></div>
                            <div class="information_cntn">
                                <?php echo $this->element('session_msg'); ?>

                                
                                <div class="form_list_education">
                                   <label class="lable-acc"><?php echo __d('user', 'Import File', true);?> </label>
                                    <div class="form_input_education form_upload_file">
                                        <span class="choose-file-your">Choose File</span>
                                        <?php echo $this->Form->file('User.filedata', array('class' => 'form-control required','id'=>'filedata')); ?>
                                    </div>
                                   <div class="abccc pstrength-minchar"><?php echo __d('user', 'Supported File Types', true);?>: pdf, doc,docx</div>
                                </div>                                

                                <div class="form_lst sssss">
                                    <span class="rltv">
                                        <div class="pro_row_left"> 
                                            <?php echo $this->Form->submit(__d('user', 'Upload', true), array('div' => false, 'label' => false, 'class' => 'input_btn', 'onclick' => 'return imageValidation();')); ?>
                                            <?php echo $this->Html->link(__d('user', 'Cancel', true), array('controller' => 'users', 'action' => 'myaccount'), array('class' => 'input_btn rigjt', 'escape' => false,'rel'=>'nofollow')); ?>
                                        </div> 
                                    </span>
                                </div>

                            </div>        
                        </div>
                        <?php echo $this->Form->end(); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><script>
    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return;
        return filename.substr(dot_pos + 1).toLowerCase();
    }

    function imageValidation() {

        var filename = document.getElementById("filedata").value;

        var filetype = ['doc','docx','pdf'];
        
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " <?php echo __d('user', 'file not allowed for import.', true);?>");
                return false;
            } else {
                var fi = document.getElementById('filedata');
                var filesize = fi.files[0].size;//check uploaded file size
				var over_max_size = 20 * 1048576;
				if (filesize > over_max_size) {
					alert('Maximum 20MB '+" <?php echo __d('user', 'file size allowed for file.', true); ?>");
					alert("<?php // echo __d('user', 'Maximum 40MB file size allowed for CV Document.', true); ?>");
					document.getElementById("filedata").value = '';
					return false;
				}
                
            }
        }
        return true;
    }

</script>