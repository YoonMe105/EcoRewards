<?php

    include "conn.php";

    $id=intval($_GET['id']);

    $sql="Select * From admins where id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if($rows = mysqli_fetch_array($result)){
        $name = $rows['fullname'];
        $email = $rows['email'];
        $phone = $rows['phone'];
        $status = $rows['status'];
    }else{
        echo "<script>alert('No data from db!');</script>"; 
        echo "<script>window.location.href='admins.php';</script>"; 

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Admin</title>
    
    <link href="./assets/css/formupdate.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


    <center>
        <a href="admins.php" class="backlink">Back to main page</a>
        <h1>Edit Admin</h1>

        <form action="" method="post" class="editform">
             <div>
                <label for="uid">ID</label>
                <input type="text" name="uid" value="<?php echo $id;?>" readonly />
            </div>
                        

            <div>
                <label for="name">Full Name</label>
                <input type="text" class="" name="name" value="<?php echo $name;?>"  />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" class="" name="email" value="<?php echo $email;?>"  />
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="text" class="" name="phone" value="<?php echo $phone;?>" />
            </div>

            <div>
                <label for="status">Status</label>
                <select name="status" class="status">
                    <option value="active" <?php if($status == "active") echo "selected"; ?>>
                        Active
                    </option>

                    <option value="inactive" <?php if($status == "inactive") echo "selected"; ?>>
                        Inactive
                    </option>

                   
                </select>
            </div>

            <button type="submit" class="update" name="submit">Submit</button>

        </form>
    </center>


    <?php

        if(isset($_POST['submit'])){

            $uid = $_POST['uid'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $status = $_POST['status'];


            $sql = "UPDATE admins SET ".
            "fullname = '$name',".
            "email = '$email',".
            "phone= '$phone',".
            "status= '$status' WHERE id = $uid";

            mysqli_query($dbConn,$sql);

            if(mysqli_affected_rows($dbConn)<=0) { 
                die("<script>alert('Cannot update data!');</script>"); 
                
                echo "<script>window.location.href='admins.php';</script>";
            } 

            echo "<script>alert('Successfully updated data!');</script>"; 
            echo "<script>window.location.href='admins.php';</script>"; 
                }
    ?>


    
</body>
</html>