<?php

include "conn.php"; 
$id=intval($_GET['id']);

$sql="Select * FROM rewards WHERE id=$id"; 
$result=mysqli_query($dbConn, $sql);

if($rows = mysqli_fetch_array($result)){
    $name = $rows['name'];
    $partners = $rows['partners_id'];
    $description = $rows['description'];
    $qty = $rows['quantity'];
    $points = $rows['points_required'];
    $expireddate = $rows['expired_at'];
    $status = $rows['status'];
}else{
    echo "<script>alert('No data from db!');</script>"; 
    echo "<script>window.location.href='view.php';</script>"; 

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Rewards</title>
    
    <style>
        .editform {
        width: 450px;          /* 🔹 form size */
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        margin: 40px auto;     /* 🔹 center horizontally */
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


    <center>
        <h1>Edit Rewards</h1>

        <form action="" method="post" class="editform">
            <div>
                <label for="name">Reward Name</label>
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
                <div>
                    <label for="points">Points Required</label>
                    <input type="text" class="" name="points" value="<?php echo $points;?>" />
                </div>

                <div>
                    <label for="qty">Stock Quantity</label>
                    <input type="text" class="" name="qty" value="<?php echo $qty;?>" />
                </div>
            </div>

            <div>
                <div>
                    <label for="exprieddate">Expired Date</label>
                    <input type="date" class="" name="exprieddate" value="<?php echo $expireddate;?>" />
                </div>

                <div>
                    <label for="status">Status</label>
                    <select name="status">
                        <option value="available" <?php if($status == "available") echo "selected"; ?>>
                            Available
                        </option>

                        <option value="outofstock" <?php if($status == "outofstock") echo "selected"; ?>>
                            Out of Stock
                        </option>

                        <option value="expired" <?php if($status == "expired") echo "selected"; ?>>
                            Expired
                        </option>
                    </select>
                </div>
            </div>

            

        </form>
    </center>



    
</body>
</html>