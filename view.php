<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tree Comments</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
<div class="wrapper">
    <div class="navbar">
        <a class="logo" href="/comments/controller/index.php">Tree Comments Exercise</a>
    </div>
    <div class="post">
        <h2>Random Post</h2>
        <div class="post-row">
            Is allowance instantly strangers applauded discourse so. Separate entrance welcomed sensible laughing why
            one moderate shy. We seeing piqued garden he.
            As in merry at forth least ye stood. And cold sons yet with. Delivered middleton therefore me at. Attachment
            companions man way excellence how her pianoforte.
            Conveying or northward offending admitting perfectly my. Colonel gravity get thought fat smiling add but.
            Wonder twenty hunted and put income set desire expect.
            Am cottage calling my is mistake cousins talking up. Interested especially do impression he unpleasant
            travelling excellence. All few our knew time done draw ask.
            Greatest properly off ham exercise all. Unsatiable invitation its possession nor off. All difficulty
            estimating unreserved increasing the solicitude.
        </div>
    </div>
    <div class="commentaries">
        <?php include_once "errors.php" ?>
        <div class="comments-form">
            <h3>Leave a commentary</h3>
            <form action="index.php" method="post">
                <div class="input">
                    <input type="text" name="name" placeholder="Your name" size="53">
                </div>
                <div class="textarea">
                    <textarea rows="4" cols="50" name="content" placeholder="Enter Comment"></textarea>
                </div>
                <div class="submit">
                    <button type="submit" name="submit_comment" id="submit_comment">Submit</button>
                </div>
            </form>
        </div>
        <?php foreach ($sortedComments as $comment): ?>
            <div class="comments">
                <div class="comment-added-by">
                    By <b><?= htmlspecialchars($comment['name'], ENT_QUOTES); ?></b> on <?= $comment['date']; ?>
                </div>
                <hr>
                <div class="comment-content">
                    <p><?= htmlspecialchars($comment['content'], ENT_QUOTES); ?></p>
                </div>
                <hr>
                <div class="comments-reply-button">
                    <button onclick="document.getElementById('formreply-<?= $comment['id']; ?>').style.display='';">
                        Reply
                    </button>
                </div>
            </div>
            <div class="reply-form" style="display: none" id="formreply-<?= $comment['id']; ?>">
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
                        <input type="hidden" name="parent_id" value="<?= $comment['id']; ?>">
                    </form>
                </div>
            </div>
            <?php foreach (($comment['children'] ?? []) as $children): ?>
                <div class="reply-comments">
                    <div class="comment-added-by">
                        By <b><?= htmlspecialchars($children['name'], ENT_QUOTES); ?></b> on <?= $children['date']; ?>
                    </div>
                    <hr>
                    <div class="comment-content">
                        <p><?= htmlspecialchars($children['content'], ENT_QUOTES); ?></p>
                    </div>
                    <hr>
                    <div class="comments-reply-button2">
                        <button onclick="document.getElementById('formreply-<?= $children['id']; ?>').style.display='';">
                            Reply
                        </button>
                    </div>
                </div>
                <div class="reply-form2" style="display: none" id="formreply-<?= $children['id']; ?>">
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
                            <input type="hidden" name="parent_id" value="<?= $children['id']; ?>">
                        </form>
                    </div>
                </div>
                <?php foreach (($children['children'] ?? []) as $child): ?>
                    <div class="reply-comments2">
                        <div class="comment-added-by2">
                            By <b><?= htmlspecialchars($child['name'], ENT_QUOTES); ?></b> on <?= $child['date']; ?>
                        </div>
                        <hr>
                        <div class="comment-content2">
                            <p><?= htmlspecialchars($child['content'], ENT_QUOTES); ?></p>
                        </div>
                        <hr>
                        <div class="comments-reply-button3">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="footer">
        <script>

        </script>
    </div>
</div>
</body>
</html>



