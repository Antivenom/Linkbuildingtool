<?php

class Linksite
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function add($CustomerID, $name, $type, $category, $rating, $comment, $url, $submitpage, $costs, $costs_amount, $backlink, $owner, $owneremail, $campaignIDs)
    {
        $submission = new Submission($this->db);

        try {
            $stmt = $this->db->prepare("
				INSERT INTO linksites(
					customer_id,
					name,
					type,
					category,
					rating,
					comment,
					url,
					submit_page,
					costs,
					costs_amount,
					backlink,
					owner,
					owner_email
				) VALUES (
					:customerid,
					:name,
					:type,
					:category,
					:rating,
					:comment,
					:url,
					:submit_page,
					:costs,
					:costs_amount,
					:backlink,
					:owner,
					:owner_email
				)
			");

            $stmt->bindParam(':customerid', $CustomerID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':submit_page', $submitpage);
            $stmt->bindParam(':costs', $costs);
            $stmt->bindParam(':costs_amount', $costs_amount);
            $stmt->bindParam(':backlink', $backlink);
            $stmt->bindParam(':owner', $owner);
            $stmt->bindParam(':owner_email', $owneremail);

            $stmt->execute();

            if ($stmt) {
                $linksiteID = $this->db->lastInsertId();
                foreach ($campaignIDs as $id) {
                    if (!$submission->addSubmission($id, $linksiteID, $url, null, 'Not Submitted')) {
                        return false;
                    }
                }
                return true;
            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($id, $name, $type, $category, $rating, $comment, $url, $submitpage, $costs, $costs_amount, $backlink, $owner, $owneremail, $rip_status, $connectLinksites)
    {
        $stmt = $this->db->prepare("
			UPDATE linksites
			SET
				name = :name,
				type = :type,
				category = :category,
				rating = :rating,
				comment = :comment,
				url = :url,
				submitpage = :submitpage,
				costs = :costs,
				costs_amount = :costs_amount,
				backlink = :backlink,
				owner = :owner,
				owner_email = :owner_email,
				rip_status = :ripstatus
			WHERE
				id = :id
		");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':submit_page', $submitpage);
        $stmt->bindParam(':costs', $costs);
        $stmt->bindParam(':costs_amount', $costs_amount);
        $stmt->bindParam(':backlink', $backlink);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':owner_email', $owneremail);
        $stmt->bindParam(':ripstatus', $rip_status);
        $stmt->bindParam('id', $id);

        $stmt->execute();

        $objSubmission = new Submission($this->db);
        $allSubmissions = $objSubmission->getSubmissions('linksite', $id);

        return ($objSubmission->manageSubmissions('linksites', $connectLinksites, $allSubmissions));

    }
    public function delete($LinksiteID)
    {
        $stmt = $this->db->prepare("
			DELETE
			FROM linksites
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $LinksiteID);
        $stmt->execute();
    }

    public function get($linksiteID) {
        $stmt = $this->db->prepare("
			SELECT *
			FROM linksites
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $linksiteID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getLinksites($CustomerID)
    {
        $stmt = $this->db->prepare("
			SELECT *
			FROM linksites
			WHERE
				customer_id = :customerID
		");

        $stmt->bindValue(':customerID', $CustomerID);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function fetchUrl($CustomerID)
    {
        $stmt = $this->db->prepare("
			SELECT url
			FROM linksites
			WHERE
				customer_id = :customerID
		");

        $stmt->bindValue(':customerID', $CustomerID);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getLinksite($LinksiteID)
    {
        $stmt = $this->db->prepare("
			SELECT *
			FROM linksites
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $LinksiteID);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }

    public function count($CustomerID)
    {
        $stmt = $this->db->prepare("SELECT id FROM linksites WHERE customer_id = :id");
        $stmt->bindParam(':id', $CustomerID);
        $stmt->execute();

        $count = $stmt->rowCount();
        return $count;
    }
}