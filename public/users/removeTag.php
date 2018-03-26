<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Remove Tag';

$id = $_POST['id'] ;

$sql = "DELETE FROM users.Tags WHERE id='" .  $id . "'";
$sql .= "AND StudentID='" . $_SESSION['id'] . "'";

$result = mysqli_query($db, $sql);

echo "We deleted it!";
?>
/*
  <script type="text/javascript">
    $(document).ready(function() {
       $("#deleteTag").html("Remove Tag")

      $("#deleteTag").click(function(){
          $.ajax({
              url: "<?php echo url_for('/users/removeTag.php');?>",
              type: "POST",
              data: {
                id: <?php echo $id; ?>
              }
          });
        })
    });
  </script>
  */