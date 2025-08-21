var map = L.map("map").setView([18.7357, -70.1627], 7);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© SIR - OpenStreetMap",
}).addTo(map);

var markers = L.markerClusterGroup();

// Función para definir íconos según tipo
function getIcon(tipo) {
  // Mapa de colores según tipo
  const colores = {
    Accidente: "red",
    Robo: "orange",
    Desastre: "green",
    Default: "blue",
  };

  // Si no encuentra el tipo, usa Default
  const color = colores[tipo] || colores.Default;

  return L.divIcon({
    className: "custom-marker",
    html: `<i class="bi bi-geo-alt-fill" 
              style="color:${color}; font-size:24px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3)">
           </i>`,
    iconSize: [24, 24],
    iconAnchor: [12, 24], // punto exacto de referencia
    popupAnchor: [0, -24], // si quieres mostrar popups encima
  });
}

// Cargar incidencias desde PHP
fetch("getmap.php")
  .then((res) => res.json())
  .then((data) => {
    data.forEach((inc) => {
      var marker = L.marker([inc.latitud, inc.longitud], {
        icon: getIcon(inc.tipo),
      });

      marker.on("click", () => {
        document.getElementById("titulo").textContent = inc.titulo;
        document.getElementById("descripcion").textContent = inc.descripcion;
        document.getElementById("tipo").textContent = inc.tipo;
        document.getElementById("fecha").textContent = inc.fecha;
        document.getElementById("provincia").textContent = inc.provincia;
        document.getElementById("municipio").textContent = inc.municipio;
        document.getElementById("barrio").textContent = inc.barrio;
        document.getElementById("usuario").textContent =
          inc.usuario_nombre + " " + inc.usuario_apellido;
        document.getElementById("muertos").textContent = inc.muertos ?? 0;
        document.getElementById("heridos").textContent = inc.heridos ?? 0;
        document.getElementById("perdida").textContent =
          inc.perdida_estimada_de_RD ?? "0.00";
        document.getElementById("redes").href = inc.redes_link ?? "#";
        document.getElementById("foto").src =
          inc.foto ?? "https://via.placeholder.com/600x400?text=Sin+Foto";

        var modal = new bootstrap.Modal(
          document.getElementById("incidenciaModal")
        );
        modal.show();
      });

      markers.addLayer(marker);
    });

    map.addLayer(markers);
  })
  .catch((err) => console.error(err));
