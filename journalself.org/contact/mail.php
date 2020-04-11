<?php $name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$formcontent="From: $name \n Message: $message";
$recipient = "hello@journalself.org";
$subject = $_POST ['subject'];
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("oops. There is an error. Try my email: hello@journalself.org");
echo "Your message has been sent. Thank You."."<a rel='nofollow' target='_blank' href='/' style='text-decoration:none;color: #2F78FF;'> Return to homepage</a>";
?>
