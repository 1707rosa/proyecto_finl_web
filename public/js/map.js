// Inicializar mapa centrado en RD
var map = L.map("map").setView([18.7357, -70.1627], 7);

// Capa base OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap contributors",
}).addTo(map);

// Cluster de marcadores
var markers = L.markerClusterGroup();

// Función para iconos personalizados según tipo
function getIcon(tipo) {
  let color = "blue";
  if (tipo === "Accidente") color = "red";
  else if (tipo === "Robo") color = "orange";
  else if (tipo === "Desastre") color = "green";

  return L.divIcon({
    className: "custom-marker",
    html: `<i class="bi bi-geo-alt-fill" style="color:${color}; font-size:28px;"></i>`,
    iconSize: [28, 28],
    iconAnchor: [14, 28],
  });
}

// Función para abrir modal con información
function openModal(inc) {
  document.getElementById("titulo").innerText = inc.titulo;
  document.getElementById("descripcion").innerText = inc.descripcion;
  document.getElementById("tipo").innerText = inc.tipo;
  document.getElementById("fecha").innerText = inc.fecha;
  document.getElementById("provincia").innerText = inc.provincia;
  document.getElementById("municipio").innerText = inc.municipio;
  document.getElementById("barrio").innerText = inc.barrio;
  document.getElementById("usuario").innerText =
    inc.usuario_nombre + " " + inc.usuario_apellido;
  document.getElementById("muertos").innerText = inc.muertos || 0;
  document.getElementById("heridos").innerText = inc.heridos || 0;
  document.getElementById("perdida").innerText =
    inc.perdida_estimada_de_RD || 0;
  document.getElementById("redes").innerText = inc.redes_link || "#";

  document.getElementById("int_id").innerText = inc.id;
  document.getElementById("inc_id").value = inc.id;
  cargarComentarios(inc.id);

  // Condición para la foto
  const fotoEl = document.getElementById("foto");
  if (inc.foto && inc.foto.trim() !== "") {
    fotoEl.src = inc.foto;
    fotoEl.alt = "Foto de la incidencia";
    fotoEl.style.display = "block";
  } else {
    fotoEl.src = "";
    fotoEl.alt = "no existe foto";
    fotoEl.style.display = "none"; // opcional, si quieres ocultarla
  }
  var modal = new bootstrap.Modal(document.getElementById("incidenciaModal"));
  modal.show();
}

// Cargar incidencias desde PHP
fetch("../../Views/Mapa/getmap.php")
  .then((res) => res.json())
  .then((data) => {
    data.forEach((inc) => {
      let marker = L.marker([inc.latitud, inc.longitud], {
        icon: getIcon(inc.tipo),
      });
      marker.on("click", () => openModal(inc));
      markers.addLayer(marker);
    });
    map.addLayer(markers);
  })
  .catch((err) => console.error("Error al cargar incidencias:", err));

var markerNuevo;
var mapNuevo;

document
  .getElementById("nuevoModal")
  .addEventListener("shown.bs.modal", function () {
    if (!mapNuevo) {
      mapNuevo = L.map("mapNuevo").setView([18.7357, -70.1627], 7);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
      }).addTo(mapNuevo);

      mapNuevo.on("click", function (e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);
        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;

        if (markerNuevo) {
          markerNuevo.setLatLng(e.latlng);
        } else {
          markerNuevo = L.marker(e.latlng).addTo(mapNuevo);
        }
      });
    } else {
      mapNuevo.invalidateSize(); // importante para que Leaflet redibuje correctamente
    }
  });

// Provincias → Municipios
document
  .getElementById("provinciaSelect")
  .addEventListener("change", function () {
    let provinciaId = this.value;
    fetch(`getmunicipios.php?provincia_id=${provinciaId}`)
      .then((res) => res.json())
      .then((data) => {
        let municipioSelect = document.getElementById("municipioSelect");
        municipioSelect.innerHTML =
          '<option value="">-- Selecciona --</option>';
        data.forEach((m) => {
          municipioSelect.innerHTML += `<option value="${m.id}">${m.nombre}</option>`;
        });
        document.getElementById("barrioSelect").innerHTML =
          '<option value="">-- Selecciona --</option>';
      });
  });

// Municipios → Barrios
document
  .getElementById("municipioSelect")
  .addEventListener("change", function () {
    let municipioId = this.value;
    fetch(`getbarrios.php?municipio_id=${municipioId}`)
      .then((res) => res.json())
      .then((data) => {
        let barrioSelect = document.getElementById("barrioSelect");
        barrioSelect.innerHTML = '<option value="">-- Selecciona --</option>';
        data.forEach((b) => {
          barrioSelect.innerHTML += `<option value="${b.id}">${b.nombre}</option>`;
        });
      });
  });

document
  .getElementById("formIncidencia")
  .addEventListener("submit", function (e) {
    let lat = document.getElementById("lat").value.trim();
    let lng = document.getElementById("lng").value.trim();

    if (!lat || !lng) {
      e.preventDefault(); // Evita el envío
      alert(
        "⚠️ Debes seleccionar una ubicación en el mapa antes de registrar la incidencia."
      );
    }
  });
