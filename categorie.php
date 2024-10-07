<?php
$page_title = 'All categories';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

$all_categories = find_all('categories');
?>
<?php
 if(isset($_POST['add_cat'])){
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO categories (name)";
      $sql .= " VALUES ('{$cat_name}')";
      if($db->query($sql)){
        $session->msg("s", "Successfully Added New Category");
        redirect('categorie.php',false);
      } else {
        $session->msg("d", "Sorry Failed to insert.");
        redirect('categorie.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('categorie.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
<!-- Add jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<a id="top-of-page"></a>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading" style="background-image: linear-gradient(to right, #FFC0E4, #FFAED7, #FF9CCB, #FF89BF, #FF77B3, #FF64A8, #FF519C, #FF3E90); color:black">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Category</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="categorie.php">
          <div class="form-group">
            <input type="text" class="form-control" name="categorie-name" placeholder="Category Name"oninput="allowLettersOnly(event)">
          </div>
          <button type="submit" name="add_cat" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Category
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading" style="background-image: linear-gradient(to right, #FFC0E4, #FFAED7, #FF9CCB, #FF89BF, #FF77B3, #FF64A8, #FF519C, #FF3E90); color:black">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Categories</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Categories</th>
              <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_categories as $cat): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                  <a href="register_editproduct.php?id=<?php echo (int)$cat['id']; ?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <!-- this button will trigger modal for deletion-->
                    <a href="register_deleteproduct.php?id=<?php echo (int)$cat['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove" onclick="return confirm('Are you sure you want to delete this category?');">
                  <i class="glyphicon glyphicon-remove"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-center">
                <a href="#top-of-page" class="btn btn-info">
                  <span class="glyphicon glyphicon-arrow-up"></span> Return to the Top
                </a>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Deletion</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this category? All products data inside this category will also be deleted. This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top">Cancel</button>
        <a id="confirmDelete" class="btn btn-danger" href="#" title="Delete" data-toggle="tooltip" data-placement="top">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.btn-delete-category', function() {
    var categoryId = $(this).data('id');
    $('#confirmDelete').attr('href', 'delete_categorie.php?id=' + categoryId);
  });
</script>


<?php include_once('layouts/footer.php'); ?>
<script>
  function allowLettersOnly(event) {
    // Get the input value
    var inputValue = event.target.value;

    // Replace any numbers with an empty string
    var lettersOnly = inputValue.replace(/[0-9]/g, '');

    // Update the input value with letters only
    event.target.value = lettersOnly;
  }
</script>