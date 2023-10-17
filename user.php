<?php
    include 'connection.php';
    session_start();
    if(!isset($_SESSION['id'])){
        die("Error");
    }
    $id = $_SESSION['id'];
    $sql = "select * from user where id='$id'";
    $result=$con->query($sql);
    $row=$result->fetch_assoc();  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    Hi,<?php echo $row['name']; ?>
    <?php echo '<br>'; ?>
    Friend Count:<?php echo ' '.$row['count']; ?>
    <?php
        $sql = "SELECT * FROM user WHERE id != '$id' AND id NOT IN (SELECT user2 FROM friend WHERE user1 = '$id') AND id NOT IN (SELECT user1 FROM friend WHERE user2 = '$id')";
        $result=$con->query($sql);
        echo '<table><tr><th>Name</th><th>Action</th></tr>';
        while($rowResult = $result->fetch_assoc()){
            echo '<tr>
            <td>'.$rowResult["name"].'</td>
            <td><form method="post" action="user.php"><input type="hidden" name="friendId" value="'.$rowResult["id"].'"><input type="submit" name="submit" value="Add Friend"></form></td>
            </tr>';
        }
        echo '</table>';
    ?>
    </div>
    <div class="button">
        <button><a href="friendlist.php">friends</a></button>
        <button><a href="signin.php">Logout</a></button>
    </div>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $friendId = $_POST["friendId"];

        $sql = "insert into friend values('$id','$friendId')";
        $con->query($sql);

        $sqlId = "select count from user where id='$id'";
        $countResult = $con->query($sqlId);
        $countRow = $countResult->fetch_assoc();
        $countId = $countRow['count'];
        $countId++;
        $sqlId = "update user set count='$countId' where id='$id'";
        $con->query($sqlId);

        $sqlFriendId = "select count from user where id='$id'";
        $countFriendResult = $con->query($sqlFriendId);
        $countFriendRow = $countFriendResult->fetch_assoc();
        $countFriendId = $countFriendRow['count'];
        $countFriendId++;
        $sqlFriendId = "update user set count='$countFriendId' where id='$friendId'";
        $con->query($sqlFriendId);
    }
?>