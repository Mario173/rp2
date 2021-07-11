var choice = 1;

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

    ctx.moveTo(canvas.getBoundingClientRect().width / 3, 0);
    ctx.lineTo(canvas.getBoundingClientRect().width / 3, canvas.getBoundingClientRect().height);
    ctx.moveTo(2 * canvas.getBoundingClientRect().width / 3, canvas.getBoundingClientRect().height);
    ctx.lineTo(2 * canvas.getBoundingClientRect().width / 3, 0);
    ctx.moveTo(0, canvas.getBoundingClientRect().height / 3);
    ctx.lineTo(canvas.getBoundingClientRect().width, canvas.getBoundingClientRect().height / 3);
    ctx.moveTo(canvas.getBoundingClientRect().width, 2 * canvas.getBoundingClientRect().height / 3);
    ctx.lineTo(0, 2 * canvas.getBoundingClientRect().height / 3);

    ctx.stroke();
}

function klikNaPloči() {
    var canvas = $("#cnv").get(0);
    var ctx = canvas.getContext("2d");

    var x = event.clientX - canvas.getBoundingClientRect().left;
    var y = event.clientY - canvas.getBoundingClientRect().top;

    var koji_sirina = Math.floor((3 * x) / canvas.getBoundingClientRect().width);
    var koji_visina = Math.floor((3 * y) / canvas.getBoundingClientRect().height);

    if( choice === 0 ) { // crtamo x
        ctx.moveTo(koji_sirina * canvas.getBoundingClientRect().width / 3 + 20, koji_visina * canvas.getBoundingClientRect().height / 3 + 20);
        ctx.lineTo((koji_sirina + 1) * canvas.getBoundingClientRect().width / 3 - 20, (koji_visina + 1) * canvas.getBoundingClientRect().height / 3 - 20);
        ctx.moveTo((koji_sirina + 1) * canvas.getBoundingClientRect().width / 3 - 20, koji_visina * canvas.getBoundingClientRect().height / 3 + 20);
        ctx.lineTo(koji_sirina * canvas.getBoundingClientRect().width / 3 + 20, (koji_visina + 1) * canvas.getBoundingClientRect().height / 3 - 20);
    } else { // crtamo krug
        var center_x = (koji_sirina + 0.5) * canvas.getBoundingClientRect().width / 3;
        var center_y = (koji_visina + 0.5) * canvas.getBoundingClientRect().height / 3;
        var radius = Math.min(canvas.getBoundingClientRect().width, canvas.getBoundingClientRect().height) / 5 - 20;

        ctx.moveTo(center_x + radius, center_y);

        ctx.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    }

    ctx.stroke();
}

function resetiraj() {
    $("#won").html('');

    pokreni_križić_kružić();
}