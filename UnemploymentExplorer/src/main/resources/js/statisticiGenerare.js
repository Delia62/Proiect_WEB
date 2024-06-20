
export function generareSelectJudet() {
    $.ajax({
        url: './php/form_data/judet.php',
        type: 'POST',
        data: {
            judet: 'judet'
        },
        success: function(response) {
            console.log(response);
            var judet = JSON.parse(response);
            var select = document.getElementById('judet');
            for (var key in judet) {
                if (judet.hasOwnProperty(key)) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = judet[key];
                    select.add(option);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}


export function generareNivelEducatie() {
    $.ajax({
        url: './php/form_data/educatie.php',
        type: 'POST',
        data: {
            educatie: 'educatie'
        },
        success: function(response) {
            console.log(response);
            var educatie = JSON.parse(response);
            var select = document.getElementById('educatie');
            for (var key in educatie) {
                if (educatie.hasOwnProperty(key)) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = educatie[key];
                    select.add(option);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}


export function generareGrupariVarsta() {
    $.ajax({
        url: './php/form_data/grupeVarsta.php',
        type: 'POST',
        data: {
            varsta: 'varsta'
        },
        success: function(response) {
            console.log(response);
            var varsta = JSON.parse(response);
            var select = document.getElementById('varsta');
            for (var key in varsta) {
                if (varsta.hasOwnProperty(key)) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = varsta[key];
                    select.add(option);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}

export function generareGenuri() {
    $.ajax({
        url: './php/form_data/gen.php',
        type: 'POST',
        data: {
            gen: 'gen'
        },
        success: function(response) {
            console.log(response);
            var gen = JSON.parse(response);
            var select = document.getElementById('gen');
            for (var key in gen) {
                if (gen.hasOwnProperty(key)) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = gen[key];
                    select.add(option);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}

export function generareMediu() {
    $.ajax({
        url: './php/form_data/mediu.php',
        type: 'POST',
        data: {
            mediu: 'mediu'
        },
        success: function(response) {
            console.log(response);
            var mediu = JSON.parse(response);
            var select = document.getElementById('mediu');
            for (var key in mediu) {
                if (mediu.hasOwnProperty(key)) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = mediu[key];
                    select.add(option);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}