<?php

class Campaign
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function add($CustomerID, $name, $email, $emailtemplate, $url, $category, $title, $description, $owner, $active, $bot, $linksiteDATA)
    {
        $submission = new Submission($this->db);

        try {
            $stmt = $this->db->prepare("
				INSERT INTO campaigns(
					customer_id,
					name,
					email,
					email_template,
					url,
					category,
					title,
					description,
					owner,
					active,
					bot_enabled
				) VALUES (
					:customerid,
					:name,
					:email,
					:emailtemplate,
					:url,
					:category,
					:title,
					:description,
					:owner,
					:active,
					:botenabled
				)
			");

            $stmt->bindParam(':customerid', $CustomerID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':emailtemplate', $emailtemplate);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':owner', $owner);
            $stmt->bindParam(':active', $active);
            $stmt->bindParam(':botenabled', $bot);

            $stmt->execute();

            if ($stmt) {
                $campaignID = $this->db->lastInsertId();
                foreach ($linksiteDATA as $data) {
                    if (!$submission->addSubmission($campaignID, $data['id'], $data['url'], null, 'Not Submitted')) {
                        return false;
                    }
                }
                return true;
            }
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($CampaignID)
    {
        $stmt = $this->db->prepare("
			DELETE
			FROM campaigns
			WHERE
				id = :id
		");

        $stmt->bindParam(':id', $CampaignID);
        $stmt->execute();
    }

    public function getCampaigns($CustomerID)
    {
        $stmt = $this->db->prepare("
			SELECT *
			FROM campaigns
			WHERE
				customer_id = :customerID
		");

        $stmt->bindValue(':customerID', $CustomerID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    public function getCampaign($CampaignID)
    {
        $stmt = $this->db->prepare("
			SELECT *
			FROM campaigns
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $CampaignID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getCampaign2($CampaignID)
    {
        $stmt = $this->db->prepare("
			SELECT *
			FROM campaigns
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $CampaignID);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

    public function update($name, $email, $emailtemplate, $url, $category, $title, $description, $owner, $id, $active, $bot)
    {
        $stmt = $this->db->prepare("
			UPDATE campaigns
			SET
				name = :name,
				email = :email,
				email_template = :emailtemplate,
				url = :url,
				category = :category,
				title = :title,
				description = :description,
				owner = :owner,
				active = :active,
				bot_enabled = :bot
			WHERE
				id = :id
		");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emailtemplate', $emailtemplate);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':bot', $bot);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt;
    }

    public function fetchAllCampaigns()
    {

        $sqlQuery = $this->db->prepare("SELECT * FROM campaigns");
        $sqlQuery->execute();

        return $sqlQuery->fetchAll();
    }

    public function count($CustomerID)
    {
        $stmt = $this->db->prepare("SELECT id FROM campaigns WHERE customer_id = :id");
        $stmt->bindParam(':id', $CustomerID);
        $stmt->execute();

        $count = $stmt->rowCount();
        return $count;
    }
}