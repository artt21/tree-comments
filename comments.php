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
 * Sorting out comments in array to differentiate between parent comments and children. Making tree structure.
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
 * A pattern (template) for the output of tree-structured array of comments
 * @param array $comments
 * @return string
 */
function commentsPattern(array $comments): string
{

    $name = htmlspecialchars($comments['name'], ENT_QUOTES);
    $content = htmlspecialchars($comments['content'], ENT_QUOTES);
    $date = $comments['date'];
    $id = $comments['id'];

    $pattern = <<<HEREDOC
<div class="comments">
                <div class="comment-added-by">
                    By <b>%s</b> on %s
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
        $pattern .= '<ul>'.showComments($comments['children']).'</ul>';
    }

    return $pattern;

}

/**
 * Recursive function for the output of prepared pattern
 * @param array $tree
 * @return string
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










