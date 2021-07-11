var igre = ['Potapanje_brodova', 'Memory', 'Vješala', 'Križić-kružić'];
var highscore = [];
highscore['Potapanje_brodova'] = ['User1', 147, 'User2', 144, 'User3', 133]; // inače ćemo povlačit iz baze
highscore['Memory'] = ['User2', 104, 'User6', 99, 'User1', 80];
highscore['Vješala'] = ['User1', 100, 'User6', 92, 'User1', 81];
highscore['Križić-kružić'] = ['User2', 112, 'User2', 105, 'User1', 80];

var avatari = ['view/avatar.webp', 'view/avatar2.jpg', 'view/icon.png'], curr_avatar = 0, num_of_avatars = 3; // za avatare

var start = 'Potapanje_brodova'; // koja igra je početna, nije baš ni bitno

function iscrtaj_lijevo() {
    var contents = '';
    for(var i = 0; i < igre.length; i++) {
        if( i === 0 ) {
            contents += ('<div class="naslovi" id="' + igre[i] + '"><h2>Potapanje brodova</h2></div>');
        } else {
            contents += ('<div class="naslovi" id="' + igre[i] + '"><h2>' + igre[i] + '</h2></div>');
        }
    }
    $("#games").html(contents);

    switch(start) {
        case 'Potapanje_brodova':
            pokreni_brodove();
            break;
        case 'Memory':
            pokreni_memory();
            break;
        case 'Vješala':
            pokreni_vješala();
            break;
        case 'Križić-kružić':
            pokreni_križić_kružić();
            break;
    };

    iscrtaj_highscore(start);

    $(".naslovi").mouseenter( function() {
        $(this).css("background-color", "lightsteelblue");
        $(this).css("color", "black");
        $(this).css("cursor", "pointer");
    });

    $(".naslovi").mouseleave( function() {
        $(this).css("background-color", "midnightblue");
        $(this).css("color", "white");
        $(this).css("cursor", "normal");
    });

    $("nav>ul>li").mouseenter( function() {
        $(this).css("background-color", "lightsteelblue");
        $(this).children().css("color", "black");
    });

    $("nav>ul>li").mouseleave( function() {
        $(this).css("background-color", "#1A1A2E");
        $(this).children().css("color", "#E94560");
    });

    $("#avatar").on("click", function() {
        curr_avatar = (curr_avatar + 1) % num_of_avatars;
        $("#avatar").attr('src', avatari[curr_avatar]); 
    });

    $("#Potapanje_brodova").on("click", function() {
        pokreni_brodove();
        iscrtaj_highscore('Potapanje_brodova');
    });

    $("#Memory").on("click", function() {
        pokreni_memory();
        iscrtaj_highscore('Memory');
    });

    $("#Vješala").on("#click", function() {
        pokreni_vješala();
        iscrtaj_highscore('Vješala');
    });

    $("#Križić-kružić").on("click", function() {
        pokreni_križić_kružić();
        iscrtaj_highscore('Križić-kružić');
    });
}

function iscrtaj_highscore(koji) {
    let contents = '';
    for(var i = 0; i < highscore[koji].length; i += 2) {
        contents += ('<tr><td class="cell_high">' + highscore[koji][i] + '</td><td class="cell_high">' + highscore[koji][i + 1] + '</td><tr>');
    }
    $("#tablica_highscore").html(contents);
}