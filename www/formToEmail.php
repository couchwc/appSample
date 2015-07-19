<?php
if(!isset($_POST['submit']))
{
    //This page should not be accessed directly. Need to submit the form.
    echo "error: you need to submit the form!";
}

//Collect
$visitorName = $_POST['name'];
$visitorEmail = $_POST['email'];
$visitorSubject = $_POST['subject'];
$visitorMessage = $_POST['message'];

//Validate
if(empty($visitorName) || 
   empty($visitorEmail) || 
   empty($visitorMessage))//Need to add subject???
{
    echo "Name, Email, and Message are all required!";
    exit;
}

//Security: Should check all header values
//visitorName
if(IsInjected($visitorName))
{
    echo "Bad name value!";
    exit;
}
//visitorEmail
if(IsInjected($visitorEmail))
{
    echo "Bad email value!";
    exit;
}
//visitorSubject
if(IsInjected($visitorSubject))
{
    echo "Bad subject value!";
    exit;
}
//visitorMessage
if(IsInjected($visitorMessage))
{
    echo "Bad message value!";
    exit;
}

$emailFrom = "couchwc@gmail.com";//Put receiver email address here
$emailSubject = "New Form Submission Subject: $visitorSubject";
$emailBody = "You have received a new message from the user $visitorName.\n email address: $visitorEmail\n Here is the message:\n$message";
$to = "couchwc@gmail.com";//Put receiver email address here
$headers = "From: $emailFrom";

//Send Email
mail($to, $emailSubject, $emailBody, $headers);

//Done. Redirect to Thank You page!
//header(Location: thankYou.html);//???????????

//Secutiry Function to alidate against injection attempts
function IsInjected($str)
{
    $injections = array('(\n+)', 
                        '(\r+)',
                        '(\t+)',
                        '(%0A+)',
                        '(%0D+)',
                        '(%08+)',
                        '(%09+)');
    
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    
    if(preg_match($inject, $str)) { return true; }
    else { return false; }
}
>