<?php
    require_once "includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>

    <?php 
        set_error_handler("warning_handler", E_WARNING);
        $test = $_SESSION['username'];
        restore_error_handler();
            
        function warning_handler($errno, $errstr) { 
            restore_error_handler();
            header("Location: index.php");   
        }
    ?>

    <div>
        <h3>Results:</h3>
        <?php
            echo "<table>";
            echo "<th> Title </th>";
            echo "<th> Student </th>";
            echo "<th> Date </th>";
            echo "<th> Score </th>";
            try {
                require_once "includes/dbh.inc.php";
        
                $queryString = "Select Tests.title as Title, student.username as Student, solvedtests.created_at as Date, solvedtests.score as Score from 
                                ((Tests inner join SolvedTests on Tests.test_id = SolvedTests.test_id)
                                inner join Student on SolvedTests.sid= Student.sid)
                                Where Tests.tid= :tid and Tests.test_id= :test_id;";
                $stmt = $pdo->prepare($queryString);
                $stmt->bindParam(":tid", $_SESSION['tid']);
                $stmt->bindParam(":test_id", $_POST['test_id']);
                $stmt->execute();
        
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Student'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "<td>" . $row['Score'] . "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }

            echo "</table>";
        ?>
        <form id="form1" action="resolvedtests.php" method="post" hidden></form>
    </div>

</body>
</html>