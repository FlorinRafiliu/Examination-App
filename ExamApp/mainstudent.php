<?php
require_once 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="./css/main.css">

</head>
<body>

<h2 style="text-align: center;"> Welcome back, <?php
        set_error_handler("warning_handler", E_WARNING);
        echo $_SESSION['username'];
        restore_error_handler();
            
        function warning_handler($errno, $errstr) { 
            restore_error_handler();
            header("Location: index.php");   
        }
        ?>!</h2>

<div>
        <h3>Tests:</h3>
        <?php
            echo "<table>";
            echo "<th> Title </th>";
            echo "<th> Teacher </th>";
            echo "<th> Nr. of Questions </th>";
            echo "<th> Date </th>";
            echo "<th> Score </th>";
            try {
                require_once "includes/dbh.inc.php";
        
                $queryString = "Select T.test_id as tid, T.title as Title, Te.username as Name, T.nrQ as Question, T.created_at as Date from Tests as T 
                                inner join Teacher as Te on T.tid = Te.tid;";
                $stmt = $pdo->prepare($queryString);
                $stmt->execute();
        
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Question'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";

                    $queryString = "Select score from SolvedTests
                                    where sid= :sid and test_id= :test_id;";
                    $stmt = $pdo->prepare($queryString);
                    $stmt->bindParam(":sid", $_SESSION['sid']);
                    $stmt->bindParam(":test_id", $row['tid']);
                    $stmt->execute();
                    
                    $score = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(empty($score) == false) {
                        $score = $score['score'];
                    } else {
                        $score = -1;
                    }

                    if($score == -1) {
                        echo "<td> <button type='submit' name='test_id' value='" . $row['tid'] . "' form='form1'> Solve </button> </td>";
                    } else {
                        echo "<td> $score </td>";
                    }
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
            echo "</table>";    
        ?>
        <form id="form1" action="solvetest.php" method="post" hidden></form>
    </div>
    <button style="width: min-content;font-size: medium;" onclick="document.location='./index.php'; "> Disconnect </button>
            

</body>
</html>
