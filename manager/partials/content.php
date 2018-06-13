<?php
$db->select('content');
$result = $db->getResults();
?>

<div class="row">
    <div class="col-md-12">
        <form class="new_user_form" id="insert-movie" action="/manager/save.php" method="post">
            <div class="panel panel-default">
                <div class="panel-body form-horizontal payment-form">
                    <?php
                    if (isset($_GET['m']) && isset($_GET['a']) && !empty($_GET['m']) && !empty($_GET['a'])) {
                        echo '<div id="mensaje">
                                                <div class="alert alert-' . htmlentities($_GET['a']) . '" role="alert">                            
                                                  <strong>' . htmlentities($_GET['m']) . '</strong>                             
                                                </div>                            
                                              </div>';
                    }
                    ?>

                    <div class="form-group">
                        <label for="concept" class="col-md-2 control-label">Titulo:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                            <div id="resultado"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link" class="col-md-2 control-label">Link:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="link" name="link"
                                   placeholder="ej: http://www.domain.com/resource" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link" class="col-md-2 control-label">Poster:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="poster" name="poster"
                                   placeholder="ej: http://www.domain.com/img.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link" class="col-md-2 control-label">Fondo:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="fondo" name="fondo"
                                   placeholder="ej: http://www.domain.com/img.jpg">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-xs-6">
                            <label for="concept" class="col-md-4 control-label">Seccion:</label>
                            <div class="col-md-8">
                                <select class="form-control" id="type" name="type" class="chosen-select" required>
                                    <?php
                                    $db->query("SELECT id, content_type FROM  content_type");
                                    $q_cats = $db->getResults();
                                    foreach ($q_cats as $cat) {
                                        echo "<option value='" . $cat['id'] . "'>" . $cat['content_type'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 col-xs-6">
                            <label for="categorias" class="col-sm-3 control-label">Categorias:</label>
                            <div class="col-sm-9">
                                <select data-placeholder="Seleccione categorías(s)." id="choose-category"
                                        class="chosen-select" multiple required
                                        style="width:90%;" tabindex="5" name="categories[]">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-info btn-flat">
                                <i class="fa fa-check"></i>Guardar
                            </button>
                            <a href="/manager" class="btn btn-danger btn-flat">
                                <i class="fa fa-remove"></i>Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row panel panel-default">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>#</td>
                <td>Titulo</td>
                <td>Url</td>
                <td>Acción</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($result as $key => $item) {
                echo '<tr>
                                        <td>' . ($key + 1) . '</td>
                                        <td>' . $item['title'] . '</td>
                                        <td>' . $item['url'] . '</td>
                                        <td><a href="delete.php?id=' . $item['id'] . '">Eliminar</a></td>
                                    </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>