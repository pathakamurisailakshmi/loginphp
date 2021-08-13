<?php
require_once "sql.php";
if (isset($_POST['submit'])) {
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']); 
if (!preg_match("/^[a-zA-Z0-9]{6,12}+$/",$username)) {
$username_error = "Name must contain only alphabets and numbers";
}
if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]$/',$password)) {
$password_error = "Password must contain 6 characters of letters, numbers and 
    at least one special character";
}
elseif(strlen($password) < 6) {
$password_error = "Password must be minimum of 6 characters";
}       

if($password != $cpassword) {
$cpassword_error = "Password and Confirm Password doesn't match";
}
if (!$error) {
if(mysqli_query($conn, "INSERT INTO users(username,password) VALUES('" . $username . "',  '" . md5($password) . "')")) {
header("location: registration.php");
exit();
} else {
echo "Error: " . $sql . "" . mysqli_error($conn);
}
}
mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>
<body>

<h2>Login</h2>

<p>Please fill all fields in the form</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<label>Name</label>
<input type="text" name="username"  value="" maxlength="12" required="">
<span><?php if (isset($username_error)) echo $username_error; ?></span>

<br>
<br>

<label>Password</label>
<input type="password" name="password"  value="" maxlength="8" required="">
<span><?php if (isset($password_error)) echo $password_error; ?></span>
 
<br>
<br>

<label>Confirm Password</label>
<input type="password" name="cpassword"  value="" maxlength="8" required="">
<span><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>

<br>
<br>
<input type="submit"name="login" value="submit">

</form>

</body>
</html>