<?php include 'connection.php';?>
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
    <h3>Welcome to Signup Page</h3>
    <form action="signup.php" method="post">
    <div class="input">
     Name<input type="text" name="name" placeholder="Enter your name"><span id="name"></span>
    </div>
    <div class="input">
     Email<input type="email" name="email" placeholder="Enter your email"><span id="email"></span>
    </div>
    <div class="input">
     Password<input type="password" name="password" placeholder="Enter your password"><span id="password"></span>
    </div>
    <div class="input">
     Confirm-Password<input type="re_password" name="re_password" placeholder="Re-enter your password"><span id="re_password"></span>
    </div>
    <div class="button">
        <input type="submit">
        <input type="reset">
        <button><a href="signin.php">Signin</a></button>
    </div>
    </form>
    </div>
</body>
</html>

<?php
    include 'function.php';
    if($_SERVER['REQUEST_METHOD']='POST'){
        if(isset($_POST["name"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $re_password = $_POST["re_password"];

        if(empty($name)){
            echo '<script>
            let nameSpan = document.getElementById("name");
            nameSpan.innerText = "*Name field can\'t be Empty";
            </script>';
        }
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
        if(empty($re_password)){
            echo '<script>
            let re_passwordSpan = document.getElementById("re_password");
            re_passwordSpan.innerText = "*Confirm Password field can\'t Empty";
            </script>';
        }
        if(!empty($name)&&!empty($email)&&!empty($password)&&!empty($re_password)){
            $sql = "select * from user where email='$email'";
            $result = $con->query($sql);
            if($result->num_rows == 0){
                if(!nameCheck($name)){
                    echo '<script>
                    let nameSpan = document.getElementById("name");
                    nameSpan.innerText = "*Enter a valid name";
                    </script>';
                }
                if(!emailCheck($email)){
                    echo '<script>
                    let emailSpan = document.getElementById("email");
                    emailSpan.innerText = "*Enter a valid email";
                    </script>';
                }
                if(!passwordCheck($password,$re_password)){
                    echo '<script>
                    let passwordSpan = document.getElementById("password");
                    passwordSpan.innerText = "*Password, Confirm password shold be same";
                    </script>';
                }
                if(nameCheck($name)&&emailCheck($email)&&passwordCheck($password,$re_password)){
                    $sql = "insert into user(name,email,password) values('$name','$email','$password')";
                    if($con->query($sql)){
                        header('location: signin.php');
                    }
                }
            }else{
                echo '<script>
                let emailSpan = document.getElementById("email");
                emailSpan.innerText = "*Email Already Exist";
                </script>';
            }
            }
        }
    }
?>