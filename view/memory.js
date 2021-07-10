var puta_kliknuto = 1, prošli = [], točne_kućice = 0;
var table = [ ['A', 'B', 'C', 'D', 'E', 'F'], ['B', 'C', 'D', 'E', 'F', 'A'], ['C', 'D', 'E', 'F', 'A', 'B'],
                ['D', 'E', 'F', 'A', 'B', 'C'], ['E', 'F', 'A', 'B', 'C', 'D'], ['F', 'A', 'B', 'C', 'D', 'E'] ];

function pokreni_memory() {
    $("#middle").html('<h1 id="name_of_the_game"></h1><div id="place_for_table"></div>' + 
        '<br /><br /><button id="again">Hoću sve ispočetka!</button><div id="won"></div>');
    
    $("#name_of_the_game").html('Memory');
    $("#won").html('');

    nacrtaj_tablicu(table); // inače ajax upit

    $(".field_memory").on("click", klikNaPloču);

    $("#again").on("click", ponovi);
}

function nacrtaj_tablicu( table ) {
    var contents = '<table>';
    for(var i = 0; i < table.length; i++) {
        contents += '<tr>';
        for(var j = 0; j < table[i].length; j++) {
            contents += ('<td class="field_memory" id="' + i + j + '">' + table[i][j] + '</td>');
        }
        contents += '</tr>';
    }
    contents += '</table>';

    $("#place_for_table").html(contents);
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
        await new Promise(r => setTimeout(r, 500));
        puta_kliknuto = 1;
        if( prošli[2] === $(this).html() ) {
            točne_kućice += 2;
            if( točne_kućice === 36 ) {
                $("#won").html('Čestitam, pobjeda!!!');
                // računanje bodova i to
            }
        } else {
            $(this).css("color", "white");
            $("#" + prošli[0] + prošli[1]).css("color", "white");
        }
    }
}

function ponovi() {
    $("#won").html('');

    pokreni_memory();
}