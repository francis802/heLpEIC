<?php
    declare(strict_types = 1);

    class Client {
        public int $user;

        public function __construct(int $user)
        {
            $this->user = $user;
        }

        static function addClient(PDO $db, int $id): ?Client {
            $stmt = $db->prepare('
              INSERT INTO CLIENT (USER_ID)
              VALUES (?)
            ');
        
            if ($stmt->execute(array($id))) {
                return new Client($id);
            } else {
                return null;
            }
        }

        static function isClient(PDO $db, int $id): bool {
            $stmt = $db->prepare('
              SELECT USER_ID
              FROM CLIENT
              WHERE USER_ID = ?
            ');
        
            $stmt->execute(array($id));

            if($stmt->fetch()) {
                return true;
            }
            return false;
        }
    }
?>