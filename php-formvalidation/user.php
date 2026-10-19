
<?php
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
$user = $_SESSION['user_data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>User</title>
</head>
<body>
    <div>
        <h2>User</h2>
        <p><strong>Name:</strong> <?php echo $user->name; ?></p>
        <p><strong>Email:</strong> <?php echo $user->email; ?></p>
        <p><strong>Mobile:</strong> <?php echo $user->mobile; ?></p>
        <p><strong>Governorate:</strong> <?php echo $user->governorate; ?></p>
        <p><strong>Track:</strong> <?php echo $user->track; ?></p>
        <p><strong>Skills:</strong> <?php echo implode(", ", $user->skills); ?></p>
    </div>
</body>
</html>
