<?php  
require_once('./vendor/autoload.php');
use Postmark\PostmarkClient;
// you can change the key to any new key after activaing the api with your credit card.
 // the key is the one starting with f and ends with 0 
define('POSTMARK_API_KEY', 'f0653197-4a99-4fb4-a718-2f0bfa470200');
function send_email($email, &$response = null, &$http_code = null) {
  $json = json_encode(array(
    'From' => $email['from'],
    'To' => $email['to'],
    'Cc' => $email['cc'],
    'Bcc' => $email['bcc'],
    'Subject' => $email['subject'],
    'Tag' => $email['tag'],
    'HtmlBody' => $email['html_body'],
    'TextBody' => $email['text_body'],
    'ReplyTo' => $email['reply_to'],
    'Headers' => $email['headers'],
    'Attachments' => $email['attachments']
  ));
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    'X-Postmark-Server-Token: ' . POSTMARK_API_KEY
  ));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  $response = json_decode(curl_exec($ch), true);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $http_code === 200;
}
if (isset($_POST['join'])) {
  $email = $_POST['email'];
  $subject ="create your own subject here , remeber your subject will determine if your mail will go to inbox or spam";
  $html_message = "<html>
          <head>
          <title>if you think title is important</title>
          </head>
          <body>
          <h2>if you think heading is iportant</h2>
          <p>here's your welcome message you can have as many paragraph tags as possible </p>
          <a href = 'https://join.slack.com/t/triangleafrica/shared_invite/enQtNjM1ODAwNDE2Mzg4LWQ4NzVlMWE4YzIxMmM3ZTA5ZGY0MzgwOWY1N2MxMzFhMTkxZWQ5ZjllMjc0ZjZlN2ExYWNmN2U4ZTEyMDgwMTg' target='_blank' > click here to join </a>
          <p>Thank You!</P>
          <p>Best regards from all of us at Isteams</P>
          </body>
          </html>";
  $text_message = "This will be shown to plain-text mail clients, it is responsible for phones that does not view html messages";
// Send an email:
  $sent = send_email(array(
    'to' => $email,
    'from' => '<hi@triangle.africa>',
    'subject' => $subject,
    'text_body' => $text_message,
    'html_body' => $html_message
  ), $response, $http_code);
// Did it send successfully?
  if( $sent ) {
    // echo 'The email was sent!';
    header("Location: https://join.slack.com/t/triangleafrica/shared_invite/enQtNjM1ODAwNDE2Mzg4LWQ4NzVlMWE4YzIxMmM3ZTA5ZGY0MzgwOWY1N2MxMzFhMTkxZWQ5ZjllMjc0ZjZlN2ExYWNmN2U4ZTEyMDgwMTg");
   exit;
  } else {
    // echo 'The email could not be sent!';
    $Error_message = "your error message here";
    // below is javascript alert box
    echo "<SCRIPT> 
       alert('".$Error_message."');
    </SCRIPT>";
    // redirect to the homepage after 2 seconds if error
    header("Refresh: 2; url= index.php");
   exit;
  }
// Show the response and HTTP code: uncomment the below lines with echo only if there's an error
  // echo '<pre>';
  // echo 'The JSON response from Postmark:<br />';
  // print_r($response);
  // echo 'The HTTP code was: ' . $http_code;
  // echo '</pre>';
}

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

  <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Triangle Africa</title>
    <meta name="description" content="">
    <meta name="author" content="">

  <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">

  </head>
  <body id="home">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-sm">
      <div class="container">
        <a href="index/html" class="navbar-brand">
          <img src="images/logo.svg"  alt="Logo"/>
        </a>
      </div>
    </nav>

    <!-- Hero Header -->
    <section id="header" class="pt-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="pad pl-2">
              <h3 class="font-weight-bold">Slack Community For Creative Minds </h3>
              <p class="py-2">Learn, Build, Grow together</p>
              <p>Enter your email below and we'll instantly send you an invitation to the Triangle Africa Slack Workspace!</p>
            </div>
            <form action="#" method="POST" class="pl-2">
              <div class="form-group">
                <input type="text" name="email" class="form-control form-control-md" placeholder="joe@email.com">
              </div>
              <!-- <a href="https://join.slack.com/t/triangleafrica/shared_invite/enQtNjM1ODAwNDE2Mzg4LWQ4NzVlMWE4YzIxMmM3ZTA5ZGY0MzgwOWY1N2MxMzFhMTkxZWQ5ZjllMjc0ZjZlN2ExYWNmN2U4ZTEyMDgwMTg" class="btn btn-lg text-center btn-primary" type="button"> Join Now</a> -->

              <button name="join" class="btn btn-lg text-center btn-primary" type="submit"> Join Now</button>
            </form>
          </div>
          <div class="col-md-6">
            <img src="images\illustration.svg" alt="Community">
          </div>
        </div>
      </div>
    </section>

    <!-- PARTNER SECTION -->

    <section id="partner" class="py-3">
      <div class="container">
        <div class="row">
          <div class="col">
            <h3 class="text-center">Our Partner</h3>
            <div class="py-2 partner-img">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
            </div>
            <div class="py-2 partner-img-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
              <img src="images\Rectangle.svg" alt="partner1" class="p-2">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- VALUE SECTION -->

    <section id="value" class="py-5">
      <div class="container">
        <div class="row justify-content-center ">
          <div class="col-md-4">
            <img src="images\learn.png" alt="" class="py-3 pl-5 image">
            <h3 class="text-center text-white py-3">Learn</h3>
            <p class="text-center text-white pb-5 px-3">
              Get your project idea validated and reviewed to guarantee its success and maximize its potential
            </p>
          </div>
          <div class="col-md-4">
            <img src="images\build.png" alt="" class="py-3 pl-5 image">
            <h3 class="text-center text-white py-3">Build</h3>
            <p class="text-center text-white pb-5 px-3">
              Get your project idea validated and reviewed to guarantee its success and maximize its potential
            </p>
          </div>
          <div class="col-md-4">
            <img src="images\grow.png" alt="" class="py-3 pl-5 image">
            <h3 class="text-center text-white py-3">Grow</h3>
            <p class="text-center text-white pb-5 px-3">
              Get your project idea validated and reviewed to guarantee its success and maximize its potential
            </p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="quote-content">
              <img src="images\quote-left.png" alt="quote">
              <p class="text-center py-3 px-5">
                Triangle Africa is the fastest growing Pan-African Community
                of disruptive innovators and creators coming together to share ideas, build stuff and grow their immediate communities.
                Our goal is simple; to establish a strong foumdation for creative talents by providing training resources and build up gigs to ensure development and dependability of African communities.
                Simply put, we are building a network and fostering a community of smartest people creating freat stuff for Africa!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PERKS OF THE COMMUNITY -->
    <section id="perks">
      <div class="container">
        <div class="row justify-content-content">
          <div class="col">
            <h3 class="py-5 text-center">Perks of the Community</h3>
          </div>
        </div>
        <div class="row py-5">
          <div class="col-md-6 col-lg-4">
            <img src="images\knowledge_perk.svg" alt="" class="perks-image">
          </div>
          <div class="col-md-6 col-lg-8">
            <h5 class="font-weight-bold py-3">Knowledge Base</h5>
            <p class="pr-3">Triangle Africa comprises of the brightest minds in Africa skilled in various specialities, serving as knowledge-base for everyother person in the community</p>
          </div>
        </div>
        <div class="row py-5">
          <div class="col-md-6 col-lg-8 pt-4 order-last">
            <h5 class="font-weight-bold py-3">Collaboration</h5>
            <p class="pr-3">This is our number one rule! Everyone collaborates locally and internationally to work and build a friendly ecosysytem for all.</p>
          </div>
          <div class="col-md-6 col-lg-4 order-lg-last order-md-last">
            <img src="images\collab_perk.svg" alt="" class="perks-image ">
          </div>
        </div>
        <div class="row py-5">
          <div class="col-md-6 col-lg-4">
            <img src="images\interview_perk.svg" alt="" class="perks-image">
          </div>
          <div class="col-md-6 col-lg-8">
            <h5 class="font-weight-bold py-3">Opportunities</h5>
            <p class="pr-3">Communitiy members get first hand information about the latestn gigs, funding/ grants for thier startup/cause and more groundbreakking  ideas or resources</p>
          </div>
        </div>
        <div class="row py-5">
          <div class="col-md-6 col-lg-8 pt-4 order-last">
            <h5 class="font-weight-bold py-3">You get to Build</h5>
            <p class="pr-3">Creating and sustaining the development of Africa is our (and the community member’s)  responsibility. We believe that everyone’s contribution revolutionize Africa one product, tool, art, business or solution at a time!</p>
          </div>
          <div class="col-md-6 col-lg-4 order-lg-last order-md-last">
            <img src="images\build_perk.svg" alt="" class="perks-image ">
          </div>
        </div>
      </div>
    </section>

    <!-- INVOLVE -->
    <section id="involve" class="py-5">
      <img src="images\involve.svg" alt="creatives involved" class="img-fluid">
    </section>

    <!-- BLOG -->

    <section id="blog" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col">
            <h3 class="font-weight-bold pb-2">The Blog</h3>
            <a href="#" class="btn text-center btn-primary" role="button"> View All Post</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 py-3">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title py-2">Anouncing Triangle Africa</h3>
                <img src="images\Ellipse.svg" alt="" class="float-left pr-4">
                <p class="card-text pt-3">Ademola Adeniyi  on 27/03/2019</p>
                <a href="#" role="button">Read more <i class="fa fa-arrow-right pl-2"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 py-3">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title py-2">Anouncing Triangle Africa</h3>
                <img src="images\Ellipse.svg" alt="" class="float-left pr-4">
                <p class="card-text pt-3">Ademola Adeniyi  on 27/03/2019</p>
                <a href="#" role="button">Read more <i class="fa fa-arrow-right pl-2"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- NEWSLETTER -->

    <div class="container">
      <div class="row">
        <div class="col">
          <h3 class="text-center font-weight-bold py-3">Subscribe to our Newsletter
          </h3>
        </div>
      </div>
    </div>
    <section id="newsletter" >
      <div class="container">
        <div class="row justify-content-center pt-5">
          <div class="col-md-6">
            <div class="ml-3">
              <p class=" text-left font-weight-bold">
                Stay in the Angle
              </p>
              <p class=" text-left">
                Sign up to start receiving great updates from us.
              </p>
            </div>
          </div>
          <div class="col-md-6 ">
            <form action="https://africa.us20.list-manage.com/subscribe/post?u=4ccecfc8c10a9f6cbf0d34ebd&amp;id=992b1aa184" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="form-inline target="_blank" novalidate">
              <input type="email" value="" name="EMAIL" id="mce-EMAIL" class="form-control form-control-lg mr-0" placeholder="Enter your email address">
              <button class="btn btn-lg ml-3" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" >Subscribe</button>
              <div id="mce-responses" class="clear ">
                <div class="response text-center" id="mce-error-response" style="display:none"></div>
                <div class="response text-center" id="mce-success-response" style="display:none"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <footer class="pt-5" id="footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <img src="images/triangle.png" class="footer-img" width="200" height="125" alt="Triangel Africa Logo"/>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="pt-3">
              <p class="font-weight-bold text-center">hi@triangle.africa</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex flex-row justify-content-center pt-0">
              <div class="p-3">
                <a href="#"><i class="fa fa-twitter"></i></a>
              </div>
              <div class="p-3">
                <a href="#"><i class="fa fa-medium"></i></a>
              </div>
              <div class="p-3">
                <a href="https://github.com/triangle-africa"><i class="fa fa-github"></i></a>
              </div>
              <div class="p-3">
                <a href="#"><i class="fa fa-behance"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <script src="jquery/jquery.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
    <script type='text/javascript'>
      (function($) {
       window.fnames = new Array();
       window.ftypes = new Array();
       fnames[0]='EMAIL';
       ftypes[0]='email';
     } (jQuery));
      var $mcj = jQuery.noConflict(true);
    </script>
  </body>
  </html>
