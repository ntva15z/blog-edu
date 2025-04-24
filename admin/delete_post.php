<?php include "../config/config.php"?>
<?php include "../db/Database.php"?>

<?php
$db =new Database();

    if (!isset($_GET['del_postid']) || $_GET['del_postid'] == NULL){
        header('location:post_list.php');
    }else{
        $delete_id = $_GET['del_postid'];

        $query = "SELECT * FROM documents WHERE id = '$delete_id'";
        $getData = $db->select($query);
        if ($getData){
            while ($delimg = $getData->fetch_assoc()){
                $thumbnail = $delimg['thumbnail'];
                if ($thumbnail) {
                    unlink($thumbnail);
                }
                $document = $delimg['file_name'];
                if ($document) {
                    unlink($document);
                }
            }
        }
        $delquery = "DELETE FROM documents WHERE  id = '$delete_id'";
        $delData = $db->delete($delquery);
        if ($delData){
            echo "<script>alert('Data deleted successfully')</script>";
            echo "<script>window.location = 'post_list.php'; </script>";
        }else{
            echo "<script>alert('Data not deleted ')</script>";
            echo "<script>window.location = 'post_list.php'; </script>";
        }
}