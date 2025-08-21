<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Validacion de registro de usuario
include('../../config/db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = trim($_POST['nombre']);
    $email = trim(strtolower($_POST['email'])); // Normalizar email
    $password = $_POST['password'];
    $rol = 'reportero'; // por defecto según la tabla
    
    // Validaciones adicionales del servidor
    if(strlen($nombre) < 2 || strlen($nombre) > 100) {
        $error = "El nombre debe tener entre 2 y 100 caracteres";
    } elseif(strlen($email) > 150) {
        $error = "El email es demasiado largo";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido";
    } elseif(strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
    } else {
        // Verificar si el email ya existe
        try {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if($stmt->rowCount() > 0){
                $error = "El email ya está registrado";
            } else {
                // Hash de la contraseña
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar nuevo usuario
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña, rol) VALUES (?, ?, ?, ?)");



                if($stmt->execute([$nombre, $email, $password_hash, $rol])){
                    // Redirigir al login con un mensaje
                    header("Location: ./login.php");
                    exit();
                }
                

                
                if($stmt->execute([$nombre, $email, $password_hash, $rol])){
                    $success = "Usuario registrado con éxito";
                } else {
                    $error = "Error al registrar el usuario";
                }

            }
        } catch(PDOException $e) {
            $error = "Error de base de datos: " . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../public/css/stylelog.css">
</head>
<body>
    <div class="form-container">
        <h1>Crear Cuenta</h1>
        
        <?php if(isset($error)): ?>
            <div class="error-message server-message" style="display: block; margin-bottom: 15px; padding: 10px; background-color: #fee; border: 1px solid #fcc; color: #c33; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="success-message server-message" style="display: block; margin-bottom: 15px; padding: 10px; background-color: #efe; border: 1px solid #cfc; color: #3c3; border-radius: 4px;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form id="registrationForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       required 
                       minlength="2" 
                       maxlength="100"
                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                <div class="error-message" id="nombreError"></div>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required 
                       maxlength="150"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required minlength="8" maxlength="255">
                <div class="error-message" id="passwordError"></div>
                <div class="password-requirements">
                    <div class="requirement" id="length">Al menos 8 caracteres</div>
                    <div class="requirement" id="lowercase">Una letra minúscula</div>
                    <div class="requirement" id="uppercase">Una letra mayúscula</div>
                    <div class="requirement" id="number">Un número</div>
                    <div class="requirement" id="special">Un carácter especial</div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirmar contraseña</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8">
                <div class="error-message" id="confirmPasswordError"></div>
            </div>

            <div class="form-group">
                <label for="rol">Rol (opcional)</label>
                <select id="rol" name="rol" class="select-input">
                    <?php
                    // Obtener los valores ENUM de la columna rol
                    try {
                        $stmt = $conn->prepare("SHOW COLUMNS FROM usuarios LIKE 'rol'");
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if($row) {
                            // Extraer los valores del ENUM
                            preg_match_all("/'([^']+)'/", $row['Type'], $matches);
                            $roles = $matches[1];
                            
                            foreach($roles as $rol_option) {
                                $selected = ($rol_option === 'reportero') ? 'selected' : '';
                                $rol_display = ucfirst($rol_option);
                                
                                // Mostrar todas las opciones si es admin, solo reportero y usuario si no
                                if(!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
                                    if(in_array($rol_option, ['reportero', 'validador'])) {
                                        echo "<option value='{$rol_option}' {$selected}>{$rol_display}</option>";
                                    }
                                } else {
                                    echo "<option value='{$rol_option}' {$selected}>{$rol_display}</option>";
                                }
                            }
                        }
                    } catch(PDOException $e) {
                        // Fallback en caso de error
                        echo "<option value='reportero' selected>Reportero</option>";
                    }
                    ?>
                </select>
                <div class="error-message" id="rolError"></div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Registrarse</button>
        </form>

        <div class="success-message" id="successMessage" style="display: none;">
            ¡Registro exitoso! Bienvenido a nuestra plataforma.
        </div>
    </div>

    <!-- <script src="/public/js/scriptlog.js"></script> -->
</body>
</html>