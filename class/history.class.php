<?php

class History
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function get($submissionID) {
        $stmt = $this->db->prepare("
			SELECT history.*, users.* FROM history
			INNER JOIN users ON history.users_id = users.id
			WHERE history.submissions_id = :submissionID
		");

        $stmt->bindParam(':submissionID', $submissionID);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insert($submissionID, $userID, $status, $comment) {
        $stmt = $this->db->prepare("
            INSERT INTO submissions(
              submissions_id,
              users_id,
              new_status,
              comment,
              date
            ) VALUES (
              :submissionID,
              :userID,
              :status,
              :comment,
              now()
            )
        ");
        $stmt->bindParam(':submissionID', $submissionID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':comment', $comment);

        $stmt->execute();
    }
}