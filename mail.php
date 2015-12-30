<?php

  if (isset($_POST)) {
    
    //form validation vars
    $formok = true;
    $errors = array();
    
    //sumbission data
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $date = date('d/m/Y');
    $time = date('H:i:s');
    
    //form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    //form validation to go here....
    if (empty($name)) {
      $formok = false;
      $errors[] = "You have not entered a name";
    }

    if (empty($email)) {
      $formok = false;
      $errors[] = "You have not entered an email address";
    //validate email address is valid
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $formok = false;
      $errors[] = "You have not entered a valid email address";
    }

    if (empty($message)) {
      $formok = false;
      $errors[] = "You have not entered a message";
    }

    if ($formok) {
      $headers = "From: stain88@github.io" . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      
      $emailbody = "<p>New message recieved.</p>
        <p><strong>Name: </strong> {$name} </p>
        <p><strong>Email: </strong> {$email} </p>
        <p><strong>Message: </strong> {$message} </p>
        <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";
         
      mail("marcbaghdadi@gmail.com","New Message",$emailbody,$headers);
    }

    $returndata = array(
      'posted_form_data' => array(
        'name' => $name,
        'email' => $email,
        'message' => $message
      ),
      'form_ok' => $formok,
      'errors' => $errors
    );

    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
      //set session variables
      session_start();
      $_SESSION['cf_returndata'] = $returndata;
      
      //redirect back to form
      header('location: ' . $_SERVER['HTTP_REFERER']);
    }
  }

?>