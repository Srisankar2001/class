<?php 
    include 'connection.php';
    session_start();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <div class="container">
    <h2>Friend System</h2>
    <h3>Welcome to Signin Page</h3>
    <form action="signin.php" method="post">
    <div class="input">
     Email<input type="email" name="email" placeholder="Enter your email"><span id="email"></span>
    </div>
    <div class="input">
     Password<input type="password" name="password" placeholder="Enter your password"><span id="password"></span>
    </div>
    <div class="button">
        <input type="submit">
        <input type="reset">
        <button><a href="signup.php">Signup</a></button>
    </div>
    </form>
    </div>
</body>
</html>


<?php
    include 'function.php';
    if($_SERVER['REQUEST_METHOD']='POST'){
        if(isset($_POST["email"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        if(empty($email)){
            echo '<script>
            let emailSpan = document.getElementById("email");
            emailSpan.innerText = "*Email field can\'t be Empty";
            </script>';
        }
        if(empty($password)){
            echo '<script>
            let passwordSpan = document.getElementById("password");
            passwordSpan.innerText = "*Password field can\'t Empty";
            </script>';
        }
        if(!empty($email)&&!empty($password)){
            $sql = "select * from user where email='$email'";
            $result = $con->query($sql);
            if($result->num_rows == 1){
                $row = $result->fetch_assoc();
                if($password == $row['password']){
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    header('location: user.php');
                    exit;
                }else{
                    echo '<script>
                    let passwordSpan = document.getElementById("password");
                    passwordSpan.innerText = "*Password not correct";
                    </script>';
                }
            }else{
                echo '<script>
                let emailSpan = document.getElementById("email");
                emailSpan.innerText = "*Email not registered";
                </script>';
            }
            }
        }
    }
?>