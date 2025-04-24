<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php"?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Post List</h2>
                <div class="block">  
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
                            <th width="5%">STT</th>
							<th width="13%">Post Title</th>
							<th width="10%">Category Name</th>
							<th width="10%">Document</th>
							<th width="10%">Thumbnail</th>
							<th width="12%">Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php
                        $query = "SELECT documents.*, categories.name as category_name FROM documents INNER JOIN categories
                                   ON documents.category_id = categories.id
                                   ORDER BY documents.id DESC ";
                        $post = $db->select($query);
                        if ($post){
                            $i = 0;
                            while ($result =  $post->fetch_assoc()){
                                $i++;
                    ?>
						<tr class="odd gradeX">
							<td style="vertical-align: middle"><?php echo $i ?></td>
							<td style="vertical-align: middle"><?php echo $result['name'] ?></td>
                            <td style="vertical-align: middle"><?php echo $result['category_name'] ?></td>
							<td style="vertical-align: middle"><a style="color: blue" href="<?php echo $result['file_name'] ?>"><?php echo $result['file_name'] ?></a></td>
							<td style="vertical-align: middle"><img src="<?php echo $result['thumbnail'] ?>" height="60px" width="80px" alt=""></td>
							<td style="vertical-align: middle"><a href="edit_post.php?edit_postid=<?php echo $result['id'] ?>">Edit</a>
                                || <a  onclick="return confirm('Are you sure to Delete?')" href="delete_post.php?del_postid=<?php echo $result['id'] ?>">Delete</a></td>
						</tr>
                    <?php }
                        }?>
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