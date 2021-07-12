var choice = 0, won = 0;
var check = [['', '', ''], ['', '', ''], ['', '', '']];
var positions_left = [0, 1, 2, 3, 4, 5, 6, 7, 8];

function pokreni_križić_kružić() {
    $("#middle").html('<h1 id="name_of_the_game"></h1><canvas id="cnv"></canvas>' +
        '<br> <br><button id="again">Hoću sve ispočetka!</button><div id="game_id"></div><div id="won"></div></div>');
    
    $("#name_of_the_game").html('Križić-kružić');
    $("#won").html('');

    // možda biranje simbola prvo

    create_board();

    $("#cnv").on("click", klikNaPloči);

    $("#again").on("click", resetiraj);
}

function create_board() {
    var canvas = $("#cnv").get(0);
    var ctx = canvas.getContext("2d");

    canvas.width = 400;
    canvas.height = 400;
    canvas.style.width = canvas.width;
    canvas.style.height = canvas.height;

    ctx.moveTo(canvas.width / 3, 0);
    ctx.lineTo(canvas.width / 3, canvas.height);
    ctx.moveTo(2 * canvas.width / 3, canvas.height);
    ctx.lineTo(2 * canvas.width / 3, 0);
    ctx.moveTo(0, canvas.height / 3);
    ctx.lineTo(canvas.width, canvas.height / 3);
    ctx.moveTo(canvas.width, 2 * canvas.height / 3);
    ctx.lineTo(0, 2 * canvas.height / 3);

    ctx.stroke();
}

function klikNaPloči() {
    var canvas = $("#cnv").get(0);
    var ctx = canvas.getContext("2d");

    var x = event.clientX - canvas.getBoundingClientRect().left;
    var y = event.clientY - canvas.getBoundingClientRect().top;

    var koji_sirina = Math.floor((3 * x) / canvas.width);
    var koji_visina = Math.floor((3 * y) / canvas.height);

    if( positions_left.indexOf(3 * koji_sirina + koji_visina) !== -1 ) {
        if( won === 0 ) {
            nacrtaj_simbol(koji_sirina, koji_visina, choice);
            provjeri_pobjedu();
        }

        if( won === 0 && positions_left.length !== 0 ) {
            // random generiraj idući potez
            var randomElement = positions_left[Math.floor(Math.random() * positions_left.length)];

            nacrtaj_simbol(Math.floor(randomElement / 3), randomElement % 3, 1 - choice);
            provjeri_pobjedu();
        }
    }

    if( positions_left.length === 0 && won === 0 ) {
        $("#won").html('Izjednačeno');
    }
}

function nacrtaj_simbol( koji_sirina, koji_visina, choice ) {
    var canvas = $("#cnv").get(0);
    var ctx = canvas.getContext("2d");

    positions_left.splice(positions_left.indexOf(3 * koji_sirina + koji_visina), 1); // briše element 3 * koji_sirina + koji_visina iz liste

    if( choice === 0 ) { // crtamo x
        ctx.moveTo(koji_sirina * canvas.width / 3 + 20, koji_visina * canvas.height / 3 + 20);
        ctx.lineTo((koji_sirina + 1) * canvas.width / 3 - 20, (koji_visina + 1) * canvas.height / 3 - 20);
        ctx.moveTo((koji_sirina + 1) * canvas.width / 3 - 20, koji_visina * canvas.height / 3 + 20);
        ctx.lineTo(koji_sirina * canvas.width / 3 + 20, (koji_visina + 1) * canvas.height / 3 - 20);

        check[koji_sirina][koji_visina] = 'x';
    } else { // crtamo krug
        var center_x = (koji_sirina + 0.5) * canvas.width / 3;
        var center_y = (koji_visina + 0.5) * canvas.height / 3;
        var radius = Math.min(canvas.width, canvas.height) / 5 - 20;

        ctx.moveTo(center_x + radius, center_y);

        ctx.arc(center_x, center_y, radius, 0, 2 * Math.PI);

        check[koji_sirina][koji_visina] = 'o';
    }

    ctx.stroke();
}

function provjeri_pobjedu() {
    for(var i = 0; i < 2; i++) { // provjeri retke
        if( check[i][0] === check[i][1] && check[i][1] === check[i][2] && check[i][0] !== '') {
            ispiši_pobjedu(check[i][0]);
        }
    }

    for(var j = 0; j < 2; j++) { // provjeri stupce
        if( check[0][j] === check[1][j] && check[1][j] === check[2][j] && check[0][j] !== '') {
            ispiši_pobjedu(check[0][j]);
        }
    }

    // glavna dijagonala
    if( check[0][0] === check[1][1] && check[1][1] === check[2][2] && check[0][0] !== '') {
        ispiši_pobjedu(check[0][0]);
    }

    // sporedna dijagonala
    if( check[0][2] === check[1][1] && check[1][1] === check[2][0] && check[0][2] !== '') {
        ispiši_pobjedu(check[0][2]);
    }
}

function ispiši_pobjedu( symbol ) {
    var player = choice ? 'o' : 'x';
    won = 1;

    if( symbol === player ) {
        $("#won").html('Čestitam, pobjeda!!!');
    } else {
        $("#won").html('Žao mi je, izgubili ste. :(');
    }
}

function resetiraj() {
    $("#won").html('');
    won = 0;
    positions_left = [0, 1, 2, 3, 4, 5, 6, 7, 8];
    check = [['', '', ''], ['', '', ''], ['', '', '']];

    pokreni_križić_kružić();
}