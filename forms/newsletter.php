<?php
  // NexMutation Newsletter Subscription Handler
  $receiving_email_address = 'nexmutation.technology@gmail.com';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
  }

  $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';

  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die('Please enter a valid email address.');
  }

  $email_subject = "New Newsletter Subscription: " . $email;
  $email_body = "A new subscriber has joined the NexMutation newsletter:\n\nEmail: $email\nDate: " . date('Y-m-d H:i:s') . "\n";

  $headers = "From: NexMutation Web <noreply@" . ($_SERVER['SERVER_NAME'] ?? 'nexmutation.com') . ">\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();

  // Attempt to send email via standard PHP mail
  @mail($receiving_email_address, $email_subject, $email_body, $headers);

  // Return OK for AJAX validate.js
  echo 'OK';
?>
