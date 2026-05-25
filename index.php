<?php
// =========================================================================
// 1. DATABASE CONNECTION & CONFIGURATION (Runs in the background)
// =========================================================================
$host     = '127.0.0.1'; // Standard internal IP for Termux MariaDB
$dbname   = 'divinestar_db'; 
$username = 'root';   
$password = ''; // Default empty password for Termux

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // If MariaDB server isn't turned on in Termux, stop and show error
    die("Database connection failed: " . $e->getMessage());
}

// =========================================================================
// 2. FORM PROCESSING INTERCEPTOR (Only fires when "Submit" is pressed)
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Clean and sanitize user inputs
    $student_name    = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $student_age     = filter_input(INPUT_POST, 'student_age', FILTER_VALIDATE_INT) ?: null;
    $class_selection = filter_input(INPUT_POST, 'class_selection', FILTER_SANITIZE_SPECIAL_CHARS);
    $old_school_name = filter_input(INPUT_POST, 'old_school_name', FILTER_SANITIZE_SPECIAL_CHARS) ?: null;
    $parent_name     = filter_input(INPUT_POST, 'parent_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $relationship    = filter_input(INPUT_POST, 'relationship', FILTER_SANITIZE_SPECIAL_CHARS);
    $parent_email    = filter_input(INPUT_POST, 'parent_email', FILTER_VALIDATE_EMAIL);
    $message         = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?: null;

    // Validate that all required inputs exist
    if ($student_name && $class_selection && $parent_name && $parent_email && $relationship) {
        
        $sql = "INSERT INTO admissions 
                (student_name, student_age, class_selection, old_school_name, parent_name, relationship, parent_email, message) 
                VALUES 
                (:student_name, :student_age, :class_selection, :old_school_name, :parent_name, :relationship, :parent_email, :message)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':student_name'    => $student_name,
                ':student_age'     => $student_age,
                ':class_selection' => $class_selection,
                ':old_school_name' => $old_school_name,
                ':parent_name'     => $parent_name,
                ':relationship'    => $relationship,
                ':parent_email'    => $parent_email,
                ':message'         => $message
            ]);

            // Alert user of success and smoothly snap back to the admission section
          // Paste this inside index.php right after your SQL $stmt->execute(...) success block
http_response_code(200); 
exit;


        } catch (PDOException $e) {
            die("Error processing application database entry: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('Please fill out all required fields with valid details </script>
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Divine Star Academy</title>
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="header">
    <nav class="navbar">
      <div class="logo">
        <h2>Divine Star Academy</h2>
      </div>

      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <ul class="nav-links" id="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#academics">Academics</a></li>
        <li><a href="#admission">Admissions</a></li>
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero" id="home">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Welcome To Divine Star Academy</h1>
        <p>Quality Education From Creche To JHS 3</p>
        <a href="#admission" class="btn">Apply Now</a>
      </div>
    </div>
  </section>

  <section class="about section" id="about">
    <div class="container">
      <div class="section-title">
        <h2>About Our School</h2>
      </div>

      <div class="about-content">
        <div class="about-image">
          <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1470&auto=format&fit=crop" alt="School building campus">
        </div>

        <div class="about-text">
          <h3>Excellence In Education</h3>
          <p>Divine Star Academy provides quality education from Creche to JHS 3.</p>
          <p>We focus on leadership, discipline, and academic excellence.</p>
        </div>
      </div>
    </div>
  </section>
  
  <section class="levels section" id="academics">
    <div class="container">
      <div class="section-title">
        <h2>Academic Levels</h2>
      </div>

      <div class="level-cards">
        <div class="card">
          <i class="fa-solid fa-baby"></i>
          <h3>Creche</h3>
          <p>Early childhood development.</p>
        </div>

        <div class="card">
          <i class="fa-solid fa-school"></i>
          <h3>Kindergarten</h3>
          <p>Fun foundational learning.</p>
        </div>

        <div class="card">
          <i class="fa-solid fa-book"></i>
          <h3>Primary</h3>
          <p>Strong academic growth.</p>
        </div>

        <div class="card">
          <i class="fa-solid fa-graduation-cap"></i>
          <h3>JHS 1 - 3</h3>
          <p>Preparing future leaders.</p>
        </div>
      </div>
    </div>
  </section>
  
  <section class="gallery section" id="gallery">
    <div class="container">
      <div class="section-title">
        <h2>School Gallery</h2>
      </div>

      <div class="gallery-grid">
        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1470&auto=format&fit=crop" alt="Students in classroom setup">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1470&auto=format&fit=crop" alt="Graduation configuration items">
        <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?q=80&w=1470&auto=format&fit=crop" alt="Student studying records">
      </div>
    </div>
  </section>

  <section class="admission section" id="admission">
    <div class="container">
      <div class="section-title">
        <h2>Admissions</h2>
      </div>
      
      <form class="admission-form" action="index.php" method="POST">
        <p>
          <label for="student-name">Student Name</label>
          <input type="text" id="student-name" name="student_name" placeholder="Student Name" required>
        </p>
        
        <p>
          <label for="student-age">Student Age</label>
          <input type="number" id="student-age" name="student_age" placeholder="Student Age">
        </p>
        
        <p>
          <label for="class-selection">Select Class</label>
          <select id="class-selection" name="class_selection" required>
            <option value="">Select Class</option>
            <option value="creche">Creche</option>
            <option value="kindergarten">Kindergarten</option>
            <option value="primary">Primary</option>
            <option value="jhs">JHS</option>
          </select>
        </p>
       
        <p>
          <label for="oldschoolname">Old School Name</label>
          <input type="text" id="oldschoolname" name="old_school_name" placeholder="Enter your old school name here">
        </p>
        
        <p>
          <label for="parentname">Parent Name</label>
          <input type="text" id="parentname" name="parent_name" placeholder="Parent Name" required>
        </p>
          
        <p>
          <label for="parent-type">Relationship:</label>
          <select id="parent-type" name="relationship" required>
            <option value="mother">Mother</option>
            <option value="father">Father</option>
            <option value="guardian">Legal Guardian</option>
            <option value="other">Other</option>
          </select>
        </p>

        <p>
          <label for="parentemail">Parent Email</label>
          <input type="email" id="parentemail" name="parent_email" placeholder="Parent Email" required>
        </p>
       
        <p>
          <label for="message">Write Message</label>
          <textarea id="message" name="message" placeholder="Write here..."></textarea>
        </p>
      
        <button type="submit" class="btn">Submit Application</button>
      </form>
    </div>
  </section>

  <section class="contact section" id="contact">
    <div class="container">
      <div class="section-title">
        <h2>Contact Us</h2>
      </div>

      <div class="contact-content">
        <div class="contact-info">
          <p>
            <i class="fa-solid fa-location-dot"></i>
            Hatorgodo | Korpegah, Ghana
          </p>
          <p>
            <i class="fa-solid fa-phone"></i>
            +233 ---+++++++++++
          </p>
          <p>
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:philipalor10@gmail.com" class="contact-email-link">philipalor10@gmail.com</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <h2>Divine Star Academy</h2>
          <p>Excellence • Discipline • Success</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2026 Divine Star Academy. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
