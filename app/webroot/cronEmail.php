<?php
//define('HTTP_PATH', 'http://' . $_SERVER['SERVER_NAME'] . '/');
//$curlURL='http://stage.reyferjobs.com/jobs/cronEmail';
if(!empty($_SERVER['argv'][1]) && !empty($_SERVER['argv'][2]) && !empty($_SERVER['argv'][3]) && !empty($_SERVER['argv'][4]) && !empty($_SERVER['argv'][5]) && !empty($_SERVER['argv'][6])){
			
		$toEmail = $_SERVER['argv'][1];
		$subjectToSend = $_SERVER['argv'][2];
		$replyTo = $_SERVER['argv'][3];
		$from = $_SERVER['argv'][4];
		$layout = $_SERVER['argv'][5];
		$messageToSend="";
		if(!empty($_SERVER['argv'][6])){
			$messageToSend = $_SERVER['argv'][6];
		}
		$pdfAttach="";
		if(!empty($_SERVER['argv'][8])){
			$pdfAttach = $_SERVER['argv'][8];
		}
		$curlURL = base64_decode($_SERVER['argv'][7]);
		$postArray123 = array("toEmail"=>$toEmail,"subjectToSend"=>$subjectToSend,"replyTo"=>$replyTo,"from"=>$from,"layout"=>$layout,"messageToSend"=>$messageToSend,"pdfAttach"=>$pdfAttach);
		file_put_contents("dd.txt",json_encode($postArray123));
		$ch	=curl_init($curlURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postArray123));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($postArray123)))); 
		$result = curl_exec($ch);
		curl_close($ch);
		//file_put_contents("dd.txt",$toEmail."=".$subjectToSend."=".$replyTo."=".$from."=".$layout."=".$messageToSend);
		
	}
		die;
?>