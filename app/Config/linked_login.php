<?php
require_once '../webroot/linkedinoauth/vendor/autoload.php';
$linkconfig = array('callback'=> LINKEDIN_REDIRECT,'keys'=> array('id'=> LINKEDIN_API_KEY,'secret'=> LINKEDIN_SECRET),'scope'=> 'r_liteprofile r_emailaddress');


