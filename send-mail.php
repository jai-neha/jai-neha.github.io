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
    $mail_to = 'jaipatadia@gmail.com'; // Your email here
    $mail_subject = $subject != '' ? $subject : 'New Guest Attending your Wedding Event';

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
    if (mail($mail_to, $mail_subject, $message, $headers)) {
        // Email sent successfully, now insert into database
        
        // Database configuration
        $servername = "localhost";
        $username = "bizzpsei_jai";
        $password = "n9d-~[XSQepz";
        $dbname = "bizzpsei_weddinginvite";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO guests (name, email, mobile, event) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $mobile, $event);

        // Attempt to execute the SQL query
        if ($stmt->execute()) {
            // Close statement and database connection
            $stmt->close();
            $conn->close();
            
            // Return success response
            echo json_encode(array('success' => true, 'message' => 'Email sent successfully and record inserted into database.'));
        } else {
            // Return error response
            echo json_encode(array('success' => false, 'message' => 'Failed to insert record into database: ' . $conn->error));
        }
    } else {
        // Return error response
        echo json_encode(array('success' => false, 'message' => 'Failed to send email. Please try again later.'));
    }
} else {
    // Return error response
    echo json_encode(array('success' => false, 'message' => 'Method Not Allowed'));
}

?>
