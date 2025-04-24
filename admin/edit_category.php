
<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
<?php include "includes/data_tree.php"?>
<?php
if (!isset($_GET['catid']) || $_GET['catid'] == NULL){
    header('location:category_list.php');
}else{
    $id = $_GET['catid'];
}
?>
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

    <div class="grid_10">

        <div class="box round first grid">
            <h2>Update Category</h2>
            <div class="block copyblock">
<!--                Category update query-->
                <?php
                $query = "SELECT * FROM categories WHERE id = '$id'";
                $category = $db->select($query);

                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = $_POST['name'];
                    $name = mysqli_real_escape_string($db->link, $name);
                    $parentId = mysqli_real_escape_string($db->link, $_POST['parent_id']) ?? null;
                    if (empty($name)){
                        echo "<span style='color:red;font-size:18px;'>Field must not be empty</span>";
                    } else{
                        $isUpdate = false;
                        if ($parentId) {
                            if ($parentId == $category->fetch_assoc()['id']) {
                                echo "<span style='color:red;font-size:18px;'>You cannot assign a category as its own parent.</span>";
                            } else {
                                $query = "UPDATE categories SET name = '$name', parent_id = $parentId WHERE id='$id'";
                                $isUpdate = true;
                            }
                        } else {
                            $query = "UPDATE categories SET name = '$name' WHERE id='$id'";
                            $isUpdate = true;
                        }

                        if ($isUpdate) {
                            $update_cat =  $db->update($query);
                            if ($update_cat){
                                echo "<span style='color:green;font-size:18px;'>Category updated successfully</span>";
                            }else{
                                echo "<span style='color:red;font-size:18px;'>Category not updated</span>";
                            }
                        }
                    }
                }
                ?>
<!--                Show selected Category -->
                <?php
                    if ($category){
                    while ($result = $category->fetch_assoc()){
                ?>
                <form method="post">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Category Name</label>
                            </td>
                            <td>
                                <input type="text" name="name" value="<?php echo $result['name']?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Parent Category</label>
                            </td>
                            <td>
                                <select id="select" name="parent_id">
                                    <option value="">Select Category </option>
                                        <?php if ($list_cat) :?>
                                            <?php foreach ($list_cat as $cate): ?>
                                                <option value="<?php echo $cate['id'] ?>" <?php echo $result['parent_id'] == $cate['id'] ? 'selected' : '' ?>><?php echo str_repeat('-', $cate['level']) . ' ' . $cate['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="submit" Value="update" />
                            </td>
                        </tr>
                    </table>
                </form>
                <?php } } else{
                        echo "Category not found";
                    } ?>
            </div>
        </div>
    </div>
<?php include "includes/footer.php";?>