<?php
add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
});
?>
<div class="container mt-5" style="max-width: 600px;">
<div class="card shadow border-0">
<div class="card-header bg-primary text-white text-center">
<h3 class="mb-0">Agregar Nota Rápida</h3>
</div>
<div class="card-body">
<form method="post" class="row g-4">
<div class="col-12">
<label for="titulo" class="form-label fw-semibold">Título</label>
<input type="text" name="titulo" id="titulo" required class="form-control" placeholder="Ej: Recordatorio de reunión">
</div>
<div class="col-12">
<label for="contenido" class="form-label fw-semibold">Contenido</label>
<textarea name="contenido" id="contenido" rows="4" class="form-control" placeholder="Escribe tu nota aquí..."></textarea>
</div>
<div class="col-12">
<label for="prioridad" class="form-label fw-semibold">Prioridad</label>
<select name="prioridad" id="prioridad" class="form-select">
<option value="Alta">Alta</option>
<option value="Media" selected>Media</option>
<option value="Baja">Baja</option>
</select>
</div>
<div class="col-12 text-end">
<?php submit_button('Guardar Nota', 'primary', '', false, ['class' => 'btn btn-primary px-4']); ?>
</div>
</form>
</div>
</div>
</div>