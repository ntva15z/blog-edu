<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>User List</h2>
                <?php
//                For delete Category form Database
                    if (isset($_GET['delid'])){
                        $delid = $_GET['delid'];
                        $delete_query = "DELETE FROM users WHERE id= '$delid'";
                        $delete_data = $db->delete($delete_query);
                        if ($delete_data){
                            echo "<span style='color:green;font-size:18px;'>User deleted successfully</span>";
                        }else{
                            echo "<span style='color:red;font-size:18px;'>User not deleted</span>";
                        }
                    }


                ?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Username</th>
							<th>Role</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php
//                        Show category list from Database
                        $query = "SELECT * FROM users ORDER BY id DESC ";
                        $category = $db->select($query);
                        if ($category){
                            $i = 0;
                            while ($result = $category->fetch_assoc()){
                                $i++;
                    ?>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result['username'];?></td>
							<td><?php echo $result['role'] == 1 ? 'Admin' : 'User';?></td>
							<td><a href="edit_user.php?id=<?php echo $result['id'];?>">Edit</a>
                                || <a onclick="return confirm('Bạn có chắc chắn xoá?')" href="?delid=<?php echo $result['id'];?>">Delete</a></td>
						</tr>
                    <?php } }?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
        <script type="text/javascript">

            $(document).ready(function () {
                setupLeftMenu();

                $('.datatable').dataTable();
                setSidebarHeight();


            });
        </script>

<?php include "includes/footer.php";?>