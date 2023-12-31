<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/message.class.php');
require_once(__DIR__ . '/../database/faq.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/agent.class.php');
?>

<?php function setHeader(Session $session)
{ ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat help.eic</title>
        <link href="../css/common-style.css" rel="stylesheet">
        <link href="../css/chat-style.css" rel="stylesheet">

    </head>
<?php } ?>

<?php
function drawBody(array $messages, int $ticketId, PDO $db, Session $session)
{ ?>
    <div class="chat-outer-container">
        <div class="chat-inner-container">
            <div class="chat-header">Chat Conversation</div>
            <div class="chat-messages">
                <?php foreach ($messages as $message) drawMessage($message,$db)?>
            </div>
            <?php drawInput($ticketId,$db, $session); ?>
        </div>
    </div>
<?php } ?>

<?php function drawMessage(Message $message, PDO $db)
{ ?>
    <div class="message">
        <div class="message-sender"><?php echo User::getName($db, $message->senderId); ?></div>
        <div class="message-content"><?php echo $message->messageText; ?></div>
        <div class="message-timestamp"><?php echo $message->createdAt; ?></div>
    </div>
<?php } ?>




<?php function drawInput(int $ticketId, PDO $db, Session $session) { ?>
    <?php 
        $ticket = Ticket::getTicket($db, $ticketId);
        $faqs = FAQ::getSubjectFAQs($db, $ticket->subject);
    ?>
    <div class="chat-input">
        <form method="post" action="../actions/action_send_message.php" class="input-form">
            <input type="hidden" name="ticket_id" value="<?php echo $ticketId; ?>">
            <textarea name="message" placeholder="Type your message"></textarea>
            <?php if (Agent::isAgent($db,$session->getId())) { ?>
                <select class="faq-bar" name="faq_id">
                    <option class="faq-option" value="">Select FAQ</option>
                    <?php foreach ($faqs as $faq) { ?>
                        <option class="faq-option" value="<?php echo $faq->id ?>"><?php echo $faq->question ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
            <input type="hidden" name="csrf" value="<?php echo $session->getCSRF(); ?>">
            <button type="submit" class="send-button">Send</button>
        </form>
    </div>

<?php } ?>

