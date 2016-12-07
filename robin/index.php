<?php

require_once '../config.php';

$submissions = $objRobin->getSubmissions();

foreach ($submissions as $submission) {
    $html = $objRobin->get_data($submission['link_url']);
    $result = $objRobin->execute($html, $submission['url']);

    $objRobin->setStatus($submission['id'], $result);

    echo $result;
}