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
        <?php echo '<ul>'. showComments($sortedComments) .'</ul>'; ?>
    </div>
    <div class="footer">
        <script>

        </script>
    </div>
</div>
</body>
</html>



