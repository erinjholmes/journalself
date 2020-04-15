<?php
  if (session_status() == PHP_SESSION_NONE)
  {
    session_start();
    require_once("../include/DB_jself_config.php");
  }
  if($_POST['Signup']) //if user clicked "Signup" button
  {
    //save all entered data as session variables
    $email_signup = $_POST['email_signup'];
    $_SESSION["email_signup"] = $email_signup;
    $fname_signup = $_POST['fname_signup'];
    $_SESSION["fname_signup"] = $fname_signup;
    $lname_signup = $_POST['lname_signup'];
    $_SESSION["lname_signup"] = $lname_signup;
    $title_signup = $_POST['title_signup'];
    $_SESSION["title_signup"] = $title_signup;
    $organization_signup = $_POST['organization_signup'];
    $_SESSION["organization_signup"] = $organization_signup;
    $scopusid_signup = $_POST['scopusid_signup'];
    $_SESSION["scopusid_signup"] = $scopusid_signup;

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

       $time_signup = gmdate("Y-m-d H:i:s");
       $sql = 'CREATE TABLE IF NOT EXISTS betatesters (n INT AUTO_INCREMENT PRIMARY KEY, timesignup DATETIME, email VARCHAR(250), fname VARCHAR(50), lname VARCHAR(50), title VARCHAR(250), organization VARCHAR(250), scopusid VARCHAR(50))';
       $result = mysqli_query($DBcon, $sql);
       if(!$result) print_r(mysqli_error($DBcon) . '<br>');

       $sql = 'INSERT INTO betatesters (timesignup, email, fname, lname, title, organization, scopusid) VALUES ("' . $time_signup . '","' . $email_signup . '","' . $fname_signup . '","' . $lname_signup . '","' . $title_signup . '","' . $organization_signup . '","' . $scopusid_signup . '")';
       $result = mysqli_query($DBcon, $sql);
       if(!$result) print_r(mysqli_error($DBcon) . '<br>');
       $successFlag_signup = true;
       $_SESSION["successFlag_signup"] = $successFlag_signup;
    }
  }
  $email_signup = $_SESSION["email_signup"];
  $fname_signup = $_SESSION["fname_signup"];
  $lname_signup = $_SESSION["lname_signup"];
  $title_signup = $_SESSION["title_signup"];
  $organization_signup = $_SESSION["organization_signup"];
  $scopusid_signup = $_SESSION["scopusid_signup"];
  $recaptcha_highlight = $_SESSION["recaptcha_highlight"];
  $successFlag_signup = $_SESSION["successFlag_signup"];
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs -->
  <meta charset="utf-8">
  <title>Signup</title>
  <meta name="description" content="JournalSelf is an open-access publishing editor and repository for electronic preprints. JournalSelf consists of research papers across all fields of academia, which can be accessed online.">
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
          <nav class="main-menu hidden-xs hidden-sm hidden-md">
              <ul class="nav-list">
          <li class="menu-item"><a class="menu-item-link" href="../index.html">Home</a></li>
          <li class="menu-item"><a class="menu-item-link" href="../about/index.html">About</a></li>
          <li class="menu-item"><a class="menu-item-link menu-item-current" href="../signup/index.php">Signup</a></li>
          <li class="menu-item"><a class="menu-item-link" href="../contact/index.php">Contact</a></li>
        </ul>
          </nav>
              </div>
        <div class="navbar-right">
        </div>
      </div>
    </div>
  </header>

  <!-- Banner -->
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
          <h1>Be The First To Try JournalSelf.</h1>
          <p>Signup for an early invite and we'll notify you before we open protocols to the general public.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->

<div class="section signup">
  <div class="container">
    <div class="row">
      <?php
         if($connection_error_flag)
         {
            echo "<b>Sorry! Our database connection is too busy at the moment. Please try again later. You can also let us know about this probelm at our <a href='../contact/index.php'>Contact page</a>.</b>";
         }
         if($successFlag_signup)
         {
            echo "<b>Thank you, " . $fname_signup . ", for signing up! We will send you an invitation via e-mail as soon as we are ready for beta-testing.</b>";
         }
      ?>
      <div class="card-panel">
        <div class="col-12">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
              <label for="EmailInput">Your Email*</label>
              <input class="full-width" type="email" name="email_signup" id="EmailInput" value="<?php echo $email_signup; ?>" required>

              <label for="FNameInput">First Name*</label>
              <input class="full-width" type="fname" name="fname_signup" id="FNameInput" value="<?php echo $fname_signup; ?>" required>

              <label for="LNameInput">Last Name*</label>
              <input class="full-width" type="lname" name="lname_signup" id="LNameInput" value="<?php echo $lname_signup; ?>" required>

              <label for="TitleInput">Title</label>
              <input class="full-width" type="title" name="title_signup" id="TitleInput" value="<?php echo $title_signup; ?>">

              <label for="OrgInput">School or Organization, Country</label>
              <input class="full-width" type="organization" name="organization_signup" id="OrgInput" value="<?php echo $organization_signup; ?>">

              <label for="OrgInput">Your <a href=https://www.scopus.com/search/form.uri?display=basic#author>Scopus ID</a> (typically 10-digit number)</label>
              <input class="full-width" type="text" name="scopusid_signup" id="OrgInput" value="<?php echo $scopusid_signup; ?>">

              <?php
                  if($recaptcha_highlight) echo '<div><font color="red">Please check the reCaptcha form:</font></div>';
              ?>
              <div class="g-recaptcha" data-sitekey="6LcDUNEUAAAAADBAPtIDF64cx6UXrowryE7nR8Sr"></div><br>

            <input class="button-primary" type="submit" name="Signup" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
?>

<!-- Footer -->
  <div class="footer">
      <a class="logo" href="../index.html"><span class="logo-text">Journal<span style="font-weight: 300;">Self</span></span></a>
      <div class="footer-social">
        <ul class="icons">
          <li><a class="icon brands fa-twitter" href="https://twitter.com/journalselforg"></a></li>
          <li><a class="icon brands fa-facebook" href="https://facebook.com/journalselforg"></a></li>
          <li><a class="icon brands fa-linkedin" href="https://www.linkedin.com/company/journalselforg"></a></li>
          <li><a class="icon brands fa-github" href="https://github.com/JournalSelf"></a></li>
          <li><a class="icon brands fa-telegram-plane" href="https://t.me/joinchat/Kgb4KBtIC41lLch-sCEDRw"></a></li>
      </ul>
  </div>
</div>

<!-- Site Footer -->
<footer class="site-footer">
  <div class="container">
      <p class="copyright">&copy; JournalSelf Inc. | Academic Publishing Framework | All Rights Reserved</p>
    <ul class="menu">
        <li><a class="footer-menu-item" href="../privacy-policy/index.html">Privacy policy</a></li>
        <li><a class="footer-menu-item" href="../terms-of-service/index.html">Terms of service</a></li>
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
  integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
  crossorigin="anonymous">
</script>

<script src="../assets/js/main.js"></script>

</body>
</html>
