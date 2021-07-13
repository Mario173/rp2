var igre = ['Potapanje_brodova', 'Memory', 'Vješala', 'Križić-kružić'];
var highscore = [];
highscore['Potapanje_brodova'] = ['User1', 147, 'User2', 144, 'User3', 133]; // inače ćemo povlačit iz baze
highscore['Memory'] = ['User2', 104, 'User6', 99, 'User1', 80];
highscore['Vješala'] = ['User1', 100, 'User6', 92, 'User1', 81];
highscore['Križić-kružić'] = ['User2', 112, 'User2', 105, 'User1', 80];
var game_id;
var reviews_data;

var avatari = ['view/avatar.webp', 'view/avatar2.jpg', 'view/icon.png'], curr_avatar = 0, num_of_avatars = 3; // za avatare

var start = 'Potapanje_brodova'; // koja igra je početna, nije baš ni bitno

function iscrtaj_gore() {

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

}


function iscrtaj_lijevo() {

    console.log("Ovo trazis " +document.location.pathname);

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

    iscrtaj_highscore(1);
    iscrtaj_reviews(1);

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

    $("#Potapanje_brodova").on("click", function() {
        pokreni_brodove();
        iscrtaj_highscore(1);
        iscrtaj_reviews(1);
    });

    $("#Memory").on("click", function() {
        pokreni_memory();
        iscrtaj_highscore(2);
        iscrtaj_reviews(2);
    });

    $("#Vješala").on("click", function() {
        pokreni_vješala();
        iscrtaj_highscore(3);
        iscrtaj_reviews(3);
    });

    $("#Križić-kružić").on("click", function() {
        pokreni_križić_kružić();
        iscrtaj_highscore(4);
        iscrtaj_reviews(4);
    });
}

function iscrtaj_highscore(koji) {

    $.ajax(
        {   
            type: "POST",
            url: "/~zecicmar/igre/igre/index.php?rt=igre/get_highscores",
            data:
            {
                id_game: koji,
                
            },
            success: function( data )
            {
                // Jednostavno sve što dobiješ od servera stavi u dataset.
                //console.log(data);
                //console.log("uspjesan review");
                reviews_data = data.array;
                let contents = '';
                for(var i = 0; i < reviews_data.length; i += 1) {
                    contents += ('<tr><td class="cell_high">' + reviews_data[i][0] + '</td><td class="cell_high">' + reviews_data[i][1] + '</td><tr>');
                }
                $("#tablica_highscore").html(contents);
                //$( "#datalist_imena" ).html( data );
            },
            error: function( xhr, status )
            {
                if( status !== null )
                    console.log( "Greška prilikom Ajax poziva: " + status );
            }
        } );
}

function iscrtaj_reviews(koji){
    $.ajax(
        {   
            type: "POST",
            url: "/~zecicmar/igre/igre/index.php?rt=igre/get_reviews",
            data:
            {
                id_game: koji,
                
            },
            success: function( data )
            {
                // Jednostavno sve što dobiješ od servera stavi u dataset.
                //console.log(data);
                //console.log("uspjesan review");
                reviews_data = data.array;
                let contents = '';
                for(var i = 0; i < reviews_data.length; i += 1) {
                    contents += ('<tr><td class="cell_review">' + reviews_data[i][0] + '</td><td class="cell_review">' + reviews_data[i][1] + '</td><td class="cell_review">' + reviews_data[i][2] + '</td><tr>');
                }
                $("#tablica_reviews").html(contents);
                //$( "#datalist_imena" ).html( data );
            },
            error: function( xhr, status )
            {
                if( status !== null )
                    console.log( "Greška prilikom Ajax poziva: " + status );
            }
        } );

}

function sendReview(){
    let rating = $("#rating").val();
    let comment = $("#comment").val();
    if( rating >= 1 && rating <= 5){
        $.ajax(
            {   
                type: "POST",
                url: "/~zecicmar/igre/igre/index.php?rt=igre/review_game",
                data:
                {
                    id_game: game_id,
                    rating: rating,
                    comment: comment
                    
                },
                success: function( data )
                {
                    // Jednostavno sve što dobiješ od servera stavi u dataset.
                    console.log(data);
                    console.log("uspjesan review");
                    //$( "#datalist_imena" ).html( data );
                },
                error: function( xhr, status )
                {
                    if( status !== null )
                        console.log( "Greška prilikom Ajax poziva: " + status );
                }
            } );
    }
}

function napravi_review_div(){
    let review_div = $("<div id = ship_review_div></div>");

    review_div.html(
    "<h2>Ocjenite igru</h2><select name=\"rating\" id=\"rating\"><option selected=\"selected\" disabled=\"disabled\">" +
    "Please select...</option>" +
    "<option value=\"1\">1</option>" +
    "<option value=\"2\">2</option>" +
    "<option value=\"3\">3</option>" +
    "<option value=\"4\">4</option>" +
    "<option value=\"5\">5</option></select>" +
    "<br><br>" +
    "<textarea name=\"comment\" id=\"comment\" rows=\"4\" cols=\"40\"></textarea>" + 
    "<br><br>" +
    "<input type=\"submit\" id = \"reviewButton\" name=\"btnSubmit\" value= \"Ocjeni!\"/>"
    );

    $("#middle").append(review_div);

    $("#reviewButton").on("click", sendReview);
}

