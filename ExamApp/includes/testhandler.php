<?php
require_once 'config.php';

set_error_handler("warning_handler", E_WARNING);
$test = $_SESSION['username'];
restore_error_handler();
                
function warning_handler($errno, $errstr) { 
    restore_error_handler();
    header("Location: index.php");   
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {
        require_once 'dbh.inc.php';

        echo "<p>aici1</p>";
        // Creeare un nou test
        $queryString = "Insert Into Tests (tid, nrQ, title) values(:tid, :nrQ, :title);";
        $stmt = $pdo->prepare($queryString);

        echo "<p>".$_SESSION['tid'] . " " . $_SESSION['nrQ']. " " . $_SESSION['title'] . "</p>";

        $stmt->bindParam(":tid", $_SESSION['tid']);
        $stmt->bindParam(":nrQ", $_SESSION['nrQ']);
        $stmt->bindParam(":title", $_SESSION['title']);

        $stmt->execute();

        echo "<p>aici2</p>";
        //Extragere ID
        $queryString = "Select test_id from Tests order by test_id desc limit 1;";
        $stmt = $pdo->prepare($queryString);
        $stmt->execute();

        $test_id = $stmt->fetchColumn(0);
        $id = 1;

        echo "<p>aici3</p>";

        $nrQ = $_SESSION['nrQ'];
        while($id <= $nrQ) {
            $question = $_POST["question".$id];
            $ans1 = $_POST["qans".$id."_1"];
            $ans2 = $_POST["qans".$id."_2"];
            $ans3 = $_POST["qans".$id."_3"];
            $ans4 = $_POST["qans".$id."_4"];
            $ans = $_POST["ans$id"];

            $queryString = "Insert Into Questions (question, ans1, ans2, ans3, ans4, ans, test_id)
                            values (:question, :ans1, :ans2, :ans3, :ans4, :ans, :test_id);";
            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":question", $question);
            $stmt->bindParam(":ans1", $ans1);
            $stmt->bindParam(":ans2", $ans2);
            $stmt->bindParam(":ans3", $ans3);
            $stmt->bindParam(":ans4", $ans4);
            $stmt->bindParam(":ans", $ans);
            $stmt->bindParam(":test_id", $test_id);

            $stmt->execute();
            $id += 1;
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
    
} 

header("Location: ../main.php");
die();
