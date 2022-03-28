<?php

/**
 * Collecting all records from database
 * @return array
 */
function getComments(): array
{

    $pdo = new PDO("mysql:host=localhost;dbname=comments;charset=utf8", "root", "");

    $sql = "SELECT * FROM comments ORDER BY parent_id ASC, `date` ASC";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    foreach ($comments as $comment){
        if($comment['parent_id'] === null){
            $arr[$comment['id']] = $comment;
        } else{
            $arr[$comment['parent_id']]['children'][] = $comment;
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
function dataValidation():array
{

    $errorMessage = [];

    $name = trim($_POST['name']);
    $content = trim($_POST['content']);
    $allowedSymbols = "/^[a-zA-Z-' ]*$/";
    $nameLength = 50;
    $contentLength = 1000;

    if (mb_strlen($name) > $nameLength) {
        $errorMessage['name'] = "Name should have less than 30 symbols";
    } if (mb_strlen($content) > $contentLength) {
        $errorMessage['content'] = "Commentary should have less than 1000 symbols";
    } if (empty($name)) {
        $errorMessage['name'] = "Enter your name";
    } if (empty($content)) {
        $errorMessage['content'] = "Enter your commentary";
    } if (!preg_match($allowedSymbols, $name)) {
        $errorMessage['name'] = "Only letters and white space allowed";
    } if (!preg_match($allowedSymbols, $content)) {
        $errorMessage['content'] = "Only letters and white space allowed";
    }

    return $errorMessage;

}










