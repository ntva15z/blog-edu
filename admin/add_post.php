<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
<?php include "includes/data_tree.php"?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New Post</h2>
                 <?php
//                     Post field Validation
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

                            if ($title == '' || $category_id == '' || $file_name == '' || $document_name == '' || $content == '') {
                                echo "<span style='color:red;font-size:18px;'>Field must not be empty</span>";
                            } elseif ($file_size > 1048567) {
                                echo "<span class='error'>Thumbnail Size should be less then 1MB!</span>";
                            } elseif ($document_size > 1048567 * 10) {
                                echo "<span class='error'>Document Size should be less then 10MB!</span>";
                            } elseif (in_array($file_ext, $permited) === false) {
                                echo "<span class='error'>You can upload thumbnail only:-" . implode(', ', $permited) . "</span>";
                            } elseif (in_array($file_ext_document, $permitedDocument) === false) {
                                echo "<span class='error'>You can upload document only:-" . implode(', ', $permitedDocument) . "</span>";
                            } else {
                                if (!is_dir('uploads/thumbnails/')) {
                                    mkdir('uploads/thumbnails/', 0777, true);
                                }
                                move_uploaded_file($file_temp, $uploaded_image);

                                if (!is_dir('uploads/documents/')) {
                                    mkdir('uploads/documents/', 0777, true);
                                }
                                move_uploaded_file($document_temp, $uploaded_document);
                                
                                $query = "INSERT INTO documents (category_id, name, content, thumbnail, file_name )
                                                    VALUES('$category_id', '$title', '$content', '$uploaded_image', '$uploaded_document')";
                                $inserted_rows = $db->crate($query);
                                if ($inserted_rows) {
                                    echo "<span class='success'>Data created Successfully.</span>";
                                } else {
                                    echo "<span class='error'>Data Not created !</span>";
                                }
                            }
                       }
                  ;?>
                <div class="block">               
                 <form action="" method="post" enctype="multipart/form-data">
                    <table class="form">
                       
                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td>
                                <input type="text" name="title" placeholder="Enter Post Title..." class="medium" />
                            </td>
                        </tr>
                     
                        <tr>
                            <td>
                                <label>Category</label>
                            </td>
                            <td>
                                <select id="select" name="category_id">
                                    <option value="">Select Category </option>
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
                                        <?php if ($list_cat) :?>
                                            <?php foreach ($list_cat as $cate): ?>
                                                <option value="<?php echo $cate['id'] ?>"><?php echo str_repeat('-', $cate['level']) . ' ' . $cate['name'] ?></option>
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
                                <input type="file" name="thumbnail"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Document</label>
                            </td>
                            <td>
                                <input type="file" name="document"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; padding-top: 9px;">
                                <label>Content</label>
                            </td>
                            <td>
                                <textarea class="tinymce" name="content"></textarea>
                            </td>
                        </tr>
						<tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
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