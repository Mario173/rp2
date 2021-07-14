var choice = 0, won = 0; // varijable koje prate koji je simbol igrač odabrao te je li pobjedio
var check = [['', '', ''], ['', '', ''], ['', '', '']]; // polje koje prati na kojem je mjestu koji simbol
var positions_left = [0, 1, 2, 3, 4, 5, 6, 7, 8]; // polje koje prati koja mjesta su već označena
var gameid = 4, broj_poteza;

// funkcija koja služi za pokretanje igre
function pokreni_križić_kružić() {


    game_id = 4;


    // odaberi simbol
    $("#middle").html('<h1 id="name_of_the_game"></h1>Koji simbol birate?' 
                    + '<br /><button id="x">X</button><button id="o">O</button>');

    $("#name_of_the_game").html('Križić-kružić');
    $("won").html('');

    napravi_review_div();

    var clicked = false;
    broj_poteza = 0;

    // ako je kliknut gumb X, igrač je odabrao x
    $("#x").on("click", function() {
        choice = 0;
        pokreni_križić_kružić_nastavi();
    });

    // ako je kliknut gumb O, igrač je odabrao o
    $("#o").on("click", function() {
        choice = 1;
        pokreni_križić_kružić_nastavi();
    });

}

function pokreni_križić_kružić_nastavi() {

    game_id = 4;

    $("#middle").html('<h1 id="name_of_the_game"></h1><canvas id="cnv"></canvas>' +
        '<br> <br><button id="again">Hoću sve ispočetka!</button><div id="game_id"></div><div id="won"></div></div>');
    
    $("#name_of_the_game").html('Križić-kružić');
    $("#won").html('');


    napravi_review_div();

    // možda biranje simbola prvo


    // funkcija koja služi za iscrtavanje ploče

    create_board();

    // funkcija koja se poziva na klik na canvas
    $("#cnv").on("click", klikNaPloči);

    // funkcija koja se poziva na klik na gumb Hoću sve ispočetka!
    $("#again").on("click", resetiraj);
}

// funkcija za iscrtavanje ploče na canvasu -> iscrta 3×3 grid
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

// funkcija koja se izvrši kada korisnik klikne na ploču
function klikNaPloči() {
    var canvas = $("#cnv").get(0);
    var ctx = canvas.getContext("2d");

    // izračunaj koordinate klika na canvasu
    var x = event.clientX - canvas.getBoundingClientRect().left;
    var y = event.clientY - canvas.getBoundingClientRect().top;

    // izračunaj u kojem se polju klik dogodio
    var koji_sirina = Math.floor((3 * x) / canvas.width);
    var koji_visina = Math.floor((3 * y) / canvas.height);

    if( positions_left.indexOf(3 * koji_sirina + koji_visina) !== -1 ) { // ako je to polje već popunjeno, nemoj ništa napraviti
        if( won === 0 ) { // ako je netko već pobjedio, nemoj ništa napraviti
            nacrtaj_simbol(koji_sirina, koji_visina, choice);
            provjeri_pobjedu();
        }

        if( won === 0 && positions_left.length !== 0 ) { // ako je netko već pobjedio ili su sva polja popunjena (izjednačeno), nemoj ništa napraviti
            // random generiraj idući potez
            var randomElement = positions_left[Math.floor(Math.random() * positions_left.length)];

            nacrtaj_simbol(Math.floor(randomElement / 3), randomElement % 3, 1 - choice);
            provjeri_pobjedu();
        }
    }

    if( positions_left.length === 0 && won === 0 ) { // ako su sva polja popunjena i nitko nije pobjedio, onda je izjednačeno
        $("#won").html('Izjednačeno');
    }
}

// funkcija za crtanje simbola u odabranom polju
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

    //ovo je moj dodatak da na neki nacin odredimo score, a ovdje je to preko broja poteza potrebnih za pobjedu
    broj_poteza++;

    ctx.stroke();
}

// funkcija koja provjereva je li itko pobjedio
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

// funkcija koja ispisuje tko je pobjedio
function ispiši_pobjedu( symbol ) {
    var player = choice ? 'o' : 'x';
    won = 1;

    let score = ( 6 - broj_poteza ) * 400;

    if( symbol === player ) {
        $("#won").html('Čestitam, pobjeda!!!');
    } else {
        $("#won").html('Žao mi je, izgubili ste. :(');
    }
    $.ajax({
        url: "/~marjamar/Projekt/index.php?rt=igre/obradiRezultate",
        type: "POST",
        // u igrac na pocetku spremamo id igraca dobiven preko ajaxa
        data: {
            game: gameid,
            score: score
        },
        // datatype: "json",
        success: function(data){
            console.log("Kriz - kruz: uspio ajax upit za postavljanje score u highscore ");
            console.log("data: "+ data + "data.type" + typeof(data) );
        },
        error: function(data){
            console.log("greska u slanju ajax pobjede: " + data);
        }
    });
}

// funkcija koja opet pokreće igru
function resetiraj() {
    $("#won").html('');
    won = 0;
    positions_left = [0, 1, 2, 3, 4, 5, 6, 7, 8];
    check = [['', '', ''], ['', '', ''], ['', '', '']];

    pokreni_križić_kružić();
}

function resetiraj() {
    $("#won").html('');

    pokreni_brodove();
}

