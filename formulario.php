<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale =1.0">
    <style>
        .error {
        color: red;
        }
        .success {
        color: green;
        }
        label {
        display: block;
        margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], textarea {
        width: 300px;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }
        button {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        }
    </style>

</head>
<body>
    <?php
// Define variables to hold form data and error messages
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";
$submissionSuccess = false;

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate Name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $isValid = false;
    } else {
        $name = sanitizeInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
            $isValid = false;
        }
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } else {
        $email = sanitizeInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $isValid = false;
        }
    }

    // Validate Message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
        $isValid = false;
    } else {
        $message = sanitizeInput($_POST["message"]);
    }

    // If all validations pass, process the data
    if ($isValid) {
        $submissionSuccess = true;
        // In a real application, you would save this data to a database or send an email.
        // $name = $email = $message = ""; // We don't clear here to display the data
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name;?>" required>
    <span class="error"><?php echo $nameErr;?></span>
    <br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $email;?>" required>
    <span class="error"><?php echo $emailErr;?></span>
    <br><br>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required><?php echo $message;?></textarea>
    <span class="error"><?php echo $messageErr;?></span>
    <br><br>

    <button type="submit">Submit</button>
</form>

<?php if ($submissionSuccess): ?>
    <div class="submission-template">
        <p><strong>Welcome <?php echo htmlspecialchars($name); ?>!</strong></p>
        <p>This is all the data you submitted:</p>
        <ul>
            <li><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
            <li><strong>Message:</strong> <?php echo htmlspecialchars($message); ?></li>
        </ul>
    </div>
<?php endif; ?>
    <title>Document</title>
</body>
</html>