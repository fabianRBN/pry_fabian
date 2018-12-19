var hexToRgbA = function(hex, opacity){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+ opacity +')';
    }
    throw new Error('Bad Hex');
}


$.get(SivozConfig.domain + '/stats').done(function(data){

    data = JSON.parse(data);
    var charts = [];

    data.forEach(function(e,i){
        var datasetItem = []
        var colors = [];

        e.dataset.forEach(function(ee,ii){
            if(typeof ee === 'number'){
                datasetItem.push(ee)
            }
        })

        e.colors.forEach(function(ee,ii){
            colors.push(hexToRgbA(ee, 0.6))
        })
        
        var dataset = {
            type: e.type,
            data: {
                labels: e.labels,
                datasets: [{
                    label: e.label,
                    data: datasetItem,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        }

        $('.chart-' + (i + 1) + '  h4').html(e.title);
        $('.chart-' + (i + 1) + '  img').hide()

        //console.log(dataset)

        charts.push(new Chart(document.getElementById("chart-" + (i + 1)).getContext('2d'), dataset));      
    })

})


