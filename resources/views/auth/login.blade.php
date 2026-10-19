<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NIRVANA BENGKEL</title>
    <!-- Bootstrap 5 CSS & FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #0b192c;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: #112136;
            border: 1px solid #1e324d;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            padding: 40px 30px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: #ff5722;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            box-shadow: 0 4px 15px rgba(255, 87, 34, 0.4);
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 5px;
        }

        .brand-subtitle {
            font-size: 13px;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            background-color: #0b192c;
            border: 1px solid #233854;
            color: #ffffff;
            border-radius: 10px;
            padding: 12px 15px 12px 45px;
        }

        .form-control:focus {
            background-color: #0b192c;
            border-color: #ff5722;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(255, 87, 34, 0.25);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }

        .btn-primary-custom {
            background-color: #ff5722;
            border: none;
            color: #ffffff;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #e64a19;
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            color: #fca5a5;
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo Bengkel -->
        <div class="brand-logo">
            <i class="fa-solid fa-wrench fa-2x text-white"></i>
        </div>
        <div class="brand-title">NIRVANA BENGKEL</div>
        <div class="brand-subtitle">Silakan masuk untuk mengelola sistem</div>

        <!-- Pesan Error Login Validasi (Sesuai Flowchart)[cite: 1] -->
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <!-- Input Username -->
            <div class="input-group-custom">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>

            <!-- Input Password -->
            <div class="input-group-custom">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary-custom mt-2">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk
            </button>
        </form>
    </div>

</body>
</html>