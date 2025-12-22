
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// SMTP credentials from Afrihost
$smtpHost = 'mail.imscollegesa.co.za';
$smtpUsername = 'info@imscollegesa.co.za';
$smtpPassword = 'IMS082680';                      
$smtpPort = '465/587/993';
$toEmail = 'info@imscollegesa.co.za';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize form input
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $idNumber = htmlspecialchars($_POST['id_number']);
    $gender = htmlspecialchars($_POST['gender']);
    $program = htmlspecialchars($_POST['program']);
    $campus = htmlspecialchars($_POST['campus']);
    $message = htmlspecialchars($_POST['message']);

    // Build email content
    $subject = "New Admission Application from $firstName $lastName";
    $body = "
        <h2>Admission Application Details</h2>
        <p><strong>Name:</strong> $firstName $lastName</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>ID Number:</strong> $idNumber</p>
        <p><strong>Gender:</strong> $gender</p>
        <p><strong>Program:</strong> $program</p>
        <p><strong>Preferred Campus:</strong> $campus</p>
        <p><strong>Additional Info:</strong><br>$message</p>
    ";

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUsername;
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
        $mail->Port       = $smtpPort;

        // Recipients
        $mail->setFrom($smtpUsername, 'IMS College Admissions');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
