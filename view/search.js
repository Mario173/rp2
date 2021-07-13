

function suggest_names(){
    var txt = $( "#search_textbox" );

    // Kad netko nešto tipka u text-box:
    txt.on( "input", function(e)
    {
        var unos = $( this ).val(); // this = HTML element input, $(this) = jQuery objekt

        console.log("poziva se ovo");

        // Napravi Ajax poziv sa GET i dobij sva imena koja sadrže s kao podstring
        $.ajax(
        {   
            type: "POST",
            url: "/~marjamar/Projekt/index.php?rt=search/search_help",
            data:
            {
                q: unos
            },
            success: function( data )
            {
                // Jednostavno sve što dobiješ od servera stavi u dataset.
                console.log(data);
                $( "#datalist_imena" ).html( data );
            },
            error: function( xhr, status )
            {
                if( status !== null )
                    console.log( "Greška prilikom Ajax poziva: " + status );
            }
        } );

        /*$.ajax({
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

    } );

    */
    }
    
    );
}