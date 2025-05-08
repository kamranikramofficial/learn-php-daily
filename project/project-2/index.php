<!DOCTYPE HTML>  
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Form Validation Example</title>
  <style>
    /* Basic reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Set background color and center content */
    .main-content {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      color: #333;
    }

  


    /* Styling the form */
    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 400px;
      transition: transform 0.3s ease-in-out;
    }

    form:hover {
      transform: translateY(-10px); /* Hover effect */
    }

    /* Input Fields Styling */
    input[type="text"], textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus, textarea:focus {
      border-color: #4caf50;
      outline: none;
      box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
    }

    /* Radio Button Styling */
    input[type="radio"] {
      margin: 10px 5px;
    }

    /* Submit Button Styling */
    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 20px;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    /* Label Styling */
    label {
      font-size: 16px;
      margin: px 0;
      display: block;
      color: #555;
    }

    /* Section Styling */
    .section2 {
      background-color: #ffffff;
      padding: 20px;
      margin-top: 30px;
      width: 400px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      font-family: 'Arial', sans-serif;
      color: #333;
      
      animation: fadeIn 0.5s ease-out;
    }

    /* Fade-In Animation */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Section Heading Styling */
    .section2 h2 {
      font-size: 24px;
      color: #4caf50;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Paragraph Styling */
    .section2 p {
      font-size: 16px;
      margin: 8px 0;
      padding: 8px;
      background-color: #f9f9f9;
      border-left: 4px solid #4caf50;
      border-radius: 5px;
      box-sizing: border-box;
      transition: background-color 0.3s ease;
    }
    .margin-t{
        margin-top:-20rem;
    }
    /* Hover effect on each paragraph */
    .section2 p:hover {
      background-color: #e8f5e9;
    }

    /* Responsive Design for smaller screens */
    @media (max-width: 500px) {
      form, section {
        width: 90%;
      }

      h2 {
        font-size: 24px;
      }

      input[type="text"], textarea {
        font-size: 14px;
        padding: 10px;
      }

      input[type="submit"] {
        font-size: 14px;
        padding: 10px;
      }
    }

  </style>
</head>
<body>  

<?php
$name = $email = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $comment = test_input($_POST["comment"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<section class="main-content">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <label for="name">Name:</label>
  <input type="text" name="name" id="name" required>

  <label for="email">E-mail:</label>
  <input type="text" name="email" id="email" required>

  <label for="website">Website:</label>
  <input type="text" name="website" id="website">

  <label for="comment" required>Comment:</label>
  <textarea name="comment" id="comment" rows="5" cols="40"></textarea>


  <input type="submit" name="submit" value="Submit">  
</form>
</section>
<section class="main-content margin-t">
<section class="section2">
  <?php
    echo "<h2>Your Input:</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Website:</strong> $website</p>";
    echo "<p><strong>Comment:</strong> $comment</p>";
  ?>
</section>
</section>

</body>
</html>
