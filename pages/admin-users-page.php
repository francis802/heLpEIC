<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/admin-page.tpl.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = getDatabaseConnection();

  $users = User::getAllUsers($db);

  setHeaderAdminPage();
  drawHeader($session);
  listAllUsers($users, $db);
  drawFooter();
?>