<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/createtable.css">

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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nrQ = $_POST['nrQ'];
    $id = 1;


    echo "<form action='testhandler.php' method='post'>";
    while($id <= $nrQ) {
        echo "<div style='border: 1px outset black; width: 100%'>";
        echo "<label for=".$id.">Question ".$id." text: </label>";
        echo "<textarea name='question".$id."' rows='4' cols='50' required></textarea>";

        echo "<input type='text' id='qans".$id."_1' name='qans".$id."_1' placeholder='Enter answer' required>";
        echo "<input type='text' id='qans".$id."_2' name='qans".$id."_2' placeholder='Enter answer' required>";
        echo "<input type='text' id='qans".$id."_3' name='qans".$id."_3' placeholder='Enter answer' required>";
        echo "<input type='text' id='qans".$id."_4' name='qans".$id."_4' placeholder='Enter answer' required>";

        echo '<div style="display:flex; flex-direction: row;">';
        echo '<input type="radio" id="ans'.$id.'_1" name="ans'.$id.'" value="1">';
        echo '<label for="ans'.$id.'_1"> Answer 1</label>';
        echo '</div>';

        echo '<div style="display:flex; flex-direction: row;">';
        echo '<input type="radio" id="ans'.$id.'_2" name="ans'.$id.'" value="2">';
        echo '<label for="ans'.$id.'_2"> Answer 2</label>';
        echo '</div>';

        echo '<div style="display:flex; flex-direction: row;">';
        echo '<input type="radio" id="ans'.$id.'_3" name="ans'.$id.'" value="3">';
        echo '<label for="ans'.$id.'_3"> Answer 3</label>';
        echo '</div>';

        echo '<div style="display:flex; flex-direction: row;">';
        echo '<input type="radio" id="ans'.$id.'_4" name="ans'.$id.'" value="4">';
        echo '<label for="ans'.$id.'_4"> Answer 4</label>';
        echo '</div>';

        echo "</div>";
        $id += 1;
    }
    echo "<input type='submit'>";
    echo "</form>";
    echo '<button style="width: min-content;font-size: medium;" onclick="document.location=\'../main.php\';"> Back  </button>';
    $_SESSION['nrQ'] = $nrQ;
    $_SESSION['title'] = $_POST['title'];
}

?>
</body>
</html>