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

        $id = 1;
        $nrQ = $_SESSION['nrQ'];

        $score = 1.;
        while($id <= $nrQ) {
            if($_POST["c_ans$id"] == $_POST["ans$id"]) {
                $score += 9. / $nrQ;
            }
            $id += 1;
        }
        
        $queryString = "Insert Into SolvedTests (test_id, sid, score) values(:test_id, :sid, :score);";
        $stmt = $pdo->prepare($queryString);

        $stmt->bindParam(":test_id", $_SESSION['test_id']);
        $stmt->bindParam(":sid", $_SESSION['sid']);
        $stmt->bindParam(":score", $score);
        $stmt->execute();

        $stmt = null;
        $pdo = null;

        header("Location: ../mainstudent.php");
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
    
} else {
    header("Location: ../main.php");
    die();
}
