<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New User</h2>
               <div class="block copyblock">
                   <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $username     = mysqli_real_escape_string($db->link, $_POST['username']);
                            $password = mysqli_real_escape_string($db->link, $_POST['password']);
                            $role     = mysqli_real_escape_string($db->link, $_POST['role']) ?? 2;
                            if (empty($username)){
                                echo "<span style='color:red;font-size:18px;'>Username must not be empty</span>";
                            } else if (empty($password)) {
                                echo "<span style='color:red;font-size:18px;'>Password must not be empty</span>";
                            } else{
                                $hashedPassword = md5($password);
                                $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";
                                $create_user =  $db->crate($query);
                                if ($create_user){
                                    echo "<span style='color:green;font-size:18px;'>User created successfully.</span>";
                                }else{
                                    echo "<span style='color:red;font-size:18px;'>User create failed.</span>";
                                }
                            }
                        }
                   ?>
                 <form method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="username" placeholder="Enter username" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="password" placeholder="Enter password" class="medium" />
                            </td>
                        </tr>
                        <td>
                            <label for="role">Role:</label><br>
                            <select name="role" id="role" class="medium">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </td>
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