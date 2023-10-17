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
    Hi,<?php echo $row['name']; ?><br>
    Welcome to FriendList
    <?php echo '<br>'; ?>
    Friend Count:<?php echo ' '.$row['count']; ?>
    <?php
        $sql = "select * from user where id in (select user1 from friend where user2='$id') or id in (select user2 from friend where user1='$id')";
        $result=$con->query($sql);
        echo '<table><tr><th>Name</th><th>Action</th></tr>';
        while($rowResult = $result->fetch_assoc()){
            echo '<tr>
            <td>'.$rowResult["name"].'</td>
            <td><form method="post" action="friendlist.php"><input type="hidden" name="friendId" value="'.$rowResult["id"].'"><input type="submit" name="submit" value="Un Friend"></form></td>
            </tr>';
        }
        echo '</table>';
    ?>
    <div class="button">
        <button><a href="user.php">Add friends</a></button>
        <button><a href="signin.php">Logout</a></button>
    </div>
    </div>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $friendId = $_POST["friendId"];

        $sql = "delete from  friend where (user1='$id' and user2='$friendId') or (user2='$id' and user1='$friendId')";
        $con->query($sql);

        $sqlId = "select count from user where id='$id'";
        $countResult = $con->query($sqlId);
        $countRow = $countResult->fetch_assoc();
        $countId = $countRow['count'];
        $countId--;
        $sqlId = "update user set count='$countId' where id='$id'";
        $con->query($sqlId);

        $sqlFriendId = "select count from user where id='$id'";
        $countFriendResult = $con->query($sqlFriendId);
        $countFriendRow = $countFriendResult->fetch_assoc();
        $countFriendId = $countFriendRow['count'];
        $countFriendId--;
        $sqlFriendId = "update user set count='$countFriendId' where id='$friendId'";
        $con->query($sqlFriendId);
    }
?>