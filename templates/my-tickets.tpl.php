<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/subject.class.php');
require_once(__DIR__ . '/../database/status.class.php');
?>

<?php function setHeaderMyTickets()
{ ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>help.eic Profile</title>
    <link rel="stylesheet" href="../css/my-tickets-style.css" />
    <link rel="stylesheet" href="../css/common-style.css" />
  </head>

<?php } ?>

<?php function drawSwitchMode()
{ ?>
  <div class="flex-switch">
    <div id="client">Client</div>
    <label class="switch">
      <input type="checkbox" checked>
      <span class="slider round"></span>
    </label>
    <div id="agent">Agent</div>
  </div>
<?php } ?>

<?php function drawTitle()
{ ?>
  <div class="container">
    <h1 class="upcomming">YOUR TICKETS</h1>

  <?php } ?>


  <?php function drawTicket(PDO $db, Ticket $ticket)
  { ?>
    <div class="item">
      <div class="item-right">
        <h2 class="num">
          <?php
          echo date("j", strtotime($ticket->time));
          ?>
        </h2>
        <p class="day">
          <?php
          $months = array(
            1 => "Jan",
            2 => "Feb",
            3 => "Mar",
            4 => "Apr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Aug",
            9 => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec"
          );
          echo $months[date("n", strtotime($ticket->time))];
          ?>
        </p>
        <span class="up-border"></span>
        <span class="down-border"></span>
      </div> <!-- end item-right -->

      <div class="item-left">
        <a href="another-page.html" class="plus-sign">&#43;</a>
        <p class="event">Ticket
          #
          <?php echo $ticket->id ?>
        </p>
        <h2 class="title">
          <?php echo $ticket->title ?>
        </h2>
        <div class="sce">
          <div class="icon">
            <i class="fa fa-table"></i>
          </div>
          <p>Client: <?php echo User::getName($db, $ticket->client) ?> <br />

            Agent: <?php
            if ($ticket->agent == null)
              echo "Not assigned";
            else
              echo User::getName($db, $ticket->agent) ?>
            </p>
          </div>
          <div class="fix"></div>
          <div class="loc">
            <div class="icon">
              <i class="fa fa-map-marker"></i>
            </div>
            <p>
            <?php 
              $subject = Subject::getSubject($db, $ticket->subject);
              
              echo "$subject->code $subject->subject_name <br /> $subject->full_name";?>
          </p>
        </div>
        <div class="fix"></div>
        <button class="<?php 
          $status = Status::getStatus($db,$ticket->status);
          echo "Open"; ?>"> <!--//TODO: change the status -->
            <?php echo $status->status_text; ?>
        </button>
      </div>
    </div>


  <?php } ?>

 