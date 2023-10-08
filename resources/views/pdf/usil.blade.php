@include('layouts.headerPDF')
          <div class="row">
            <div class="col-md-12">
              <div style="text-align:center; padding: 20px;">
                <button class="btn btn-primary" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status">Generando PDF...</span>
                </button>
              </div>
    <div id="contenedor_pdf">
      <div id="page-1" class="page-1 pdf-page">
        <div class="header-pdf">
          <table class="table-header">
            <tr>
              <td width="214">
                <img src="<?php echo url('/img/logo.png'); ?>" />
              </td>
              <td></td>
              <td width="134">
                <img src="<?php echo url('/img/usil.png'); ?>" />
              </td>
            </tr>
          </table>
        </div>
        <div class="hero">
          <h1 class="title-main">Evaluación a Alumnos USIL</h1>
          <h2 class="name">{{ $report["candidato"] }}</h2>
          <h3 class="datos facultad"><span class="datos-span">Facultad:</span> {{ $report["facultad"] }}</h3>
          <h3 class="datos carrera"><span class="datos-span">Carrera:</span> {{ $report["carrera"] }}</h3>
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
            @foreach ($report["resultados_generales"] as $competencia)
            <tr>
              <td class="table-1_aside">{{ $competencia["competencia"] }}</td>
              <td class="table-1_basic table-1_level">{{ $competencia["nivel"] }}</td>
              <td class="table-1_basic">{{ $competencia["definicion"] }}</td>
            </tr>
            @endforeach
          </table>
          <div class="graphics">
            <div class="graphics-content">
              <canvas id="myChart" width="350" height="350"></canvas>
            </div>
          </div>
        </div>
      </div>
      @foreach ($report["perfil_ideal"] as $key=>$perfil_ideal_competencia)
      <div id="page-{{$index}}" class="page-{{$index}} page_break pdf-page">
        <div class="title-content">
          <h2 class="title">{{$key}}</h2>
        </div>
        <div class="body">
          <div class="subtitle-content">
            <h3 class="subtitle">Nivel Obtenido</h3>
          </div>
          <div class="definition-content">
            <div class="definition-header">
                
                <div class="graphics-content-2">
                        <canvas id="myChart2-{{$index}}" width="150" height="150"></canvas>
                    </div>
            </div>
            <div class="definition-body">
              <h4 class="subtitle-4">Definición:</h4>
              <p class="parrafo-4">{{$report["resultados_generales"][$key]["definicion"]}}</p>
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
                      <img class="personality-icon" src="<?php echo url('/img/check-mark.png'); ?>" width="24" height="24" /> <span class="personality-icon_text">Fortalezas</span>
                      <ul class="ul_little">
                        @foreach ($grafica2[$key]["lista_fortalezas"] as $fortaleza)
                        <li> {{$fortaleza}}</li>
                        @endforeach
                      </ul>
                    </li>
                    </div>
                    <div class="definition-col_item">
                      <img class="personality-icon" src="<?php echo url('/img/line-chart.png'); ?>" width="24" height="24" /> <span class="personality-icon_text">Oportunidades de Mejora</span>
                      <ul class="ul_little">
                        @foreach ($grafica2[$key]["lista_oportunidades"] as $oportunidad)
                        <li> {{$oportunidad}}</li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </td>
                <td width="50%">
                  <div class="definition-graph_content">
                    <div class="graphics-content-3">
                        <canvas id="myChart3-{{$index}}" width="200" height="200"></canvas>
                    </div>
                  </div>
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
            <!--<tr>
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
            </tr>-->
            <?php $last_evaluacion = ""; ?>
            @foreach ($perfil_ideal_competencia as $perfil_ideal)
              @foreach ($perfil_ideal as $evaluacionObj)
              <tr>
                @if ($evaluacionObj["evaluacion"] != $last_evaluacion)
                <td class="table-divisor_left_aside" rowspan="{{count($perfil_ideal)}}">
                  {{ $evaluacionObj["evaluacion"] }}
                </td>
                @endif
                <td class="table-divisor_left_value">{{ $evaluacionObj["rasgo"] }}</td>
                <td class="table-divisor_gap"></td>
                <td class="table-divisor_right_aside">{{ $evaluacionObj["resultado"] }}</td>
                <td class="table-divisor_right_value">{{ $evaluacionObj["detalle"] }}</td>
              </tr>
              <?php $last_evaluacion = $evaluacionObj["evaluacion"]; ?>
              @endforeach
            @endforeach
          </table>
        </div>
      </div>
      <?php $index = $index + 1; ?>
      @endforeach
    </div>

    <style>
      @page {
        margin: 0;
      }
      h2, h3, h4{
        margin-top:0.2rem;
        margin-bottom:0.2rem;
      }
      #contenedor_pdf{
        width:850px !important;
        min-width:850px;
        margin: auto;
      }
      .page_break {
        page-break-before: always;
      }
      .header-pdf {
        background-color: #0c5393;
        color: #FFF;
        padding: 16px 24px;
      }
      .hero {
        text-align: center;
        padding: 11px 12px 16px;
      }
      .ul_little{
        font-size:9px;
        columns: 2;
        margin:0px;
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
        font-size:1.1rem;
      }
      .parrafo-4 {
        font-size:13px;
      }
      .body {
        padding: 12px;
      }
      .table-1 {
        font-size: 12px;
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
        max-width: 200px;
      }
      .table-1_level {
        text-align: center;
      }
      .table-1_levelBK {
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
        padding: 10px 24px;
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
        font-size: 11px;
      }
      .table-divisor td {
        border: 1px solid #bbb;
        padding: 4px;
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
        width: 300px;
      }
      .graphics-content-2 {
        margin: 0 auto;
        width: 200px;
      }
      .graphics-content-3 {
        margin: 0 auto;
        width: 200px;
      }
      
    </style>
    <script>
      $( document ).ready(function() {
          
        var ctxPie = document.getElementById("myChart").getContext("2d", { willReadFrequently: true });
        new Chart(ctxPie, {
          type: "pie",
          data: {
            @if ($count_grafica1 === 1)
            labels: ["NIVEL 1"],
            @elseif ($count_grafica1 === 2)
            labels: ["NIVEL 1", "NIVEL 2"],
            @elseif ($count_grafica1 === 3)
            labels: ["NIVEL 1", "NIVEL 2", "NIVEL 3"],
            @endif
            datasets: [{
              // label: "# of Votes",
              data: [{{implode(", ", $grafica1)}}],
              @if ($count_grafica1 === 1)
              backgroundColor: ["#0d5393"],
              @elseif ($count_grafica1 === 2)
              backgroundColor: ["#0d5393", "#00afaa"],
              @elseif ($count_grafica1 === 3)
              backgroundColor: ["#0d5393", "#00afaa", "#5693cb"],
              @endif
              borderWidth: 0
            }]
          },
          plugins: [ChartDataLabels],
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: "top",
              },
              labels: {
                  render: 'percentage',
                  fontColor: ['green', 'white', 'red'],
                  precision: 3
              },
              datalabels: {
                color: 'white',
                textAlign: 'center',
                font: {
                  weight: 'bold',
                  size: 16,
                },
                formatter: function(value, ctx) {
                  var index = ctx.dataIndex;
                  var label = ctx.chart.data.labels[index];
                  //return label + '\n' + value;
                  return label + '\n' + value +'%';
                }
              }
            }
          }
        });

        
        @foreach ($report["perfil_ideal"] as $key=>$perfil_ideal_competencia)
        
          var circuference = 180; // deg
          var bgColor = ["#0d5393", "#00afaa", "#5693cb"];
            /*if('{{$report["resultados_generales"][$key]["nivel"]}}' == 1 || '{{$report["resultados_generales"][$key]["nivel"]}}' == '1' || '{{$report["resultados_generales"][$key]["nivel"]}}' == 'Nivel 1'){
                bgColor = ["#0d5393", "#00afaa", "#00afaa"];
            }else if('{{$report["resultados_generales"][$key]["nivel"]}}' == 2 || '{{$report["resultados_generales"][$key]["nivel"]}}' == '2' || '{{$report["resultados_generales"][$key]["nivel"]}}' == 'Nivel 2'){
                bgColor = ["#0d5393", "#0d5393", "#00afaa"];
            }else if('{{$report["resultados_generales"][$key]["nivel"]}}' == 3 || '{{$report["resultados_generales"][$key]["nivel"]}}' == '3' || '{{$report["resultados_generales"][$key]["nivel"]}}' == 'Nivel 3'){
                bgColor = ["#0d5393", "#0d5393", "#0d5393"];
            }*/
            var data = {
            labels: ["1", "2", "3"],
            datasets: [
                {
                    data: [1, 1, 1],
                    backgroundColor: bgColor
                }
            ]
            };

            var config = {
                type: "doughnut",
                data: data,
                options: {   
                    reponsive: true,
                    maintainAspectRatio: false,
                    rotation: (circuference / 2) * -1,
                    circumference: circuference,
                    cutout: "80%",
                    borderWidth: 0,
                    borderRadius: function (context, options) {
                        const index = context.dataIndex;
                        let radius = {};
                        if (index == 0) {
                            radius.innerStart = 50;
                            radius.outerStart = 50;
                        }
                        if (index === context.dataset.data.length - 1) {
                            radius.innerEnd = 50;
                            radius.outerEnd = 50;
                        }
                        return radius;
                    },
                    plugins: {
                        title: false,
                        subtitle: false,
                        legend: {
                            position: "bottom",
                            align: "middle"
                        }
                    },
                    animation: {
                        onComplete: function () {
                            var canvas = document.getElementById("myChart2-{{$indexJS}}");
                            var ctx = canvas.getContext('2d');
                            var cw = canvas.offsetWidth;
                            var ch = canvas.offsetHeight;
                            var cx = cw / 2;
                            var cy = ch - (ch / 3);
                             
                            var gpn = 60;//grados_por_nivel
                            @if ($report["resultados_generales"][$key]["nivel_promedio"] === 1)
                            var niv = 2;
                            @elseif ($report["resultados_generales"][$key]["nivel_promedio"] === 2)
                            var niv = 1;
                            @else
                            var niv = 0;
                            @endif
                            ctx.translate(cx, cy);
                            ctx.rotate((-(gpn*niv+30) * Math.PI / 180));
                            ctx.beginPath();
                            ctx.moveTo(0, -5);
                            ctx.lineTo(85, 0);
                            ctx.lineTo(0, 5);
                            ctx.fillStyle = 'rgba(0, 76, 0, 0.8)';
                            ctx.fill();
                            ctx.rotate(-(-(gpn*niv+30) * Math.PI / 180));
                            ctx.translate(-cx, -cy);
                            ctx.beginPath();
                            ctx.arc(cx, cy, 7, 0, Math.PI * 2);
                            ctx.fill();
                            //drawNeedle(150, -45 * Math.PI / 180);
                        }
                    }
                }
            };
            var ctxSpeed{{$indexJS}} = new Chart("myChart2-{{$indexJS}}", config);

          var ctxDona{{$indexJS}} = document.getElementById("myChart3-{{$indexJS}}").getContext("2d", { willReadFrequently: true });
          new Chart(ctxDona{{$indexJS}}, {
            type: "doughnut",
            data: {
              labels: ["Fortalezas", "Oportunidades de Mejora"],
              datasets: [{
                // label: "# of Votes",
                data: [{{$grafica3[$key]["fortalezas_porc"]}}, {{$grafica3[$key]["oportunidades_porc"]}}],
                backgroundColor: ["#0d5393", "#00afaa"],
                borderWidth: 0
              }]
            },
            plugins: [ChartDataLabels],
            options: {
              responsive: true,
              plugins: {
                legend: {
                    position: "bottom"
                },
                datalabels: {
                    color: 'white',
                    textAlign: 'center',
                    font: {
                      weight: 'bold',
                      size: 12,
                    },
                    formatter: function(value, ctx) {
                    var index = ctx.dataIndex;
                    var label = ctx.chart.data.labels[index];
                    var new_label = value + '%';
                    return new_label;
                    }
                },
                title: {
                  display: false,
                }
              }
            }
          });
        <?php $indexJS = $indexJS + 1; ?>
        @endforeach

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

        setTimeout(function(){
          var pdf = new jsPDF(jsPDFOpts);
          var div_anterior = 0;
          var slides = document.getElementsByClassName("pdf-page");
          for (var i = 0; i < slides.length; i++) {
            var pdfWidth = pdf.internal.pageSize.getWidth();
            var pdfHeight = 0;
            console.log("#"+slides[i].id);
            html2canvas(document.querySelector("#"+slides[i].id)).then(canvas => {
                var img = canvas.toDataURL("image/jpeg");
                const imgProps= pdf.getImageProperties(img);
                pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                //document.getElementById("contenedor_pdf").style.display = 'none';
                pdf.addImage(img, 'PNG', 0, div_anterior, pdfWidth, pdfHeight);
                
                //if(i < slides.length){
                  pdf.addPage('A4', 'portrait');
                //}
            });
            div_anterior = pdfHeight;
          }
          setTimeout(function(){ 
              //pdf.save('reporte_candidato.pdf'); 
              var blob = pdf.output('blob');
              console.log(blob);
              var formData = new FormData();
              formData.append('pdf', blob);
              formData.append('name', '{{ $name }}');
              formData.append('csrf_token', '{{ csrf_token() }}');
              let fetchRes = fetch('<?php echo route('pdf.uploadblob'); ?>?name={{$name}}', {
                  method: "POST", 
                  body: formData 
              });
              fetchRes.then(res => 
                      res.json()).then(d => { 
                          window.location.href = '<?php echo route("pdf.index", [ 'message' => 'archivo_importado']); ?>';
                      }) 
            //window.close();
          }, 1750);
        }, 1750);
      });
    </script>
    </div>
    <!-- /.col-->
  </div>
  <!-- /.row-->
@include('layouts.footerPDF')