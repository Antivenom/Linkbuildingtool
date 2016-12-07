<?php

class Submission
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function manageSubmissions($type, $checkedData, $submissions)
    {
        if ($type == 'linksites') {
            foreach($submissions as $submission){
                if($submission == $checkedData) {

                } elseif($submission != $checkedData) {
                    $this->deleteSubmission($submission);
                } elseif($checkedData == $submission) {

                } elseif($checkedData != $submission) {
                    $this->add();
                }
            }
        } elseif ($type == 'campaigns') {
            foreach($submissions as $submission){
                if($submission == $checkedData) {

                } elseif($submission != $checkedData) {
                    $this->deleteSubmission($submission);
                } elseif($checkedData == $submission) {

                } elseif($checkedData != $submission) {
                    $this->add();
                }
            }
        }
    }

    private function add($CampaignID, $LinksiteID, $LinkUrl, $Comment, $Status)
    {
        $stmt = $this->db->prepare("
			INSERT INTO submissions(
				campaigns_id,
				linksites_id,
				link_url,
				comment,
				status
			) VALUES (
				:campaignid,
				:linksiteid,
				:linkurl,
				:comment,
				:status
			)
		");

        $stmt->bindParam(':campaignid', $CampaignID);
        $stmt->bindParam(':linksiteid', $LinksiteID);
        $stmt->bindParam(':linkurl', $LinkUrl);
        $stmt->bindParam(':comment', $Comment);
        $stmt->bindParam(':status', $Status);

        $stmt->execute();

        return $stmt;
    }

    private function deleteSubmission($SubmissionID)
    {
        $stmt = $this->db->prepare("
			DELETE
			FROM submissions
			WHERE
				id = :id
		");

        $stmt->bindParam(':id', $SubmissionID);
        $stmt->execute();
    }

    public function getSubmissions($type, $ID)
    {
        if($type == 'campaign'){
            $stmt = $this->db->prepare("
			SELECT linksites.*, submissions.* FROM submissions
			INNER JOIN linksites ON submissions.linksites_id = linksites.id
			WHERE submissions.campaigns_id = :campaignID
		    ");
            $stmt->bindValue(':campaignID', $ID);
        }elseif($type == 'linksite'){
            $stmt = $this->db->prepare("
			SELECT campaigns.*, submissions.* FROM submissions
			INNER JOIN campaigns ON submissions.campaigns_id = campaigns.id
			WHERE submissions.linksite_id = :linksiteID
		    ");
            $stmt->bindValue(':linksiteID', $ID);
        }
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getSubmissionID($CampaignID) {
        $stmt = $this->db->prepare("
			SELECT id
			FROM submissions
			WHERE campaigns_id = :campaignid
		");

        $stmt->bindParam(':campaignid', $CampaignID);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSubmissionStatus($CampaignID)
    {
        $stmt = $this->db->prepare("
			SELECT status
			FROM submissions
			WHERE campaigns_id = :campaignid
		");

        $stmt->bindParam(':campaignid', $CampaignID);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($submissionID, $newStatus, $newComment){
        $stmt = $this->db->prepare("
            UPDATE history
            SET
              comment = :comment,
              status = :status,
            WHERE
              id = :submissionid
        ");
        $stmt->bindParam(':comment', $newComment);
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':submissionid', $submissionID);

        $stmt->execute();
    }

    public function getSubmission($campaignID, $linksiteID){
        $stmt = $this->db->prepare("
            SELECT *
            FROM submissions
            WHERE
              linksites_id = :linkID
            AND
              campaigns_id = :campaignID
        ");

        $stmt->bindParam(':linkID', $linksiteID);
        $stmt->bindParam(':campaignID', $campaignID);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}