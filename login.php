<?php
include "config.php";

if(isset($_POST['password'])){
    if($_POST['password'] == $admin_password){
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Wrong Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Solar Fly Login</title>
</head>
<body>

<h2>Solar Server Login</h2>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="password" name="password" placeholder="Enter Password">
    <button type="submit">Login</button>
</form>

</body>
</html>