<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Required fields
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '';

    // Additional fields
    $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : '';
    $mobile = isset($_POST['mobile']) ? strip_tags(trim($_POST['mobile'])) : '';
    $event = isset($_POST['event']) ? strip_tags(trim($_POST['event'])) : '';

    // Send email
    $to_email = 'jaipatadia@gmail.com'; // Your email here
    $subject = $subject != '' ? $subject : 'New Guest Attending your Wedding Event';

    $message = '<h3>You got a new Guest Attending your Wedding Event:</h3>' . '<br/>';
    $message .= '<b>Name:</b> ' . $name . '<br/>';

    if (!empty($email)) {
        $message .= '<b>Email:</b> ' . $email . '<br/>';
    }

    if (!empty($mobile)) {
        $message .= '<b>Mobile:</b> ' . $mobile . '<br/>';
    }

    if (!empty($event)) {
        $message .= '<b>Event:</b> ' . $event . '<br/>';
    }

    // Set the email headers
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
    $headers .= 'From: Wedding Invite <no-reply@wedding-invite.com>' . "\r\n";

    // Attempt to send email
    if (mail($to_email, $subject, $message, $headers)) {
        // Email sent successfully
        echo json_encode(array('success' => true, 'message' => 'Email sent successfully.'));
    } else {
        // Return error response
        echo json_encode(array('success' => false, 'message' => 'Failed to send email. Please try again later.'));
    }
} else {
    // Return error response
    echo json_encode(array('success' => false, 'message' => 'Method Not Allowed'));
}

?>
