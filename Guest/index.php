<?php
include "db.php";

/* Top 3 */
$top3 = mysqli_query($conn,
    "SELECT fullname, role, user_points
     FROM users
     WHERE user_points > 0
     ORDER BY user_points DESC
     LIMIT 3"
);

if (!$top3) {
    die("Top 3 query failed: " . mysqli_error($conn));
}

/* Rank 4 & 5 */
$next2 = mysqli_query($conn,
    "SELECT fullname, role, user_points
     FROM users
     WHERE user_points > 0
     ORDER BY user_points DESC
     LIMIT 2 OFFSET 3"
);

if (!$next2) {
    die("Next 2 query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRewards</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
<!-- Header -->
<header class="header">
  <div class="container header-container">

    <!-- Hamburger -->
    <div class="mobile-hamburger" id="hamburger">☰</div>

    <!-- Logo -->
    <div class="logo">
      <img src="images/logo.png" alt="EcoRewards Logo" class="logo-img">
      <span class="logo-text">EcoRewards</span>
  </div>


    <!-- Navigation -->
    <nav class="nav" id="navMenu">
      <a href="#home" class="nav-link active">Home</a>
      <a href="#about" class="nav-link">About Recycling</a>
      <a href="#items" class="nav-link">Recycling Items</a>
      <a href="#process" class="nav-link">Process</a>
      <a href="#events" class="nav-link">Events</a>
      <a href="#leaderboard" class="nav-link">Leaderboard</a>
      <a href="#partners" class="nav-link">Partners</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>

    <!-- Auth buttons -->
    <div class="auth-buttons">
      <button class="btn-login" onclick="window.location.href='../User/php/login.php'">Log In</button>
      <button class="btn-register">Register</button>
    </div>

  </div>
</header>


<!-- Home Section -->
<section id="home" class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <h1>Make APU Greener & Earn Rewards!</h1>
        <p>Join the EcoRewards community and turn your recycling efforts into points. 
          Redeem campus perks and help build a sustainable environment at APU!
        </p>
        <div class="hero-buttons">
          <button class="btn-primary">Get Started</button>
          <button class="btn-secondary">Learn More</button>
        </div>
      </div>
      <div class="hero-image">
        <img src="images/homenew.JPG" alt="Recycling">
      </div>
    </div>
  </div>
</section>

<!--Stats Section-->
<section class="stats">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">♻️</div>
        <h3>Weekly Recycler</h3>
        <p>Recycle at least 5kg of materials this week</p>
      </div>
      <div class="stat-card">
        <div class="stat-icon">👥</div>
        <h3>Community Helper</h3>
        <p>Participate in one EcoRewards event</p>
      </div>
      <div class="stat-card">
        <div class="stat-icon">💧</div>
        <h3>Water Saver</h3>
        <p>Reduce household in one usage by 100L</p>
      </div>
      <div class="stat-card">
        <div class="stat-icon">⚡</div>
        <h3>Energy Conscious</h3>
        <p>Switch off unused electrical appliances</p>
      </div>
    </div>
  </div>
</section>

<!-- About Recycling Section -->
<section id="about" class="about-recycling">
  <div class="container about-container">

    <!-- LEFT: Text -->
    <div class="about-text">
      <h2>Why Recycling Matters at APU</h2>
      <p>
        Recycling helps reduce waste, conserve natural resources, and protect
        the environment. At APU, students are encouraged to recycle responsibly
        on campus to support sustainability efforts and reduce environmental impact.
      </p>
    </div>

    <!-- RIGHT: Image -->
    <div class="about-image">
      <img src="images/about.JPG" alt="Recycling activities at APU">
    </div>

  </div>
</section>


<!--Recycling Items-->
<section id="items" class="items">
  <div class="container">
    <h2>🍃 What Can You Recycle?</h2>

    <div class="items-slider">
      <!-- Left Arrow -->
      <button class="arrow left" onclick="slideLeft()">&#10094;</button>

      <!-- Grid of items -->
      <div class="items-grid" id="itemsGrid">
        <div class="item-card">
          <div class="item-icon">
            <img src="images/tin.JPG" alt="Tin">
          </div>
          <p>Aluminium Tin</p>
        </div>

        <div class="item-card">
          <div class="item-icon">
            <img src="images/glassnew.JPG" alt="Glass">
          </div>
          <p>Glass</p>
        </div>

        <div class="item-card">
          <div class="item-icon">
            <img src="images/plastic.JPG" alt="Plastic">
          </div>
          <p>Plastic</p>
        </div>

        <div class="item-card">
          <div class="item-icon">
            <img src="images/paper.JPG" alt="Paper">
          </div>
          <p>Paper</p>
        </div>
      </div>

      <!-- Right Arrow -->
      <button class="arrow right" onclick="slideRight()">&#10095;</button>
    </div>
  </div>
</section>


<!-- Process Section -->
<section id="process" class="process-section">
  <div class="container">

    <h2>♻️ How EcoRewards Works</h2>
    <p class="process-subtitle">
      Follow these simple steps to earn points and redeem rewards at APU!
    </p>

    <div class="process-steps">

      <!-- Step 1 -->
      <div class="process-step">
        <div class="step-icon">🗑️</div>
        <h3>Collect Items</h3>
        <p>Bottles, cans, and paper collected on campus bins.</p>
        <p><strong>Points:</strong> 5 pts per item</p>
      </div>

      <!-- Step 2 -->
      <div class="process-step">
        <div class="step-icon">📸</div>
        <h3>Submit Proof</h3>
        <p>Upload a photo to confirm your recycling activity.</p>
        <p><strong>Points:</strong> Verified submissions earn points</p>
      </div>

      <!-- Step 3 -->
      <div class="process-step">
        <div class="step-icon">✅</div>
        <h3>Verification</h3>
        <p>Admin checks submissions and confirms your earned points.</p>
      </div>

      <!-- Step 4 -->
      <div class="process-step">
        <div class="step-icon">🎁</div>
        <h3>Redeem Rewards</h3>
        <p>Use your points for campus perks like discounts, vouchers, or prizes.</p>
      </div>

    </div>

  </div>
</section>


<!--Event-->
<section id="events" class="events">
  <div class="container">
    <h2>Join Our Events</h2>

    <!-- Toggle Buttons -->
    <div class="event-toggle-buttons">
      <button type="button" id="past-btn" class="active">Past Events</button>
      <button type="button" id="upcoming-btn">Upcoming Events</button>
    </div>

    <!-- Past Events -->
    <div id="past-events" class="events-grid">
      <div class="event-card">
        <img src="images/tree.JPG" alt="Tree Planning">
        <span class="past-label">Event Completed</span>
        <div class="event-category">Tree Planning</div>
        <h3>Tree Planting Program</h3>
        <p class="event-date">📆 November 11, 2025</p>
        <p class="event-location">📍Asia Pacific University, Bukit Jalil</p>
        <p class="event-description">Join tree planting activity to protect the environment.</p>
        <p class="event-spots">👥 20 spots attended</p>
      </div>

      <div class="event-card">
        <img src="images/beach.JPG" alt="Beach Cleanup">
        <span class="past-label">Event Completed</span>
        <div class="event-category">Beach Cleanup</div>
        <h3>Beach Cleanup Drive - Port Dickson</h3>
        <p class="event-date">📆 April 20, 2025</p>
        <p class="event-location">📍Port Dickson Beach, Negeri Sembilan</p>
        <p class="event-description">Help clean our beaches and protect marine life. All equipment provided.</p>
        <p class="event-spots">👥 60 spots attended</p>
      </div>
    </div>

    <!-- Upcoming Events -->
    <div id="upcoming-events" class="events-grid">
      <div class="event-card">
        <img src="images/drive.JPG" alt="Campus Recycle">
        <div class="event-category">Campus Recycle</div>
        <h3>Campus Recycle Day</h3>
        <p class="event-date">📆 February 12, 2026</p>
        <p class="event-location">📍Asia Pacific University, Bukit Jalil</p>
        <p class="event-description">Recycle items around campus and earn double points.</p>
        <p class="event-spots">👥 20 spots remaining</p>
      </div>

      <div class="event-card">
        <img src="images/ewaste.JPG" alt="E-Waste Campaign">
        <div class="event-category">E-Waste</div>
        <h3>E-Waste Collection Campaign</h3>
        <p class="event-date">📆 February 20, 2026</p>
        <p class="event-location">📍Sunway Pyramid, Petaling Jaya</p>
        <p class="event-description">Dispose of your old electronics responsibly. Free collection for all e-waste items.</p>
        <p class="event-spots">👥 12 spots remaining</p>
      </div>
    </div>

  </div>
</section>

<section id="leaderboard" class="leaderboard">
  <div class="container">
    <h1>🏆 EcoRewards Public Leaderboard</h1>
    <p>See the top contributors and the impact of our EcoRewards program!</p>

    <!-- Top 3 -->
    <div class="top-three">
    <?php
    $medals = ["🥇", "🥈", "🥉"];
    $i = 0;

    while ($row = mysqli_fetch_assoc($top3)) {
        echo "
        <div class='card contributor-card'>
            <h2>{$medals[$i]} {$row['fullname']}</h2>
            <p>Role: {$row['role']}</p>
            <p>Points: {$row['user_points']}</p>
        </div>
        ";
        $i++;
    }
    ?>
    </div>

    <!-- Rank 4 & 5 -->
    <div class="next-two">
    <?php
    while ($row = mysqli_fetch_assoc($next2)) {
        echo "
        <div class='card contributor-card'>
            <h2>{$row['fullname']}</h2>
            <p>Role: {$row['role']}</p>
            <p>Points: {$row['user_points']}</p>
        </div>
        ";
    }
    ?>
    </div>

  </div>
</section>

</body>
</html>

<!-- Partners -->
<section id="partners" class="partners">
  <div class="container">

    <h2>Partner Merchants</h2>

    <div class="partner-slider-wrapper">

      <button class="partner-arrow left" onclick="slidePartners(-1)">❮</button>

      <div class="partner-grid" id="partnerSlider">

        <?php
        $query = "SELECT name, email, phone, address FROM partners";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {

          if ($row['name'] == 'Subway') {
              $image = "images/subway.JPG";
              $description = "International sandwich brand offering fresh and customizable meal options.";
          } elseif ($row['name'] == 'Aicha') {
              $image = "images/aicha.JPG";
              $description = "Popular beverage brand serving a variety of refreshing milk teas and drinks.";
          } elseif ($row['name'] == 'BilaBila') {
              $image = "images/bila.JPG";
              $description = "Local cafe offering a wide range of meals and beverages for everyday dining.";
          }
        ?>
          <div class="partner-card">

            <img src="<?php echo $image; ?>" class="partner-img">

            <h3><?php echo $row['name']; ?></h3>

            <p><?php echo $description; ?></p>

            <p>📧 <?php echo $row['email']; ?></p>
            <p>📞 <?php echo $row['phone']; ?></p>
            <p>📍 <?php echo $row['address']; ?></p>

          </div>
        <?php } ?>

      </div>

      <button class="partner-arrow right" onclick="slidePartners(1)">❯</button>

    </div>
  </div>
</section>

<!--Contact-->
<section id="contact" class="contact">
  <div class="container">
    <!-- Section Title -->
    <h2 class="section-title">Contact Us</h2>
    <p class="section-subtitle">
      Have questions or need help? We're here for you.
    </p>
    <div class="contact-content">
      <div class="contact-form">
        <form onsubmit="return handleSubmit(event)">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" id="fullname" required placeholder="Enter your full name">
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" id="Email" required placeholder="your.email@example.com">
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" id="phone" required placeholder="+60 12 - 345 6789">
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea name="message" id="message" required rows="5" placeholder="Tell us more..."></textarea>
          </div>
          <button type="submit" class="btn-primary">Send Message</button>
        </form>
      </div>

<!--Contact Information-->
      <div class="contact-info">
        <h3>Contact Information</h3>
        <p>📍 No. 11, Jalan Teknologi 5, Taman Teknologi Malaysia, Bukit Jalil, 57000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur.</p>
        <p>📞  +60 3-1234 5678</p>
        <p>📧 info@ecorewards.com.my</p>
        <p>🕒 Mon-Fri: 9:00 AM - 6:00 PM</p>
      </div>
    </div>
  </div>
</section>

<!--Footer-->
<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <div class="footer-brand">
        <div class="logo">
          <img src="images/logo.png" alt="EcoRewards Logo" class="logo-img">
          <span>EcoRewards</span>
        </div>
        <p>Building a sustainable future through community-driven recycling initiatives across Malaysia.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <a href="#home">Home</a>
        <a href="#about">About Recycling</a>
        <a href="#items">Recycling Items</a>
        <a href="#process">Process</a>
        <a href="#events">Events</a>
      </div>
      <div class="footer-links">
        <h4>Community</h4>
        <a href="#leaderboard">Leaderboard</a>
        <a href="#partners">Partners</a>
        <a href="#contact">Contact</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 EcoRewards. All rights reserved.</p>
      <p>Made with ♻️ for a sustainable Malaysia</p>
    </div>
  </div>
</footer>

<!-- Register Modal -->
<div id="registerModal" class="register-modal">
  <div class="register-content">

    <span class="register-close" onclick="closeRegisterModal()">&times;</span>

    <h2>Create Account</h2>

    <form 
      action="register.php"
      method="POST"
      enctype="multipart/form-data"
    >

      <label>Full Name</label>
      <input type="text" name="fullname" required placeholder="Enter your full name">

      <label>Profile Image</label>
      <input type="file" name="profile_image" accept="image/*" required>

      <label>Role</label>
      <select name="role" required>
        <option value="">Select role</option>
        <option value="student">Student</option>
        <option value="staff">Staff</option>
      </select>

      <label>Email Address</label>
      <input type="email" name="email" required placeholder="your.email@example.com">

      <label>Phone Number</label>
      <input type="tel" name="phone" required placeholder="+60 12-345 6789">

      <label>Password</label>
      <input type="password" name="password" required placeholder="Enter your password">

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" required placeholder="Confirm your password">

      <button type="submit" class="btn-primary">Register</button>
    </form>

  </div>
</div>

<script src="main.js"></script>
</body>
</html>
