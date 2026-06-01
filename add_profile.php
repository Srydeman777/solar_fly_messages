<?php
include "config.php";

if(!isset($_SESSION['login'])) exit;

// create uploads folder automatically
if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}

// add profile
if(isset($_POST['name'])){

    $name = trim($_POST['name']);

    $photo = "";

    if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ""){

        $photo = time() . "_" . basename($_FILES['photo']['name']);
        $tmp = $_FILES['photo']['tmp_name'];

        move_uploaded_file($tmp, "uploads/".$photo);
    }

    $conn->query("
        INSERT INTO profiles(name,photo)
        VALUES('$name','$photo')
    ");

    $success = "Profile Added";
}

// delete profile
if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);

    // get photo
    $res = $conn->query("SELECT photo FROM profiles WHERE id=$id");
    $row = $res->fetch_assoc();

    if($row){

        $file = "uploads/".$row['photo'];

        if(file_exists($file)){
            unlink($file);
        }
    }

    // delete profile
    $conn->query("DELETE FROM profiles WHERE id=$id");

    header("Location: add_profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>

    <style>

        body{
            background:#0b0f1a;
            color:white;
            font-family:Arial;
            padding:20px;
        }

        h2{
            color:#00c3ff;
        }

        input{
            padding:10px;
            width:250px;
            margin-bottom:10px;
        }

        button{
            padding:10px 20px;
            background:#00c3ff;
            border:none;
            color:white;
            cursor:pointer;
            border-radius:5px;
        }

        .profile{
            background:#1c2333;
            padding:10px;
            margin-top:10px;
            border-radius:10px;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .profile img{
            width:50px;
            height:50px;
            border-radius:50%;
            object-fit:cover;
        }

        .delete{
            margin-left:auto;
            color:red;
            text-decoration:none;
        }

        .success{
            color:lime;
        }

    </style>
</head>

<body>

<h2>👤 Add Profile</h2>

<?php
if(isset($success)){
    echo "<p class='success'>$success</p>";
}
?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Profile Name" required>
    <br>

    <input type="file" name="photo" required>
    <br>

    <button type="submit">Save Profile</button>

</form>

<hr>

<h2>📋 All Profiles</h2>

<?php

$result = $conn->query("SELECT * FROM profiles ORDER BY id DESC");

while($row = $result->fetch_assoc()){

?>

<div class="profile">

    <img src="uploads/<?php echo $row['photo']; ?>">

    <div>
        <b><?php echo $row['name']; ?></b>
        <br>
        ID: <?php echo $row['id']; ?>
    </div>

    <a class="delete"
       href="?delete=<?php echo $row['id']; ?>"
       onclick="return confirm('Delete this profile?')">
       Delete
    </a>

</div>

<?php } ?>

</body>
</html>