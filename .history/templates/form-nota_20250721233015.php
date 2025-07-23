
<div class="wrap nr-form-wrap">
<h1>Agregar Nota Rápida</h1>
<form method="post" class="nr-form">
<table class="form-table">
<tr>
<th><label for="titulo">Título</label></th>
<td><input type="text" name="titulo" id="titulo" required class="regular-text"></td>
</tr>
<tr>
<th><label for="contenido">Contenido</label></th>
<td><textarea name="contenido" id="contenido" rows="5" cols="50" class="large-text"></textarea></td>
</tr>
<tr>
<th><label for="prioridad">Prioridad</label></th>
<td>
<select name="prioridad" id="prioridad">
<option value="Alta">Alta</option>
<option value="Media" selected>Media</option>
<option value="Baja">Baja</option>
</select>
</td>
</tr>
</table>
<?php submit_button('Guardar Nota'); ?>
</form>
</div>