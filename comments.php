<?php

/**
 * Collecting all records from database
 * @return array
 */
function getComments(): array
{

    $pdo = new PDO("mysql:host=localhost;dbname=comments;charset=utf8", "root", "");


    $sql = "SELECT * FROM comments ORDER BY parent_id ASC, `date` ASC";
    $statement = $pdo->query($sql);
    $comments = [];
    while ($comment = $statement->fetch(PDO::FETCH_ASSOC)){
        $comments[$comment['id']] = $comment;
    }
    return $comments;

}

/**
 * Sorting out comments to differentiate between parent comments and children
 * @param array $comments
 * @return array
 */
function sortComments(array $comments): array
{

    $arr = [];

    foreach ($comments as $id => &$comment) {
        if ($comment['parent_id'] === null){
            $arr[$id] = &$comment;
        }else{
            $comments[$comment['parent_id']]['children'][$id] = &$comment;
        }
    }

    return $arr;

}

/**
 * Adding records from the form to database
 * @param string $name
 * @param string $content
 * @param int|null $parentId
 */
function addComment(string $name, string $content, ?int $parentId = null): void
{

    $pdo = new PDO("mysql:host=localhost;dbname=comments;charset=utf8", "root", "");

    $sql = "INSERT INTO comments (name, content, parent_id) VALUES (:name, :content, :parent_id)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam("name", $name);
    $statement->bindParam("content", $content);
    $statement->bindParam("parent_id", $parentId);
    $statement->execute();

}

/**
 * Validation of records put into the form
 * @return array
 */
function dataValidation(): array
{

    $errorMessage = [];

    $name = trim($_POST['name']);
    $content = trim($_POST['content']);
    $allowedSymbols = "/^[a-zA-Z0-9-',.:!? ]*$/";
    $nameLength = 50;
    $contentLength = 1000;

    if (mb_strlen($name) > $nameLength) {
        $errorMessage['name'] = "Name should have less than 30 symbols";
    }
    if (mb_strlen($content) > $contentLength) {
        $errorMessage['content'] = "Commentary should have less than 1000 symbols";
    }
    if (empty($name)) {
        $errorMessage['name'] = "Enter your name";
    }
    if (empty($content)) {
        $errorMessage['content'] = "Enter your commentary";
    }
    if (!preg_match($allowedSymbols, $name)) {
        $errorMessage['name'] = "Such symbols are not allowed";
    }
    if (!preg_match($allowedSymbols, $content)) {
        $errorMessage['content'] = "Such symbols are not allowed";
    }

    return $errorMessage;

}










