<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<div class="container flex flex-col justify-center mt-3 w-auto">

  <div class="other-Container flex-col justify-center self-center items-center">

  <div class="stats1 pl-12 grid grid-cols-2 grid-rows-2 w-[300px] lg:w-[800px] lg:grid-cols-4 lg:grid-rows-1">
  <span class="text-lg text-center font-extrabold w-2/4 lg:text-2xl"><img class="self-center" src="src/vita.png"><p id="vita"> 100/100</p> </span>
  <span class="text-lg text-center font-extrabold w-2/4 lg:text-2xl"><img class="self-center" src="src/fame.png"> <p id="fame"> 100/100</p></span>
  <span class="text-lg text-center font-extrabold w-2/4 lg:text-2xl"><img class="self-center" src="src/energia.png"> <p id="energia"> 100/100</p></span>
  <span class="text-lg text-center font-extrabold w-2/4 lg:text-2xl"><img class="self-center" src="src/divertimento.png"><p id="divertimento"> 100/100</p> </span>
  </div>
    <div id="sfondo" class="screen w-[300px] h-[280px] border-4 flex bg-no-repeat bg-cover lg:w-[800px] lg:h-[700px]">

    <img id="imgAnimaletto" src="./src/pipistrello_idle.png" alt="egg" class="w-[100px] ml-[30px] h-auto self-center lg:w-[200px] lg:h-auto lg:ml-[300px] cursor-grab" onmouseover="startPetting();" onmouseleave="stopPetting();">
    </div>
    <div class="bottoni flex flex-col w-full">
    <div class="gruppo bottoni 1 flex flex-row justify-center items-center space-x-1">
    <input id="eat" type="button" value="Mangia" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-extrabold rounded w-[50%] h-[60px]">
    <input id="sleep" type="button" value="Dormi" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-extrabold rounded w-[50%] h-[60px]">
    </div>
  <!--<div class="gruppo bottoni 2 flex flex-row justify-center items-center mt-2 space-x-1">
    <input id="accarezza" type="button" value="Accarezza" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-extrabold rounded w-[50%] h-[60px]">
    <input type="button" value="Gioca" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-extrabold rounded w-[50%] h-[60px]">
    <div class="flex flex-row justify-center items-center">
  </div>  -->
  </div>
  
</div>
</div>
</div>



</body>
</html>


<script>

let petting;
let tipo_animale;
  $(document).ready(function() {
    
    eseguiAzione('start'); //per far aggiornare all'avvio della pagina i valori
    $('#eat').click(function() {
        eseguiAzione('eat');
    });

    $('#sleep').click(function() {
        eseguiAzione('sleep');
    });

    $('#accarezza').click(function() {
        eseguiAzione('accarezza');
    });
  });
    // Funzione per eseguire un'azione e aggiornare lo stato dell'animale
    function eseguiAzione(azione) {
        $.ajax({
            url: 'azione.php',
            type: 'POST',
            data: { action: azione },
            success: function(response) {
                console.log(response);
                aggiornaStato(response);
                if(azione=='eat'||azione=='sleep'){
                console.log("mangio");
                $('#imgAnimaletto').attr('src', 'src/' + tipo_animale + '_' + azione + '.png');
                setTimeout(function() {
                $('#imgAnimaletto').attr('src', 'src/' + tipo_animale + '_' + "idle" + '.png');
                }, 2000);}
                else if(azione=="accarezza"|| azione=="dead"){
                  $('#imgAnimaletto').attr('src', 'src/' + tipo_animale + '_' + azione + '.png');
                } else if(azione!="decrease"){
                   $('#imgAnimaletto').attr('src', 'src/' + tipo_animale + '_' + "idle" + '.png');
                }
            }
        });
    }
    
   
    //funzione per accarezzare l'animaletto
    function startPetting() {
      petting=setInterval(()=>eseguiAzione("accarezza"), 300);
      console.log('Mouse entrato nell\'immagine, accarezzando...');
    }


    function stopPetting() {
    console.log('Mouse uscito dall\'immagine, smetti di accarezzare');
    clearInterval(petting); // Interrompi l'accarezzamento quando il mouse esce dall'immagine
    $('#imgAnimaletto').attr('src', 'src/' + tipo_animale + '_' + "idle" + '.png');
  }

     // Funzione per aggiornare lo stato dell'animale nella pagina HTML
     function aggiornaStato(animale) {
      var sfondoElement=document.getElementById("sfondo");
      console.log("prima del parse: "+animale);
      animale=JSON.parse(animale);
      tipo_animale=animale.tipo;
      console.log(animale.imgBackground)
      sfondoElement.style.backgroundImage=`url("${animale.imgBackground}")`;
        $('#fame').text(animale.fame+"/100");
        $('#divertimento').text(animale.divertimento+"/100");
        $('#energia').text(animale.energia+"/100");
        $('#vita').text(animale.vita+"/100");
        console.log(animale.tipo);
        if(animale.tipo=="volpe"){
          $('#imgAnimaletto').attr('class', "w-[100px] ml-[100px] mt-[200px] h-auto self-center cursor-grab lg:w-[200px] lg:h-auto lg:ml-[300px] lg:mt-[500px]");
        }
        if(animale.vita<=0){
          $('#imgAnimaletto').attr('src', 'src/' + animale.tipo + '_' + "dead" + '.png');
          alert("Ti sei preso poco cura del tuo animaletto e purtroppo ora è troppo tardi!");
          $.ajax({
            url: 'azione.php',
            type: 'POST',
            data: { action: "dead" },
            success: window.location.href="lobby.html"
        });
        }

     }
     setInterval(function() {
      eseguiAzione('decrease');
    }, 5000); // Controlla lo stato ogni 5 secondi

    setInterval(function() {
        $.ajax({
            url: 'azione.php',
            type: 'POST',
            data: { action: 'save' },
            success: function(response) {
             console.log("response "+response);
            }
        });
    }, 5000);
</script>