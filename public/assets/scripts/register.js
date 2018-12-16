$(function() {
    var pais = $('#pais').magicSuggest({
        data: SivozConfig.domain + '/paises',
        placeholder: 'País',
        allowFreeEntries: false,
        autoSelect: true,
        maxSelection: 1
    });
    $(pais).on('selectionchange', function(e,m){
        var p = pais.getValue()[0];
        $('[name="pais"]').val(p)
        var ciudad = $('#ciudad').magicSuggest({
            data: null,
            placeholder: 'Ciudad',
            autoSelect: true,
            allowFreeEntries: false,
            maxSelection: 1
        })
        if(p!=undefined){
                ciudad.setData(SivozConfig.domain + '/ciudades?pais=' + p);
        }else{
                ciudad.setData([]);
        }

            

        $(ciudad).on('selectionchange', function(e,m){
            var c =ciudad.getValue()[0].toUpperCase();
            $('[name="ciudad"]').val(c)
        })
    });

});