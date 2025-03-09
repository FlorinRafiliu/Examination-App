

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./css/index.css">
</head>

<body>
  <form action="includes/loginhandler.php" method="post">
    <label for="username">Username: </label>
    <input type="text" id="username" name="username" required> 
    <label for="pwd">Password: </label>
    <input type="password" id="pwd" name ="pwd" required>
    <a href="register.php" style="font-size: small;" name="register">Create a new account<br><br></a>
    <input type="submit" name="submit" value="Log in">
    
  </form>
</body>
</html>