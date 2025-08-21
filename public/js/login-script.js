// Elementos del DOM
const form = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const loginBtn = document.getElementById('loginBtn');
const loginText = document.getElementById('loginText');
const loadingSpinner = document.getElementById('loadingSpinner');
const togglePassword = document.getElementById('togglePassword');
const eyeIcon = document.getElementById('eyeIcon');
const successMessage = document.getElementById('successMessage');
const signupLink = document.getElementById('signupLink');

// Estado del formulario
let isFormValid = false;

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    validateForm();
});

/**
 * Inicializa todos los event listeners
 */
function initializeEventListeners() {
    // Validación en tiempo real
    emailInput.addEventListener('input', validateEmail);
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('input', validatePassword);
    passwordInput.addEventListener('blur', validatePassword);

    // Mostrar/ocultar contraseña
    togglePassword.addEventListener('click', togglePasswordVisibility);

    // Envío del formulario
    form.addEventListener('submit', handleFormSubmit);

    // Botones sociales
    document.querySelector('.google-btn').addEventListener('click', () => handleSocialLogin('google'));
    document.querySelector('.facebook-btn').addEventListener('click', () => handleSocialLogin('facebook'));

    // Enlace de registro
    signupLink.addEventListener('click', handleSignupClick);

    // Enter en campos para enviar formulario
    emailInput.addEventListener('keypress', handleEnterKey);
    passwordInput.addEventListener('keypress', handleEnterKey);
}

/**
 * Valida el campo de email
 */
function validateEmail() {
    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let isValid = true;
    let errorMessage = '';

    if (email === '') {
        isValid = false;
        errorMessage = 'El correo electrónico es requerido';
    } else if (!emailRegex.test(email)) {
        isValid = false;
        errorMessage = 'Ingresa un correo electrónico válido';
    }

    showFieldError('email', !isValid, errorMessage);
    validateForm();
    return isValid;
}

/**
 * Valida el campo de contraseña
 */
function validatePassword() {
    const password = passwordInput.value;
    let isValid = true;
    let errorMessage = '';

    if (password === '') {
        isValid = false;
        errorMessage = 'La contraseña es requerida';
    } else if (password.length < 6) {
        isValid = false;
        errorMessage = 'La contraseña debe tener al menos 6 caracteres';
    }

    showFieldError('password', !isValid, errorMessage);
    validateForm();
    return isValid;
}

/**
 * Muestra u oculta errores de campo
 * @param {string} fieldName - Nombre del campo
 * @param {boolean} hasError - Si hay error
 * @param {string} message - Mensaje de error
 */
function showFieldError(fieldName, hasError, message) {
    const input = document.getElementById(fieldName);
    const errorElement = document.getElementById(fieldName + 'Error');

    if (hasError) {
        input.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('show');
    } else {
        input.classList.remove('error');
        errorElement.textContent = '';
        errorElement.classList.remove('show');
    }
}

/**
 * Valida todo el formulario
 */
function validateForm() {
    const emailValid = emailInput.value.trim() !== '' && !emailInput.classList.contains('error');
    const passwordValid = passwordInput.value !== '' && !passwordInput.classList.contains('error');
    
    isFormValid = emailValid && passwordValid;
    loginBtn.disabled = !isFormValid;
}

/**
 * Alterna la visibilidad de la contraseña
 */
function togglePasswordVisibility() {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    eyeIcon.textContent = isPassword ? '🙈' : '👁️';
    
    // Mantener el foco en el input
    passwordInput.focus();
}

/**
 * Maneja el envío del formulario
 * @param {Event} e - Evento de envío
 */
async function handleFormSubmit(e) {
    // e.preventDefault();

    // Validar campos una vez más
    const emailValid = validateEmail();
    const passwordValid = validatePassword();

    if (!emailValid || !passwordValid) {
        return;
    }

    // Mostrar estado de carga
    setLoadingState(true);

    try {
        // Simular petición de login
        await simulateLogin();
        
        // Mostrar éxito
        showSuccess();
        
    } catch (error) {
        showFieldError('password', true, 'Credenciales incorrectas. Intenta nuevamente.');
        console.error('Error en el login:', error);
    } finally {
        setLoadingState(false);
    }
}

/**
 * Simula una petición de login al servidor
 * @returns {Promise} - Promesa que resuelve después de un delay
 */
function simulateLogin() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            // Simular diferentes escenarios
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            
            // Credenciales de prueba
            if (email === 'admin@test.com' && password === '123456') {
                resolve({ success: true, user: { email } });
            } else {
                reject(new Error('Credenciales incorrectas'));
            }
        }, 2000); // 2 segundos de delay
    });

    // En un caso real, harías algo como:
    /*
    return fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: emailInput.value.trim(),
            password: passwordInput.value,
            remember: document.getElementById('remember').checked
        })
    }).then(response => {
        if (!response.ok) {
            throw new Error('Login failed');
        }
        return response.json();
    });
    */
}

/**
 * Establece el estado de carga del formulario
 * @param {boolean} loading - Si está cargando
 */
function setLoadingState(loading) {
    loginBtn.disabled = loading;
    
    if (loading) {
        loginBtn.classList.add('loading');
        loginText.textContent = 'Iniciando...';
        loadingSpinner.style.display = 'inline-block';
    } else {
        loginBtn.classList.remove('loading');
        loginText.textContent = 'Iniciar Sesión';
        loadingSpinner.style.display = 'none';
    }
}

/**
 * Muestra el mensaje de éxito y simula redirección
 */
function showSuccess() {
    successMessage.classList.add('show');
    form.style.opacity = '0.6';
    loginBtn.textContent = 'Redirigiendo...';
    
    // Simular redirección después de 2 segundos
    setTimeout(() => {
        console.log('Redirigiendo al dashboard...');
        // window.location.href = '/dashboard';
    }, 2000);
}

/**
 * Maneja el login con redes sociales
 * @param {string} provider - Proveedor social (google, facebook)
 */
function handleSocialLogin(provider) {
    console.log(`Iniciando login con ${provider}`);
    
    // En un caso real, redirigirías a la URL de OAuth
    // window.location.href = `/auth/${provider}`;
    
    // Simular para demo
    alert(`Redirigiendo a ${provider} para autenticación...`);
}

/**
 * Maneja el clic en el enlace de registro
 * @param {Event} e - Evento de clic
 */
function handleSignupClick(e) {
    e.preventDefault();
    console.log('Redirigiendo a registro...');
    // window.location.href = '/register';
    alert('Redirigiendo a la página de registro...');
}

/**
 * Maneja la tecla Enter en los campos
 * @param {KeyboardEvent} e - Evento de teclado
 */
function handleEnterKey(e) {
    if (e.key === 'Enter' && isFormValid) {
        handleFormSubmit(e);
    }
}

/**
 * Funciones de utilidad para almacenamiento local (si es necesario)
 */
const storage = {
    set: (key, value) => localStorage.setItem(key, JSON.stringify(value)),
    get: (key) => {
        try {
            return JSON.parse(localStorage.getItem(key));
        } catch {
            return null;
        }
    },
    remove: (key) => localStorage.removeItem(key)
};

// Recuperar email guardado si existe
document.addEventListener('DOMContentLoaded', () => {
    const rememberedEmail = storage.get('rememberedEmail');
    if (rememberedEmail) {
        emailInput.value = rememberedEmail;
        document.getElementById('remember').checked = true;
        validateEmail();
    }
});