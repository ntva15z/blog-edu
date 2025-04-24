
<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
<?php
if (!isset($_GET['id']) || $_GET['id'] == NULL){
    header('location:user_list.php');
}else{
    $id = $_GET['id'];
}
?>

    <div class="grid_10">

        <div class="box round first grid">
            <h2>Update User</h2>
            <div class="block copyblock">
<!--                Category update query-->
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $username = $_POST['username'];
                    $username = mysqli_real_escape_string($db->link, $username);
                    $role     = mysqli_real_escape_string($db->link, $_POST['role']) ?? 1;
                    if (empty($username)){
                        echo "<span style='color:red;font-size:18px;'>Username must not be empty</span>";
                    } else{
                        $query = "UPDATE user SET username = '$username'WHERE id='$id'";
                        $update_user =  $db->update($query);
                        if ($update_user){
                            echo "<span style='color:green;font-size:18px;'>User update successfully.</span>";
                        }else{
                            echo "<span style='color:red;font-size:18px;'>User update failed.</span>";
                        }
                    }
                }
                ?>
<!--                Show selected Category -->
                <?php
                    $query = "SELECT * FROM users WHERE id = '$id'";
                    $user = $db->select($query);
                    if ($user){
                    while ($result = $user->fetch_assoc()){
                ?>
                <form method="post">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Username</label>
                            </td>
                            <td>
                                <input type="text" name="username" value="<?php echo $result['username']?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="role">Role:</label><br>
                                <select name="role" id="role" class="medium">
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
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
                        echo "User not found.";
                    } ?>
            </div>
        </div>
    </div>
<?php include "includes/footer.php";?>