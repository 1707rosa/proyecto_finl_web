<?php
session_start();
include('../../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        echo "Debes ingresar correo y contraseña";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['contraseña'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: ../../../Views/Mapa/mapa.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../../public/css/login-style.css">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Bienvenido</h1>
            <p>Inicia sesión en tu cuenta</p>
        </div>

        <form id="loginForm" method="post" action="">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required autocomplete="email">
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                    <button type="button" class="toggle-password" id="togglePassword">
                        <span id="eyeIcon">👁️</span>
                    </button>
                </div>
                <div class="error-message" id="passwordError"></div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span class="checkmark"></span>
                    Recordarme
                </label>
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <span id="loginText">Iniciar Sesión</span>
                <div class="loading-spinner" id="loadingSpinner"></div>
            </button>
        </form>

        <div class="divider">
            <span>o continúa con</span>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn google-btn">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Google
            </button>
            <button type="button" class="social-btn facebook-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                Facebook
            </button>
        </div>

        <div class="signup-link">
            ¿No tienes cuenta? <a href="./registro.php">Regístrate aquí</a>

        </div>

        <div class="success-message" id="successMessage">
            ¡Inicio de sesión exitoso! Redirigiendo...
        </div>
    </div>

    <script src="/public/js/login-script.js"></script>
</body>

</html>