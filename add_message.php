<?php
include "config.php";

if(!isset($_SESSION['login'])) exit;

// generate custom ID
$res = $conn->query("SELECT COUNT(*) as total FROM messages");
$row = $res->fetch_assoc();

$msg_id = str_pad($row['total'] + 1, 3, "0", STR_PAD_LEFT);

// add message
if(isset($_POST['title'])){

    $profile_id = intval($_POST['profile_id']);

    $title = trim($_POST['title']);
    $body = trim($_POST['body']);

    $start = $_POST['start_date'];
    $expire = $_POST['expire_date'];

    $conn->query("
        INSERT INTO messages
        (msg_id, profile_id, title, body, start_date, expire_date)
        VALUES
        ('$msg_id','$profile_id','$title','$body','$start','$expire')
    ");

    $success = "Message Saved ID: $msg_id";
}

// delete message
if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);

    $conn->query("DELETE FROM messages WHERE id=$id");

    header("Location: add_message.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Message</title>

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

        input,
        textarea,
        select{
            width:300px;
            padding:10px;
            margin-bottom:10px;
            border:none;
            border-radius:5px;
        }

        textarea{
            height:100px;
            resize:none;
        }

        button{
            padding:10px 20px;
            background:#00c3ff;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .success{
            color:lime;
        }

        .message{
            background:#1c2333;
            padding:15px;
            margin-top:10px;
            border-radius:10px;
        }

        .top{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .top img{
            width:50px;
            height:50px;
            border-radius:50%;
            object-fit:cover;
        }

        .title{
            font-size:18px;
            font-weight:bold;
        }

        .meta{
            color:#00c3ff;
            font-size:12px;
        }

        .delete{
            color:red;
            text-decoration:none;
            float:right;
        }

    </style>
</head>

<body>

<h2>📩 Add Message</h2>

<?php
if(isset($success)){
    echo "<p class='success'>$success</p>";
}
?>

<form method="POST">

<select name="profile_id" required>

<?php

$p = $conn->query("SELECT * FROM profiles ORDER BY id DESC");

while($r = $p->fetch_assoc()){

    echo "<option value='{$r['id']}'>{$r['name']}</option>";
}

?>

</select>
<br>

<input type="text"
       name="title"
       placeholder="Message Title"
       required>

<br>

<textarea name="body"
          placeholder="Write message..."
          required></textarea>

<br>

<label>Start Date</label>
<br>

<input type="date"
       name="start_date"
       required>

<br>

<label>Expire Date</label>
<br>

<input type="date"
       name="expire_date"
       required>

<br>

<button type="submit">Send Message</button>

</form>

<hr>

<h2>📋 All Messages</h2>

<?php

$result = $conn->query("
SELECT m.*, p.name, p.photo
FROM messages m
JOIN profiles p ON m.profile_id = p.id
ORDER BY m.id DESC
");

while($row = $result->fetch_assoc()){

?>

<div class="message">

    <a class="delete"
       href="?delete=<?php echo $row['id']; ?>"
       onclick="return confirm('Delete this message?')">
       Delete
    </a>

    <div class="top">

        <img src="uploads/<?php echo $row['photo']; ?>">

        <div>
            <div class="title">
                <?php echo $row['title']; ?>
            </div>

            <div class="meta">
                ID: <?php echo $row['msg_id']; ?>
            </div>

            <div class="meta">
                From: <?php echo $row['name']; ?>
            </div>
        </div>

    </div>

    <p>
        <?php echo nl2br($row['body']); ?>
    </p>

    <div class="meta">
        Start: <?php echo $row['start_date']; ?>
    </div>

    <div class="meta">
        Expire: <?php echo $row['expire_date']; ?>
    </div>

</div>

<?php } ?>

</body>
</html>