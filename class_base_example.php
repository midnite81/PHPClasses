<?php 
require_once('class_base.php'); 

	define('_HOST_','<your_host_name>'); 
	define('_DB_','<database_name>'); 
	define('_USER_','<database_username>'); 
	define('_PASS_','<database_password>'); 
	
$base = new myCore; 

/* Retrieve data using PDO */ 
$data = $base->getData('SELECT * FROM `news` WHERE category = :cat',array(':cat'=>4)); 
/* Retrieve data using mysqli */ 
$data = $base->getData('SELECT * FROM `news` WHERE category = :cat',array(':cat'=>4),'mysqli'); 

/* Turn email addresses into Hyperlinks */
$str = "<p>I have an email address which is dave@123.com"; 
echo $base->emailize($str) . "<br><br>\n"; 

/* Remove blank paragraphs */ 
$str = "<h1>Hello World</h1>
<p>I have some blank paragraphs</p>
<p>  </p>
<p> &nbsp;</p>
<p>You will see this one</p>
<p>&nbsp;</p>";
echo htmlentities($base->removeParagraphBlanks($str)) . "<br><br>\n";

/* Create a random string */
echo $base->createRandom(8,3);
?>