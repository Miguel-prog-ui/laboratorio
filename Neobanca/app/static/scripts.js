document.addEventListener('DOMContentLoaded', function() {
    const passwordModal = document.getElementById("password-modal");
    const debitCardModal = document.getElementById("debit-card-modal");
    const notificationsModal = document.getElementById("notifications-modal");
    const exchangeModal = document.getElementById("exchange-modal");
    const debitCardButton = document.getElementById("debit-card-button");
    const passwordSubmit = document.getElementById("password-submit");
    const showAllNotifications = document.getElementById("show-all-notifications");
    const exchangeOperationsButton = document.getElementById("exchange-operations-button");
    const exchangeForm = document.getElementById("exchange-form");
    const closeButtons = document.querySelectorAll(".close");

    // Evento para abrir el modal de la tarjeta de débito
    debitCardButton.onclick = function() {
        passwordModal.style.display = "block";
    };

    // Evento para enviar la contraseña y validar
    passwordSubmit.onclick = async function() {
        const password = document.getElementById("password-input").value;

        // Enviar la contraseña al backend para validación
        const response = await fetch('/validate_password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ password: password })
        });

        const result = await response.json();

        if (result.valid) {
            passwordModal.style.display = "none";
            debitCardModal.style.display = "block";
        } else {
            alert("Contraseña incorrecta");
        }
    };

    // Evento para mostrar todas las notificaciones
    showAllNotifications.onclick = function() {
        notificationsModal.style.display = "block";
    };

    // Evento para abrir el modal de operaciones cambiarias
    exchangeOperationsButton.onclick = function() {
        exchangeModal.style.display = "block";
    };

    // Evento para manejar el envío del formulario de compra/venta de divisas
    exchangeForm.onsubmit = async function(event) {
        event.preventDefault();

        const tipo_operacion = document.getElementById("tipo_operacion").value;
        const monto = document.getElementById("monto").value;

        const response = await fetch('/compra_venta_dolares', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ tipo_operacion: tipo_operacion, monto: monto })
        });

        const result = await response.json();

        if (result.mensaje) {
            document.getElementById("mensaje").textContent = result.mensaje;
        }

        if (result.saldo) {
            document.querySelector(".saldo").textContent = `Bs.${result.saldo}`;
        }

        if (result.saldo_dolares) {
            document.querySelector(".saldo-dolares").textContent = `$${result.saldo_dolares}`;
        }

        if (result.notificaciones) {
            const notificacionesList = document.querySelector(".notifications");
            notificacionesList.innerHTML = "";
            result.notificaciones.forEach(notificacion => {
                const li = document.createElement("li");
                li.textContent = `Su ${notificacion.tipo} ha sido ${notificacion.notificacion} el ${notificacion.fecha}`;
                notificacionesList.appendChild(li);
            });
        }

        exchangeModal.style.display = "none";
    };

    // Evento para cerrar los modales
    closeButtons.forEach(button => {
        button.onclick = function() {
            button.parentElement.parentElement.style.display = "none";
        };
    });

    // Evento para cerrar los modales haciendo clic fuera de ellos
    window.onclick = function(event) {
        if (event.target === passwordModal || event.target === debitCardModal || event.target === notificationsModal || event.target === exchangeModal) {
            event.target.style.display = "none";
        }
    };
});
