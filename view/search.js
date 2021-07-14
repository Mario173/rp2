

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
            url: document.location.pathname + "?rt=search/search_help",
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
    }
    
    );
}