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
            align-items: center;
            justify-content: center;
        }
        .card-login {
            background-color: #d9d9d9;
            border-radius: 5px;
            padding: 50px;
            width: 100%;
            max-width: 600px;
        }
        input.form-control { background-color: #d9d9d9; border: 1px solid #999; }
        .btn-login { background-color: #101c44; color: white; }
    </style>
</head>
<body>
    <div class="card card-login shadow-lg">
        <h2 class="text-center fw-bold mb-5">Login Murid</h2>
        <form>
            <div class="row mb-3 align-items-center">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-4 align-items-center">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control">
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-login btn-lg px-5">Login</button>
            </div>
        </form>
    </div>
</body>
</html>