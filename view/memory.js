var puta_kliknuto = 1, prošli = [], točne_kućice = 0;
var table = [ ['A', 'B', 'C', 'D', 'E', 'F'], ['G', 'H', 'I', 'J', 'K', 'L'], ['M', 'N', 'O', 'P', 'Q', 'R'],
                ['R', 'Q', 'P', 'O', 'N', 'M'], ['L', 'K', 'J', 'I', 'H', 'G'], ['F', 'E', 'D', 'C', 'B', 'A'] ];

var which_icon = [];

var broj_grešaka = 0;

function pokreni_memory() {
    točne_kućice = 0;

    $("#middle").html('<h1 id="name_of_the_game"></h1><div id="place_for_table_memory"></div>' + 
        '<br /><br /><button id="again">Hoću sve ispočetka!</button><div id="won"></div>');
    
    $("#name_of_the_game").html('Memory');
    $("#won").html('');

    postavi_ikone();
    $.ajax({
        async: false,
        type: "POST",
        url: "controller/ajaxControllerHelp.php", // ovde je problem, ne znan kako nać ajaxControllerHelp.php
        dataType: "json",
        data: {
            game: 'memory'
        },
        success: function( data ) {
            console.log( data );
            $("#game_id").html(data['id']);
            nacrtaj_tablicu( data['table'] );
        },
        error: function( xhr, status, data ) {
            console.log(JSON.stringify(data));
            if( status != null ) {
                console.log('Ajax greška: ' + status);
            }
        }
    });

    $(".field_memory").on("click", klikNaPloču);

    $("#again").on("click", ponovi);
}

function nacrtaj_tablicu( table ) {
    var contents = '<table>';
    for(var i = 0; i < table.length; i++) {
        contents += '<tr>';
        for(var j = 0; j < table[i].length; j++) {
            contents += ('<td class="field_memory" id="' + i + j + '">' + which_icon[table[i][j]] + '</td>');
        }
        contents += '</tr>';
    }
    contents += '</table>';

    $("#place_for_table_memory").html(contents);
}

async function klikNaPloču() {
    var tekst = $(this).attr('id');
    var x = parseInt(tekst.charAt(0)), y = parseInt(tekst.charAt(1));

    if( puta_kliknuto === 1 ) {
        prošli = [x, y, $(this).html()]; // kad budu slikice, treci char u id ce bit jedan od A, B, C, D, E, F
        $(this).css("color", "black");
        puta_kliknuto++;
    } else {
        $(this).css("color", "black");
        puta_kliknuto = 1;
        if( prošli[2] === $(this).html() ) {
            točne_kućice++;
            if( točne_kućice === 18 ) {
                $("#won").html('Čestitam, pobjeda!!!');
                // računanje bodova i to
            }
        } else {
            broj_grešaka++;
            await new Promise(r => setTimeout(r, 500)); // bolje da je ovde
            $(this).css("color", "white");
            $("#" + prošli[0] + prošli[1]).css("color", "white");
        }
    }
}

function ponovi() {
    broj_grešaka = 0;
    $("#won").html('');

    pokreni_memory();
}

function postavi_ikone() {
    which_icon['A'] = '<i class="fas fa-satellite"></i>';
    which_icon['B'] = '<i class="fas fa-meteor"></i>';
    which_icon['C'] = '<i class="fas fa-rocket"></i>';
    which_icon['D'] = '<i class="fas fa-atom"></i>';
    which_icon['E'] = '<i class="fas fa-robot"></i>';
    which_icon['F'] = '<i class="fas fa-user-astronaut"></i>';
    which_icon['G'] = '<i class="fas fa-tv"></i>';
    which_icon['H'] = '<i class="fas fa-toilet-paper"></i>';
    which_icon['I'] = '<i class="fas fa-cat"></i>';
    which_icon['J'] = '<i class="fas fa-crow"></i>';
    which_icon['K'] = '<i class="fas fa-dog"></i>';
    which_icon['L'] = '<i class="fas fa-dragon"></i>';
    which_icon['M'] = '<i class="fas fa-kiwi-bird"></i>';
    which_icon['N'] = '<i class="fas fa-cocktail"></i>';
    which_icon['O'] = '<i class="fas fa-globe-europe"></i>';
    which_icon['P'] = '<i class="fas fa-ghost"></i>';
    which_icon['Q'] = '<i class="fas fa-dice"></i>';
    which_icon['R'] = '<i class="fas fa-square-root-alt"></i>';
}