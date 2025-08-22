<?php
include('../../config/db.php');
session_start();
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Correcciones</h3>
        <!-- Botón Añadir Corrección -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCorreccion">
            <i class="bi bi-plus-circle"></i> Añadir Corrección
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Incidencia</th>
                    <th>Campo</th>
                    <th>Valor sugerido</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="correccionesBody"></tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Corrección -->
<div class="modal fade" id="modalAgregarCorreccion" tabindex="-1" aria-labelledby="modalAgregarCorreccionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAgregarCorreccionLabel">Añadir Corrección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarCorreccion">
                    <div class="mb-3">
                        <label>Incidencia ID</label>
                        <input type="number" name="incidencias_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Campo a corregir</label>
                        <select name="campo" class="form-control" required>
                            <option value="">-- Selecciona --</option>
                            <option value="muertos">Muertos</option>
                            <option value="heridos">Heridos</option>
                            <option value="provincia_id">Provincia</option>
                            <option value="municipio_id">Municipio</option>
                            <option value="perdida_estimada_de_RD">Pérdida estimada</option>
                            <option value="latitud">Latitud</option>
                            <option value="longitud">Longitud</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Valor sugerido</label>
                        <input type="text" name="sugerencia" class="form-control" required>
                    </div>
                    <input type="hidden" name="usuarios_id" value="<?php echo $_SESSION['id']; ?>">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>