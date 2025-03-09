<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once "./dbh.inc.php";

        $role = $_POST["role"];

        $password = $_POST["pwd1"];
        $options = ["cost" => 10];
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

        if($role == 'teacher') {

            $username = $_POST["username"];

            $queryString = "Select * from Teacher 
                            Where username= :username";

            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":username", $username);

            $stmt->execute();

            
            if(empty($stmt->fetchAll(PDO::FETCH_ASSOC)) == false) {
                $stmt = null;
                $pdo = null;
        
                header("Location: ../register.php");
                die();
            }

            $email = $_POST["email"];

            $queryString = "Insert into Teacher (username, password, email) 
                            Values (:username, :password, :email)";

            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $hashedPwd);
            $stmt->bindParam(":email", $email);

            $stmt->execute();

            $stmt = null;
            $pdo = null;

            header("Location: ../index.php");
            die("Account created successfully!");
        } else {
            $username = $_POST["username"];

            $queryString = "Select * from Student 
                            Where username= :username";

            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":username", $username);

            $stmt->execute();

            
            if(empty($stmt->fetchAll(PDO::FETCH_ASSOC)) == false) {
                $stmt = null;
                $pdo = null;
        
                header("Location: ../register.php");
                die();
            }

            $email = $_POST["email"];

            $queryString = "Insert into Student (username, password, email) 
                            Values (:username, :password, :email)";

            $stmt = $pdo->prepare($queryString);

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $hashedPwd);
            $stmt->bindParam(":email", $email);

            $stmt->execute();

            $stmt = null;
            $pdo = null;

            header("Location: ../index.php");
            die("Account created successfully!");
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }


} else {
    header("Location: ../index.php");
}