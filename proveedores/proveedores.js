document.querySelector('form').addEventListener('submit', function(e) {
    const telefono = document.querySelector('input[name="telefono_contacto"]').value;
    const email = document.querySelector('input[name="email"]').value;
    
    // Validar longitud del teléfono
    if (telefono.replace(/[^0-9]/g, '').length < 7) {
        e.preventDefault();
        alert('El teléfono debe tener al menos 7 dígitos');
        return false;
    }
    
    // Validar formato de email más estricto
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Ingrese un email válido');
        return false;
    }
    
    return true;
});