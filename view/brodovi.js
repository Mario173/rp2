var board, check_list;
var igra_id = 1;

function pokreni_brodove() {

    game_id = 1;

    $("#middle").html('<h1 id="name_of_the_game"></h1><div id="place_for_table"></div><div id="ships_and_buttons">' + 
        'Brodovi koje treba rasporediti:<br><div id="ships"></div><br> <br><button id="check">Provjeri!</button>' + 
        '<br> <br><button id="again">Hoću sve ispočetka!</button><div id="game_id"></div><div id="won"></div></div>');
    
    $("#name_of_the_game").html('Potapanje brodova');
    $("#won").html('');
    
    napravi_review_div();

    create_ships();
    
    $.ajax({
        async: false,
        type: "GET",
        url: "https://rp2.studenti.math.hr/~zbujanov/dz4/id.php",
        dataType: "json",
        success: function( data ) {
            $("#game_id").html(data['id']);
            create_table( data['id'], data['rows'], data['cols'] );
        },
        error: function( xhr, status ) {
            if( status != null ) {
                console.log('Ajax greška: ' + status);
            }
        }
    });

    $("td").on("click", klikNaPloči);

    $("#check").on("click", provjeri);

    $("#again").on("click", resetiraj);
}

function create_table( id, rows, cols ) {
    var contents = '<table>';
    board = new Array(10); check_list = new Array(10);
    for(var i = 0; i < 10; i++) {
        board[i] = new Array(10).fill(0); // za praćenje je li na tom polju prazno, more ili brod
        check_list[i] = new Array(10).fill('N'); // za bojanje brodova poslije
        contents += '<tr>';
        for(var j = 0; j < 10; j++) {
            contents += ('<td class="field" id="' + i + j + '"></td>');
        }
        contents += ('<td class="nums" id="row' + i + '"> ' + rows[i] + ' </td>');
        contents += '</tr>';
    }

    for(var j = 0; j < 10; j++) {
        contents += ('<td class="nums" id="col' + j + '"> ' + cols[j] + ' </td>');
    }

    contents += '</table>';
    $("#place_for_table").html(contents);
}

function create_ships() {
    // za lakše bojanje
    var count = 1;

    // brod duljine 4
    contents = '<div id="ship4">';
    for(var i = 0; i < 4; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    // brodovi duljine 3
    contents += '</div><br><div class="three" id="ship3_1">'
    for(var i = 0; i < 3; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    contents += '</div><div class="three"></div>';
    contents += '<div class="three" id="ship3_2">';
    for(var i = 0; i < 3; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    // brodovi duljine 2
    contents += '</div><br><br><div class="two" id="ship2_1">';
    for(var i = 0; i < 2; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    contents += '</div><div class="two"></div>';
    contents += '<div class="two" id="ship2_2">';
    for(var i = 0; i < 2; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    contents += '</div><div class="two"></div>';
    contents += '<div class="two" id="ship2_3">';
    for(var i = 0; i < 2; i++) {
        contents += '<div class="ship"></div>';
        count++;
    }
    // brodovi duljine 1
    contents += '</div><br><br>';
    for(var i = 1; i < 5; i++) {
        contents += ('<div class="one" id="ship1_' + i + '"><div class="ship"></div></div>');
        count++;
        contents += '<div class="one"></div>';
    }
    $("#ships").html(contents);
}

var whichOne = ['empty', 'ship', 'sea'];

function klikNaPloči() {
    var tekst = $(this).attr('id');
    var x = parseInt(tekst.charAt(0)), y = parseInt(tekst.charAt(1));

    board[x][y] = (board[x][y] + 1) % 3; // promijeni znak na polju

    switch(board[x][y]) {
        case 0: // prazno polje
            $(this).html('');
            break;
        case 1: // brod
            $(this).html('<div class="ship"></div>');
            break;
        case 2: // more
            $(this).html('<img alt="Sea" id="sea" src="view/wave.png">');
            break;
        default:
            console.log('Greška board!!');
            break;
    }

    // promijeni boju broja
    var koliko_red = parseInt($("#row" + x).text()), koliko_stupac = parseInt($("#col" + y).text());
    var count_ships_row = 0, count_ships_col = 0;
    for(var i = 0; i < 10; i++) {
        if(board[x][i] === 1) {
            count_ships_row++;
        }
        if(board[i][y] === 1) {
            count_ships_col++;
        }
    }
    if(koliko_red === count_ships_row) {
        $("#row" + x).css("color", "lime");
    } else {
        $("#row" + x).css("color", "#f3172d");
    }
    if(koliko_stupac === count_ships_col) {
        $("#col" + y).css("color", "lime");
    } else {
        $("#col" + y).css("color", "#f3172d");
    }

    // provjeri brodove
    provjeri_brodove();
}

// provjerava koliko kojih brodova ima na ploči
function provjeri_brodove() {
    // provjeravamo samo prema dolje i prema desno da ne brojimo iste
    var count_len = 1;
    var num = [0, 0, 0, 0];
    vrati_na_staro();
    for(var i = 0; i < 10; i++) {
        for(var j = 0; j < 10; j++) {
            if(board[i][j] === 1 && check_list[i][j] === 'N') {
                check_list[i][j] = 'Y';
                if(i < 9 && board[i + 1][j] === 1) {
                    while((i + count_len) <= 9 && board[i + count_len][j] === 1) {
                        check_list[i + count_len][j] = 'Y';
                        count_len++;
                    }
                } else if(j < 9 && board[i][j + 1]) {
                    while((j + count_len) <= 9 && board[i][j + count_len] === 1) {
                        check_list[i][j + count_len] = 'Y';
                        count_len++;
                    }
                }
                num[count_len - 1]++;
                count_len = 1;
            }
        }
    }
    obojaj(num);
    for(var i = 0; i < 10; i++) {
        for(var j = 0; j < 10; j++) {
            check_list[i][j] = 'N';
        }
    }
}

function vrati_na_staro() {
    $("#ships").children().children().css("background-color", "black");
}

function obojaj(num) {
    if(num[3] >= 1) {
        $("#ship4").children().css("background-color", "lime");
    }

    if(num[2] >= 1) {
        $("#ship3_1").children().css("background-color", "lime");
    }
    if(num[2] >= 2) {
        $("#ship3_2").children().css("background-color", "lime");
    }

    if(num[1] >= 1) {
        $("#ship2_1").children().css("background-color", "lime");
    }
    if(num[1] >= 2) {
        $("#ship2_2").children().css("background-color", "lime");
    }
    if(num[1] >= 3) {
        $("#ship2_3").children().css("background-color", "lime");
    }

    if(num[0] >= 1) {
        $("#ship1_1").children().css("background-color", "lime");
    }
    if(num[0] >= 2) {
        $("#ship1_2").children().css("background-color", "lime");
    }
    if(num[0] >= 3) {
        $("#ship1_3").children().css("background-color", "lime");
    }
    if(num[0] >= 4) {
        $("#ship1_4").children().css("background-color", "lime");
    }
}

function provjeri() {
    var lista = [], num = 0;

    for(var i = 0; i < 10; i++) {
        for(var j = 0; j < 10; j++) {
            if(board[i][j] !== 0) {
                lista[num] = {row: i + 1, col: j + 1, type: whichOne[board[i][j]]};
                num++;
            }
        }
    }

    var flag = 1, counter = 0;

    $.ajax({
        async: false,
        type: "POST",
        url: "https://rp2.studenti.math.hr/~zbujanov/dz4/check.php",
        data: {
            id: $("#game_id").text(),
            list: lista
        },
        dataType: "json",
        success: function( data ) {
            for(var i = 0; i < lista.length; i++) {
                var j = parseInt(data[i]['row']) - 1;
                var k = parseInt(data[i]['col']) - 1;
                var which = "#" + j + k;
                if( data[i]['answer'] === 'wrong' ) {
                    flag = 0;
                    $(which).css("background-color", "red");
                } else {
                    $(which).css("background-color", "white");
                }
                if(data[i]['type'] === 'ship') {
                    counter++;
                }
            }
        },
        error: function( xhr, status ) {
            if( status != null ) {
                console.log('Ajax greška: ' + status);
            }
        }
    });

    if(flag === 1 && counter === 20) {
        $("#won").html('Čestitam, pobjeda!!');
        // ovdje ide dodavanje bodova useru
    }
}

function resetiraj() {
    $("#won").html('');

    pokreni_brodove();
}
