<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>

    <link href="./assets/css/eventapprovalstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Event Approval</h1>
                </div>
                
            </div>

            <div class="approval-card">
                <div class="event-top">
                    <h3>Recycle Workshop</h3>
                    <p>This is event that to bring 3 coffee cups shelve.</p>
                </div>

                <div class="event-info">
                    <span>📅 Dec 12, 2025 - Dec 19, 2025</span>
                    <span>📍 Center Point</span>
                    <span>🤝 BilaBila</span>
                </div>

                <div class="event-bottom">
                    <span class="points">Reward - 200 points </span>
                    <div class="actions">
                        
                        <button class="btn approve">Approve</button>
                        <button class="btn reject">Reject</button>
                    </div>
                </div>
            </div>

            
        </main>

        

        

    </div>
    
    

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>