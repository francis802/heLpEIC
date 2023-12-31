<?php
    declare(strict_types = 1);

    class Hashtag {
        public int $id;
        public string $tag;

        public function __construct(int $id, string $tag)
        {
            $this->id = $id;
            $this->tag = $tag;
        }

        static function drawAllHashtags(PDO $db): array {
            $stmt = $db->prepare('
            SELECT *
            FROM HASHTAG');
            $stmt->execute();
            $hashtags = $stmt->fetchAll();
            $hashtagArray = array();
            foreach($hashtags as $hashtag) {
                $hashtagArray[] = new Hashtag(
                    (int) $hashtag['ID'],
                    $hashtag['TAG']
                );
            }
            return $hashtagArray;
        }

        static function getHashtagsFromTicket(PDO $db, int $ticket_id): array {
            $stmt = $db->prepare('
            SELECT HASHTAG.ID, HASHTAG.TAG
            FROM HASHTAG, TICKET_HASHTAG
            WHERE HASHTAG.ID = TICKET_HASHTAG.TAG
            AND TICKET_HASHTAG.TICKET_ID = ?');
            $stmt->execute(array($ticket_id));
            $hashtags = $stmt->fetchAll();
            $hashtagArray = array();
            foreach($hashtags as $hashtag) {
                $hashtagArray[] = new Hashtag(
                    (int) $hashtag['ID'],
                    $hashtag['TAG']
                );
            }
            return $hashtagArray;
        }

        static function getHashtag(PDO $db, int $hashtag_id): Hashtag {
            $stmt = $db->prepare('
            SELECT *
            FROM HASHTAG
            WHERE ID = ?');
            $stmt->execute(array($hashtag_id));
            $hashtag = $stmt->fetch();
            return new Hashtag(
                (int) $hashtag['ID'],
                $hashtag['TAG']
            );
        }

        static function associateTicket(PDO $db, int $ticket_id, int $hashtag_id): void {
            $stmt = $db->prepare('
            INSERT INTO TICKET_HASHTAG (TICKET_ID, TAG)
            VALUES (?, ?)');
            $stmt->execute(array($ticket_id, $hashtag_id));
        }

        static function verifyIfHashtagExists(PDO $db, int $tag, int $ticket_id): bool {
            $stmt = $db->prepare('
            SELECT *
            FROM TICKET_HASHTAG
            WHERE TAG = ? AND TICKET_ID = ?');
            $stmt->execute(array($tag,$ticket_id));
            $hashtag = $stmt->fetch();
            if ($hashtag == false) {
                return false;
            } else {
                return true;
            }
        }

    }
?>