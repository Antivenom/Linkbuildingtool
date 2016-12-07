<?php
class Robin {
    private $db;

    function __construct($objDB_con) {
        $this->db = $objDB_con;

    }

    function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);

        curl_close($ch);
        return $data;
    }


    public function getSubmissions() {
        $stmt = $this->db->prepare("
            SELECT submissions.id, submissions.link_url, campaigns.url
            FROM submissions
            INNER JOIN campaigns ON submissions.campaigns_id = campaigns.id
			WHERE
              (submissions.status = 'accepted'
              OR
              submissions.status = 'submitted')
              AND
              campaigns.bot_enabled = 1
        ");

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function execute($targetHtmlPage, $link)
    {

        $urlPos = stripos($targetHtmlPage, $link);

        if ($urlPos === false) {
            return 'notFound';
        } else {

            $linkStart = strrpos($targetHtmlPage, '<a', -1 * (strlen($targetHtmlPage) - $urlPos));
            $linkEnd = strpos($targetHtmlPage, '</a>', $urlPos);
            if ($linkStart === false) {
                return 'notFound';
            }

            if ($linkEnd === false) {
                return 'notFound';
            }
            // is glitched, zet nu error ook al staat de nofollow aan de andere kant van de wereld.
            $noFollow = strpos($targetHtmlPage, 'rel="nofollow"', $linkStart);
            if ($noFollow === false || $noFollow > $linkEnd) {
                $noFollow = strpos($targetHtmlPage, "rel='nofollow'", $linkStart);

                if ($noFollow === false || $noFollow > $linkEnd) {
                    return 'Found';
                } else {
                    return 'noFollow';
                }
            } else {
                return 'noFollow';
            }
        }
    }

    public function setStatus($id, $botStatus) {
        if($botStatus == 'Found'){
            $botStatus = '1';
            $botColor = '5cb85c';
        }elseif($botStatus == 'notFound'){
            $botStatus = '0';
            $botColor = 'd9534f';
        }elseif($botStatus == 'noFollow'){
            $botStatus = '2';
            $botColor = 'fde300';
        }

        $stmt = $this->db->prepare("
            UPDATE submissions
            SET
              bot_updated = now(),
              bot_color = :color,
              bot_status = :status
            WHERE
              id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $botStatus);
        $stmt->bindParam(':color', $botColor);

        return $stmt->execute();
    }

    public function addHistory() {

    }
}