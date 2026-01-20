<?php

    include "conn.php"; 
    $id=intval($_GET['id']);

    $sql="Select * FROM point_rules WHERE id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if($rows = mysqli_fetch_array($result)){
        $type = $rows['material_type'];
        $unit = $rows['unit'];
        $point = $rows['points'];
        $status = $rows['status'];
    }else{
        echo "<script>alert('No data from db!');</script>"; 
        echo "<script>window.location.href='pointsrule.php';</script>"; 

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Point Rules</title>
    
    <link href="./assets/css/formupdate.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


    <center>
        <a href="pointsrule.php" class="backlink">Back to main page</a>
        <h1>Edit Point Rule</h1>

        <form action="" method="post" class="editform">
             <div>
                <label for="uid">ID</label>
                <input type="text" name="uid" value="<?php echo $id;?>" readonly />
            </div>

            <div>
                <label for="type">Material Type</label>
                <input type="text" name="type" value="<?php echo $type;?>" />
            </div>
                        

            <div>
                <label for="unit">Unit</label>
                <input type="text" name="unit" value="<?php echo $unit;?>" />
            </div>

            <div>
                <label for="points">Points</label>
                <input type="text" class="" name="points" value="<?php echo $point;?>"  />
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
            $type = $_POST['type'];
            $unit = $_POST['unit'];
            $point = $_POST['points'];
            $status = $_POST['status'];

            // echo $type;
            // echo $unit;
            // echo $point;
            // echo $status;
            

            $sql = "UPDATE point_rules SET ".
            "material_type= '$type',".
            "unit = '$unit',".
            "points = '$point',".
            "status= '$status' WHERE id = $uid";

            mysqli_query($dbConn,$sql);

            if(mysqli_affected_rows($dbConn)<=0) { 
                die("<script>alert('Cannot update data!');</script>"); 
                
                echo "<script>window.location.href='pointsrule.php';</script>";
            } 

            echo "<script>alert('Successfully updated data!');</script>"; 
            echo "<script>window.location.href='pointsrule.php';</script>"; 
        }
    ?>


    
</body>
</html>