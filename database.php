<?php 

// Variable to Store the info of the DB to make connection
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "clinic_db";
    $conn = ""; // Variable that will make connection

    try{
        $conn = mysqli_connect( $db_server, 
                                $db_user, 
                                $db_pass, 
                                $db_name);
    } catch(mysqli_sql_exception){
        echo "Sorry Something Went Wrong With The DB Connection. <br>";
    }
    
    // Uses if() to check if it made the connection
    if($conn){
       // echo "Connect Successfully. <br><br>";
    }

?>