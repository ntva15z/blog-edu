<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
<?php include "includes/data_tree.php"?>
<?php
if (!isset($_GET['edit_postid']) || $_GET['edit_postid'] == NULL){
    header('location:post_list.php');
}else{
    $id = $_GET['edit_postid'];
}
?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Update Post</h2>
            <?php
//            Insert post into database
            //                      field Validation
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title = mysqli_real_escape_string($db->link, $_POST['title']);
                $category_id = mysqli_real_escape_string($db->link, $_POST['category_id']);
                $content = mysqli_real_escape_string($db->link, $_POST['content']);
//                            image validation
                $permited = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['thumbnail']['name'];
                $file_size = $_FILES['thumbnail']['size'];
                $file_temp = $_FILES['thumbnail']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                $uploaded_image = "uploads/thumbnails/" . $unique_image;

                // document validation
                $permitedDocument = array('doc', 'docx', 'pdf', 'xls', 'xlsx');
                $document_name = $_FILES['document']['name'];
                $document_size = $_FILES['document']['size'];
                $document_temp = $_FILES['document']['tmp_name'];

                $divDocument = explode('.', $document_name);
                $file_ext_document = strtolower(end($divDocument));
                $unique_document = substr(md5(time()), 0, 10) . '.' . $file_ext_document;
                $uploaded_document = "uploads/documents/" . $unique_document;

                if ($title == '' || $category_id == '' || $content == '') {
                    echo "<span style='color:red;font-size:18px;'>Field must not be empty</span>";
                } else{
                    $isChangeThumbnail = false;
                    if (!empty($file_name)) {
                        if ($file_size > 1048567) {
                            echo "<span class='error'>Image Size should be less then 1MB!</span>";
                        } elseif (in_array($file_ext, $permited) === false) {
                            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
                        } else {
                            $isChangeThumbnail = true;
                        }
                    }
                    
                    $isChangeDocument = false;
                    if (!empty($document_name)) {
                        if ($document_size > 1048567) {
                            echo "<span class='error'>Image Size should be less then 1MB!</span>";
                        } elseif (in_array($file_ext_document, $permitedDocument) === false) {
                            echo "<span class='error'>You can upload only:-" . implode(', ', $permitedDocument) . "</span>";
                        } else {
                            $isChangeDocument = true;
                        }
                    }
                    
                    else{
                        $query = "UPDATE documents SET category_id = '$category_id', name = '$title', content = '$content'";
                        if ($isChangeThumbnail) {
                            move_uploaded_file($file_temp, $uploaded_image);
                            $query .= ", thumbnail = '$uploaded_image'";
                        }
                        if ($isChangeDocument) {
                            move_uploaded_file($document_temp, $uploaded_document);
                            $query .= ", thumbnail = '$uploaded_document'";
                        }

                        $query .= " where id = '$id'";

                        $updated_row = $db->update($query);
                        if ($updated_row) {
                            echo "<span class='success'>Data updated Successfully.</span>";
                        } else {
                            echo "<span class='error'>Data Not updated !</span>";
                        }
                    }
                }
            }
            ;?>
            <div class="block">
                <?php
                    $query = "SELECT * FROM categories";
                    $show_category = $db->select($query);
                    $list_cat = [];
                    if ($show_category){
                        $categories = [];
                        while ($result = $show_category->fetch_assoc()){
                            $categories[] = $result;
                        }
                        $list_cat = data_tree($categories, 0);
                    }
                ?>
                <?php
                    $query = "SELECT * FROM documents WHERE id = '$id'";
                    $getpost = $db->select($query);
                    if ($getpost){
                        while ($postresult = $getpost->fetch_assoc()){

                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="form">

                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $postresult['name'] ?>" class="medium" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>Category</label>
                            </td>
                            <td>
                                <select id="select" name="category_id">
                                    <option value="">Select Category </option>
                                        <?php if ($list_cat) :?>
                                            <?php foreach ($list_cat as $cate): ?>
                                                <option value="<?php echo $cate['id'] ?>" <?php echo $postresult['category_id'] == $cate['id'] ? 'selected' : '' ?> ><?php echo str_repeat('-', $cate['level']) . ' ' . $cate['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Thumbnail</label>
                            </td>
                            <td>
                                <img src="<?php echo $postresult['thumbnail'] ?>" height="60px" width="100px" alt="">
                                <input type="file" name="thumbnail"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Document</label>
                            </td>
                            <td>
                                <img src="img/office.jpg" height="60px" width="100px" alt="">
                                <input type="file" name="document"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; padding-top: 9px;">
                                <label>Content</label>
                            </td>
                            <td>
                                <textarea class="tinymce" name="content"><?php echo $postresult['content'] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                        <?php
                        }
                        }?>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <!-- Load TinyMCE -->
    <script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
            setDatePicker('date-picker');
            $('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();
        });
    </script>
<?php include "includes/footer.php";?>