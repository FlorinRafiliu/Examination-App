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

    <h2 style="text-align: center;">Welcome back, 
        <?php 
            set_error_handler("warning_handler", E_WARNING);
            echo $_SESSION['username'];
            restore_error_handler();
                
            function warning_handler($errno, $errstr) { 
                restore_error_handler();
                header("Location: index.php");   
            }
        ?>!
    </h2>

    <form id="form1" action="includes/create_table_handler.php" method="post">
        <h3> Create a new test: </h3>
        <label for="title">Title: </label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="nrQ">Nr. of questions: </label><br>
        <input type="number" id="nrQ" name="nrQ" required> <br><br>
        <input type="submit" value="Create">
    </form>

    <div>
        <h3>Tests:</h3>
        <?php
            echo "<table>";
            echo "<th> Title </th>";
            echo "<th> Nr. of Questions </th>";
            echo "<th> Date </th>";
            try {
                require_once "includes/dbh.inc.php";
        
                $queryString = "Select test_id, title, nrQ, created_at from Tests 
                                Where tid= :tid;";
                $stmt = $pdo->prepare($queryString);
                $stmt->bindParam(":tid", $_SESSION['tid']);
                $stmt->execute();
        
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['nrQ'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td> <button type='submit' name='test_id' value='" . $row['test_id'] . "' form='form2'> See results </button> </td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }

            echo "</table>";
        ?>
        <form id="form2" action="resolvedtests.php" method="post" hidden></form>
    </div>
    <button style="width: min-content;font-size: medium;" onclick="document.location='./index.php'; "> Disconnect </button>
</body>
</html>