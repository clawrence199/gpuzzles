
<?php $page_title = 'Modify Puzzle'; ?>
<?php $page_title = 'GPuzzles > Modify Puzzles'; ?>
<?php 
    require 'bin/functions.php';
    require 'db_configuration.php';
    include('header.php'); 
    $page="puzzles_list.php";
    verifyLogin($page);
?>
<div class="container">
<style>#title {text-align: center; color: darkgoldenrod;}</style>

<?php
include_once 'db_configuration.php';

if (isset($_GET['id'])){

    $id = $_GET['id'];
    
    $sql = "SELECT * FROM gpuzzles
            WHERE id = '$id'";

    if (!$result = $db->query($sql)) {
        die ('There was an error running query[' . $connection->error . ']');
    }//end if
}//end if

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      if(isset($_GET['modifyPuzzle'])){
        if($_GET["modifyPuzzle"] == "fileRealFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not real, Please Try Again!</h3>';
        }
      }
      if(isset($_GET['modifyPuzzle'])){
        if($_GET["modifyPuzzle"] == "fileTypeFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not a valid image type (jpg,jpeg,png,gif), Please Try Again!</h3>';
        }
      }
      if(isset($_GET['modifyPuzzle'])){
        if($_GET["modifyPuzzle"] == "fileExistFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image already exists, Please Try Again!</h3>';
        }
      }

      echo '<h2 id="title">Modify Puzzle</h2><br>';
      echo '<form action="modifyThePuzzle.php" method="POST" enctype="multipart/form-data">
      <br>

      <!-- uncomment if you want to display info on the puzzle you are editing -->
      <!-- <h3>'.$row["puzzle_name"].' - '.$row["creator_name"].' - '.$row["author_name"].' </h3> <br> -->
      
      <div>
        <label for="id">Id</label>
        <input type="text" class="form-control" name="id" value="'.$row["id"].'"  maxlength="5" style=width:400px readonly><br>
      </div>
      
      <div>
        <label for="puzzle_name">Puzzle Name</label>
        <input type="text" class="form-control" name="puzzle_name" value="'.$row["puzzle_name"].'"  maxlength="255" style=width:400px required><br>
      </div>
      
      <div>
        <label for="creator_name">Creator Name</label>
        <input type="text" class="form-control" name="creator_name" value="'.$row["creator_name"].'"  maxlength="255" style=width:400px required><br>
      </div>
          
      <div>
        <label for="author_name">Author Name</label>
        <input type="text" class="form-control" name="author_name" value="'.$row["author_name"].'"  maxlength="255" style=width:400px required><br>
      </div>
          
      <div>
        <label for="book_name">Book Name</label>
        <input type="text" class="form-control" name="book_name" value="'.$row["book_name"].'"  maxlength="255" style=width:400px required><br>
      </div>

      <div class="form-group col-md-4">
        <label for="cadence">New Puzzle Image Path (Not Required)</label>
        <input type="file" name="fileToUpload" id="fileToUpload" maxlength="255">
      </div>
      <input type="hidden" class="form-control" name="oldimage" value="'.$row["puzzle_image"].'" maxlength="255" required>

      <div class="form-group col-md-4">
        <label for="cadence">New Solution Image Path (Not Required)</label>
        <input type="file" name="fileToUpload2" id="fileToUpload2" maxlength="255">
      </div>
      <input type="hidden" class="form-control" name="oldimage2" value="'.$row["solution_image"].'" maxlength="255" required>
      
      <div>
        <label for="notes">Notes</label>
        <input type="text" class="form-control" name="notes" value="'.$row["notes"].'"  maxlength="255" style=width:400px ><br>
      </div>
      <br>
      <div class="text-left">
          <button type="submit" name="submit" class="btn btn-primary btn-md align-items-center">Modify Puzzle</button>
      </div>
      <br> <br>
      
      </form>';
    
    }//end while
}//end if
else {
    echo "0 results";
}//end else

?>

</div>


