function cargarCorrecciones() {
  const tbody = document.getElementById("correccionesBody");
  if (!tbody) return;

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
            <button class="btn btn-sm btn-success" onclick="aceptar(${c.id})">Aceptar</button>
            <button class="btn btn-sm btn-danger" onclick="rechazar(${c.id})">Rechazar</button>
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

// Enviar nueva corrección
document
  .getElementById("formAgregarCorreccion")
  ?.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("../../Views/super/correcciones_accion.php?action=add", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((r) => {
        if (r.status === "ok") {
          cargarCorrecciones();
          const modal = bootstrap.Modal.getInstance(
            document.getElementById("modalAgregarCorreccion")
          );
          modal.hide();
          this.reset();
        } else {
          alert("Error al agregar corrección");
        }
      })
      .catch((err) => console.error(err));
  });

document.addEventListener("DOMContentLoaded", () => {
  cargarCorrecciones();
});



// ======================
// ESTADÍSTICAS - Chart
// ======================
fetch("../../Views/super/get_estadisticas.php")
  .then(res => res.json())
  .then(data => {
    const ctx = document.getElementById("chartIncidencias").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: data.map(d => d.tipo),
        datasets: [{
          label: "Cantidad de incidencias",
          data: data.map(d => d.total),
          backgroundColor: "rgba(54, 162, 235, 0.7)"
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } }
      }
    });
  })
  .catch(err => console.error("Error al cargar estadísticas:", err));
