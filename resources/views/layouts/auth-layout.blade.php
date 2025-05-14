<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>DTU English Hub</title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        .left-panel, .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .left-panel {
            background-color: #212529;
            color: white;
            text-align: center;
            flex-direction: column
        }

        .left-panel img {
            width: 200px;
        }

        .tagline {
            margin-top: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 340px;
        }

        .right-panel {
            background-color: #ffffff;
        }

        .auth-form {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            border-radius: 10px;
            height: 45px;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .auth-footer a {
            color: #0d6efd;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100%;
                padding: 1.5rem;
            }

            .auth-form {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="left-panel">
            <img src="{{ asset('img/logodtu.svg') }}" alt="DTU Logo">
            <div class="tagline mt-3">
                DTU English Hub – Nền tảng học tiếng Anh<br>
                dành riêng cho DTUer.
            </div>
        </div>  
        <div class="right-panel">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
