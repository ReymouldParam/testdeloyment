<?php

class PlansController extends AppController {

    public $name = 'Plans';
    public $uses = array('Admin', 'Plan', 'User', 'Payment', 'UserPlan','Emailtemplate');
    public $helpers = array('Html', 'Form', 'Paginator', 'Fck', 'Javascript', 'Ajax', 'Js', 'Text', 'Number');
    public $paginate = array('limit' => '50', 'page' => '1', 'order' => array('Plan.name' => 'asc'));
    public $components = array('RequestHandler', 'Email', 'Upload', 'PImageTest', 'PImage', 'Captcha');
    public $layout = 'admin';

    function beforeFilter() {
        $loggedAdminId = $this->Session->read("adminid");
        if (isset($this->params['admin']) && $this->params['admin'] && !$loggedAdminId) {
            $this->redirect("/admin/admins/login");
        }
    }

    public function admin_index() {

        $this->layout = "admin";
        $site_title = $this->getSiteConstant('title');
        $tagline = $this->getSiteConstant('tagline');
        $title_for_pages = $site_title . " :: ";
        $this->set('title_for_layout', $title_for_pages . "Plan List");

        $this->set('planS', 'active');
        $condition = array();
        $separator = array();
        $urlSeparator = array();
        $strategyName = '';
        $searchByDateFrom = '';
        $searchByDateTo = '';


        if (!empty($this->data)) {
            if (isset($this->data['Plan']['strategyName']) && $this->data['Plan']['strategyName'] != '') {
                $strategyName = trim($this->data['Plan']['strategyName']);
            }

            if (isset($this->data['Plan']['searchByDateFrom']) && $this->data['Plan']['searchByDateFrom'] != '') {
                $searchByDateFrom = trim($this->data['Company']['searchByDateFrom']);
            }

            if (isset($this->data['Plan']['searchByDateTo']) && $this->data['Plan']['searchByDateTo'] != '') {
                $searchByDateTo = trim($this->data['Plan']['searchByDateTo']);
            }

            if (isset($this->data['Plan']['action'])) {
                $idList = $this->data['Plan']['idList'];
                if ($idList) {
//                   / pr($idList); exit;
                    if ($this->data['Plan']['action'] == "activate") {
                        $cnd = array("Plan.id IN ($idList) ");
                        $this->Plan->updateAll(array('Plan.status' => "'1'"), $cnd);
                    } elseif ($this->data['Plan']['action'] == "deactivate") {
                        $cnd = array("Plan.id IN ($idList) ");
                        $this->Plan->updateAll(array('Plan.status' => "'0'"), $cnd);
                    } elseif ($this->data['Plan']['action'] == "delete") {
                        $cnd = array("Plan.id IN ($idList) ");
                        $this->Plan->deleteAll($cnd);
                    }
                }
            }
        } elseif (!empty($this->params)) {
            if (isset($this->params['named']['strategyName']) && $this->params['named']['strategyName'] != '') {
                $strategyName = urldecode(trim($this->params['named']['strategyName']));
            }
            if (isset($this->params['named']['searchByDateFrom']) && $this->params['named']['searchByDateFrom'] != '') {
                $searchByDateFrom = urldecode(trim($this->params['named']['searchByDateFrom']));
            }
            if (isset($this->params['named']['searchByDateTo']) && $this->params['named']['searchByDateTo'] != '') {
                $searchByDateTo = urldecode(trim($this->params['named']['searchByDateTo']));
            }
        }

        if (isset($strategyName) && $strategyName != '') {
            $separator[] = 'strategyName:' . urlencode($strategyName);
            $strategyName = str_replace('_', '\_', $strategyName);
            $condition[] = " (`Plan`.`plan_name` LIKE '%" . addslashes($strategyName) . "%'  ) ";
            $strategyName = str_replace('\_', '_', $strategyName);
            $this->set('searchKey', $strategyName);
        }

        if (isset($searchByDateFrom) && $searchByDateFrom != '') {
            $separator[] = 'searchByDateFrom:' . urlencode($searchByDateFrom);
            $searchByDateFrom = str_replace('_', '\_', $searchByDateFrom);
            $searchByDate_con1 = date('Y-m-d', strtotime($searchByDateFrom));
            $condition[] = " (Date(Plan.start_date)>='$searchByDate_con1' ) ";
            $searchByDateFrom = str_replace('\_', '_', $searchByDateFrom);
        }

        if (isset($searchByDateTo) && $searchByDateTo != '') {
            $separator[] = 'searchByDateTo:' . urlencode($searchByDateTo);
            $searchByDateTo = str_replace('_', '\_', $searchByDateTo);
            $searchByDate_con2 = date('Y-m-d', strtotime($searchByDateTo));
            $condition[] = " (Date(Plan.start_date)<='$searchByDate_con2' ) ";
            $searchByDateTo = str_replace('\_', '_', $searchByDateTo);
        }

        $order = array('Plan.id' => 'DESC');
        $separator = implode("/", $separator);

        if (!empty($this->passedArgs)) {
            if (isset($this->passedArgs["page"])) {
                $urlSeparator[] = 'page:' . $this->passedArgs["page"];
            }
            if (isset($this->passedArgs["sort"])) {
                $urlSeparator[] = 'sort:' . $this->passedArgs["sort"];
            }
            if (isset($this->passedArgs["direction"])) {
                $urlSeparator[] = 'direction:' . $this->passedArgs["direction"];
            }
        }

        $this->set('searchByDateFrom', $searchByDateFrom);
        $this->set('searchByDateTo', $searchByDateTo);

        $urlSeparator = implode("/", $urlSeparator);
        $this->set('strategyName', $strategyName);
        $this->set('separator', $separator);

        $this->paginate['Plan'] = array('conditions' => $condition, 'limit' => '20', 'page' => '1', 'order' => $order);
        $this->set('plans', $this->paginate('Plan'));

        //pr($this->paginate('Plan'));exit;
        if ($this->request->is('ajax')) {
            //Configure:write('debug', 0);
            $this->layout = '';
            $this->viewPath = 'Elements' . DS . 'admin/plans';
            $this->render('index');
        }
    }

    public function admin_addPlan() {
        $this->layout = "admin";
        $site_title = $this->getSiteConstant('title');
        $tagline = $this->getSiteConstant('tagline');
        $title_for_pages = $site_title . " :: ";
        $this->set('title_for_layout', $title_for_pages . "Add Plan");
        $this->set('planS', 'active');
        $msgString = '';

        if ($this->data) {
           
            if (trim($this->data["Plan"]["plan_name"]) == '') {
                $msgString .= "- Plan Name is required field.<br>";
            } else if ($this->Plan->isRecordUniquePlan($this->data["Plan"]["plan_name"]) == false) {
                $msgString .= "- Plan Name already exists.<br>";
            }


            if ($this->data["Plan"]["amount"] < 0) {
                $msgString .= "- Amount is required field.<br>";
            }
//            if ($this->request->data['Plan']['planuser'] == 'employer') {
                if (!isset($this->data["Plan"]["feature_ids"]) || count($this->data["Plan"]["feature_ids"]) < 1) {
                    $msgString .= "- Please select at least one feature.<br>";
                }
//            }
            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
//                echo '<pre>'; print_r($this->data);
                $selectFet = $this->data["Plan"]["selectFet"];
                $seleccheckbox = $this->data["Plan"]["seleccheckbox"];


//                if ($this->request->data['Plan']['planuser'] == 'employer') {
                $feature_ids = $this->data["Plan"]["feature_ids"];
                $feature_ids = $this->data["Plan"]["feature_ids"];
               if ($this->request->data['Plan']['planuser'] == 'jobseeker') {
                    $feature_ids1 = array_values($feature_ids);
                    if(in_array(1, $feature_ids1) || in_array(2, $feature_ids1) || in_array(3, $feature_ids1)){
                    unset($feature_ids[0]);
                    unset($feature_ids[1]);
                    unset($feature_ids[2]);
                    }
                } else {
                    $feature_ids1 = array_values($feature_ids);
                    if(in_array(4, $feature_ids1)){
                   unset($feature_ids[3]);
                    }
                   
                }
                $fvaluesarray = array();
                global $planFeatuersMax;
                if ($feature_ids) {
                    foreach ($feature_ids as $fid) {
                        if (array_key_exists($fid, $selectFet)) {
                            if (array_key_exists($fid, $seleccheckbox)) {
                                $fvaluesarray[$fid] = $planFeatuersMax[$fid];
                            } else {
                                $fvaluesarray[$fid] = $selectFet[$fid];
                            }
                        }
                    }
                }
                $this->request->data['Plan']['status'] = 1;
                $this->request->data['Plan']['slug'] = $this->stringToSlugUnique(trim($this->data['Plan']['plan_name']), 'Plan', 'slug');
                $this->request->data['Plan']['feature_ids'] = implode(',', $feature_ids);

//                }
                $this->request->data['Plan']['fvalues'] = json_encode($fvaluesarray);
//                echo '<pre>'; print_r($this->request->data);die;
                if ($this->Plan->save($this->data)) {

                    $this->Session->setFlash('Plan added successfully.', 'success_msg');
                    $this->redirect(array('controller' => 'plans', 'action' => 'index', ''));
                }
            }
        }
    }

    public function admin_editPlan($slug = null) {

        $this->layout = "admin";
        $site_title = $this->getSiteConstant('title');
        $tagline = $this->getSiteConstant('tagline');
        $title_for_pages = $site_title . " :: ";
        $this->set('title_for_layout', $title_for_pages . "Edit Plan");
        $this->set('planS', 'active');
        $msgString = '';

        if ($this->data) {

            if (trim($this->data["Plan"]["plan_name"]) == '') {
                $msgString .= "- Plan Name is required field.<br>";
            } else if ($this->data["Plan"]["plan_name"] != $this->data["Plan"]["old_name"]) {
                if ($this->Plan->isRecordUniquePlan($this->data["Plan"]["plan_name"], $this->data["Plan"]["planuser"]) == false) {
                    $msgString .= "- Plan Name already exists.<br>";
                }
            }
//            if (trim($this->data["Plan"]["planuser"]) == 'employer') {
                if (!isset($this->data["Plan"]["feature_ids"]) || count($this->data["Plan"]["feature_ids"]) < 1) {
                    $msgString .= "- Please select at least one feature.<br>";
                }
//            }

            if ($this->data["Plan"]["amount"] < 0) {
                $msgString .= "- Amount is required field.<br>";
            }


            if (isset($msgString) && $msgString != '') {
                $this->Session->setFlash($msgString, 'error_msg');
            } else {
//echo '<pre>'; print_r($this->request->data);
                $feature_ids = $this->data["Plan"]["feature_ids"];
                if ($this->request->data['Plan']['planuser'] == 'jobseeker') {
                    $feature_ids1 = array_values($feature_ids);
                    if(in_array(1, $feature_ids1) || in_array(2, $feature_ids1) || in_array(3, $feature_ids1)){
                    unset($feature_ids[0]);
                    unset($feature_ids[1]);
                    unset($feature_ids[2]);
                    }
                } else {
                    $feature_ids1 = array_values($feature_ids);
                    if(in_array(4, $feature_ids1)){
                   unset($feature_ids[3]);
                    }
                   
                }
//                print_r($feature_ids);
                $selectFet = $this->data["Plan"]["selectFet"];
                $seleccheckbox = $this->data["Plan"]["seleccheckbox"];
                $this->request->data['Plan']['feature_ids'] = implode(',', $feature_ids);
                $fvaluesarray = array();
                global $planFeatuersMax;
                if ($feature_ids) {
                    foreach ($feature_ids as $fid) {
                        if (array_key_exists($fid, $selectFet)) {
                            if (array_key_exists($fid, $seleccheckbox)) {
                                $fvaluesarray[$fid] = $planFeatuersMax[$fid];
                            } else {
                                $fvaluesarray[$fid] = $selectFet[$fid];
                            }
                        }
                    }
                }

                $this->request->data['Plan']['fvalues'] = json_encode($fvaluesarray);
//                 echo '<pre>'; print_r($this->data);die;
                $this->Plan->save($this->data);

                $this->Session->setFlash('Plan updated successfully', 'success_msg');
                $this->redirect(array('controller' => 'plans', 'action' => 'index', ''));
            }
        } elseif ($slug != '') {
            $id = $this->Plan->field('id', array('Plan.slug' => $slug));
            $this->Plan->id = $id;
            $this->data = $this->Plan->read();
            $this->request->data['Plan']['old_name'] = $this->data['Plan']['plan_name'];
            $this->request->data['Plan']['feature_ids_old'] = $this->data["Plan"]["feature_ids"];
        }
    }

    public function admin_activateplans($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Plan->field('id', array('Plan.slug' => $slug));
            $cnd = array('Plan.id' => $id);
            $this->Plan->updateAll(array('Plan.status' => "'1'"), $cnd);
            $this->set('action', '/admin/plans/deactivateplans/' . $slug);
            $this->set('id', $id);
            $this->set('status', 1);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deactivateplans($slug = NULL) {
        if ($slug != '') {
            $this->layout = "";
            $id = $this->Plan->field('id', array('Plan.slug' => $slug));
            $cnd = array('Plan.id' => $id);
            $this->Plan->updateAll(array('Plan.status' => "'0'"), $cnd);
            $this->set('action', '/admin/plans/activateplans/' . $slug);
            $this->set('id', $id);
            $this->set('status', 0);
            $this->viewPath = 'Elements' . DS . 'admin';
            $this->render('update_status');
        }
    }

    public function admin_deletePlan($slug = NULL) {
        if ($slug != '') {
            $plaInfo = $this->Plan->findBySlug($slug);
            $id = $plaInfo['Plan']['id'];

            $isPlan = $this->UserPlan->find('first', array('conditions' => array('UserPlan.plan_id' => $id)));
            if ($isPlan) {
                $this->Session->setFlash('You can not delete this plan because an employee purchased this plan.', 'error_msg');
            } else {
                if ($this->Plan->delete($id)) {
                    $this->Session->setFlash('Plan deleted successfully.', 'success_msg');
                }
            }
            $this->redirect(array('controller' => 'plans', 'action' => 'index', ''));
        }
    }

    public function purchase() {
      
        $this->layout = "client";
        $site_title = $this->getSiteConstant('title');
        $tagline = $this->getSiteConstant('tagline');
        $title_for_pages = $site_title . " :: " . $tagline . " - ";
        $this->set('title_for_layout', $title_for_pages . __d('controller', 'Purchase Membership Plan', true));
        $this->userLoginCheck();
		//$this->recruiterAccess();
		$this->set('transactionCreditActive', 'active');	
        $userId = $this->Session->read("user_id");
        $userdetail = $this->User->findById($userId);

        $this->set('userdetail', $userdetail);
        
        if ($userdetail['User']['user_type'] == 'recruiter') {
       // $condition = array('Plan.status' => 1,'Plan.planuser' => 'employer');
        } else {
        // $condition = array('Plan.status' => 1,'Plan.planuser' => 'jobseeker');   
        }
		
		$condition = array('Plan.status' => 1);
        $plans = $this->Plan->find('all', array('conditions' => $condition, 'order' => array('Plan.amount' => 'ASC')));
        $this->set('plans', $plans);
        $userId = $this->Session->read("user_id");
		$userCredit = $this->User->field('credit', array('User.id' => $userId));
        $this->set('userCredit', $userCredit);
        $msgString = '';
        if ($this->data) {
           //echo '<pre>';print_r($this->data);die;
            if (empty($this->data["Plan"]["id"])) {
                $msgString .= " Please select plan.<br>";
            }
            if (isset($msgString) && $msgString != '') {
                $this->Session->write('error_msg', $msgString);
            } else {
                $planId = $this->data["Plan"]["id"];
                $payment_option = $this->data["Plan"]["payment_option"];
                $aplimp = $this->data["Plan"]["aplimp"];
                $planInfo = $this->Plan->findById($planId);

                $idOld = $this->Payment->find('first', array('conditions' => array('Payment.user_id' => $userId, 'Payment.payment_status' => 'pending')));
                if ($idOld) {
                    $this->request->data['Payment']['id'] = $idOld['Payment']['id'];
                } else {
                    $this->request->data['Payment']['id'] = '';
                }
                $payment_number = 'pay-' . date('Ymd') . time();
                $this->request->data['Payment']['user_id'] = $userId;
                $this->request->data['Payment']['payment_number'] = $payment_number;
                $this->request->data['Payment']['payment_status'] = 'pending';
                $this->request->data['Payment']['price'] = $planInfo['Plan']['amount'];
                $this->request->data['Payment']['plan_id'] = $planInfo['Plan']['id'];
                $this->request->data['Payment']['payment_option'] = $payment_option;
                $this->request->data['Payment']['status'] = 0;
                $this->request->data['Payment']['slug'] = $payment_number . $userId;
                if ($aplimp) {
                    $aplimp = 1;
                }
                $this->request->data['Payment']['aplimp'] = $aplimp;

                $this->Payment->save($this->data['Payment']);
                if ($payment_option == 'stripe') {
                    $this->redirect('/payments/checkoutStripe/' . $payment_number);
                } else {
                    $this->redirect('/payments/checkout/' . $payment_number);
                }
            }
        }
    }

    public function getcurrentplan($userId) {
        echo $userId;
        exit;
    }
	
	public function ajaxPlan() {
      
        $this->layout = '';
        $user_id = $this->Session->read('user_id');
        if(!empty($_POST['jobId']) && !empty($_POST['jobSlug'])){	
			$userId = $this->Session->read("user_id");
			$jobId = $_POST['jobId'];
			$jobSlug = $_POST['jobSlug'];
			$fromPage = $_POST['page'];
        }
		$condition = array('Plan.status' => 1);
        $plans = $this->Plan->find('all', array('conditions' => $condition, 'order' => array('Plan.amount' => 'ASC')));
        $this->set('plans', $plans);
		$this->set('jobId', $jobId);
		$this->set('jobSlug', $jobSlug);
		$this->set('fromPage', $fromPage);
        $this->viewPath = 'Elements';
        $this->render('ajax_plan');
    }
	
	public function ajaxPlanSubmit() {
		if ($this->data) {
			$site_title = $this->getSiteConstant('title');
			$mail_from = $this->getMailConstant('from');
            if (empty($this->data["Plan"]["id"])) {
                $msgString .= " Please select plan.<br>";
				echo json_encode(array('status' => 'error', 'message' =>"Please select plan"));
				exit;
            }
			else 
			{
				$userId = $this->Session->read("user_id");
                $planId = $this->data["Plan"]["id"];
                $payment_option = $this->data["Plan"]["payment_option"];
                $aplimp = $this->data["Plan"]["aplimp"];
                $planInfo = $this->Plan->findById($planId);

                $idOld = $this->Payment->find('first', array('conditions' => array('Payment.user_id' => $userId, 'Payment.payment_status' => 'pending')));
                if ($idOld) {
                    $this->request->data['Payment']['id'] = $idOld['Payment']['id'];
                } 
				else 
				{
                    $this->request->data['Payment']['id'] = '';
                }
                $payment_number = 'pay-' . date('Ymd') . time();
                $this->request->data['Payment']['user_id'] = $userId;
                $this->request->data['Payment']['payment_number'] = $payment_number;
                $this->request->data['Payment']['payment_status'] = 'pending';
                $this->request->data['Payment']['price'] = $planInfo['Plan']['amount'];
                $this->request->data['Payment']['plan_id'] = $planInfo['Plan']['id'];
                $this->request->data['Payment']['payment_option'] = $payment_option;
                $this->request->data['Payment']['status'] = 0;
                $this->request->data['Payment']['slug'] = $payment_number . $userId;
                if ($aplimp) {
                    $aplimp = 1;
                }
                $this->request->data['Payment']['aplimp'] = $aplimp;
				$this->Payment->save($this->data['Payment']);
				$transactionId = 'free'.date('Ymd').rand(1000,9999);
				$amountPaid = $planInfo['Plan']['amount'];
				if($transactionId){
					$invoice_no = $this->UserPlan->find('first', array('fields' => array('MAX(UserPlan.invoice_no) AS max_invoice_no')));
					$max_invoice_no = isset($invoice_no[0]['max_invoice_no']) ? $invoice_no[0]['max_invoice_no']+1 : '1';
            
					$paymentInfo = $this->Payment->find('first', array('conditions'=>array('Payment.payment_number'=>$payment_number)));
					if ($paymentInfo['Payment']['payment_status'] == 'pending') {
						$this->Payment->updateAll(array('Payment.payment_status' => "'completed'", 'Payment.transaction_id' => "'$transactionId'"), array('Payment.id' => $paymentInfo['Payment']['id']));
               
						$companyname = $paymentInfo["User"]["company_name"];
						$email = $paymentInfo["User"]["email_address"];
						$name = $paymentInfo["User"]["first_name"].' '.$paymentInfo["User"]["last_name"];
						$planName = $paymentInfo["Plan"]["plan_name"].' Plan';
						$amount = CURR.' '.$paymentInfo["Plan"]["amount"];
						$date = date('F d, Y h:i A');
                
						$this->request->data['UserPlan']['payment_id']  = $paymentInfo['Payment']['id'];
						$this->request->data['UserPlan']['user_id']  = $paymentInfo['Payment']['user_id'];
						$this->request->data['UserPlan']['plan_id']  = $paymentInfo['Payment']['plan_id'];
						$this->request->data['UserPlan']['features_ids']  = $paymentInfo['Plan']['feature_ids'];
						$this->request->data['UserPlan']['fvalues']  = $paymentInfo['Plan']['fvalues'];
						$this->request->data['UserPlan']['amount']  = $paymentInfo['Plan']['amount'];
						$lastPlan = $this->UserPlan->find('first', array('conditions'=>array('UserPlan.user_id'=>$paymentInfo['Payment']['user_id']), 'order'=>array('UserPlan.id'=>'DESC')));
						$sdate = date('Y-m-d');
						if($lastPlan){
							$this->UserPlan->updateAll(array('UserPlan.is_expire' => "'1'"), array('UserPlan.id' => $lastPlan['UserPlan']['id']));
							$sdate = date('Y-m-d');
						}               
						$tpvalue = $paymentInfo['Plan']['type_value'];
						if($paymentInfo['Plan']['type'] == 'Months'){
							$edate = date('Y-m-d', strtotime($sdate. " + $tpvalue Months"));
						}
						else
						{
							$edate = date('Y-m-d', strtotime($sdate. " + $tpvalue Years"));
						}                 
						$this->request->data['UserPlan']['start_date']  = $sdate;
						$this->request->data['UserPlan']['end_date']  = $edate;
						$this->request->data['UserPlan']['slug']  = 'uplan-'.$paymentInfo['Payment']['user_id'].time();
						$this->request->data['UserPlan']['invoice_no'] = $max_invoice_no;
                
						$this->UserPlan->save($this->data['UserPlan']);
						$payinfo = '<p style="color:#434343; margin:10px 0 0;"><b>'.__d('controller', 'Plan Name', true).':</b> '.$planName.'</p>';
						$payinfo .= '<p style="color:#434343; margin:0px 0 0;"><b>'.__d('controller', 'Amount', true).':</b> '.$amount.'</p>';
						$payinfo .= '<p style="color:#434343; margin:0px 0 0;"><b>'.__d('controller', 'Transaction ID', true).':</b> '.$transactionId.'</p>';
						$payinfo .= '<p style="color:#434343; margin:0px 0 0;"><b>'.__d('controller', 'Date', true).':</b> '.$date.'</p>';
               
						$currentYear = date('Y', time());
						$emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='41'"));
						$emData = $this->Emailtemplate->getSubjectLang();
						$subjectField = $emData['subject'];
						$templateField = $emData['template'];
                
						$toSubArray = array('[!username!]', '[!payinfo!]', '[!SITE_TITLE!]', '[!DATE!]');
						$fromSubArray = array($name, $payinfo, $site_title, $currentYear);
						$subjectToSend = str_replace($toSubArray, $fromSubArray, $emailtemplateMessage['Emailtemplate'][$subjectField]);
						//$this->Email->subject = $subjectToSend;
						//$this->Email->replyTo = $site_title . "<" . $mail_from . ">";
						//$this->Email->from = $site_title . "<" . $mail_from . ">";

						$toRepArray = array('[!username!]', '[!payinfo!]', '[!SITE_TITLE!]', '[!DATE!]');
						$fromRepArray = array($name, $payinfo, $site_title, $currentYear);
						$messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate'][$templateField]);
						/*$this->Email->layout = 'default';
						$this->set('messageToSend', $messageToSend);
						$this->Email->template = 'email_template';
						$this->Email->sendAs = 'html';
						$this->Email->send();
						 $this->Email->reset();*/
						$toEmail = base64_encode($email);
						$replyTo = base64_encode($site_title . "<" . $mail_from . ">");
						$from = base64_encode($site_title . "<" . $mail_from . ">");
						$layout = 'default';
						$messageToSend = base64_encode($messageToSend);
						$subjectToSend = base64_encode($subjectToSend);
						$path = WWW_ROOT.'cronEmail.php';
						$pdfAttach ="";
						$cronUrl = base64_encode(BACKGROUND_PATH);
						exec("php -f  $path  $toEmail $subjectToSend $replyTo $from $layout $messageToSend $cronUrl $pdfAttach >/dev/null 2>&1 &",$exeoutput);
						$adminInfo = $this->Admin->findById(1);

						//$this->Email->to = $adminInfo['Admin']['email'];
						$emailtemplateMessage = $this->Emailtemplate->find("first", array("conditions" => "Emailtemplate.id='42'"));
						$toSubArray = array('[!username!]', '[!job_title!]', '[!SITE_TITLE!]', '[!DATE!]', '[!transactionId!]', '[!amountPaid!]', '[!company_name!]');
						$fromSubArray = array($name, $jobTitle, $site_title, $date, $transactionId, $amountPaid, $companyname);
						$subjectToSend = str_replace($toSubArray, $fromSubArray, $emailtemplateMessage['Emailtemplate']['subject']);
						//$this->Email->subject = $subjectToSend;

						//$this->Email->replyTo = $site_title . "<" . $mail_from . ">";
						//$this->Email->from = $site_title . "<" . $mail_from . ">";

						$toRepArray = array('[!username!]', '[!payinfo!]', '[!SITE_TITLE!]', '[!DATE!]');
						$fromRepArray = array($name, $payinfo, $site_title, $date);
						$messageToSend = str_replace($toRepArray, $fromRepArray, $emailtemplateMessage['Emailtemplate']['template']);
						/*$this->Email->layout = 'default';
						$this->set('messageToSend', $messageToSend);
						$this->Email->template = 'email_template';
						$this->Email->sendAs = 'html';
						$this->Email->send();*/
						$toEmail = base64_encode($adminInfo['Admin']['email']);
						$replyTo = base64_encode($site_title . "<" . $mail_from . ">");
						$from = base64_encode($site_title . "<" . $mail_from . ">");
						$layout = 'default';
						$messageToSend = base64_encode($messageToSend);
						$subjectToSend = base64_encode($subjectToSend);
						$path = WWW_ROOT.'cronEmail.php';
						$pdfAttach ="";
						$cronUrl = base64_encode(BACKGROUND_PATH);
						exec("php -f  $path  $toEmail $subjectToSend $replyTo $from $layout $messageToSend $cronUrl $pdfAttach >/dev/null 2>&1 &",$exeoutput);
						echo json_encode(array('status' => 'success', 'message' =>"You have successfully completed payment for your membership plan"));
						exit;
						
                
					}
					else
					{
						echo json_encode(array('status' => 'success', 'message' =>"You have successfully completed payment for your membership plan"));
						exit;
					}
				}
            }
        }
	}

}

?>
