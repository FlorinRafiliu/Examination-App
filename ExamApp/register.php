<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="./css/index.css">


  <script> 
    function checkPwd() {
        if(document.getElementById("pwd1").value != document.getElementById("pwd2").value) {
            document.getElementById("pwd2").value = "";
            alert("Passwords are not matching!");
        }
    }
  </script>

</head>

<body>
  <form action="includes/registerhandler.php" method="post">
    <label for="username">Username: </label> 
    <input type="text" id="username" name="username" required>
    <label for="pwd1">Password: </label> 
    <input type="password" id="pwd1" name ="pwd1" required>
    <label for="pwd2">Confirm password: </label>
    <input type="password" id="pwd2" name ="pwd2" required>
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" required>
    
    <div style="display:flex; flex-direction: row;">
      <label for="student">Student</label>
      <input type="radio" id="student" name="role" value="student">
      <label for="teacher">Teacher</label>
      <input type="radio" id="teacher" name="role" value="teacher">
    </div>
      
    <div style="display:flex; flex-direction: row;">
      <input type="button" onclick="document.location='index.php'" name="back" value="Cancel">
      <input type="submit" onclick="checkPwd()" name="submit" value="Register">
    </div>
  </form>


</body>
</html>