// Elementos del DOM
const form = document.getElementById('registrationForm');
const inputs = form.querySelectorAll('input');
const submitBtn = document.getElementById('submitBtn');
const successMessage = document.getElementById('successMessage');

// Inicializar event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real para todos los campos
    inputs.forEach(input => {
        input.addEventListener('input', () => validateField(input));
        input.addEventListener('blur', () => validateField(input));
    });

    // Manejo del envío del formulario
    form.addEventListener('submit', handleFormSubmit);

    // Inicializar el estado del botón
    updateSubmitButton();
});

/**
 * Valida un campo específico del formulario
 * @param {HTMLInputElement} input - El campo a validar
 */
function validateField(input) {
    const value = input.value.trim();
    const fieldName = input.name;
    let isValid = true;
    let errorMessage = '';

    switch (fieldName) {
        case 'nombre':
            if (value.length < 2) {
                isValid = false;
                errorMessage = 'El nombre debe tener al menos 2 caracteres';
            } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                isValid = false;
                errorMessage = 'El nombre solo puede contener letras y espacios';
            }
            break;

        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Ingresa un correo electrónico válido';
            }
            break;

        case 'password':
            validatePassword(value);
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'La contraseña debe tener al menos 8 caracteres';
            }
            break;

        case 'confirmPassword':
            const password = document.getElementById('password').value;
            if (value !== password) {
                isValid = false;
                errorMessage = 'Las contraseñas no coinciden';
            }
            break;
    }

    showError(input, isValid, errorMessage);
    updateSubmitButton();
}

/**
 * Valida los requisitos de la contraseña
 * @param {string} password - La contraseña a validar
 * @returns {boolean} - Si la contraseña cumple todos los requisitos
 */
function validatePassword(password) {
    const requirements = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };

    // Actualizar los indicadores visuales
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(req);
        if (requirements[req]) {
            element.classList.add('valid');
        } else {
            element.classList.remove('valid');
        }
    });

    return Object.values(requirements).every(req => req);
}

/**
 * Muestra u oculta mensajes de error
 * @param {HTMLInputElement} input - El campo con error
 * @param {boolean} isValid - Si el campo es válido
 * @param {string} message - El mensaje de error
 */
function showError(input, isValid, message) {
    const errorElement = document.getElementById(input.name + 'Error');
    
    if (isValid) {
        input.classList.remove('error');
        errorElement.textContent = '';
        errorElement.classList.remove('show');
    } else {
        input.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
}

/**
 * Actualiza el estado del botón de envío
 */
function updateSubmitButton() {
    const allValid = Array.from(inputs).every(input => {
        return input.value.trim() !== '' && !input.classList.contains('error');
    });

    submitBtn.disabled = !allValid;
}

/**
 * Maneja el envío del formulario
 * @param {Event} e - El evento de envío
 */
function handleFormSubmit(e) {
    // e.preventDefault();
    
    // Validar todos los campos antes del envío
    let allValid = true;
    inputs.forEach(input => {
        validateField(input);
        if (input.classList.contains('error') || input.value.trim() === '') {
            allValid = false;
        }
    });

    if (allValid) {
        // Simular envío exitoso
        showSuccessMessage();
        
        // En un caso real, aquí harías la petición al servidor
        submitFormData();
    }
}

/**
 * Muestra el mensaje de éxito
 */
function showSuccessMessage() {
    successMessage.classList.add('show');
    form.style.opacity = '0.5';
    submitBtn.textContent = 'Registrado';
    submitBtn.disabled = true;
}

/**
 * Simula el envío de datos al servidor
 */
function submitFormData() {
    // Recopilar datos del formulario
    const formData = new FormData(form);
    const userData = Object.fromEntries(formData);
    
    // Eliminar la confirmación de contraseña de los datos
    delete userData.confirmPassword;
    
    console.log('Datos del usuario a enviar:', userData);
    
    // Aquí harías la petición fetch real al servidor
    // fetch('/api/register', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify(userData)
    // })
    // .then(response => response.json())
    // .then(data => {
    //     if (data.success) {
    //         showSuccessMessage();
    //     } else {
    //         showServerError(data.message);
    //     }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    //     showServerError('Error de conexión');
    // });
}