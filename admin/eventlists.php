<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>

    <link href="./assets/css/eventliststyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Event Lists</h1>
                    <p>Organize and manage recycling event lists.</p>
                </div>
                

                <button class="adduser" id="addevents">
                    <i class="fa-solid fa-plus"></i>
                     Create Event
                </button>
            </div>

            <div class="event-card">
                <div class="event-top">
                    <h3>Recycle Workshop</h3>
                    <span class="status upcoming">Upcoming</span>
                </div>

                <div class="event-info">
                    <span>📅 Dec 12, 2025 - Dec 19, 2025</span>
                    <span>📍 Center Point</span>
                </div>

                <div class="event-bottom">
                    <span class="points">Points - 200</span>
                    <div class="actions">
                        <button class="btn view" onclick="openModal()">View Details</button>
                        <button class="btn edit">Edit</button>
                        <button class="btn delete">Delete</button>
                    </div>
                </div>
            </div>

            
        </main>

        <!-- Start Add event Model haven't done -->
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
        <!-- End Add event Model -->

        <!-- start view details -->
        <div class="modal-overlay" id="viewModal">
            <div class="modal">
                <div class="modal-header">
                    <h3>Event Details</h3>
                    <button class="close-btn" onclick="closeModal()">✕</button>
                </div>

                <div class="modal-body">
                    <h4>Recycle Workshop</h4>

                    <div class="modal-section">
                        <strong>Description</strong>
                        <p>
                            Join us for a community-wide cleanup initiative to make our parks
                            cleaner and greener. Bring gloves and enthusiasm!
                        </p>
                    </div>

                    <div class="modal-section">
                        <strong>Date</strong>
                        <p>Dec 12, 2025 - Dec 19, 2025</p>
                    </div>

                    <div class="modal-section">
                        <strong>Location</strong>
                        <p>Center Point</p>
                    </div>

                    <div class="modal-section">
                        <strong>Partner</strong>
                        <p>BilaBila</p>
                    </div>

                    <div class="modal-section">
                        <strong>Points Reward</strong>
                        <p>200</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn cancel" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </div>

        <!-- end view details -->

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


        function openModal() {
            document.getElementById("viewModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("viewModal").style.display = "none";
        }
    </script>

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>