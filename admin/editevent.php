<?php

    include "conn.php";

    $id=intval($_GET['id']);

    $sql="Select events.*,partners.name As pname From events Left Join partners On events.partners_id = partners.id where events.id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if($rows = mysqli_fetch_array($result)){
        $name = $rows['name'];
        $partners = $rows['pname'];
        $description = $rows['description'];
        $points = $rows['points_reward'];
        $startdate = $rows['start_date'];
        $enddate = $rows['end_date'];
    }else{
        echo "<script>alert('No data from db!');</script>"; 
        echo "<script>window.location.href='eventlists.php';</script>"; 

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Event</title>
    
    <link href="./assets/css/formupdate.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


    <center>
        <a href="eventlists.php" class="backlink">Back to main page</a>
        <h1>Edit Event</h1>

        <form action="" method="post" class="editform">
             <div>
                <label for="uid">ID</label>
                <input type="text" name="uid" value="<?php echo $id;?>" readonly />
            </div>
                        

            <div>
                <label for="name">Event Name</label>
                <input type="text" class="" name="name" value="<?php echo $name;?>"  />
            </div>

            <div>
                <label for="description">Description</label>
                <input type="text" class="" name="description" value="<?php echo $description;?>"  />
            </div>

            <div>
                <label for="partner">Partner</label>
                <input type="text" class="" name="partner" value="<?php echo $partners;?>" />
            </div>

            <div>
                <label for="points">Points Reward</label>
                <input type="text" class="" name="points" value="<?php echo $points;?>" />
            </div>


            <div>
                <div>
                    <label for="startdate">Expired Date</label>
                    <input type="date" name="startdate" 
                            value="<?php echo !empty($startdate) ? date('Y-m-d', strtotime($startdate)) : ''; ?>" />
                </div>

                <div>
                    <label for="enddate">Expired Date</label>
                    <input type="date" name="enddate" 
                            value="<?php echo !empty($enddate) ? date('Y-m-d', strtotime($enddate)) : ''; ?>" />
                </div>
            </div>


            <button type="submit" class="update" name="submit">Submit</button>

        </form>
    </center>


    <?php

        if(isset($_POST['submit'])){

            $uid = $_POST['uid'];
            $name = $_POST['name'];
            $partners = $_POST['partner'];
            $description = $_POST['description'];
            $points = $_POST['points'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];


            $query = "SELECT id FROM partners WHERE name = '$partners'";
            $partner_res = mysqli_query($dbConn, $query);
            $partner_row = mysqli_fetch_assoc($partner_res);
            $partnerid = $partner_row['id'];


            $sql = "UPDATE events SET ".
            "partners_id= '$partnerid',".
            "name = '$name',".
            "description = '$description',".
            "points_reward= '$points',".
            "start_date= '$startdate',".
            "end_date= '$enddate' WHERE id = $uid";

            mysqli_query($dbConn,$sql);

            if(mysqli_affected_rows($dbConn)<=0) { 
                die("<script>alert('Cannot update data!');</script>"); 
                
                echo "<script>window.location.href='eventlists.php';</script>";
            } 

            echo "<script>alert('Successfully updated data!');</script>"; 
            echo "<script>window.location.href='eventlists.php';</script>"; 
                }
    ?>


    
</body>
</html>