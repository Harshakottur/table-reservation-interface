<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

// GET
if(isset($_GET['delete_id'])){
  $id = $_GET['delete_id'];
  try{
    if($id != null){
      if($objUser->delete($id)){
        $objUser->redirect('index.php?deleted');
      }
    }else{
      var_dump($id);
    }
  }catch(PDOException $e){
    echo $e->getMessage();
  }
}
?>
<?php



if (isset($_POST["submit"])) {
	$name = $_POST["search"];
  $query = "SELECT * FROM crud_users WHERE name LIKE '%$name%'";
  $stmt = $objUser->runQuery($query);
  $stmt->execute();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
		<br><br><br>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="table-responsive">
    <table class="table table-striped table-sm">
			<tr>
        <th>Booking#</th>
				<th>Name</th>
				<th>Phone</th>
        <th>Person(s)</th>
				<th>Booking Time</th>
        <th>Remove</th>
			</tr>
			<tr>
        <td><?php echo $row['id'];?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['phone'];?></td>
        <td><?php echo $row['person'];?></td>
        <td><?php echo $row['datetime'];?></td>
        <td>
            <a class="confirmation" href="index.php?delete_id=<?php print($row['id']); ?>">
            <span data-feather="trash"></span>
            </a>
        </td>
			</tr>

		</table>
    </div>
    </main>
  <?php 
	}
		else{
			echo '<script>alert("Name Does Not Exist")</script>';
		}


}

?>
<!doctype html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php'; ?>
    </head>
    <body>
    <style>
     h1 {color:black;}
     p {color:blue;}
    </style>
        <!-- Header banner -->
        <?php require_once 'includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once 'includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 align="center"style="margin-top: 10px">Data Table</h1>
                    <form method="post" >
                     <!-- <input type="text" name="search">
                       <input type="submit" name="submit"> -->
                        <p align="right" style=margin-right:50px>
                        <input type="text" placeholder="Search.." name="search" align="right">
                        <button type="submit" name="submit" ><i class="fa fa-search"></i></button></p>
                    </form>

                    <?php
                      if(isset($_GET['updated'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User!<trong> Updated with success.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                          </button>
                        </div>';
                      }else if(isset($_GET['deleted'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User!<trong> Deleted with success.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                          </button>
                        </div>';
                      }else if(isset($_GET['inserted'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User!<trong> Inserted with success.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                          </button>
                        </div>';
                      }else if(isset($_GET['error'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>DB Error!<trong> Something went wrong with your action. Try again!
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                          </button>
                        </div>';
                      }
                    ?>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                              <tr>
                                <th>Booking#</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Person(s)</th>
                                <th>Booking Time</th>
                                <th>Remove</th>
                              </tr>
                            </thead>
                            <?php
                              $query = "SELECT * FROM crud_users";
                              $stmt = $objUser->runQuery($query);
                              $stmt->execute();
                            ?>
                            <tbody>
                                <?php if($stmt->rowCount() > 0){
                                  while($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)){
                                 ?>
                                 <tr>
                                    <td><?php print($rowUser['id']); ?></td>

                                    <td>
                                    <a href="form.php?edit_id=<?php print($rowUser['id']); ?>">
                                      <?php print($rowUser['name']); ?>
                                      </a>
                                    </td>

                                    <td><?php print($rowUser['phone']); ?></td>
                                    <td><?php print($rowUser['person']); ?></td>
                                    <td><?php print($rowUser['datetime']); ?></td>

                                    <td>
                                      <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id']); ?>">
                                      <span data-feather="trash"></span>
                                      </a>
                                    </td>
                                 </tr>


                          <?php } } ?>
                            </tbody>
                        </table>

                      </div>


                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            // JQuery confirmation
            $('.confirmation').on('click', function () {
                return confirm('Are you sure you want to delete this user?');
            });
        </script>
    </body>
</html>
