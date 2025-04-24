<?php $pageTitle = 'Courses Detail' ?>
<?php include "includes/header.php"?>
<?php
    if (!isset($_GET['id']) || $_GET['id'] == NULL){
        header("location:index.php");
    }else{
        $id = $_GET['id'];
        $query = "SELECT * FROM documents WHERE id = $id";
        $getpost = $db->select($query);
        if (!$getpost) {
            header("location:404.php");
            return;
        }
        $post = $getpost->fetch_assoc();

        $postCateId= $post['category_id'];

        $allRelatePost = [];
        $query = "SELECT * FROM documents WHERE id != $id and category_id = $postCateId";
        $relatePost = $db->select($query);
        if ($relatePost) {
            while ($result = $relatePost->fetch_assoc()){
                $allRelatePost[] = $result;
            }
        }

    }
?>

    <!-- Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <div class="section-title position-relative mb-5">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Course Detail</h6>
                            <h1 class="display-4"><?php echo $post['name'] ?></h1>
                        </div>
                        <?php echo $post['content'] ?>
                        <?php if ($post['file_name']) :?>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="<?php echo 'admin/' . $post['file_name'] ?>" target="_blank" style="width: 200px;" class="btn btn-outline-primary d-lg-block">Download Document</a>
                            </div>
                        <?php endif; ?>

                        <div class="comment-panel">
                            <h5 class="mb-4">💬 Comments</h5>
                            <?php 
                                $commentQuery = "SELECT * FROM chats WHERE document_id = $id and reply_to is null";
                                $getComment = $db->select($commentQuery);
                                $comments = [];
                                if ($getComment) {
                                    while ($result = $getComment->fetch_assoc()){
                                        $comments[] = $result;
                                    }
                                }

                                // list reply
                                $replyQuery = "SELECT * FROM chats WHERE document_id = $id and reply_to is not null";
                                $getReply = $db->select($replyQuery);
                                $replies = [];
                                if ($getReply) {
                                    while ($result = $getReply->fetch_assoc()){
                                        $replies[] = $result;
                                    }
                                }

                                function findReplies($replies, $commentId) {
                                    $result = [];
                                    if (!count($replies)) return $result;
                                    foreach ($replies as $reply) {
                                        if ($reply['reply_to'] == $commentId) {
                                            $result[] = $reply;
                                        }
                                    }
                                    return $result;
                                }

                            ?>
                            <!-- Bình luận chính -->
                            <?php if ($comments) :?>
                                <?php foreach ($comments as $comment) :?>
                                    <!-- get user -->
                                    <div class="comment">
                                        <img src="img/avatar-default.jpg" alt="avatar">
                                        <div>
                                            <div class="comment-body">
                                                <strong><?php echo $comment['name'] ?></strong>
                                                <p><?php echo $comment['content'] ?></p>
                                            </div>
                                            <button class="reply-btn" onclick="showReplyForm('replyForm<?php echo $comment['id'] ?>')">Reply</button>

                                            <?php $listReply = findReplies($replies, $comment['id']); ?>
                                            <?php if ($listReply) :?>
                                                <?php foreach ($listReply as $reply) :?>
                                                    <div class="reply mt-2">
                                                        <img src="img/avatar-default.jpg" alt="avatar">
                                                        <div class="reply-body">
                                                            <strong><?php echo $reply['name'] ?></strong>
                                                            <p><?php echo $reply['content'] ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            
                                            <!-- Reply form -->
                                            <form id="replyForm<?php echo $comment['id'] ?>" class="reply-form reply d-none mt-2" action="comment.php" method="POST">
                                            <div class="flex-grow-1 ms-2">
                                                <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id'] ?>">
                                                <textarea name="content" rows="2" class="form-control" placeholder="Reply..." required></textarea>
                                                <div class="text-end mt-1">
                                                    <button type="submit" class="btn btn-sm btn-primary">Send</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <!-- Thêm bình luận mới -->
                            <form class="comment-form mt-4" action="comment.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                                <div class="d-flex">
                                    <div class="flex-grow-1 ms-2">
                                        <textarea name="content" rows="2" class="form-control" placeholder="Comment..." required></textarea>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary px-4">Send</button>
                                </div>
                            </form>

                        </div>
    
                    </div>

                    <h2 class="mb-3">Related Courses</h2>
                    <?php if ($allRelatePost) :?>
                        <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                            <?php foreach ($allRelatePost as $rePost) :?>
                                <a class="courses-list-item position-relative d-block overflow-hidden mb-2" href="post_details.php?id=<?php echo $rePost['id'];  ?>">
                                    <img class="img-fluid" src="<?php echo 'admin/'.$rePost['thumbnail'] ?>" alt="">
                                    <div class="courses-text">
                                        <h4 class="text-center text-white px-3"><?php echo $rePost['name'] ?></h4>
                                        <div class="border-top w-100 mt-3">
                                            <div class="d-flex justify-content-between p-4">
                                                <span class="text-white"><i class="fa fa-user mr-2"></i>Jhon Doe</span>
                                                <span class="text-white"><i class="fa fa-star mr-2"></i>4.5</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
               </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="bg-primary mb-5 py-3">
                        <h3 class="text-white py-3 px-4 m-0">Course Features</h3>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Instructor</h6>
                            <h6 class="text-white my-3">John Doe</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Rating</h6>
                            <h6 class="text-white my-3">4.5 <small>(250)</small></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Lectures</h6>
                            <h6 class="text-white my-3">15</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Duration</h6>
                            <h6 class="text-white my-3">10.00 Hrs</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Skill level</h6>
                            <h6 class="text-white my-3">All Level</h6>
                        </div>
                        <div class="d-flex justify-content-between px-4">
                            <h6 class="text-white my-3">Language</h6>
                            <h6 class="text-white my-3">English</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->
<?php include "includes/footer.php"; ?>