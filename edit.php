<?php
session_start();

include("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Change Profile</title>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Home</a></p>
        </div>

        <div class="right-links">
            <!-- <a href="#">Change Profile</a> -->
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $id = $_SESSION['id'];
                if ($_FILES["file"]["size"] != 0) {
                    // rename the image before saving to database
                    $original_name = $_FILES["file"]["name"];
                    $file = uniqid() . time() . "." . pathinfo($original_name, PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $file);
                    // remove the old image from uploads directory
                    unlink("uploads/" . $_POST["file_old"]);
                } else {
                    $file = mysqli_real_escape_string($con, $_POST["file_old"]);
                }
                $edit_query = mysqli_query($con, "UPDATE users SET name='$name', email='$email', file='$file' WHERE id=$id ") or die("error occurred");

                if ($edit_query) {
                    echo "<div class='suc-message'>
                        <p>Profile Updated!</p>
                    </div> <br>";
                    echo "<a href='home.php'><button class='btn'>Go Home</button>";
                }
            } else {

                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM users WHERE id=$id ");

                while ($result = mysqli_fetch_assoc($query)) {
                    $res_Name = $result['name'];
                    $res_Email = $result['email'];
                    $res_File = $result['file'];
                }

            ?>
                <header>Update Profile</header>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?php echo $res_Name; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                    <label for="file">Image</label>
                        <input type="hidden" name="file_old" id="file_old" value="<?php echo $res_File; ?>">
                        <input type="file" name="file" accept="image/*" autocomplete="off">
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Update" required>
                    </div>

                </form>
        </div>
    <?php } ?>
    </div>
</body>

</html>