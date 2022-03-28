<?php

include "../comments.php";

$comments = getComments();

$sortedComments = sortComments($comments);

$errorMessage = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errorMessage = dataValidation();

    if (empty($errorMessage)) {

        $parentID = $_POST['parent_id'] ?? null;

        addComment($_POST['name'], $_POST['content'], $parentID);
        header("Location: index.php");
    }

}

include_once "../view.php";



