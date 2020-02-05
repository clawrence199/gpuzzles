<?php

include_once 'db_configuration.php';

if (isset($_POST['id'])){

    $id = mysqli_real_escape_string($db, $_POST['id']);
    $puzzle_name = mysqli_real_escape_string($db, $_POST['puzzle_name']);
    $creator_name = mysqli_real_escape_string($db, $_POST['creator_name']);
    $author_name = mysqli_real_escape_string($db, $_POST['author_name']);
    $book_name = mysqli_real_escape_string($db, $_POST['book_name']);
    $oldimage = mysqli_real_escape_string($db, $_POST['oldimage']);
    $oldimage2 = mysqli_real_escape_string($db, $_POST['oldimage2']);
    $puzzle_image_name = basename($_FILES["fileToUpload"]["name"]);
    $solution_image_name = basename($_FILES["fileToUpload2"]["name"]);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);

    $validate = true; // code to invalidate users here TODO    
    
    if($validate) {
    
        if($puzzle_image_name != "") {
            $target_puzzle_dir = "Images/puzzle_images/";
            $target_puzzle_file = $target_puzzle_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            unlink($oldimage);
            $imageFileType = strtolower(pathinfo($target_puzzle_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    header('location: modifyPuzzle.php?modifyPuzzle=fileRealFailed');
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_puzzle_file)) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileExistFailed');
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileTypeFailed');
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_puzzle_file)) {
                        echo $target_puzzle_file;       
                    $sql = "UPDATE gpuzzles
                    SET puzzle_name = '$puzzle_name',
                        creator_name = '$creator_name',
                        author_name = '$author_name',
                        book_name = '$book_name',
                        notes = '$notes',
                        puzzle_image = '$puzzle_image_name'        
                    
                    WHERE id = '$id'";

                    mysqli_query($db, $sql);
                    header('location: puzzles_list.php?puzzleUpdated=Success');
                    }
                }
        }
        if($solution_image_name != "") {
            $target_solution_dir = "Images/solution_images/";
            $target_solution_file = $target_solution_dir . basename($_FILES["fileToUpload2"]["name"]);
            $uploadOk = 1;
            unlink($oldimage2);
            $imageFileType = strtolower(pathinfo($target_solution_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    header('location: modifyPuzzle.php?modifyPuzzle=fileRealFailed');
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_solution_file)) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileExistFailed');
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileTypeFailed');
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_solution_file)) {
                        echo $target_solution_file;       
                    $sql = "UPDATE gpuzzles
                    SET solution_image = '$solution_image_name'        
                    
                    WHERE id = '$id'";

                    mysqli_query($db, $sql);
                    header('location: puzzles_list.php?puzzleUpdated=Success');
                    }
                }
        } else {
                    
            $image = $_SESSION["image"];

            $sql = "UPDATE gpuzzles
            SET puzzle_name = '$puzzle_name',
                creator_name = '$creator_name',
                author_name = '$author_name',
                book_name = '$book_name',
                notes = '$notes'
            
            WHERE id = '$id'";

            mysqli_query($db, $sql);

            header('location: puzzles_list.php?puzzleUpdated=Success');
        }
    }
}//end if



?>
