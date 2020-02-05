<?php

include_once 'db_configuration.php';

if (isset($_POST['id'])){

    $id = mysqli_real_escape_string($db, $_POST['id']);
    $file = mysqli_real_escape_string($db, $_POST['image_name']);

    unlink($file);

    $sql = "DELETE FROM gpuzzles
            WHERE id = '$id'";

    mysqli_query($db, $sql);
    header('location: puzzles_list.php?puzzleDeleted=Success');
}//end if
?>

