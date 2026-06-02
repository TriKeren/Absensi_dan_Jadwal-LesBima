<?php
session_start();
require_once __DIR__ . '/connection/koneksi.php';


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "
        SELECT *
        FROM murid
        WHERE username='$username'
        AND password='$password'
    ");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $_SESSION['id_murid'] = $data['id_murid'];
        $_SESSION['nama_murid'] = $data['nama_murid'];

        header("Location: ./pages/murid/dashboard.php");
        exit;
    } else {

        echo "<script>
                alert('Username atau Password salah!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Murid</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4b398a, #0d132b);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-login {
            background: #d9d9d9;
            border-radius: 10px;
            padding: 50px;
            width: 100%;
            max-width: 600px;
        }

        .btn-login {
            background: #101c44;
            color: white;
        }
    </style>
</head>

<body>

    <div class="card card-login shadow">

        <h2 class="text-center fw-bold mb-5">
            Login Murid
        </h2>

        <form method="POST">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">
                    Username
                </label>

                <div class="col-sm-9">
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        required>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">
                    Password
                </label>

                <div class="col-sm-9">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>
                </div>
            </div>

            <div class="text-center">
                <button
                    type="submit"
                    name="login"
                    class="btn btn-login px-5">

                    Login
                </button>
            </div>

        </form>

    </div>

</body>

</html>