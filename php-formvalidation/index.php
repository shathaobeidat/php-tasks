
<?php
$name = $_COOKIE['user_name'] ?? '';
$email = '';
$mobile = '';
$track = '';
$skills = [];
$gvr = '';
$agree = '';
$message = '';
  $name = $_COOKIE['user_name'] ?? '';

$errors = [ 'name' => '','mobile' => '','email' => '','track' => '','agree' => '','skills' => '','governorate' => ''];
$successObject = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? '');
    $mobile = trim($_POST["mobile"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $track = trim($_POST["track"] ?? '');
    $agree = isset($_POST["agree"]) ? $_POST["agree"] : '';
    $skills = $_POST["skills"] ?? [];
    $gvr = $_POST["governorate"] ?? '';
    $message = trim($_POST["message"] ?? '');

    if (empty($name)) {
        $errors['name'] = "Name field is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile is required";
    } else if (!preg_match("/^07[789]\d{7}$/", $mobile)) {
        $errors['mobile'] = "Invalid mobile format (e.g., 0791234567)";
    }

    if (empty($gvr)) {
        $errors['governorate'] = "Governorate must be selected";
    }

    if (empty($track)) {
        $errors['track'] = "One option must be selected";
    }

    if (empty($skills)) {
        $errors['skills'] = "At least one skill should be selected";
    }

    if (empty($agree)) {
        $errors['agree'] = "You must accept the terms";
    }

    if (empty(array_filter($errors))) {
        class register {
            public $name, $email, $mobile, $governorate, $track, $skills, $message;
            public function __construct($n, $e, $m, $g, $t, $sk, $msg) {
                $this->name = $n;
                $this->email = $e;
                $this->mobile = $m;
                $this->governorate = $g;
                $this->track = $t;
                $this->skills = $sk;
                $this->message = $msg;
            }
        }
        session_start();
        $successObject = new register(
            $name,
            $email,
            $mobile,
            $gvr,
            $track,
            $skills,
            $message
        );
        $_SESSION['user_data'] = $successObject;
        setcookie("user_name", $name, time() + (86400 * 3), "/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registration Form</title>
</head>
<body>

  <?php if ($successObject): ?>

    <div style="border:2px solid green; border-radius:23px; padding:10px;">
        <h2>Registration Successful</h2>

        <p><strong>Name:</strong> <?php echo $successObject->name; ?></p>
        <p><strong>Email:</strong> <?php echo $successObject->email; ?></p>
        <p><strong>Mobile:</strong> <?php echo $successObject->mobile; ?></p>
        <p><strong>Governorate:</strong> <?php echo $successObject->governorate; ?></p>
        <p><strong>Track:</strong> <?php echo $successObject->track; ?></p>
        <p><strong>Skills:</strong> <?php echo implode(", ", $successObject->skills); ?></p>
        <p><strong>Message:</strong> <?php echo $successObject->message ?: 'No message provided'; ?></p>

        <br>
        <a href="user.php">View Data from Session</a>
    </div>

  <?php else: ?>

    <form action="" method="post">

      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>">
      <span style="color:red;"><?php echo $errors['name'] ?? ''; ?></span>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>">
      <span style="color:red;"><?php echo $errors['email'] ?? ''; ?></span>

      <label for="mobile">Mobile</label>
      <input type="tel" id="mobile" name="mobile" placeholder="0791234567" value="<?php echo $mobile; ?>">
      <span style="color:red;"><?php echo $errors['mobile'] ?? ''; ?></span>

      <label for="governorate">Governorate</label>
      <select id="governorate" name="governorate">
        <option value="">Choose a governorate</option>
        <option value="Amman" <?php if ($gvr == 'Amman') echo 'selected'; ?>>Amman</option>
        <option value="Irbid" <?php if ($gvr == 'Irbid') echo 'selected'; ?>>Irbid</option>
        <option value="Aqaba" <?php if ($gvr == 'Aqaba') echo 'selected'; ?>>Aqaba</option>
        <option value="Zarqa" <?php if ($gvr == 'Zarqa') echo 'selected'; ?>>Zarqa</option>
      </select>
      <span style="color:red;"><?php echo $errors['governorate'] ?? ''; ?></span>

      <label>Track</label>

      <label class="inline">
        <input type="radio" name="track" value="Full Stack" <?php if ($track == 'Full Stack') echo 'checked'; ?>> Full Stack
      </label>

      <label class="inline">
        <input type="radio" name="track" value="Frontend" <?php if ($track == 'Frontend') echo 'checked'; ?>> Frontend
      </label>

      <label class="inline">
        <input type="radio" name="track" value="Backend" <?php if ($track == 'Backend') echo 'checked'; ?>> Backend
      </label>

      <span style="color:red;"><?php echo $errors['track'] ?? ''; ?></span>

      <label>Skills you already have</label>

      <label class="inline">
        <input type="checkbox" name="skills[]" value="HTML" <?php if (in_array('HTML', $skills)) echo 'checked'; ?>> HTML
      </label>

      <label class="inline">
        <input type="checkbox" name="skills[]" value="CSS" <?php if (in_array('CSS', $skills)) echo 'checked'; ?>> CSS
      </label>

      <label class="inline">
        <input type="checkbox" name="skills[]" value="JavaScript" <?php if (in_array('JavaScript', $skills)) echo 'checked'; ?>> JavaScript
      </label>

      <span style="color:red;"><?php echo $errors['skills'] ?? ''; ?></span>

      <label for="message">Why do you want to join? (optional)</label>
      <textarea id="message" name="message" rows="4"><?php echo $message; ?></textarea>

      <label class="inline terms">
        <input type="checkbox" name="agree" <?php if ($agree) echo 'checked'; ?>> I agree to the academy terms
      </label>

      <span style="color:red;"><?php echo $errors['agree'] ?? ''; ?></span>

      <button type="submit">Register</button>

    </form>

  <?php endif; ?>

</body>
</html>
