<?php
// Define variables and set to empty values
$nameErr = $emailErr = $messageErr = "";
$name = $email = $message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if the email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    // If all fields are filled out, send the email
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $to = "contact@teknocyte.com"; // Replace with your email address
        $subject = "Contact Form Submission";
        $headers = "From: $email" . "\r\n" .
            "Reply-To: $email" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        // Compose the email message
        $email_message = "Name: $name\n\n";
        $email_message .= "Email: $email\n\n";
        $email_message .= "Message:\n$message";

        // Send the email
        mail($to, $subject, $email_message, $headers);

        // Optionally, you can redirect the user to a thank you page
        header("Location: thank_you.php");
        exit();
    }
}

// Function to sanitize and validate input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>

<h2>Contact Form</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    Email: <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $emailErr; ?></span>
    <br><br>
    Message: <textarea name="message" rows="5" cols="40"><?php echo $message; ?></textarea>
    <span class="error">* <?php echo $messageErr; ?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>