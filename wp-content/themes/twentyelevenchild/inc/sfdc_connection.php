<?php

//Get some things from the wp_options table so that we don't have to hard-code them
define("USERNAME", get_option('sfdc_user'));
define("PASSWORD", get_option('sfdc_password'));
define("SECURITY_TOKEN", get_option('sfdc_token'));

//disable caching for now. Might want to enable it at some point
ini_set('soap.wsdl_cache_enabled', '0');

require_once ('sfdc/soapclient/SforceEnterpriseClient.php');

$mySforceConnection = new SforceEnterpriseClient();
$mySforceConnection->createConnection(get_stylesheet_directory() . '/' ."inc/sfdc.wsdl.jsp.xml");
$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);