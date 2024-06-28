<?php

// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate form data.
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : "";
    $email = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : "";
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : "";
    
    // Check for empty fields.
    if (empty($fullname) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Please fill out all fields.";
        exit;
    }
    
    // Set recipient email address.
    $recipient = "info@delifastlimited.com";
    
    // Set the email subject.
    $subject = "New contact from $fullname";
    
    // Build the email headers.
    $email_headers = "From: $fullname <$email>";
    
    // Build the email content.
    $email_content = "Fullname: $fullname\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Message:\n$message\n";
    
    // Send the email.
    $mail_sent = mail($recipient, $subject, $email_content, $email_headers);
    
    if ($mail_sent) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
    
} else {
    http_response_code(403);
    echo "Forbidden - Please submit the form using POST method.";
}

?>
