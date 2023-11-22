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
        $to = "mike.browning2000@gmail.com"; // Replace with your email address
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
        header("Location: ./index.html");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teknocyte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <nav class="main-nav navbar fixed-top bg-dark border-body navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./img/logo.svg" alt="Teknocyte Logo" width="150px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="./index.html/#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.html/#about">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.html/#services">Web Design and Development</a></li>
            <li><a class="dropdown-item" href="index.html/#services">Device Repair</a></li>
            <li><a class="dropdown-item" href="index.html/#services">Custom PC Builds</a></li>
            <!-- <li><a class="dropdown-item" href="#">Coming Soon</a></li> -->
            <!-- <li><a class="dropdown-item" href="#"></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"></a></li> -->
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                  </svg>
            </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<section id="contact" class="py-5">
  <div class="container py-5">

    

<form class="form-control form-outline-teal bg-dark text-white mx-auto d-block" style="width: 25rem"method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
    <h2 class="display-6 text-white text-center">Contact US</h2>
    <p><span class="error">* required field</span></p>
    
    <label for="formNameInput" class="form-label">Name<span class="error">* <?php echo $nameErr; ?></span>
    </label>
    <input id="formNameInput" class="form-control form-outline-teal" type="text" name="name" value="<?php echo $name; ?>">
    
    
    <label for="formEmailInput" class="form-label">Email<span class="error">* <?php echo $emailErr; ?></span></label>
    <input id="formEmailInput" class="form-control form-outline-teal" type="email" name="email" value="<?php echo $email; ?>">
    
    
    <label for="formMessageInput" class="form-label">Message<span class="error">* <?php echo $messageErr; ?></span></label>
    <textarea id="formMessageInput" class="form-control form-outline-teal" name="message" rows="5" cols="40"><?php echo $message; ?></textarea>
    
    
    <div class="mt-3 d-grid gap-2">
        <input class="btn btn-teal" type="submit" name="submit" value="Submit">
    </div>
    
</form>

  </div>
</section>

<footer class=" contianer text-center text-white bg-dark p-5">
  <p>Copyright 2023 Teknocyte </p>

</footer>  


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

</body>
</html>