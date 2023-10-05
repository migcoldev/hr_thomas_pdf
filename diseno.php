<?php
// Logo 1
$path_logo_thomas = 'logo.png';
$path_logo_usil = 'usil.png';
$path_check = 'check-mark.png';
$path_graph = 'line-chart.png';

$html = '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      @page {
        margin: 0;
      }
      #contenedor_pdf{
        width:850px;
      }
      .page_break {
        page-break-before: always;
      }
      body {
        font-family: "Arial", "Helvetica", sans-serif;
        line-height: 1.1;
      }
      .header {
        background-color: #0c5393;
        color: #FFF;
        padding: 16px 24px;
      }
      .hero {
        text-align: center;
        padding: 12px 12px 16px;
      }
      .title-main {
        font-weight: bold;
        font-size: 24px;
        line-height: 1;
      }
      .name {
        line-height: 1;
        font-size: 20px;
        font-weight: normal;
      }
      .datos {
        line-height: 1;
        font-size: 16px;
        margin: 0;
      }
      .datos-span {
        font-weight: normal;
      }
      .table-header {
        width: 100%;
      }
      .title {
        color: #FFF;
        text-trasnform: uppercase;
        font-size: 16px;
        line-height: 1;
      }
      .title-content {
        background-color: #0c5393;
        padding: 3px 12px;
      }
      .subtitle {
        font-size:14px;
        font-weight: bold;
      }
      .subtitle-content {
        padding: 2px 12px;
        background-color: #eee;
        margin-bottom: 8px;
      }
      .subtitle-4 {
        font-weight: bold;
        margin-bottom: 0;
        line-height: 1;
      }
      .body {
        padding: 12px;
      }
      .table-1 {
        font-size: 13px;
        width: 100%;
        border-collapse: collapse;
      }
      .table-1 td {
        border: 1px solid #bbb;
      }
      .table-1_header {
        background-color: #0c5393;
        color: #FFF;
        font-weight: bold;
        text-align: center;
        padding: 12px 6px;
      }
      .table-1_aside, .table-1_basic {
        padding: 8px;
      }
      .table-1_aside {
        background-color: #0c5393;
        color: #FFF;
      }
      .table-1_level {
        text-align: center;
        width: 150px;
      }
      .definition-content {
        background-color: #eee;
        padding: 8px;
        margin-bottom: 24px;
      }
      .personality-content {
        background-color: #eee;
        padding: 20px;
        margin-bottom: 24px;
      }
      .table-definition_grid {
        width: 100%;
      }
      .definition-body {
        padding-left: 24px;
        padding-right: 24px;
      }
      .definition-col {
        display: flex;
        justify-content: center;
        flex-direction: column;
      }
      .definition-col_item {
        padding: 40px 24px;
      }
      .personality-icon {
        vertical-align: middle;
      }
      .personality-icon_text {
        vertical-align: middle;
        font-weight: bold;
      }
      .table-divisor {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
      }
      .table-divisor td {
        border: 1px solid #bbb;
        padding: 8px;
      }
      .table-divisor_left_header {
        width: 280px;
        text-align: center;
        font-weight: bold;
        background-color: #0c5393;
        color: #FFF;
      }
      .table-divisor_gap {
        width: 4px;
        border-bottom-color: transparent !important;
        border-top-color: transparent !important;
      }
      .table-divisor_right_header {
        text-align: center;
        font-weight: bold;
        background-color: #5aa432;
        color: #FFF;
      }
      .table-divisor_left_aside {
        font-weight: bold;
        background-color: #0c5393;
        color: #FFF;
      }
      .table-divisor_left_value {
        font-weight: bold;
        background-color: #5693cb;
        color: #FFF;
      }
      .table-divisor_right_aside {
      }
      .table-divisor_righ_value {

      }
      .graphics {
        background-color: #eee;
        padding: 20px;
      }
      .graphics-content {
        margin: 0 auto;
        width: 400px;
      }
      
    </style>
  </head>
  <body>
    <div id="contenedor_pdf">
      <div id="page-1" class="page-1 pdf-page">
        <div class="header">
          <table class="table-header">
            <tr>
              <td width="214">
                <img src="' . convert_to_64($path_logo_thomas) . '" />
              </td>
              <td></td>
              <td width="134">
                <img src="' . convert_to_64($path_logo_usil) . '" />
              </td>
            </tr>
          </table>
        </div>
        <div class="hero">
          <h1 class="title-main">Evaluación a Alumnos USIL</h1>
          <h2 class="name">Alejandro Arias</h2>
          <h3 class="datos facultad"><span class="datos-span">Facultad:</span> Xxxxxxxx Xxxxx</h3>
          <h3 class="datos carrera"><span class="datos-span">Carrera:</span> Xxxxxxxx Xxxxx</h3>
        </div>
        <div class="title-content">
          <h2 class="title">RESULTADOS GENERALES</h2>
        </div>
        <div class="body">
          <div class="subtitle-content">
            <h3 class="subtitle">Las competencias evaluadas serán calificadas entre el Nivel 1, Nivel 2 y Nivel 3, siendo este último el mayor nivel a obtener.</h3>
          </div>
          <table class="table-1">
            <tr>
              <td class="table-1_header">Competencias</td>
              <td class="table-1_header">Nivel obtenido</td>
              <td class="table-1_header">Definición</td>
            </tr>
            <tr>
              <td class="table-1_aside">Comunicación integral</td>
              <td class="table-1_basic table-1_level">Nivel 2</td>
              <td class="table-1_basic">Redacta textos con propiedad valorando su entorno y todo aquello relacionado a este con la finalidad de ser un crítico activo de los cambios, innovaciones y transformaciones a todo nivel.</td>
            </tr>
            <tr>
              <td class="table-1_aside">Comunicación Bilingüe</td>
              <td class="table-1_basic table-1_level">Nivel 1</td>
              <td class="table-1_basic">Comprende la importancia del inglés para sumar valor a su formación académica.</td>
            </tr>
            <tr>
              <td class="table-1_aside">Emprendimiento</td>
              <td class="table-1_basic table-1_level">Nivel 1</td>
              <td class="table-1_basic">Distingue escenarios a futuro en los que le gustaría ser parte para empezar a plantear su proyecto de vida.</td>
            </tr>
            <tr>
              <td class="table-1_aside">Investigación</td>
              <td class="table-1_basic table-1_level">Nivel 1</td>
              <td class="table-1_basic">Comprende el método científico para identificar las problemáticas de su entorno.</td>
            </tr>
            <tr>
              <td class="table-1_aside">Desarrollo Humano y Sostenible</td>
              <td class="table-1_basic table-1_level">Nivel 2</td>
              <td class="table-1_basic">Genera y participa de manera activa en acciones que impulsen su perfil académico - laboral.</td>
            </tr>
          </table>
          <div class="graphics">
            <div class="graphics-content">
              <canvas id="myChart" width="400" height="400"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div id="page-2" class="page-2 page_break pdf-page">
        <div class="title-content">
          <h2 class="title">COMUNICACIÓN INTEGRAL</h2>
        </div>
        <div class="body">
          <div class="subtitle-content">
            <h3 class="subtitle">Nivel Obtenido</h3>
          </div>
          <div class="definition-content">
            <div class="definition-header">
            </div>
            <div class="definition-body">
              <h4 class="subtitle-4">Definición:</h4>
              <p>Redacta textos con propiedad valorando su entorno y todo aquello relacionado a este con la finalidad de ser un crítico activo de los cambios, innovaciones y transformaciones a todo nivel.</p>
            </div>
          </div>
          <div class="subtitle-content">
            <h3 class="subtitle">Estilos conductuales y Rasgos de Personalidad Evaluados</h3>
          </div>
          <div class="personality-content">
            <table class="table-definition_grid">
              <tr>
                <td width="50%">
                  <div class="definition-col">
                    <div class="definition-col_item">
                      <img class="personality-icon" src="' . convert_to_64($path_check) . '" width="24" height="24" /> <span class="personality-icon_text">Fortalezas</span>
                    </div>
                    <div class="definition-col_item">
                      <img class="personality-icon" src="' . convert_to_64($path_graph) . '" width="24" height="24" /> <span class="personality-icon_text">Oportunidades de Mejora</span>
                    </div>
                  </div>
                </td>
                <td width="50%">
                  <div class="definition-graph_content">Gráfico aquí</div>
                </td>
              </tr>
            </table>
          </div>
          <div class="subtitle-content">
            <h3 class="subtitle">Perfil Ideal Comunicación Integral</h3>
          </div>
          <table class="table-divisor">
            <tr>
              <td class="table-divisor_left_header" colspan="2">Perfil Ideal</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_header" colspan="2">Resultado</td>
            </tr>
            <tr>
              <td class="table-divisor_left_aside" rowspan="2">
                Estilo Conductual<br> Prueba PPA
              </td>
              <td class="table-divisor_left_value">Alta Influencia</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Fortaleza</td>
              <td class="table-divisor_right_value">El gusto que tienes por la interacción con personas te facilitará en la generación de espacios de diálogo</td>
            </tr>
            <tr>
              <td class="table-divisor_left_value">Alta Estabilidad</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Fortaleza</td>
              <td class="table-divisor_right_value">El gusto que tienes por escuchar a otras personas, generará un impacto positivo y de apertura en tu audiencia</td>
            </tr>

            <tr>
              <td class="table-divisor_left_aside" rowspan="4">
                Inteligencia<br> Emocional<br> Prueba TEIQ
              </td>
              <td class="table-divisor_left_value">Alta Empatía</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Oportunidad de Mejora</td>
              <td class="table-divisor_right_value">
              Es importante valorar la posición de tu entorno cuando mostramos una posición crítica en todo nivel
              </td>
            </tr>
            <tr>
              <td class="table-divisor_left_value">Alta Adaptabilidad</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Oportunidad de Mejora</td>
              <td class="table-divisor_right_value">
              Es importante entender que pueden haber distintas percepciones e interpretaciones, sin la necesidad que tengamos que coincidir con las mismas
              </td>
            </tr>
            <tr>
              <td class="table-divisor_left_value">Alta Asertividad</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Fortaleza</td>
              <td class="table-divisor_right_value">
              Tu alta asertividad te ayudará a sostener tus ideas y pensamientos con claridad.
              </td>
            </tr>
            <tr>
              <td class="table-divisor_left_value">Alta Percepción emocional</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Oportunidad de Mejora</td>
              <td class="table-divisor_right_value">
              Es importante identificar y considerar las emociones de las personas en tu entorno cuando mostramos una posición crítica a todo nivel
              </td>
            </tr>

            <tr>
              <td class="table-divisor_left_aside" rowspan="2">
                Potencial para el<br> Liderazgo<br> Prueba HPTI
              </td>
              <td class="table-divisor_left_value">Autoexigencia Moderado</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Fortaleza</td>
              <td class="table-divisor_right_value">
              Tu autoexigencia moderada te ayudará a conocer y entender algunos detalles valorados por tu entorno
              </td>
            </tr>
            <tr>
              <td class="table-divisor_left_value">Curiosidad Moderado</td>
              <td class="table-divisor_gap"></td>
              <td class="table-divisor_right_aside">Fortaleza</td>
              <td class="table-divisor_right_value">
              Tu curiosidad moderada te ayudará a encontrar distintos medios de comunicación que puedan estar a tu alcance
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <script>
      var ctx = document.getElementById("myChart").getContext("2d");

      new Chart(ctx, {
        type: "pie",
        data: {
          labels: ["Nivel 1", "Nivel 2"],
          datasets: [{
            // label: "# of Votes",
            data: [67, 33],
            backgroundColor: ["#0d5393", "#00afaa"],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: false,
            }
          }
        }
      });
    </script>
  </body>
  </html>';

function convert_to_64($image)
{
  $type = pathinfo($image, PATHINFO_EXTENSION);
  $data = file_get_contents($image);
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
  return $base64;
}

echo $html;

//<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
?>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  

  window.jsPDF = window.jspdf.jsPDF;

  let doc_width = 5.4;
  //let doc_height = 8.27;
  let doc_height = 11.69;
  let aspect = doc_height / doc_width;
  let dpi = 120; // targeting ~1200 window width
  let img_width = doc_width * dpi;
  let img_height = doc_height * dpi;
  let win_width = img_width;
  let win_height = img_height;

  // https://html2canvas.hertzen.com/configuration
  let html2canvasOpts = {
    scale: img_width/win_width,   // equals 1
    width: img_width,
    height: img_height,
    windowWidth: win_width,
    windowHeight: win_height,
  };

  // https://rawgit.com/MrRio/jsPDF/master/docs/jsPDF.html
  let jsPDFOpts = {
    orientation: 'portrait',
    unit: 'in',
    format: 'A4'
  };

  /*setTimeout(function(){
    html2canvas(document.querySelector("#contenedor_pdf")).then(canvas => {
        var img = canvas.toDataURL("image/jpeg");
        var pdf = new jsPDF(jsPDFOpts);
        const imgProps= pdf.getImageProperties(img);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        var slides = document.getElementsByClassName("pdf-page");
        console.log(slides);
        var div_anterior = 0;
        for (var i = 0; i < slides.length; i++) {
          pdf.addPage('A4', 'portrait');
          pdf.addImage(img, 'PNG', 0, div_anterior, pdfWidth, pdfHeight);
          div_anterior = pdfHeight;
        }
        //pdf.addImage(img, 'PNG', 0, 1, doc_width+.16, doc_height); // no idea why the extra .16 is needed...
        pdf.save('reporte_candidato.pdf'); 
        document.getElementById("contenedor_pdf").style.display = 'none';
        setTimeout(function(){ 
              window.close();
        }, 500);
    });
  }, 500);*/

  setTimeout(function(){
    var pdf = new jsPDF(jsPDFOpts);
    var div_anterior = 0;
    var slides = document.getElementsByClassName("pdf-page");
    for (var i = 0; i < slides.length; i++) {
      var pdfWidth = pdf.internal.pageSize.getWidth();
      var pdfHeight = 0;
      console.log("SLIDE1 : "+i+" --- "+slides.length);
      html2canvas(document.querySelector("#"+slides[i].id)).then(canvas => {
          var img = canvas.toDataURL("image/jpeg");
          const imgProps= pdf.getImageProperties(img);
          pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
          document.getElementById("contenedor_pdf").style.display = 'none';
          pdf.addImage(img, 'PNG', 0, div_anterior, pdfWidth, pdfHeight);
          
          //if(i < slides.length){
            pdf.addPage('A4', 'portrait');
          //}
      });
      div_anterior = pdfHeight;
    }
    setTimeout(function(){ 
      pdf.save('reporte_candidato.pdf'); 
      window.close();
    }, 1000);
  }, 500);
</script>
