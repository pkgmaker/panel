<?php
$total = $db->select('content_type');
$secciones = '';

foreach ($db->getResults() as $res) {
    $tipo = $res['tipo'] == 0 ? "Resumible" : "Favoritable";
    $secciones .= '<tr data-key="' . $res['id'] . '">
                      <td>' . $res['content_type'] . '</td>
                      <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-cog"></span> Opciones <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li data-remove="' . $res['id'] . '">
                                    <a href="#"><span class="fa fa-remove"></span>Eliminar</a>
                                </li>                                                
                            </ul>
                         </div>
                      </td>
                   </tr>';
}
?>
<i class="glyphicon glyphicon-list"></i>
<span class="va-2">Listado de secciones</span>
<button type="button" class="btn btn-info btn-sm pull-right flat" data-toggle="modal" data-target="#myModal">
    <i class="glyphicon glyphicon-plus"></i>
</button>
<hr>
<div class="row panel panel-default">
    <div class="panel-body form-horizontal payment-form col-md-12">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Secciones</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $secciones; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_modal">Agregar Seccion</h4>
            </div>
            <div class="modal-body">
                <form id="add_section">
                    <div class="form-group has-feedback" id="input-usuario">
                        <label for="nombre_cat">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            </div>
                            <input type="text" class="form-control" id="section_name" placeholder="Nombre de la seccion"/>
                        </div>
                    </div>
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-info flat"><i class="fa fa-check"></i>Guardar</button>
                        <button type="button" class="btn btn-danger flat" data-dismiss="modal">
                            <i class="fa fa-remove"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>