<div class="container mt-4">
<div class="card shadow-sm">
<div class="card-header bg-primary text-white">
<h3 class="mb-0">Agregar Nota Rápida</h3>
</div>
<div class="card-body">
<form method="post" class="row g-3">
<div class="col-12">
<label for="titulo" class="form-label">Título</label>
<input type="text" name="titulo" id="titulo" required class="form-control">
</div>
<div class="col-12">
<label for="contenido" class="form-label">Contenido</label>
<textarea name="contenido" id="contenido" rows="4" class="form-control"></textarea>
</div>
<div class="col-12">
<label for="prioridad" class="form-label">Prioridad</label>
<select name="prioridad" id="prioridad" class="form-select">
<option value="Alta">Alta</option>
<option value="Media" selected>Media</option>
<option value="Baja">Baja</option>
</select>
</div>
<div class="col-12">
<?php submit_button('Guardar Nota', 'primary', '', false, ['class' => 'btn btn-primary']); ?>
</div>
</form>
</div>


</div>    </div>    </div>
</div>