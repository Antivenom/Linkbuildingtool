<?php
	class Permission
	{
		private $db;
		
		public function __construct($objDB_con)
		{
			$this->db = $objDB_con;
		}
		
		public function manageUser($UserID)
		{
			$superUser = $this->isSuperUser($_SESSION['UserID']);
			$hasCustomer = $this->hasUser($UserID);
			
			return ($superUser && $hasCustomer);
		}
		
		public function hasUser($UserID) {
			$CustomerIDUser = $this->db->prepare("
				SELECT customers_id
				FROM users
				WHERE
					id = :userid
			");
			
			$CustomerIDUser->bindParam(':userid', $UserID);
			$CustomerIDUser->execute();
			
			$fetchedConnectedCustomerUser = $CustomerIDUser->fetch(PDO::FETCH_ASSOC);
			
			return ($fetchedConnectedCustomerUser['customers_id'] == $_SESSION['CustomerID']);
		}
		
		public function isSuperUser($UserID)
		{
			$stmt = $this->db->prepare("
				SELECT superuser
				FROM users
				WHERE
					id = :id
			");
			
			$stmt->bindValue(':id', $UserID);
			$stmt->execute();
			
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			
			
			if($results['superuser'] == 1)
			{
				return true;
			} else {
				return false;
			}
		}
		
		public function Campaign($CampaignID, $CustomerID)
		{
			$stmt = $this->db->prepare("
				SELECT customer_id
				FROM campaigns
				WHERE
					id = :id
			");
			
			$stmt->bindValue(':id', $CampaignID);
			$stmt->execute();
			
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			return ($results['customer_id'] == $CustomerID);
		}
		
		public function Linksite($LinksiteID, $CustomerID)
		{
			$stmt = $this->db->prepare("
				SELECT customer_id
				FROM linksites
				WHERE
					id = :id
			");
			
			$stmt->bindValue(':id', $LinksiteID);
			$stmt->execute();
			
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			return ($results['customer_id'] == $CustomerID);
		}
		
		public function Submission($SubmissionID, $CustomerID)
		{
			$stmt = $this->db->prepare("
				SELECT campaigns_id
				FROM submissions
				WHERE
					id = :id
			");
			
			$stmt->bindParam(':id', $SubmissionID);
			$stmt->execute();
			
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$campaignID = $result['campaigns_id'];
			
			$stmt2 = $this->db->prepare("
				SELECT customer_id
				FROM campaigns
				WHERE
					id = :id
			");
			
			$stmt2->bindParam(':id', $campaignID);
			$stmt2->execute();
			
			$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			
			return ($result2['customer_id'] == $CustomerID);
			
		}

		public function activeCustomer($customerID) {
			$stmt = $this->db->prepare("
            SELECT active
            FROM customers
            WHERE id = :customerid
        ");
			$stmt->bindParam(':customerid', $customerID);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			return $result['active'];
		}

		public function activeUser($userID) {
			$stmt = $this->db->prepare("
            SELECT active
            FROM users
            WHERE id = :userid
        ");
			$stmt->bindParam(':userid', $userID);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			return $result['active'];
		}

		public function addCampaign() {
			$objCampaigns = new Campaign($this->db);
			$stmt = $this->db->prepare("
				SELECT packages.* FROM customers
				INNER JOIN packages ON customers.packages_id = packages.id
				WHERE customers.id = :customersID
			");

			$stmt->bindParam(':customersID', $_SESSION['CustomerID']);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$allowedAmount = $result['campaigns_amount'];
			$currentAmount = $objCampaigns->count($_SESSION['CustomerID']);

			return ($currentAmount < $allowedAmount);
		}

		public function addLinksite() {
			$objLinksites = new Linksite($this->db);
			$stmt = $this->db->prepare("
				SELECT packages.* FROM customers
				INNER JOIN packages ON customers.packages_id = packages.id
				WHERE customers.id = :customersID
			");

			$stmt->bindParam(':customersID', $_SESSION['CustomerID']);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$allowedAmount = $result['linksites_amount'];
			$currentAmount = $objLinksites->count($_SESSION['CustomerID']);

			return ($currentAmount < $allowedAmount);
		}
	}