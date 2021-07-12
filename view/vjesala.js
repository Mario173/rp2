var score, rijec, tezina=2, duljinaRijeci, krivaSlova;

var easy_rijeci = ["MALO", "NETKO", "SUPER", "STOL", "DOBAR", "PAMET", "DVOBOJ", "LAPTOP", "SJEKIRA"];
var teze_rijeci = ["MATEMATIKA", "ZAMIŠLJENO", "PETEROSTRUKO", "KVALITETNO"];
var abeceda = "ABCČĆDĐEFGHIJKLMNOPRSŠTUVZŽ";

function pokreni_vješala()
{
    console.log(" usli smo u pokreni vjesala");
    // postavi početne gumbe da korisnik izabere tip igre
    // daj korisniku da izabere težinu igre
    $("#middle").html('<h1 id="name_of_the_game" ></h1>'
                        +'<canvas id="cnv" disabled></canvas>' + '<br>'
                        +'<div id="slova_za_birati" display="inline-block"></div>'
                        +'<input type="text", id="pokusaj">'
                        +'<button id="provjeri">Provjeri!</button>"'
                        +'<button id="again">Hoću sve ispočetka!</button>'
                        +'<div id="won"></div>'
                        +'<input type="radio id="težina" name="težina>');

    $("#name_of_the_game").html('Vješala');
    $("#won").html('');

    // težinu bismo htjeli dobiti preko radio buttona

    // odaberi riječ preko ajaxa, ali ovdje za pocetak cemo random inace mozda napraviti fju za to tipa init rijec
    if( tezina === 1 )
    {
        // zelim neki nasumicni broj izmedu 0 i 9
        let i = Math.floor( Math.random() * 9 );
        rijec = easy_rijeci[i];
        duljinaRijeci = rijec.length;
    }
    else if( tezina === 2 || tezina === 3 )
    {
        // zelim neki nasumicni broj izmedu 0 i 9
        let i = Math.floor( Math.random() * 4 );
        rijec = easy_rijeci[i];
        duljinaRijeci = rijec.length;
    }

    score = 0; krivaSlova = 0;
    initCanvas();
    initIzbor();

    console.log('inicijalizirali smo');
    $("#provjeri").attr('disabled', false);
    $('#slovo').attr('disabled', false);
    $("#provjeri").on('click', provjeriRijec );
    $('.slovo').on('click', obradiSlovo );
    $("#again").on('click', pokreni_vješala  );
    
}

function obradiSlovo()
{
    let canvas = $("#cnv").get(0);
    let ctx = canvas.getContext('2d');
    console.log('OBRADI SLOVO');
    let slovo = $(this).val();
    $(this).attr("disabled", true);
    let ind = rijec.indexOf(slovo)
    console.log("u rijeci: '"+rijec+"' SLOVO: "+slovo+' je na indeksu: '+ind);
    // ctx.strokeText(slovo, 10, 10);
    if( ind < 0 )
    {
        // slova nema u rijeci
        krivaSlova++;
        crtajVjesalo();
        score -= 100;
    }
    else
    {
        score += 200;
        crtajSlovo(slovo);
    }
    if( krivaSlova === 7 )
        gameOver();
}

function crtajSlovo( char )
{
    console.log('CRTAJ SLOVO');
    let x = 10, y = 30;
    let canvas = $("#cnv").get(0);
    let ctx = canvas.getContext('2d');
    let def = ctx.font;
    ctx.font = "green 20px Ariel";
    // sada idemo kroz riječ i ako je na tom mjestu u riječi slovo napiši ga na canvas
    for( let j = 0; j < duljinaRijeci; j++ )
    {
        x += 20;
        if( rijec[j] === char )
            ctx.strokeText( char, x+2, y-2);
    }
    ctx.font = def;
}

function crtajVjesalo()
{
    console.log('CRTAJ VJESALO');
    let canvas = $("#cnv").get(0);
    let ctx = canvas.getContext('2d');
    switch (krivaSlova) {
        case 1:
            // crtamo stup
            ctx.beginPath();
            ctx.moveTo(20, 280);
            ctx.lineTo(20, 80);
            ctx.stroke();
            break;
        case 2:
            // greda
            ctx.beginPath(); ctx.moveTo(20,80);
            ctx.lineTo(50,80); ctx.stroke();
            break;
        case 3:
            // uže
            ctx.beginPath(); ctx.moveTo(50,80);
            ctx.lineTo(50,100); ctx.stroke();
            break;
        case 4:
            // glava
            ctx.beginPath(); ctx.arc(50, 105, 5, 0, 2*Math.PI );
            ctx.stroke();
            break;
        case 5:
            // tijelo
            ctx.beginPath(); ctx.moveTo(50,110);
            ctx.lineTo(50,130); ctx.stroke();
            break;
        case 6:
            // noge
            ctx.beginPath(); ctx.moveTo(50,130);
            ctx.lineTo(30,170); ctx.stroke();
            ctx.beginPath(); ctx.moveTo(50,130);
            ctx.lineTo(60,170); ctx.stroke();
            break;
        case 7:
            // ruke
            ctx.beginPath(); ctx.moveTo(50,113);
            ctx.lineTo(40,135); ctx.stroke();
            ctx.beginPath(); ctx.moveTo(50,113);
            ctx.lineTo(60,135); ctx.stroke();
            break;
    }
}

function provjeriRijec()
{
    
    // ono što je napisano u textu 
    let pokusaj = $('#pokusaj').val();
    pokusaj = pokusaj.toUpperCase();
    console.log('PROVJERI RIJEC '+pokusaj);
    if( pokusaj === rijec )
    {
        // bravo pogodio si riječ!
        console.log("rijec je pogodena");
        score += 1000*tezina;
        pobjeda();
    }
    else
    {
        console.log("fulao si rijec");
        // smanji score za vecu tezinu manje opadne
        score -= 300*(1/tezina);
    }
}

function initIzbor()
{
    let contents = '<div display="inline-block" height="500" width="200">'
    for( let i = 0; i < 3; i++ )
    {
        // 3 stupca
        let stupac = '<div display="inline-block" height="450" width="60">'
        for( j = 0; j < 9; j++ )
        {
            // svako slovo
            slovo_checkbox = '<input type="checkbox" class="slovo" id="slovo"'+i*9+j+' display="inline-block" height="20" width="50" value="'+abeceda[i*9+j]+'">'+abeceda[i*9+j];
            stupac += slovo_checkbox;
            // console.log("radimo slova"+abeceda[i*9+j]);
            
        }
        stupac += '</div>';
        contents += stupac;
    }
    contents += '</div>'
    $("#slova_za_birati").html(contents);
    /*
    let wrap = $("#slova_za_birati");
     $("#slova_za_birati").prop("width",200).prop("height",500);
    let stupac1=$('<span id="stupac" >'), stupac2=$('<span id="stupac" >'), stupac3=$('<span id="stupac">');
    $("#stupac").prop('width',100);$("#stupac").prop('height',400); $("stupac").css("display", "inline_block");
    // sada u wrap treba napraviti checkbox za svako slovo - mislio sam ih poslagati u 3 stupca
    for( j = 0; j < abeceda.length; j++ )
    {
        let char = abeceda[j];
        let novo = '<input type="checkbox" height="20" width="50" display="inline-block" id="slovo" value="'+char+' >' +char;
        // ako igramo na najtežem ne smiju se izabrati samoglasnici
        if( tezina === 3 && ( char==='A' || char==='E' || char==='I' || char ==='O' || char==='U' ) )
        {
            novo.attr('disabled', true);
        }
        switch (j%3) {
            case 0:
                stupac1.append(novo);
                break;
            case 1:
                stupac2.append(novo);
                break;
            case 2:
                stupac3.append(novo);
                break;
        }
        $("#slova_za_birati").append(novo);
    }
    $("#slova_za_birati").html(stupac1+stupac2+stupac3);
    */
}

function initCanvas()
{
    console.log('CRTAMO pocetno platno');
    $("#cnv").attr('disabled', false);
    let ctx = $("#cnv").get(0)
    let canvas = ctx.getContext("2d");
    //nacrtaj background
    canvas.fillStyle = "cyan";
    canvas.fillRect(0,0,400,200);
    canvas.fillStyle = "brown";
    canvas.fillRect(0,300,400,100);
    let x = 30, y = 30;
    // canvas.moveTo(x,y);
    canvas.strokeStyle = "black";
    console.log("duljina rijeci je : "+ duljinaRijeci );
    // postavi crtice za slova rijči koja se pogađa
    for( let i = 0; i < duljinaRijeci; i++ )
    {
        // stavi 2px prazno lijevo i kasnije desno radi razmaka među crticama za riječi
        // također crtica je 26px jer nam je najduža riječ 12 slova pa da se može za bilo koju iscrtati
        x+=2;
        canvas.beginPath();
        canvas.moveTo(x,y);        
        x+=16;
        canvas.lineTo(x,y);
        canvas.stroke();
        x+=2;
        canvas.moveTo(x,y);
        console.log("Radimo crtice za slova u rijeci");
    }
    canvas.fillStyle = "black";
}

function pobjeda()
{
    // ispiši na canvasu pobjeda, pogledaj score i ovisno o tome ga treba spremati
    let ctx = $("#cnv").get(0).getContext('2d');
    ctx.fillStyle = "white";
    ctx.fillRect(0,0,400,300);
    ctx.strokeStyle = "red";
    ctx.fillText = "yellow"
    ctx.font = "bold 40px Verdana"; ctx.textAlign = "centre";
    ctx.strokeText("POBJEDA!!!", 80, 80, 150);
    ctx.strokeStyle = "black";
    ctx.strokeText("SCORE: "+score, 120, 130, 150);
}

function gameOver()
{
    // želimo ispisati koja je riječ bila i napisati velikim slovima game over
    // također ću disablati unos riječi, provjeru i slova
    $("#provjeri").attr('disabled', true); $(".slovo").attr('disabled', true);
    let ctx = $("#cnv").get(0).getContext('2d');
    ctx.fillStyle = "red"; ctx.fillRect(0,0,300,300);
    ctx.fillStyle = "red"; ctx.font = "bold 80px Verdana"; ctx.textAlign = "left";
    ctx.fillRect(50,50,200,50); ctx.strokeText('Game Over', 80, 80, 200 )
}

