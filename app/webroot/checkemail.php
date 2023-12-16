<?PHP
$replyTo = base64_encode("Reyferjobs<contact@reyferjobs.com>");
$from = base64_encode("Reyferjobs<contact@reyferjobs.com>");
$postArray123 = array("toEmail"=>base64_encode("er.sharmadinesh1986@gmail.com"),"subjectToSend"=>base64_encode("test"),"replyTo"=>$replyTo,"from"=>$from,"layout"=>'default',"messageToSend"=>base64_encode("Test Message Stage"),"pdfAttach"=>"");
$curlURL = 'http://dev.reyferjobs.com/jobs/cronEmail';
		file_put_contents("dd.txt",json_encode($postArray123));
		$ch	=curl_init($curlURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postArray123));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($postArray123)))); 
		$result = curl_exec($ch);
		echo '<pre>';
		print_r($result);
		curl_close($ch);
		echo "dd";
		die;

$sender = 'support@approach-jobs.com';
$recipient = 'praveen.kulharee@logicspice.com';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}
?>