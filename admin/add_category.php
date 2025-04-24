<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
<?php include "includes/data_tree.php"?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New Category</h2>
               <div class="block copyblock">
                   <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $name = $_POST['name'];
                            $name = mysqli_real_escape_string($db->link, $name);
                            $parentId = mysqli_real_escape_string($db->link, $_POST['parent_id']) ?? null;
                            if (empty($name)){
                                echo "<span style='color:red;font-size:18px;'>Field must not be empty</span>";
                            } else{
                                if ($parentId) {
                                    $query = "INSERT INTO categories (name, parent_id) VALUES ('$name', '$parentId')";
                                } else {
                                    $query = "INSERT INTO categories (name) VALUES ('$name')";
                                }
                                
                                $create_cat =  $db->crate($query);
                                if ($create_cat){
                                    echo "<span style='color:green;font-size:18px;'>Category created successfully</span>";
                                }else{
                                    echo "<span style='color:red;font-size:18px;'>Category not crated</span>";
                                }
                            }
                        }
                   ?>
                 <form method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <label>Category Name</label>
                            </td>
                            <td>
                                <input type="text" name="name" placeholder="Enter Category Name..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Parent Category</label>
                            </td>
                            <td>
                                <select id="select" name="parent_id">
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
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include "includes/footer.php";?>