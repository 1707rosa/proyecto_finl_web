// Mostrar notificación tipo toast
function showToast(message, tipo = "success") {
  const toastEl = document.createElement("div");
  toastEl.className = `toast align-items-center text-bg-${tipo} border-0`;
  toastEl.role = "alert";
  toastEl.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  `;
  document.body.appendChild(toastEl);
  const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
  toast.show();
  toastEl.addEventListener("hidden.bs.toast", () => toastEl.remove());
}

// Cargar comentarios de una incidencia
function cargarComentarios(incidenciaId) {
  if (!incidenciaId) return;

  fetch(`comentarios/get_comentarios.php?incidencia_id=${incidenciaId}`)
    .then((res) => res.json())
    .then((data) => {
      const lista = document.getElementById("comentariosList");
      lista.innerHTML = "";

      data.forEach((c) => {
        const contenidoEscapado = c.Contenido.replace(/'/g, "\\'").replace(
          /"/g,
          "&quot;"
        );
        const esUsuario = c.usuarios_id == window.usuarioId;

        lista.innerHTML += `
          <li class="list-group-item d-flex justify-content-between align-items-start ${
            esUsuario ? "bg-light border-primary" : ""
          }">
            <div class="flex-grow-1">
              <strong>${c.usuario_nombre} ${c.usuario_apellido}</strong>: ${
          c.Contenido
        }
              <br><small class="text-muted">${c.fecha}</small>
            </div>
            ${
              esUsuario
                ? `<div class="ms-2">
                     <button class="btn btn-sm btn-outline-warning me-1" onclick="editarComentario(${c.id}, '${contenidoEscapado}')">Editar</button>
                     <button class="btn btn-sm btn-outline-danger" onclick="eliminarComentario(${c.id})">Eliminar</button>
                   </div>`
                : ``
            }
          </li>
        `;
      });
    })
    .catch((err) => console.error("Error al cargar comentarios:", err));
}

// Agregar comentario
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formComentario");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.set("inc_id", document.getElementById("inc_id").value);

    fetch("comentarios/add_comentarios.php", { method: "POST", body: formData })
      .then((res) => res.json())
      .then((r) => {
        if (r.status === "ok") {
          cargarComentarios(document.getElementById("inc_id").value);
          this.reset();
          showToast("Comentario agregado ✅", "success");
        } else {
          showToast("Error al agregar comentario ⚠️", "danger");
        }
      })
      .catch(() => showToast("Error de conexión ⚠️", "danger"));
  });
});

// Editar comentario usando prompt mejorado
function editarComentario(id, texto) {
  const nuevo = prompt("Editar comentario:", texto);
  if (!nuevo) return;

  fetch("comentarios/edit_comentarios.php", {
    method: "POST",
    body: new URLSearchParams({ id, comentario: nuevo }),
  })
    .then((res) => res.json())
    .then((r) => {
      if (r.status === "ok") {
        cargarComentarios(document.getElementById("inc_id").value);
        showToast("Comentario editado ✏️", "info");
      } else {
        showToast("Error al editar comentario ⚠️", "danger");
      }
    })
    .catch(() => showToast("Error de conexión ⚠️", "danger"));
}

// Eliminar comentario
function eliminarComentario(id) {
  if (!confirm("¿Seguro que deseas eliminar este comentario?")) return;

  fetch("comentarios/delete_comentarios.php", {
    method: "POST",
    body: new URLSearchParams({ id }),
  })
    .then((res) => res.json())
    .then((r) => {
      if (r.status === "ok") {
        cargarComentarios(document.getElementById("inc_id").value);
        showToast("Comentario eliminado 🗑️", "warning");
      } else {
        showToast("Error al eliminar comentario ⚠️", "danger");
      }
    })
    .catch(() => showToast("Error de conexión ⚠️", "danger"));
}
