<i class="glyphicon glyphicon-list"></i>
<span class="va-2">Cambiar contraseña</span>

<div class="row panel panel-default">
    <div class="panel-body form-horizontal payment-form col-sm-12">
        <form class="new_user_form" action="/manager/update.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Contraseña Anterior:</label>
                <div class="col-sm-10">
                    <input class="form-control input-square" data-required="true"
                           placeholder="Password" type="password" name="old_pass" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Nueva Contraseña:</label>
                <div class="col-sm-10">
                    <input class="form-control input-square" data-required="true"
                           placeholder="Password" type="password" name="pass" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Confirmar Contraseña:</label>
                <div class="col-sm-10">
                    <input class="form-control input-square" data-required="true"
                           placeholder="Password" type="password" name="confirm_pass" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i>Guardar</button>
                    <a href="/manager" class="btn btn-danger btn-flat"><i class="fa fa-remove"></i>Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>