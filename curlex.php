<?php
$a = 10;
$b = 4;
$greeting = function() use ($a)
{
    echo $a;
};
$greeting();
exit();


//Step 1

$cSession = curl_init();

//Step 2
curl_setopt($cSession, CURLOPURL, "http://www.google.com/search?q=curl");		//value of the URL which we send request to
curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);					//tell curl to return the string instead of printing it out.
curl_setopt($cSession, CURLOPT_HEADER, false);						//tell curl to ignore the header in the return value.

//Step 3
$result = curl_exec($cSession);

//Step 4
curl_close($cSession);

//Step 5
echo $result;


?>
