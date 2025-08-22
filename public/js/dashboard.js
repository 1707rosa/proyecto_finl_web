function cargarCorrecciones() {
  const tbody = document.getElementById("correccionesBody");
  if (!tbody) return; // Evita error si el tbody no existe

  fetch("../../Views/super/get_correcciones.php")
    .then((res) => res.json())
    .then((data) => {
      tbody.innerHTML = "";

      data.forEach((c) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${c.id}</td>
          <td>${c.usuario_nombre} ${c.usuario_apellido}</td>
          <td>${c.incidencias_id}</td>
          <td>${c.campo}</td>
          <td>${c.sugerencia}</td>
          <td>${c.estado}</td>
          <td>
            <button class="btn btn-sm btn-success" onclick="aceptar(${c.id})"><i class="bi bi-check-circle"></i></button>
            <button class="btn btn-sm btn-danger" onclick="rechazar(${c.id})"><i class="bi bi-x-circle"></i></button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch((err) => console.error("Error al cargar correcciones:", err));
}

function aceptar(id) {
  fetch(
    `../../Views/super/correcciones_accion.php?action=update&id=${id}&estado=aceptada`
  ).then(() => cargarCorrecciones());
}

function rechazar(id) {
  fetch(
    `../../Views/super/correcciones_accion.php?action=update&id=${id}&estado=rechazada`
  ).then(() => cargarCorrecciones());
}

document.addEventListener("DOMContentLoaded", () => {
  cargarCorrecciones();
});
