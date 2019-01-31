$(function () {
    var pais = $('#pais').magicSuggest({
        data: SivozConfig.domain + '/paises',
        placeholder: 'País',
        allowFreeEntries: false,
        autoSelect: true,
        maxSelection: 1
    });
    $(pais).on('selectionchange', function (e, m) {
        var p = pais.getValue()[0];
        $('[name="pais"]').val(p)
        var ciudad = $('#ciudad').magicSuggest({
            data: null,
            placeholder: 'Ciudad',
            autoSelect: true,
            allowFreeEntries: false,
            maxSelection: 1
        })
        if (p != undefined) {
            ciudad.setData(SivozConfig.domain + '/ciudades?pais=' + p);
        } else {
            ciudad.setData([]);
        }



        $(ciudad).on('selectionchange', function (e, m) {
            var c = ciudad.getValue()[0].toUpperCase();
            $('[name="ciudad"]').val(c)
        })
    });

});

$('input[name=correo]').change(function (data) {
    var value = $(this).val() + '';


    if (value.indexOf('@') != -1 && value.indexOf('.') != -1) {
        value = value.split("@")[1];

        $.post(SivozConfig.domain + "extension/org", {
            extension: value
        }).done(function (data) {
            console.log(data);
        });
        console.log(value);
    }

});

$('input[name=ruc]').change(function() { 
    
    validar();
});

function validar() {
    var number = document.getElementById('signin-ruc2').value;
    var dto = number.length;
    var valor;
    var acu = 0;
    if (number == "") {
        alert('No has ingresado ningún dato, porfavor ingresar los datos correspondientes.');
    } else {
        for (var i = 0; i < dto; i++) {
            valor = number.substring(i, i + 1);
            if (valor == 0 || valor == 1 || valor == 2 || valor == 3 || valor == 4 || valor == 5 || valor == 6 || valor == 7 || valor == 8 || valor == 9) {
                acu = acu + 1;
            }
        }
        if (acu == dto) {
            while (number.substring(10, 13) != 001) {
                alert('Los tres últimos dígitos no tienen el código del RUC 001.');
                return;
            }
            while (number.substring(0, 2) > 24) {
                alert('Los dos primeros dígitos no pueden ser mayores a 24.');
                return;
            }
            alert('El RUC está escrito correctamente');
            alert('Se procederá a analizar el respectivo RUC.');
            var porcion1 = number.substring(2, 3);
            if (porcion1 < 6) {
                alert('El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n');
            } else {
                if (porcion1 == 6) {
                    alert('El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n');
                } else {
                    if (porcion1 == 9) {
                        alert('El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n');
                    }
                }
            }
        } else {
            alert("ERROR: Por favor no ingrese texto");
        }
    }
}