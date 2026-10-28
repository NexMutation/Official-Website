<?php
  // NexMutation Contact Form Handler
  $receiving_email_address = 'nexmutation.technology@gmail.com';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
  }

  $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
  $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
  $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : 'New Contact Inquiry';
  $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

  if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die('Please complete the form and provide a valid email address.');
  }

  $email_subject = "NexMutation Contact Form: " . $subject;
  $email_body = "You have received a new message from the NexMutation website contact form.\n\n";
  $email_body .= "Name: $name\n";
  $email_body .= "Email: $email\n";
  $email_body .= "Subject: $subject\n\n";
  $email_body .= "Message:\n$message\n";

  $headers = "From: NexMutation Web <noreply@" . ($_SERVER['SERVER_NAME'] ?? 'nexmutation.com') . ">\r\n";
  $headers .= "Reply-To: $name <$email>\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();

  // Attempt to send email via standard PHP mail
  @mail($receiving_email_address, $email_subject, $email_body, $headers);

  // Return OK for the AJAX script (validate.js expects exactly 'OK')
  echo 'OK';
?>
