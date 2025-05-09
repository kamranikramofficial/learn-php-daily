<?php
// Database connection
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

// Create tables if they don't exist
function createTables($conn) {
    // Content table
    $sql = "CREATE TABLE IF NOT EXISTS content (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        section_name VARCHAR(50) NOT NULL,
        content_title VARCHAR(255),
        content_text TEXT NOT NULL,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        echo "Error creating content table: " . $conn->error;
    }
    
    // Content history table
    $sql = "CREATE TABLE IF NOT EXISTS content_history (
        history_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        content_id INT(6) UNSIGNED NOT NULL,
        section_name VARCHAR(50) NOT NULL,
        content_title VARCHAR(255),
        content_text TEXT NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (content_id) REFERENCES content(id)
    )";
    
    if (!$conn->query($sql)) {
        echo "Error creating content_history table: " . $conn->error;
    }
}

// Initialize tables
createTables($conn);

// Insert initial content if not exists
function initializeContent($conn) {
    // Check if content exists
    $result = $conn->query("SELECT COUNT(*) as count FROM content");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Insert sample content
        $initialContent = [
            ['about', 'About Me', "Hello! I'm Kamran, a student of Class 10 at Alberuni Education System 📚. My father's name is Muhammad Ikram 👨‍👧. I'm excited to share that I recently programmed an ESP8266 🌐 and turned it into a Wi-Fi jammer ⚡. It was an incredible experience to work on such an innovative project 💡, and I'm proud of how much I learned from it! 🚀"],
            ['school', 'My School', "Alberuni Education System is a place where education meets excellence ✨. The learning experience here is beyond compare, offering a vibrant and inspiring environment 📚. Our school is equipped with a rich variety of resources, including a well-stocked library 📖, a state-of-the-art computer lab 💻, a fully functional biology lab 🧬, and a technical lab 🛠️ that sparks curiosity and innovation. Every corner of the school encourages creativity and knowledge 💡. What truly sets us apart is the incredible talent of our teachers 👩‍🏫👨‍🏫, who are not just educators, but passionate mentors. Their dedication and expertise make learning a truly enriching experience 🌟, helping students reach their fullest potential 🌱."],
            ['teacher_tabish', 'Sir Tabish - Computer teacher', "My favorite teacher is Sir Tabish, my amazing computer teacher! 💻 He is incredibly intelligent 🧠 and always motivates me to dive deeper into the world of programming. His lessons are so engaging, and he makes complex topics seem so easy to understand 🌟. Sir Tabish inspires me every day to push my limits and keep learning 💡. Thanks to him, I'm more passionate about programming than ever before! 🚀"],
            ['teacher_atta', 'Sir Atta - Biology teacher', "Sir Atta is an incredible teacher of biology 🌿🧬! He is not only extremely talented 🧠 but also passionate about making learning exciting and fun. His enthusiasm for the subject is contagious, and he always motivates us to explore and understand the wonders of life 🌱. What makes him truly special is how he gives us the opportunity to present our projects 📊, allowing us to showcase our creativity and knowledge. Thanks to Sir Atta"],
            ['project', 'My ESP8266 Project: IoT Weather Station', "The ESP8266 is a powerful, low-cost Wi-Fi module that allows you to connect your projects to the internet 🌐. It's a small but mighty chip that enables seamless communication between devices and the internet, making it perfect for IoT (Internet of Things) applications 💡. With its easy-to-use features and vast community support, the ESP8266 has become a go-to choice for makers and engineers 👩‍💻👨‍💻.\n\nI used the ESP8266 to create a Wi-Fi jammer 🚫📶, a device that disrupts or blocks Wi-Fi signals in a specific area. This jammer can be useful in scenarios where you need to prevent unauthorized access to a network or enhance privacy 🔐."]
        ];
        
        $stmt = $conn->prepare("INSERT INTO content (section_name, content_title, content_text) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $section_name, $content_title, $content_text);
        
        foreach ($initialContent as $content) {
            $section_name = $content[0];
            $content_title = $content[1];
            $content_text = $content[2];
            $stmt->execute();
        }
        
        $stmt->close();
    }
}

// Initialize content
initializeContent($conn);

// Handle form submission for updating content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_content'])) {
    $content_id = $_POST['content_id'];
    $content_text = $_POST['content_text'];
    
    // First, get the current content to store in history
    $stmt = $conn->prepare("SELECT * FROM content WHERE id = ?");
    $stmt->bind_param("i", $content_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Store the current version in history
        $history_stmt = $conn->prepare("INSERT INTO content_history (content_id, section_name, content_title, content_text) VALUES (?, ?, ?, ?)");
        $history_stmt->bind_param("isss", $row['id'], $row['section_name'], $row['content_title'], $row['content_text']);
        $history_stmt->execute();
        $history_stmt->close();
        
        // Update the content with new version
        $update_stmt = $conn->prepare("UPDATE content SET content_text = ? WHERE id = ?");
        $update_stmt->bind_param("si", $content_text, $content_id);
        $update_stmt->execute();
        $update_stmt->close();
        
        // FIXED: Direct redirect to index.php
        header("Location: index.php?updated=true");
        exit();
    }
    
    $stmt->close();
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

// Get content history for a specific content
function getContentHistory($conn, $content_id) {
    $stmt = $conn->prepare("SELECT * FROM content_history WHERE content_id = ? ORDER BY updated_at DESC");
    $stmt->bind_param("i", $content_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    $stmt->close();
    return $history;
}

// If this file is included, don't close the connection
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    $conn->close();
}
?>