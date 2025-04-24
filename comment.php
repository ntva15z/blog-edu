<?php include "classes/Session.php";?>
<?php include "config/config.php"?>
<?php include "db/Database.php"?>
<?php
$db =new Database();
Session::init();
$userId = Session::get('userid');
$username = Session::get('username');
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentId = !empty($_POST["comment_id"]) ? htmlspecialchars(trim($_POST["comment_id"])) : null;
    $content = $_POST["content"];

    $postId = $_POST['id'];
    if (empty($postId)) {
        header("location:403.php");
    } else if (empty($content)) {
        echo "<span style='color:red;font-size:18px;'>Content is not null!</span>";
    } else {
        $content = htmlspecialchars(trim($_POST["content"]));
        $query = "SELECT * FROM documents WHERE id = $postId";
        $getpost = $db->select($query);
        if (!$getpost) {
            header("location:403.php");
            return;
        }
    
        if (empty($commentId)) {
            $createQuery = "INSERT INTO chats (user_id, name, content, document_id) VALUES ('$userId', '$username','$content', '$postId')";
        } else {
            $createQuery = "INSERT INTO chats (user_id, name, content, document_id, reply_to) VALUES ('$userId', '$username', '$content', '$postId', '$commentId')";
        }
        
        $newComment =  $db->crate($createQuery);
        if ($newComment){
            header("location:post_details.php?id=" .urlencode($postId));
        }else{
            echo "<span style='color:red;font-size:18px;'>Comment create failed!</span>";
        }
    }
}
?>
