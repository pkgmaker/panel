$(document).ready(function () {

    $('[data-toggle=collapse]').click(function () {
        $(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    });

    $("#uactivos_filter").addClass("display", "none");

    $('[data-toggle="tooltip"]').tooltip();

    $('#user_add').blur(function () {
        $('#info').html('<img src="assets/img/loader.gif" alt="" />').fadeOut(1000);

        var usuario = $(this).val();
        var datos = 'u=' + usuario;

        $.ajax({
            type: "POST",
            url: "comprueba_user.php",
            data: datos,
            success: function (data) {
                if (data.replace(/\s/g, '') == "ok") {
                    $("#input-usuario").addClass("has-success");
                    $('#info').fadeIn(1000).html('<span class="glyphicon glyphicon-ok  form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span><small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_add" data-fv-result="INVALID" style="display: block;">Usuario disponible</small>');
                } else {
                    $("#input-usuario").addClass("has-error");
                    $('#info').fadeIn(1000).html('<span class="glyphicon glyphicon-remove  form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span> <small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_add" data-fv-result="INVALID" style="display: block;">Usuario no disponible</small>');
                }
            }
        });
    });

    $('#filtro_dep').selectpicker({
        style: 'btn-sm btn-default'
    });

    $('#estatus').selectpicker({
        style: 'btn-sm btn-default'
    });

    $(".selectpicker").change(function () {
        tabla_uservod.search(this.value).draw();
    });

    $('#busqueda_reqs').on('keyup', function () {
        tabla_uservod.search(this.value).draw();
    });

    $(".selectpicker").change(function () {
        tabla_epgs.search(this.value).draw();
    });

    $("#busqueda_reqs").on('keyup', function () {
        tabla_epgs.search(this.value).draw();
    });

    $('#user').blur(function () {
        var usuario = $(this).val();
        var datos = 'u=' + usuario;
        if (usuario.length >= 3) {
            $.ajax({
                type: "POST",
                url: "/ajax/comprueba_user.php",
                data: datos,
                success: function (data) {
                    if (data.replace(/\s/g, '') == "ok") {
                        $("#input-usuario").removeClass("has-error");
                        $("#input-usuario").addClass("has-success");
                        $('#info_user').fadeIn(700).html('<span style="top:25px;" class="glyphicon glyphicon-ok  form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span><small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_add" data-fv-result="INVALID" style="display: block;">Usuario disponible</small>');
                    } else {
                        $("#input-usuario").removeClass("has-success");
                        $("#input-usuario").addClass("has-error");
                        $('#info_user').fadeIn(700).html('<span style="top:25px;" class="glyphicon glyphicon-remove  form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span> <small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_add" data-fv-result="INVALID" style="display: block;">Usuario no disponible</small>');
                    }
                }
            });
        }
    });

    $('.slimScrollDiv').css('height', '100%');
    $('.sidebar').css('height', '100%');
});

$.fn.bootstrapSwitch.defaults.size = 'normal';
$.fn.bootstrapSwitch.defaults.onColor = 'success';
$.fn.bootstrapSwitch.defaults.handleWidth = 45;
$.fn.bootstrapSwitch.defaults.onText = 'Si';
$.fn.bootstrapSwitch.defaults.offText = 'No';

$("[name='demo']").bootstrapSwitch();

var tabla_uservod = $('#uactivos').DataTable({
    searching: true,
    lengthChange: false,
    ordering: true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
    }
});