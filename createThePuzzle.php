<?php

include_once 'db_configuration.php';

//if (isset($_POST['gpuzzles'])){
//TODO  !!!!
    echo "HERE";
    $puzzle_name = mysqli_real_escape_string($db, $_POST['puzzle_name']);
    $creator_name = mysqli_real_escape_string($db, $_POST['creator_name']);
    $author_name = mysqli_real_escape_string($db,$_POST['author_name']);
    $book_name = mysqli_real_escape_string($db,$_POST['book_name']);
    $puzzle_image = basename($_FILES["fileToUpload"]["name"]);
    $solution_image = basename($_FILES["fileToUpload2"]["name"]);
    $notes = mysqli_real_escape_string($db,$_POST['notes']);
    $validate = true;//logic to reject validation here TODO 
    
    if($validate){
        
        $target_puzzle_dir = "Images/puzzle_images/";
        $target_puzzle_file = $target_puzzle_dir . basename($_FILES["fileToUpload"]["name"]);
        $target_solution_dir = "Images/solution_images/";
        $target_solution_file = $target_solution_dir . basename($_FILES["fileToUpload2"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_puzzle_file,PATHINFO_EXTENSION));
        // Check if image files are  actual images or fake images
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                header('location: createPuzzle.php?createPuzzle=fileRealFailed');
                $uploadOk = 0;
            }
            $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                header('location: createPuzzle.php?createPuzzle=fileRealFailed');
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_puzzle_file)) {
            header('location: createPuzzle.php?createPuzzle=fileExistFailed');
            $uploadOk = 0;
        }
        if (file_exists($target_solution_file)) {
            header('location: createPuzzle.php?createPuzzle=fileExistFailed');
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            header('location: createPuzzle.php?createPuzzle=fileTypeFailed');
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_puzzle_file) 
                && move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_solution_file)) {
                //big stuff for ass 3 !!!!
                $sql = "INSERT INTO gpuzzles(puzzle_name,creator_name,author_name,book_name,puzzle_image,solution_image,notes)
                VALUES ('$puzzle_name','$creator_name','$author_name','$book_name','$puzzle_image','$solution_image','$notes')
                ";

                mysqli_query($db, $sql);
                header('location: puzzles_list.php?createPuzzle=Success');
                }
            }
        }

//}//end if




?>