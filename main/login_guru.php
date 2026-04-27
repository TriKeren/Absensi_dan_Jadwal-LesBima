<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4b398a, #0d132b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-login {
            background-color: #d9d9d9;
            border-radius: 8px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        input.form-control {
            background-color: #f5f5f5;
            border: 1px solid #999;
        }

        /* Tombol utama */
        .btn-login {
            background: linear-gradient(135deg, #101c44, #1f2f6b);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1f2f6b, #2d3f8f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            color: white;
        }

        /* Responsive form */
        @media (max-width: 576px) {
            .card-login {
                padding: 20px;
            }

            .row {
                flex-direction: column;
            }

            .col-sm-3, .col-sm-9 {
                width: 100%;
            }

            label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="card card-login shadow-lg">
        <h2 class="text-center fw-bold mb-4">Login Guru</h2>

        <form>
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-login w-100 py-2">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
</html>