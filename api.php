<?php
// 连接MySQL数据库
$servername = ""; // 你的数据库主机名
$username = ""; // 你的数据库用户名
$password = ""; // 你的数据库密码
$dbname = ""; // 你的数据库名

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败");
}

// 允许跨域请求的域名列表
$allowed_origins = [
    "https://wbot.ecylt.top",
    "https://api.ecylt.top"
];

// 检查是否有 Origin 头，并且是你允许的域名
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}

// 准备一个数组来存储消息
$response = array();

// 注册用户
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        $response["message"] = "注册成功，请前往登录";
    } else {
        $response["error"] = "Error";
    }
}

// 用户登录
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // 登录成功，设置cookie
            setcookie('user', $row['username'], time() + 3600, '/', '.ecylt.top'); // 设置域为 .ecylt.top
            $response["message"] = "登录成功，请返回需要登录的页面并刷新";
        } else {
            $response["error"] = "密码错误";
        }
    } else {
        $response["error"] = "用户不存在";
    }
}

// 修改密码
if (isset($_POST['change_password'])) {
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $sql = "SELECT password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($old_password, $row['password'])) {
            // 旧密码验证成功，可以修改密码
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password='$hashed_new_password' WHERE username='$username'";
            if ($conn->query($update_sql) === TRUE) {
                $response["message"] = "密码修改成功";
            } else {
                $response["error"] = "Error";
            }
        } else {
            $response["error"] = "旧密码输入不正确";
        }
    } else {
        $response["error"] = "用户不存在";
    }
}

// 退出登录
if (isset($_POST['logout'])) {
    // 设置过期时间为过去的时间来删除 cookie
    setcookie('user', '', time() - 3600, '/', '.ecylt.top');
    $response["message"] = "已成功退出登录";
}

// 将数组以 JSON 格式输出
header('Content-Type: application/json');
echo json_encode($response);

// 关闭数据库连接
$conn->close();
?>
