<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "alberuni_education";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get content for a specific section
function getContent($conn, $section_name) {
    $stmt = $conn->prepare("SELECT * FROM content WHERE section_name = ?");
    $stmt->bind_param("s", $section_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $content = $result->fetch_assoc();
    $stmt->close();
    return $content;
}

// Get content for each section
$about_content = getContent($conn, 'about');
$school_content = getContent($conn, 'school');
$teacher_tabish_content = getContent($conn, 'teacher_tabish');
$teacher_atta_content = getContent($conn, 'teacher_atta');
$project_content = getContent($conn, 'project');

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Beruni Education System</title>
    <link rel="icon" type="image/x-icon" href="img/schoollog.png">

    <link rel="stylesheet" href="styles.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        .update-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #2ecc71;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: fadeOut 5s forwards;
        }
        
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
    </style>
</head>

<body>
    <?php if (isset($_GET['updated']) && $_GET['updated'] == 'true'): ?>
    <div class="update-notification">
        Content updated successfully!
    </div>
    <?php endif; ?>

    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="img/schoollog.jfif" alt="Logo" class="logo">
            <h1>Al-Beruni Education System</h1>
        </div>
        <ul class="nav-links">
            <li><a href="#home" class="active"><i class='bx bx-home'></i> <span>Home</span></a></li>
            <li><a href="#about"><i class='bx bx-user'></i> <span>About Me</span></a></li>
            <li><a href="#school"><i class='bx bx-building-house'></i> <span>My School</span></a></li>
            <li><a href="#teachers"><i class='bx bx-chalkboard-teacher'></i> <span>My Teachers</span></a></li>
            <li><a href="#project"><i class='bx bx-microchip'></i> <span>My Project</span></a></li>
        </ul>
        <div class="theme-switcher">
            <i class='bx bx-palette'></i>
            <span class="m-b">Change Theme</span>
        </div>
        <div class="copy">
            <p>&copy; 2025 kamranikram. All rights reserved.</p>
        </div>
    </nav>
    <main class="form">

        <main>
            <section id="home" class="section">
                <div class="hero">
                    <h1>Welcome to My ESP8266 Project Showcase</h1>
                    <p>Explore my journey in IoT and embedded systems development</p>
                    <a href="#project" class="cta-button">View My Project</a>
                </div>
            </section>

            
            <section id="about" class="section">
                <div class="card fade-in">
                    <div class="card-content">
                        <img src="img/my.jpg" alt="My Photo" class="profile-img">
                        <div class="text-content">
                            <h2><?php echo htmlspecialchars($about_content['content_title']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($about_content['content_text'])); ?></p>
                            <a href="edit_interface.php?section=about" class="video-btn">Edit Content</a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="school" class="section">
                <div class="card fade-in">
                    <div class="card-content reverse">
                        <img src="img/school.jpg " alt="School Photo" class="school-img">
                        <div class="text-content">
                            <h2><?php echo htmlspecialchars($school_content['content_title']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($school_content['content_text'])); ?></p>
                            <button class="video-btn" data-video="https://www.youtube.com/embed/Y3lr9Atoz38">School Tour</button>
                            <a href="edit_interface.php?section=school" class="video-btn">Edit Content</a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="teachers" class="section">
                <h2 class="fade-in">My Teachers</h2>
                <div class="teacher-cards fade-in">
                    <div class="card teacher-card">
                        <img src="img/sirt1.jpg" alt="Teacher 1" class="teacher-img">
                        <h3><?php echo htmlspecialchars($teacher_tabish_content['content_title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($teacher_tabish_content['content_text'])); ?></p>
                        <a href="edit_interface.php?section=teacher_tabish" class="video-btn">Edit Content</a>
                    </div>
                    <div class="card teacher-card">
                        <img src="img/sir.jpg" alt="Teacher 2" class="teacher-img">
                        <h3><?php echo htmlspecialchars($teacher_atta_content['content_title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($teacher_atta_content['content_text'])); ?></p>
                        <a href="edit_interface.php?section=teacher_atta" class="video-btn">Edit Content</a>
                    </div>
                </div>
            </section>

            <section id="project" class="section">
                <div class="card project-card fade-in">
                    <div class="card-content">
                        <img src="img/esp.png" alt="Project Photo" class="project-img">
                        <div class="text-content">
                            <h2><?php echo htmlspecialchars($project_content['content_title']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($project_content['content_text'])); ?></p>
                           
                            <a href="edit_interface.php?section=project" class="video-btn">Edit Content</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </main>
    <div id="video-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <iframe width="320" height="300" src="/placeholder.svg" frameborder="0" allow="autoplay; encrypted-media"
                allowfullscreen></iframe>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>