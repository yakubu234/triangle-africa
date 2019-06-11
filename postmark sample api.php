<?php  
require_once('./vendor/autoload.php');
use Postmark\PostmarkClient;
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
  // $client = new PostmarkClient("f0653197-4a99-4fb4-a718-2f0bfa470200");
if (isset($_POST['join'])) {
// Send an email:

$mail = "yakubuabiola2003@gmail.com";
    // 
    $sent = send_email(array(
    'to' => 'hi@triangle.africa',
    'from' => 'Me <hi@triangle.africa>',
    'subject' => 'A test from your developer',
    'text_body' => 'This will be shown to plain-text mail clients',
    'html_body' => '<html><body>But <em>this</em> will be shown to HTML mail clients please reply to '.$mail.'if you receive this message</body></html>'
), $response, $http_code);
// Did it send successfully?
if( $sent ) {
    echo 'The email was sent!';
} else {
    echo 'The email could not be sent!';
}
// Show the response and HTTP code
echo '<pre>';
echo 'The JSON response from Postmark:<br />';
print_r($response);
echo 'The HTTP code was: ' . $http_code;
echo '</pre>';
    // 

}

?>