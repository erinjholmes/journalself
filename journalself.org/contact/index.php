<?php
  if (session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  //prepare array of options for the reasons of sending an email
  $option[0] = "General questions";
  $option[1] = "Inquiries";
  $option[2] = "Proposal/idea";
  $option[3] = "Press";
  $option[4] = "Help";
  if($_POST['Contact']) //if user clicked "Submit" button (named "Contact")
  {
    //save all entered data as session variables
    $fname_contact = $_POST['fname_contact'];
    $_SESSION["fname_contact"] = $fname_contact;
    $lname_contact = $_POST['lname_contact'];
    $_SESSION["lname_contact"] = $lname_contact;
    $email_contact = $_POST['email_contact'];
    $_SESSION["email_contact"] = $email_contact;
    $reason_contact = $_POST['reason_contact'];
    $_SESSION["reason_contact"] = $reason_contact;
    $message_contact = $_POST['message_contact'];
    $_SESSION["message_contact"] = $message_contact;
    $sendyourself_contact = $_POST['sendyourself_contact'];
    $_SESSION["sendyourself_contact"] = $sendyourself_contact;
    
    //reCAPTCHA section
    if(isset($_POST['g-recaptcha-response']))
    {
      $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha)
    {
       $_SESSION["recaptcha_highlight"] = true;
    }
    else
    {
       $_SESSION["recaptcha_highlight"] = false;
       
       $secretKey = "6LcDUNEUAAAAAGZqMmpNXrl7UvPBacFXIPlGDkJP";
       // post request to server
       $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
       $response = file_get_contents($url);
       $responseKeys = json_decode($response,true);
       // should return JSON with success as true
       if(!$responseKeys["success"])exit;

       $recipient = "admin@journalself.org";
       $subject = "JournalSelf: " . $option[intval($reason_contact)];
       $formcontent="From: " . $fname_contact . " " . $lname_contact . "\n" . $message_contact;
       $mailheader = "From: " . $email_contact . "\r\n";
       
       mail($recipient, $subject, $formcontent, $mailheader) or die("oops. There is an error. Try my email: admin@journalself.org");
       
       $successFlag_contact = true;
       $_SESSION["successFlag_contact"] = $successFlag_contact;
    }
  }
  $email_contact = $_SESSION["email_contact"];
  $fname_contact = $_SESSION["fname_contact"];
  $lname_contact = $_SESSION["lname_contact"];
  $reason_contact = $_SESSION["reason_contact"];
  $selected_contact = array_fill(0,5,"");
  $selected_contact[intval($reason_contact)] = "selected";
  $message_contact = $_SESSION["message_contact"];
  $sendyourself_contact = $_SESSION["sendyourself_contact"];
  $recaptcha_highlight = $_SESSION["recaptcha_highlight"];
  $successFlag_contact = $_SESSION["successFlag_contact"];
?> 
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs -->
  <meta charset="utf-8">
  <title>Contact JournalSelf</title>
  <meta name="description" content="Please reach out for questions, inquiries, and general help.">
  <meta name="author" content="JournalSelf">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="../assets/css/normalize.css">
  <link rel="stylesheet" href="../assets/css/main.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="images/favicon.png">

  <!-- Recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>

  <!-- Navigation -->
  <header class="site-header">
    <div class="container">
      <div class="navbar">
        <div class="navbar-left">
          <div class="burger hidden-lg hidden-xl"><i class="fas fa-bars"></i></div>
          <a class="logo" href="../index.html">
        <span class="logo-text">Journal<span style="font-weight: 300;">Self</span></span></a>
        <div class="sep hidden-xs hidden-sm"></div>
          <nav class="primary-menu hidden-xs hidden-sm hidden-md">
              <ul class="nav-list primary-menu">
          <li class="menu-item"><a class="menu-item-link" href="../index.html">Home</a></li>
          <li class="menu-item"><a class="menu-item-link" href="../about/index.html">About</a></li>
          <li class="menu-item"><a class="menu-item-link" href="../signup/index.php">Signup</a></li>
          <li class="menu-item"><a class="menu-item-link menu-item-current" href="../contact/index.php">Contact</a></li>
        </ul>
          </nav>
              </div>
        <div class="navbar-right">
        </div>
      </div>
    </div>
  </header>

  <!-- Banner -->
  <div class="section banner">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
          <h1 class="major-title">Contact us at JournalSelf.</h1>
          <p class="major-paragraph">Please reach out for questions, inquiries, ideas, and general help using the form below.</p>
          <a class="button button-primary" href="../signup/index.php">or...Signup for beta</a>
        </div>
      </div>
    </div>
  </div>

  <div class="js-width-wide">

    <!-- Forms -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
          <div class="section contact">
            <div class="container">
              <div class="row">
                <?php
                   if($successFlag_contact)
                   {
                      echo "<b>Thank you, " . $fname_contact . ", for sending us an e-mail! ";
                      if($sendyourself_contact == "on") echo "We sent you the copy of your message to " . $email_contact . " (please check the spam box). ";
                      echo "We will answer you as soon as possible.</b>";
                   }
                ?>
                <div class="col-12">
                <h2>Email Us</h2>
                <p>If you need further assistance, please reach us directly via email by filling out the form below.</p>
                </div>
            <div class="col-6">
              <label for="exampleFirstNameInput">Your first name*</label>
              <input class="full-width" type="fname" name="fname_contact" id="exampleFirstNameInput" value="<?php echo $fname_contact; ?>" required>
            </div>
            <div class="col-6">
              <label for="exampleLastNameInput">Your last name*</label>
              <input class="full-width" type="lname" name="lname_contact" id="exampleLastNameInput" value="<?php echo $lname_contact; ?>" required>
            </div>
            <div class="col-6">
              <label for="exampleEmailInput">Your email*</label>
              <input class="full-width" type="email" name="email_contact" id="exampleEmailInput" value="<?php echo $email_contact; ?>" required>
            </div>
            <div class="col-6">
              <label for="exampleRecipientInput">Reason for contacting</label>
              <select class="full-width" name="reason_contact" id="exampleRecipientInput" value="<?php echo $reason_contact; ?>">
                <option value="0" <?php echo $selected_contact[0]; ?>><?php echo $option[0]; ?></option>
                <option value="1" <?php echo $selected_contact[1]; ?>><?php echo $option[1]; ?></option>
                <option value="2" <?php echo $selected_contact[2]; ?>><?php echo $option[2]; ?></option>
                <option value="3" <?php echo $selected_contact[3]; ?>><?php echo $option[3]; ?></option>
                <option value="4" <?php echo $selected_contact[4]; ?>><?php echo $option[4]; ?></option>
              </select>
            </div>
            <div class="col-12">
          <label for="exampleMessage">Message*</label>
          <textarea class="full-width" name="message_contact" id="exampleMessage" required><?php echo $message_contact; ?></textarea>
        </div>
        <div class="col-12">
          <label class="example-send-yourself-copy">
            <?php
                if($sendyourself_contact == "on")
                {
                   echo '<input type="checkbox" name="sendyourself_contact" checked>';
                }
                else
                {
                   echo '<input type="checkbox" name="sendyourself_contact">';
                }
            ?>
            <span class="label-body">Send a copy to yourself</span>
          </label>

          <a name="recaptcha_anchor"></a>
          <?php
            if($recaptcha_highlight) echo '<div><font color="red">Please check the reCaptcha form:</font></div>';
          ?>
          <div class="g-recaptcha" data-sitekey="6LcDUNEUAAAAADBAPtIDF64cx6UXrowryE7nR8Sr"></div><br>
          
          <input class="button-primary" type="submit" name="Contact" value="Submit">
        </div>
      </div>
    </div>
  </div>
    </form>

</div>
    <!-- CTA -->
    <div class="section cta">
      <div class="container">
        <h1>Beta Test Signup Is <span style="color: #2F78FF;">Open</span></h1>
          <p>Sign up to beta test our tools for publishing research papers. Our publishing tools and open access repository are free to use. </p>
        </p>
        <a class="button button-primary" href="../signup/index.php">Sign up</a>
    </div>
  </div>

<!-- Footer -->
  <div class="footer">
      <a class="logo" href="../index.html"><span class="logo-text">Journal<span style="font-weight: 300;">Self</span></span></a>
      <div class="footer-social">
        <ul class="icons">
          <li><a class="icon brands fa-twitter" href="https://twitter.com/journalselforg"></a></li>
          <li><a class="icon brands fa-facebook" href="https://facebook.com/journalselforg"></a></li>
          <li><a class="icon brands fa-linkedin" href="https://linkedin.com/journalselforg"></a></li>
          <li><a class="icon brands fa-github" href="https://github.com/journalselforg"></a></li>
          <li><a class="icon brands fa-telegram-plane" href="https://telegram.com/journalselforg"></a></li>
      </ul>
  </div>
</div>

<!-- Site Footer -->
<footer class="site-footer">
  <div class="container">
      <p class="copyright">&copy; JournalSelf Inc. | Academic Publishing Framework | All Rights Reserved</p>
    <ul class="menu">
        <li><a class="footer-menu-item" href="../privacy-policy/index.html">Privacy Policy</a></li>
        <li><a class="footer-menu-item" href="../terms-of-service/index.html">Terms Of Service</a></li>
    </ul>
  </div>
</footer>

<div class="dimmer"></div>

<div class="off-canvas">
  <div class="canvas-close"><i class="fa fa-times"></i></div>
  <div class="mobile-menu"></div>
</div>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity=""
  crossorigin="anonymous">
</script>

<script src="../assets/js/main.js"></script>

</body>
</html>
