<?php
$db->select('cat_tipo_contenido');
$sections = $db->getResults();

$tabs = '';
$content = '';
$secciones = '';

foreach ($sections as $key => $section) {
    $items = '';
    $id = $key . '-' . $section['id'];
    $active = $key == 0 ? 'active' : '';
    $tabs .= '<li role="presentation" class="' . $active . '"><a href="#' . $id . '" aria-controls="home" role="tab" data-toggle="tab">' . $section['tipo_contenido'] . '</a></li>';
    $secciones .= '<option value="' . $section['id'] . '">' . $section['tipo_contenido'] . '</option>';

    $db->select('cat_categorias', "id_cat_tipo_contenido=" . $section['id']);
    $categories = $db->getResults();

    foreach ($categories as $category) {
        $items .= '<tr>
                      <td>' . $category['categoria'] . '</td>
                      <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-cog"></span>&nbsp;Opciones<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li data-delete="' . $category['id'] . '">
                                    <a href="#"><span class="fa fa-remove"></span>Eliminar</a>
                                </li>                                                
                            </ul>
                         </div>
                      </td>
                   </tr>';
    }

    $content .= '<div role="tabpanel" class="tab-pane ' . $active . '" id="' . $id . '">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                ' . $items . '
                </tbody>
            </table>
        </div>';
}
?>

<i class="glyphicon glyphicon-list"></i>
<span class="va-2">Listado de categorías</span>
<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal">
    <i class="glyphicon glyphicon-plus"></i>
</button>
<hr>
<div class="row panel panel-default">
    <div class="panel-body form-horizontal payment-form col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <?php echo $tabs; ?>
        </ul>
        <div class="tab-content">
            <?php echo $content; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_modal">Agregar Categoría</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add_category">
                    <div class="form-group has-feedback" id="input-usuario">
                        <label for="nombre_cat">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            </div>
                            <input type="text" class="form-control" id="category_name"
                                   placeholder="Nombre de categoría"/>
                        </div>
                        <div id="info_user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seccion">Sección</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                            </div>
                            <select class="form-control" id="section">
                                <?php echo $secciones; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i>Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i>Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>