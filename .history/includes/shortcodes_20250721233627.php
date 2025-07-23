<?php
if (!defined('ABSPATH')) exit;

// Shortcode para listar todas las notas
function nr_shortcode_listar_notas() {
    
    global $wpdb;
    
    $tabla = $wpdb->prefix . 'np_notas';
    
    // Si hay una acción de eliminación
    if (isset($_GET['eliminar_nota'])) {
        
        $id = intval($_GET['eliminar_nota']);
        
        $wpdb->delete($tabla, ['id' => $id]);
        
        echo "<div class='notice'>🗑️ Nota eliminada correctamente.</div>";
    }
    
    $notas = $wpdb->get_results("SELECT * FROM $tabla ORDER BY fecha DESC");
    
    ob_start();
    ?>
    <div class="container my-4" style="max-width: 700px;">
    <div class="card shadow border-0">
    <div class="card-header bg-primary text-white text-center">
    <h2 class="mb-0">📋 Lista de notas</h2>
    </div>
    <div class="card-body p-0">
    <?php if (empty($notas)): ?>
        <div class="alert alert-info m-4">No hay notas registradas.</div>
        <?php else: ?>
            <ul class="list-group list-group-flush">
            <?php foreach ($notas as $nota): ?>
                <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                <h5 class="mb-1 fw-bold text-primary"><?php echo esc_html($nota->titulo); ?></h5>
                <div class="mb-1 small">
                <span class="badge bg-<?php echo $nota->prioridad == 'Alta' ? 'danger' : ($nota->prioridad == 'Media' ? 'warning text-dark' : 'success'); ?>">📌 <?php echo esc_html($nota->prioridad); ?></span>
                <span class="ms-2 text-muted">🕒 <?php echo esc_html($nota->fecha); ?></span>
                </div>
                </div>
                <div>
                <a href="?ver_nota=<?php echo esc_attr($nota->id); ?>" class="btn btn-outline-info btn-sm me-1" title="Ver"><span>🔍</span></a>
                <a href="?editar_nota=<?php echo esc_attr($nota->id); ?>" class="btn btn-outline-secondary btn-sm me-1" title="Editar"><span>✏️</span></a>
                <a href="?eliminar_nota=<?php echo esc_attr($nota->id); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta nota?');" title="Eliminar"><span>❌</span></a>
                </div>
                </div>
                </li>
                <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                </div>
                </div>
                </div>
                <?php
                return ob_get_clean();
            }
            add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');
            