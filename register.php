<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php

            include("php/config.php");
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                //verifying the unique email

                $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='err-message'>
                        <p>This email is used, Try another One Please!</p>
                    </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    if (!empty($_POST["name"]) && !empty($_POST["email"]) && $_FILES["file"]["size"] != 0) {
                    // rename the file before saving to database
                    $original_name = $_FILES["file"]["name"];
                    $file = uniqid() . time() . "." . pathinfo($original_name, PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $file);

                    mysqli_query($con, "INSERT INTO users(name,email,password,file) VALUES('$name','$email','$password','$file')") or die("Erroe Occured");

                    echo "<div class='suc-message'>
                      <p>Registration successfully!</p>
                  </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button>";
                    } else {
                        echo "";
                    }
                }
            } else {

            ?>

                <header>Sign Up</header>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="file">Image</label>
                        <input type="file" name="file" accept="image/*" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already a member? <a href="index.php">Sign In</a>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>
</body>

</html>