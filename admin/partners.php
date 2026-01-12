<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>

    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Partners</h1>
                    <p>Manage your EcoReward Partners.</p>
                </div>
                

                <button class="adduser" id="addpartners">
                    <i class="fa-solid fa-plus"></i>
                     Add Partners
                </button>
            </div>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search by name......">
            </div>

            <div class="partners">
                <div class="partner-card">
                    <h3>Bila Bila</h3>
                    <span class="type">Convenience Store</span>

                    <p><i class="fa-regular fa-envelope"></i> bila2@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +60112898582</p>

                    <div class="card-actions">
                        <button class="btn-outline">Edit</button>
                        <button class="btn-outline danger">Delete</button>
                    </div>
                </div>

                <div class="partner-card">
                    <h3>Bila Bila</h3>
                    <span class="type">Convenience Store</span>

                    <p><i class="fa-regular fa-envelope"></i> bila2@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +60112898582</p>

                    <div class="card-actions">
                        <button class="btn-outline">Edit</button>
                        <button class="btn-outline danger">Delete</button>
                    </div>
                </div>

                <div class="partner-card">
                    <h3>Bila Bila</h3>
                    <span class="type">Convenience Store</span>

                    <p><i class="fa-regular fa-envelope"></i> bila2@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +60112898582</p>

                    <div class="card-actions">
                        <button class="btn-outline">Edit</button>
                        <button class="btn-outline danger">Delete</button>
                    </div>
                </div>

                <div class="partner-card">
                    <h3>Bila Bila</h3>
                    <span class="type">Convenience Store</span>

                    <p><i class="fa-regular fa-envelope"></i> bila2@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +60112898582</p>

                    <div class="card-actions">
                        <button class="btn-outline">Edit</button>
                        <button class="btn-outline danger">Delete</button>
                    </div>
                </div>

                <div class="partner-card">
                    <h3>Bila Bila</h3>
                    <span class="type">Convenience Store</span>

                    <p><i class="fa-regular fa-envelope"></i> bila2@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i> +60112898582</p>

                    <div class="card-actions">
                        <button class="btn-outline">Edit</button>
                        <button class="btn-outline danger">Delete</button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Start Add Reward Model -->
        <div id="myAddPartnerModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Parnters</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="get">
                        <div class="form-group">
                            <label for="name">Partner Company Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Partner Company Name" />
                        </div>

                        <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-input" name="email" placeholder="Enter Email" />
                            </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contactperson">Contact Person</label>
                                <input type="email" class="form-input" name="contactperson" placeholder="Enter Contact Person" />
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-input" name="address" placeholder="Enter Address" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phno">Phone Number</label>
                                <input type="text" class="form-input" name="phno" placeholder="Enter Phone Number" />
                            </div>

                            <div class="form-group">
                                <label for="profile">Company Profile</label>
                                <input type="file" class="form-input" name="profile" placeholder="Browse..." />
                            </div>
                        </div>

                        

                        <div class="modal-footer">
                            <button type="button" class="cancelbtn">Cancel</button>
                            <button type="submit" class="addbtn">Add Reward</button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
        <!-- End Add Reward Model -->


    </div>
    
    <script type="text/javascript">
        var addpartnerbtn = document.getElementById('addpartners');
        var addpartnermodal = document.getElementById('myAddPartnerModal');
        var spanclose = document.getElementsByClassName('close')[0];


        addpartnerbtn.onclick = function() {
            addpartnermodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addpartnermodal.style.display = "none";
        }
    </script>

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>