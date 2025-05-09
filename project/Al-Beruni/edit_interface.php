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

// Check if section is specified
if (!isset($_GET['section'])) {
    echo "No section specified";
    exit();
}

$section_name = $_GET['section'];

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

$content = getContent($conn, $section_name);

if (!$content) {
    echo "Content not found";
    exit();
}

// Get content history
$history = getContentHistory($conn, $content['id']);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content - <?php echo htmlspecialchars($content['content_title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f0f0f0;
            --text-color: #333;
            --card-bg: #ffffff;
        }
        
        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .card {
            background-color: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        h1, h2 {
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        textarea {
            width: 95%;
            height: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            resize: none;

        }
        
        .btn {
             background-color: var(--primary-color);
            color: white;
            border: none;
             padding: 10px 20px;
             border-radius: 25px;
             cursor: pointer;
             transition: var(--transition);
                          text-decoration::none;

        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary {
            background-color: #95a5a6;
        }
        
        .history-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 10px;
            margin-bottom: 15px;
        }
        
        .history-date {
            color: #7f8c8d;
            font-size: 12px;
        }
        
        .history-text {
            margin-top: 5px;
            font-size: 14px;
            white-space: pre-wrap;
            max-height: 100px;
            overflow-y: auto;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
       a:-webkit-any-link {
            text-decoration: none;
       }
        .success-message {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['updated']) && $_GET['updated'] == 'true'): ?>
            <div class="success-message">
                Content updated successfully! The previous version has been saved to history.
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h1>Edit Content</h1>
            <h2><?php echo htmlspecialchars($content['content_title']); ?></h2>
            
            <form action="edit_system.php" method="post">
                <input type="hidden" name="content_id" value="<?php echo $content['id']; ?>">
                
                <div class="form-group">
                    <label for="content_text">Content:</label>
                    <textarea name="content_text" id="content_text" rows="10" cols="30" required><?php echo htmlspecialchars($content['content_text']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="update_content" class="btn">Save Changes</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
        
        <?php if (!empty($history)): ?>
            <div class="card">
                <h2>Content History</h2>
                
                <?php foreach ($history as $item): ?>
                    <div class="history-item">
                        <div class="history-date">
                            <?php echo date('F j, Y, g:i a', strtotime($item['updated_at'])); ?>
                        </div>
                        <div class="history-text"><?php echo htmlspecialchars($item['content_text']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>