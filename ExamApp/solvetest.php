<?php

require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/createtable.css">

</head>
<body>
    
<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $test_id = $_POST['test_id'];
    try {
        require_once "includes/dbh.inc.php";

       
        $queryString = "Select * from Questions  
                        Where test_id= :test_id";

        $stmt = $pdo->prepare($queryString);
        $stmt->bindParam(":test_id", $test_id);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id = 1;
        echo "<form action='includes/solvehandler.php' method='post'>";
        foreach($data as $row) {
            echo "<div style='border: 1px outset black; width: 100%'>";
            echo "<label for=".$id.">Question ".$id." text: </label> <br>";
            echo "<textarea readonly name='question".$id."' rows='4' cols='50'>".$row['question']."</textarea><br>";
            echo "<input type='text' name='qid$id' value='".$row['qid']."' hidden>";
            echo "<input type='text' name='c_ans$id' value='".$row['ans']."' hidden>";
            
            echo '<div style="display:flex; flex-direction: row;">';
            echo '<input type="radio" id="ans'.$id.'_1" name="ans'.$id.'" value="1">';
            echo '<label for="ans'.$id.'_1">'.$row['ans1'].'</label><br>';
            echo "</div>";

            echo '<div style="display:flex; flex-direction: row;">';
            echo '<input type="radio" id="ans'.$id.'_2" name="ans'.$id.'" value="2">';
            echo '<label for="ans'.$id.'_2">'.$row['ans2'].'</label><br>';
            echo "</div>";

            echo '<div style="display:flex; flex-direction: row;">';
            echo '<input type="radio" id="ans'.$id.'_3" name="ans'.$id.'" value="3">';
            echo '<label for="ans'.$id.'_3">'.$row['ans3'].'</label><br>';
            echo "</div>";

            echo '<div style="display:flex; flex-direction: row;">';
            echo '<input type="radio" id="ans'.$id.'_4" name="ans'.$id.'" value="4">';
            echo '<label for="ans'.$id.'_4">'.$row['ans4'].'</label><br>';
            echo "</div>";

            echo "</div>";
            $id += 1;
        }
        echo "<input type='submit'>";
        echo "</form>";

        $stmt = null;
        $pdo = null;
        
        $_SESSION['test_id'] = $test_id;
        $_SESSION['nrQ'] = $id - 1;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    die();
} else {
    header("Location: ../index.php");
}
?>
</body>
</html>