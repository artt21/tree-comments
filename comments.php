<?php

date_default_timezone_set("America/New_York");

/**
 * Collecting all records from "comments" database
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
 * Sorting out comments in array to differentiate between parent comments and children. Making tree structure.
 */
function sortComments(array $comments, ?int $parentID = null): array
{

    $arr = [];

    foreach($comments as $comment){
        if($comment['parent_id'] == $parentID){
            $children = sortComments($comments, $comment['id']);
            if ($children){
                $comment['children'] = $children;
            }
            $arr[] = $comment;
        }
    }

    return $arr;

}

/**
 * Counting how much time ago a commentary was left by user
 */
function dateInterval(DateTime $originDate): string
{

    $currentDate = date_create(date('Y-m-d H:i:s'));
    $interval = date_diff($originDate, $currentDate);

    if($interval->format('%y')){
        $date = $interval->format("%y year(s) ago");
    } elseif ($interval->format('%m')){
        $date = $interval->format('%m month(s) ago');
    } elseif ($interval->format('%d')){
        $date = $interval->format('%d day(s) ago');
    } elseif ($interval->format('%h') >= 1){
        $date = $interval->format('%h hour(s) ago');
    } elseif($interval->format('%i') < 1 ){
        $date = $interval->format('just now');
    } else{
        $date = $interval->format('%i minute(s) ago');
    }

    return $date;

}

/**
 * A pattern (template) for the output of tree-structured array of comments
 */
function commentsPattern(array $comments): string
{

    $name = htmlspecialchars($comments['name'], ENT_QUOTES);
    $content = htmlspecialchars($comments['content'], ENT_QUOTES);
    $id = $comments['id'];

    $date = dateInterval(date_create($comments['date']));

    $pattern = <<<HEREDOC
<div class="comments">
                <div class="comment-added-by">
                    By <b>%s</b> <i>%s</i>
</div>
<hr>
<div class="comment-content">
    <p>%s</p>
</div>
<hr>
<div class="comments-reply-button">
    <button onclick="document.getElementById('formreply-%d').style.display='';">
        Reply
    </button>
</div>
</div>
<div class="reply-form" style="display: none" id="formreply-%d">
    <div>
        <form action="index.php" method="post">
            <div class="reply-name">
                <input type="text" name="name" placeholder="Your name" size="53">
            </div>
            <div class="reply-comment">
                <textarea rows="2" cols="50" name="content" placeholder="Enter Comment"></textarea>
            </div>
            <div class="reply-submit">
                <button type="submit" name="submit-reply" id="submit-reply">Submit</button>
            </div>
            <input type="hidden" name="parent_id" value="%d">
        </form>
    </div>
</div>
HEREDOC;

    $pattern = sprintf($pattern, $name, $date, $content, $id, $id, $id);

    if(isset($comments['children'])){
        $pattern .= '<ul>' . showComments($comments['children']) . '</ul>';
    }

    return $pattern;

}

/**
 * Recursive function for the output of prepared pattern
 */
function showComments(array $tree): string
{

    $string = '';

    foreach($tree as $item){
        $string .= commentsPattern($item);
    }

    return $string;

}

/**
 * Adding records from the form to database
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
 */
function dataValidation(): array
{

    $errorMessage = [];

    $name = trim($_POST['name']);
    $content = trim($_POST['content']);
    $allowedSymbols = "/^[a-zA-Z0-9-',.:!_? ]*$/";
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










