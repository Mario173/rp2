var board, check_list;
var igra_id = 1;
var broj_provjera = 0;

var board, check_list, gameid=1;


// funkcija koja služi za pokretanje igre Potapanje brodova
function pokreni_brodove() {


    game_id = 1;


    // ispiše strukturu za srednji div, tj samo igru

    $("#middle").html('<h1 id="name_of_the_game"></h1><div id="place_for_table"></div><div id="ships_and_buttons">' + 
        'Brodovi koje treba rasporediti:<br><div id="ships"></div><br> <br><button id="check">Provjeri!</button>' + 
        '<br> <br><button id="again">Hoću sve ispočetka!</button><div id="game_id"></div><div id="won"></div></div>');
    
    // postavi ime igre i, kako je igra tek krenula, postavi da igrač još nije pobjedio
    $("#name_of_the_game").html('Potapanje brodova');
    $("#won").html('');
    

    napravi_review_div();


    // varijabla koja ce brojati koliko puta smo slali poredak brodova na provjeru, ako je samo jednom trebas imati max score 10 000
    var broj_provjera = 0;

    // stvori slikice za brodove koje se nalaze desno od same tablice na kojoj se igra

    create_ships();
    
    // ajax poziv, služi za dohvaćanje podataka o tome gdje se nala brodovi i koji je id igre
    $.ajax({
        async: false,
        type: "GET",
        url: "/~zecicmar/igre/igre/index.php?rt=igre/generiraj_potapanje",
        dataType: "json",
        success: function( data ) {
            $("#game_id").html(data['id']);
            create_table( data['id'], data['rows'], data['cols'] ); // funkcija koja nacrta samu tablicu za igru
        },
        error: function( xhr, status ) {
            if( status != null ) {
                console.log('Ajax greška: ' + status);
            }
        }
    });

    // funkcija za klik na jedno polje tablice
    $("td").on("click", klikNaPločiBrodovi);

    // funkcija za klik na gumb Provjeri
    $("#check").on("click", provjeri);

    // funkcija za klik na gumb Hoću sve ispočetka!
    $("#again").on("click", resetirajBrodove);
}

// funkcija koja stvara samu tablicu za igranje igre
function create_table( id, rows, cols ) {
    var contents = '<table>';
    board = new Array(10); check_list = new Array(10);
    for(var i = 0; i < 10; i++) {
        board[i] = new Array(10).fill(0); // za praćenje je li na tom polju prazno, more ili brod
        check_list[i] = new Array(10).fill('N'); // za bojanje brodova poslije (onih sa strane tablice)
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

// funkcija za stvaranje brodova sa strane tablice
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

// arry za olakšavanje praćenja što je na polju: ništa, brod ili more
var whichOne = ['empty', 'ship', 'sea'];

// funkcija koja se poziva kada korisnik klikne na ćeliju ploče
function klikNaPločiBrodovi() {
    var tekst = $(this).attr('id'); // povučemo id ćelije -> u njemu su podaci o koordinatama
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
    var koliko_red = parseInt($("#row" + x).text()), koliko_stupac = parseInt($("#col" + y).text()); // povučemo koliko bi brodova trebalo biti u tom stupcu i u tom retku
    var count_ships_row = 0, count_ships_col = 0;
    for(var i = 0; i < 10; i++) { // izbrojimo brodove u stupcu i u retku
        if(board[x][i] === 1) {
            count_ships_row++;
        }
        if(board[i][y] === 1) {
            count_ships_col++;
        }
    }
    if(koliko_red === count_ships_row) { // zeleno ako su očekivani i stvarni broj brodova jednaki
        $("#row" + x).css("color", "lime");
    } else {
        $("#row" + x).css("color", "#f3172d"); // crveno inače
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
            if(board[i][j] === 1 && check_list[i][j] === 'N') { // check_list služi za praćenje jesmo li već ubrojili to polje ili nismo još
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
                num[count_len - 1]++; // povećamo broj brodova duljine count_len za 1 jer smo pronašli takav brod
                count_len = 1;
            }
        }
    }
    obojaj(num); // obojamo pronađene brodove u zeleno
    for(var i = 0; i < 10; i++) {
        for(var j = 0; j < 10; j++) {
            check_list[i][j] = 'N'; // vratimo listu provjerenih brodova na staro za sljedeću provjeru
        }
    }
    // provjerili smo jesmo li dobro poslagali brodove, povecaj broj provjera
    broj_provjera++;
}

// obojamo sve brodove natrag u crno
function vrati_na_staro() {
    $("#ships").children().children().css("background-color", "black");
}

// obojamo brodove sa strane u zeleno (ovisno o podacima koje smo već izvukli)
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

// funkcija koja se poziva kada igrač stisne gumb Provjeri!
function provjeri() {
    var lista = [], num = 0; // u listu na mjesto num dodajemo sva polja koja su označena kao brod ili kao more

    for(var i = 0; i < 10; i++) {
        for(var j = 0; j < 10; j++) {
            if(board[i][j] !== 0) {
                lista[num] = {row: i + 1, col: j + 1, type: whichOne[board[i][j]]};
                num++;
            }
        }
    }

    var flag = 1, counter = 0;

    // ajax funkcija za provjeru točnosti igračevog unosa
    $.ajax({
        async: false,
        type: "POST",
        url: "/~zecicmar/igre/igre/index.php?rt=igre/provjeri_potapanje",
        data: {
            //id: $("#game_id").text(),
            list: lista
        },
        dataType: 'json',
        success: function( data ) {
            data_list = data['list'];
            for(var i = 0; i < lista.length; i++) {
                var j = parseInt(data_list[i]['row']) - 1;
                var k = parseInt(data_list[i]['col']) - 1;
                var which = "#" + j + k;
                if( data_list[i]['answer'] === 'wrong' ) {
                    flag = 0; // ako pronađe ijedan krivi unos postavi zastavicu na 0
                    $(which).css("background-color", "red"); // promjeni pozadinu polja u crvenu
                } else {
                    $(which).css("background-color", "white"); // inače promjeni boju pozadine u bijelu (u slučaju da je ranije bila kriva)
                }
                if(data_list[i]['type'] === 'ship') {
                    counter++; // povećaj brojač za 1 za svaki točno postavljen brod na koji naiđeš
                }
            }
        },
        error: function( xhr, status ) {
            if( status != null ) {
                console.log('Ajax greška: ' + status);
                //console.log( data );
                console.log( lista );
            }
        }
    });

    if(flag === 1 && counter === 20) { // ako imamo točno 20 brodova i svi su na dobrim mjestima, pobjeda
        $("#won").html('Čestitam, pobjeda!!');
        // ovdje ide dodavanje bodova useru
        let score = 10000 / broj_provjera;
        $.ajax({
            url: "/~zecicmar/igre/igre/index.php?rt=igre/obradiRezultate",
            type: "POST",
            // u igrac na pocetku spremamo id igraca dobiven preko ajaxa
            data: {
                game: gameid,
                score: score
            },
            // datatype: "json",
            success: function(data){
                console.log("VJESALA: uspio ajax upit za postavljanje score u highscore|| ");
                console.log("data: "+data + "data.type" + typeof(data) );
            },
            error: function(data){
                console.log("greska u slanju ajax pobjede: " + data);
            }
        });
    }
}

// funkcija koja se poziva kada se klikne na gumb Hoću sve ispočetka!
function resetirajBrodove() {
    $("#won").html(''); // postavi da još nitko nije pobjedio


    pokreni_brodove();
}

    pokreni_brodove(); // opet pokreni sve ispočetka


