<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $db = getDatabaseConnection();

  if (User::validateUsername($db, $_POST['username']) == "" && User::validateEmail($db, $_POST['email']) == ""){
    $user = User::registerUser($db, $_POST['username'], $_POST['password'], $_POST['email'], $_POST['name']);
    $session->setId($user->id);
    $session->setName($user->name);
    $session->addMessage('success', 'Registration successful!');
    header('Location: /../pages/main-page.php');
  }
  else{
    $session->addMessage('error', 'Registration unsuccessful!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
?>