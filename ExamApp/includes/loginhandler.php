<?php
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once "./dbh.inc.php";

        $username = $_POST["username"];
        $password = $_POST["pwd"];

        $queryString = "Select tid, password from Teacher 
                        Where username= :username";

        $stmt = $pdo->prepare($queryString);

        $stmt->bindParam(":username", $username);

        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($data) == false) {
            $stmt = null;
            $pdo = null;
            if(password_verify($password, $data['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['tid'] = $data['tid'];
                
                header("Location: ../main.php");
            } else {
                header("Location: ../index.php");
                die();
            }
        } else {
            $queryString = "Select sid, password from Student 
                        Where username= :username;";

            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":username", $username);

            $stmt->execute();   

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($data) == false) {
                $stmt = null;
                $pdo = null;
                if(password_verify($password, $data['password'])) {
                    $_SESSION['username'] = $username;
                    $_SESSION['sid'] = $data['sid'];
                    
                    header("Location: ../mainstudent.php");
                } else {
                    header("Location: ../index.php");
                    die();
                }
            } else {
                $stmt = null;
                $pdo = null;
                header("Location: ../index.php");
            }
        }

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}