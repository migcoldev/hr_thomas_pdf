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
    <?php $page = 1; ?>
    <div id="page-{{$page}}" class="page-{{$page}} pdf-page">
      <div class="header-pdf">
        <table class="table-header">
          <tr>
            <td width="214">
                <img width="214" src="<?php echo url('/img/logo_azul.png'); ?>" />
            </td>
            <td></td>
            <td width="134">
                <img src="<?php echo url('/img/usil_pdf.png'); ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="hero">
        <h1 class="title-main">Evaluación a Alumnos USIL - {{$faculty_name}}</h1>
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
            <td class="table-1_header" colspan="2">Nivel 1</td>
            <td class="table-1_header" colspan="2">Nivel 2</td>
            <td class="table-1_header" colspan="2">Nivel 3</td>
          </tr>
          @foreach ($arrComp as $key=>$comp_data)
          <tr>
            <td class="table-1_aside">{{$key}}</td>
            @foreach ($comp_data as $key2=>$comp_data2)
            <td class="table-1_basic table-1_level">{{$comp_data2}}</td>
            <td class="table-1_basic table-1_level">{{round($comp_data2*100/array_sum($comp_data), 2)}}%</td>
            @endforeach
          @endforeach
          </tr>
        </table>
        <table class="table-2">
          <?php $i = 0; ?>
          @foreach ($arrComp as $key=>$comp_data)
            @if ($i === 3)
            <tr>
              <td colspan="3" height="8"></td>
            </tr>
            @endif
            @if ($i === 0 || $i === 3)
            <tr>
            @else
            <td class="table-2_separator"></td>
            @endif
            <td class="table-2_col">
              <div class="table-2_content">
                <h4 class="table-2_title">{{$key}}</h4>
                <div class="table-2_graph">
                  <canvas id="myChart-{{$i}}" class="table-2_chart"></canvas>
                </div>
              </div>
            </td>
            @if ($i === 2 || $i === 5)
            </tr>
            @endif
          <?php $i++; ?>
          @endforeach
        </table>
      </div>
    </div>
     
    @foreach ($group_report_by_profile as $key=>$comp_data)
    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="title-content">
        <h2 class="title">Competencia Digital - Detalle de Fortalezas y Oportunidades</h2>
      </div>
      <div class="body">
        <div class="subtitle-content">
          <h3 class="subtitle">Estilos conductuales y Rasgos de Personalidad Evaluados</h3>
        </div>
        <table class="table-divisor">
          <tr>
            <td class="table-divisor_left_header" colspan="3" rowspan="2">Perfil Ideal</td>
            <td class="table-divisor_gap"></td>
            <td class="table-divisor_right_header" colspan="2">Fortaleza</td>
            <td class="table-divisor_right_header" colspan="2">Oportunidad de Mejora</td>
          </tr>
          <tr>
            <td class="table-divisor_gap"></td>
            <td class="table-divisor_right_header">Detalle</td><td class="table-divisor_right_header">%</td>
            <td class="table-divisor_right_header">Detalle</td><td class="table-divisor_right_header">%</td>
          </tr>
          @foreach ($comp_data as $keyN=>$comp_nivel)
            <tr>
              <td class="table-divisor_left_aside font-10" rowspan="{{$comp_nivel['total_rows']}}">
                  {{ $keyN }}
              </td>
            @foreach ($comp_nivel["data"] as $keyE=>$comp_eval)
              @foreach ($comp_eval as $keyP=>$comp_rasgo)
                <td class="table-divisor-big_left_value font-10" rowspan="{{count($comp_rasgo)}}">{{ $keyE }} - {{ $keyP }}</td>
                @foreach ($comp_rasgo as $comp_perfil)
                  <td class="table-divisor-big_right_value font-10">{{ $comp_perfil->perfil }}</td>
                  <td class="table-divisor_gap"></td>
                  <td class="table-divisor-big_right_aside text-center">{{ $comp_perfil->fortaleza_descripcion }}</td>
                  @if ($comp_perfil->total_estudiantes === 0)
                  <td class="table-divisor-big_right_aside2 text-center">0%</td>
                  @else
                  <td class="table-divisor-big_right_aside2 text-center">{{round($comp_perfil->fortaleza*100/$comp_perfil->total_estudiantes, 2)}}%</td>
                  @endif
                  <td class="table-divisor-big_right_aside text-center">{{ $comp_perfil->oportunidad_descripcion }}</td>
                  @if ($comp_perfil->total_estudiantes === 0)
                  <td class="table-divisor-big_right_aside2 text-center">0%</td>
                  @else
                  <td class="table-divisor-big_right_aside2 text-center">{{round($comp_perfil->oportunidad*100/$comp_perfil->total_estudiantes, 2)}}%</td>
                  @endif
                </tr>
                @endforeach
              @endforeach
            @endforeach
          @endforeach
        </table>
      </div>
    </div>
    @endforeach 

    @if ($faculty_name == 'General' || $faculty_name == 'GENERAL')
    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="body">
        <div class="subtitle-content">
          <h3 class="subtitle">Estilos Conductuales y Rasgos de Personalidad mas utilizados</h3>
        </div>
        <table class="table-general">
          <tr>
            <td class="table-general_left_header">Evaluación</td>
            <td class="table-general_right_header">Perfil</td>
            <td class="table-general_right_header">Rasgo</td>
            <td class="table-general_right_header">Cantidad de Veces que figura el rasgo en el Perfil Ideal</td>
          </tr>
          <tr>
            <td class="table-general_left_aside" rowspan="7">
              HPTI
            </td>
            <td class="table-general_left_value" rowspan="4">Moderado</td>
            <td class="table-general_left_profile">Curiosidad</td>
            <td class="table-general_right_value">8</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Competitividad</td>
            <td class="table-general_right_value">5</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Autoexigencia</td>
            <td class="table-general_right_value">5</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Adaptación</td>
            <td class="table-general_right_value">3</td>
          </tr>
          <tr>
            <td class="table-general_left_value" rowspan="3">Óptimo</td>
            <td class="table-general_left_profile">Curiosidad</td>
            <td class="table-general_right_value">9</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Autoexigencia</td>
            <td class="table-general_right_value">5</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Competitividad</td>
            <td class="table-general_right_value">1</td>
          </tr>
          <tr>
            <td class="table-general_left_aside" rowspan="4">
              PPA
            </td>
            <td class="table-general_left_value" rowspan="4">Alto</td>
            <td class="table-general_left_profile">Conformidad</td>
            <td class="table-general_right_value">4</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Influencia</td>
            <td class="table-general_right_value">2</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Estabilidad</td>
            <td class="table-general_right_value">1</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Dominancia</td>
            <td class="table-general_right_value">1</td>
          </tr>
          <tr>
            <td class="table-general_left_aside" rowspan="8">
              TEIQ
            </td>
            <td class="table-general_left_value" rowspan="7">Alto</td>
            <td class="table-general_left_profile">Adaptabilidad</td>
            <td class="table-general_right_value">13</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Conciencia Social</td>
            <td class="table-general_right_value">7</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Automotivación</td>
            <td class="table-general_right_value">6</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Percepción Emocional</td>
            <td class="table-general_right_value">5</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Empatía</td>
            <td class="table-general_right_value">5</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Asertividad</td>
            <td class="table-general_right_value">4</td>
          </tr>
          <tr>
            <td class="table-general_left_profile">Gestión de la Emoción</td>
            <td class="table-general_right_value">3</td>
          </tr>
          <tr>
            <td class="table-general_left_value">Promedio</td>
            <td class="table-general_left_profile">Asertividad</td>
            <td class="table-general_right_value">1</td>
          </tr>
        </table>
      </div>
    </div>
    @endif

    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="title-content">
        <h2 class="title">Assessments Aplicados - Análisis de Resultados Pruebas Thomas</h2>
      </div>
      <div class="body">
        <table class="table-graphs">
          <tr>
            <td class="table-graphs_col table-graphs_1">
              <div class="table-graphs_col-content">
                <div class="table-graphs_header">
                  <h4 class="table-graphs_title">PPA - Perfil de<br> Análisis Personal</h4>
                </div>
                <canvas class="table-graphs_canvas" id="horizontal-bars-1" height="280px"></canvas>
              </div>
            </td>
            <td class="table-graphs_separator"></td>
            <td class="table-graphs_col table-graphs_2">
              <div class="table-graphs_col-content_hbar">
                <div class="table-graphs_header">
                  <h4 class="table-graphs_title">TEIQ - Inteligencia<br> Emocional</h4>
                </div>
                <?php $heightG2 = 0; ?>
                @foreach ($arrRasgos as $objG2)
                  <?php $heightG2 = $heightG2 + 40; ?>

                @endforeach
                <canvas class="table-graphs_canvas" id="horizontal-bars-2" height="{{$heightG2}}px"></canvas>
              </div>
            </td>
            <td class="table-graphs_separator"></td>
            <td class="table-graphs_col table-graphs_3">
              <div class="table-graphs_col-content_hbar">
                <div class="table-graphs_header">
                  <h4 class="table-graphs_title">HPTI - Indicador de Rasgo<br> de Alto Potencial</h4>
                </div>
                <canvas class="table-graphs_canvas" id="horizontal-bars-3" height="280px"></canvas>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="body">
        <div class="subtitle-content">
          <h3 class="subtitle">PPA - Perfil Conductual</h3>
        </div>
        <table class="table-profile">
          <tr>
            <td class="table-profile_text">
              <div class="table-profile_content">
                <h4>Resumen Conductual (PPA):</h4>
                <p>{!! $explicacion_ppa !!}</p>
              </div>
            </td>
            <td class="table-profile_separator"></td>
            <td class="table-profile_image">
              <img src="{{$imagen_ppa}}" class="table-profile_img" />
            </td>
          </tr>
        </table>
      </div>
    </div>
    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="body">
        <div class="subtitle-content">
          <h3 class="subtitle">TEIQue - Inteligencia Emocional</h3>
        </div>
        <div class="bars-content">
            <img src="{{$imagen_teiq}}" class="table-profile_img" />
        </div>
        <div class="bars-text">
          <div class="bars-text_content">
            <h4>Resumen de Inteligencia Emocional (TEIQ):</h4>
            <p>{!! $explicacion_teiq !!}</p>
          </div>
        </div>
      </div>
    </div>
    <?php $page++; ?>
    <div id="page-{{$page}}" class="page-{{$page}} page_break pdf-page">
      <div class="body">
        <div class="subtitle-content">
          <h3 class="subtitle">HPTI - Potencial para el Liderazgo</h3>
        </div>
        <div class="bars-content">
            <img src="{{$imagen_hpti}}" class="table-profile_img" />
        </div>
        <div class="bars-text">
          <div class="bars-text_content">
            <h4>Resumen de Potencial para el Liderazgo (HPTI):</h4>
            <p>{!! $explicacion_hpti !!}</p>
          </div>
        </div>
      </div>
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
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 36px;
        table-layout: fixed;
      }
      .table-1 td {
        border: 1px solid #bbb;
        text-align: center;
      }
      .table-1_header {
        width: 25%;
        max-width: 25%;
        min-width: 25%;
        background-color: #0c5393;
        color: #FFF;
        font-weight: bold;
        text-align: center;
        padding: 12px 6px;
      }
      .table-1_aside, .table-1_basic {
        padding: 6px 8px;
      }
      .table-1_basic {
        width: 100px;
        min-width: 100px;
        max-width: 100px;
      }
      .table-1_aside {
        background-color: #0c5393;
        color: #FFF;
        font-weight: bold;
      }
      .table-1_level {
        text-align: center;
      }
      .table-2 {
        width: 100%;
        border-collapse: collapse;
      }
      .table-2_col {
        width: 32%;
        max-width: 32%;
        min-width: 32%;
        text-align: center;
      }
      .table-2_content {
        background-color: #eee;
        padding: 12px;
      }
      .table-2_separator {
        width: 2%;
      }
      .table-2_title {
        font-weight: bold;
        font-size: 14px;
        margin: 0 0 12px;
      }
      .table-2_chart {
        margin: 0 auto;
        max-width: 220px;
        max-height: 165px;
      }
      .table-graphs {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
      }
      .table-graphs_canvas {
        max-width: 100%;
      }
      .table-graphs_col {
        width: 32%;
        vertical-align: top;
      }
      .table-graphs_col-content {
        padding: 16px;
      }
      .table-graphs_col-content_hbar {
        padding: 16px;
        padding-left:3px;
      }
      .table-graphs_header {
        margin-bottom: 18px;
      }
      .table-graphs_title {
        text-align: center;
        color: #FFF;
        font-weight: bold;
        margin: 0;
        font-size: 14px;
      }
      .table-graphs_1 {
        background-color: #6793bb;
      }
      .table-graphs_2 {
        background-color: #97c67e;
      }
      .table-graphs_3 {
        background-color: #f2aa7d;
      }
      .table-graphs_col img {
        width: 100%;
      }
      .table-graphs_separator {
        width: 2%;
      }
      .table-profile {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
        margin-bottom: 24px;
      }
      .table-profile h4 {
        margin: 0 0 24px;
        font-size: 14px;
      }
      .table-profile-sin-espacio {
        margin: 0 0 0px;
      }
      .table-profile_text {
        padding: 24px;
        width: 64%;
        background-color: #eee;
        vertical-align: top;
      }
      .table-profile_img {
        width: 100%;
      }
      .table-profile_image {
        padding: 24px;
        background-color: #eee;
        width: 34%;
      }
      .table-profile_separator {
        width: 2%;
      }
      .table-ppa {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
        table-layout: fixed;
      }
      .table-ppa_content {
        margin-bottom: 24px;
      }
      .table-ppa td {
        padding: 6px 8px;
        border: 1px solid #bbb;
        text-align: center;
      }
      .table-ppa__header {
        font-weight: bold;
      }
      .table-ppa__header_col1 {
        background-color: #0c5393;
        color: #FFFFFF;
        width: 20%;
        max-width: 20%;
        min-width: 20%;
      }
      .table-ppa__header_col2,
      .table-ppa__header_col3 {
        background-color: #5aa432;
        color: #FFFFFF;
        width: 40%;
        max-width: 40%;
        min-width: 40%;
      }
      .table-ppa__aside {
        background-color: #0c5393;
        color: #FFFFFF;
      }
      .table-ppa__value {
      }
      .table-50_50 {
        width: 100%;
        table-layout: fixed;
      }
      .table-50_50 td {
        
      }
      .table-50_50-gap {
        width: 4%;
        max-width: 4%;
        min-width: 4%;
      }
      .table-50_50-left,
      .table-50_50-right {
        padding: 24px 48px;
        background-color: #eee;
        width: 48%;
        max-width: 48%;
        min-width: 48%;
        font-size: 14px;
      }
      .bars-content {
        margin-bottom: 24px;
      }
      .bars-text_content p {
        margin-top: 0;
        font-size: 14px;
      }
      .bars-text_content h4 {
        margin: 0 0 24px;
        font-size: 14px;
      }
      .bars-text {
        background-color: #eee;
        padding: 36px;
      }
      .table-general {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        table-layout: fixed;
      }
      .table-general td {
        border: 1px solid #bbb;
        padding: 6px 8px;
      }
      .table-general_left_header {
        width: 280px;
        text-align: center;
        font-weight: bold;
        background-color: #0c5393;
        color: #FFF;
      }
      .table-general_gap {
        width: 4px;
        border-bottom-color: transparent !important;
        border-top-color: transparent !important;
      }
      .table-general_right_header {
        text-align: center;
        font-weight: bold;
        background-color: #5aa432;
        color: #FFF;
      }
      .table-divisor {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        tableXXX-layout: fixed;
      }
      .table-divisor td {
        border: 1px solid #bbb;
        padding: 6px 8px;
      }
      .table-divisor_left_header {
        width: 200px;
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
      .font-10{
        font-size:10px;
      }
      .table-divisor_left_aside {
        font-weight: bold;
        background-color: #0c5393;
        text-align: center;
        color: #FFF;
        width:40px;
        max-width:40px;
        min-width:40px;
      }
      .table-divisor_left_value_eval {
        font-weight: bold;
        background-color: #5693cb;
        color: #FFF;
        width: 80px;
        max-width: 80px;
        min-width: 80px;
      }
      .table-divisor_left_value {
        font-weight: bold;
        background-color: #5693cb;
        color: #FFF;
        width: 150px;
        max-width: 150px;
        min-width: 150px;
      }
      .table-divisor_right_value {
       width: 100px;
       max-width: 100px;
       min-width: 100px;
      }
      .table-divisor_right_aside {
       width: 90px;
       max-width: 90px;
       min-width: 90px;
      }
      .table-divisor-big_left_value {
        font-weight: bold;
        background-color: #5693cb;
        color: #FFF;
        width: 100px;
        max-width: 100px;
        min-width: 100px;
      }
      .table-divisor-big_left_value_eval {
        font-weight: bold;
        background-color: #5693cb;
        color: #FFF;
        width: 50px;
        max-width: 50px;
        min-width: 50px;
      }
      .table-divisor-big_right_value {
       width: 60px;
       max-width: 60px;
       min-width: 60px;
      }
      .table-divisor-big_right_aside {
        font-size:10px;
       width: 180px;
       max-width: 180px;
       min-width: 180px;
      }
      .table-divisor-big_right_aside2 {
        font-size:10px;
       width: 40px;
       max-width: 40px;
       min-width: 40px;
      }
      .table-teiq {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        table-layout: fixed;
      }
      .table-teiq td {
        padding: 6px 8px;
        font-size: 14px;
        text-align: center;
        border: 1px solid #bbb;
      }
      .table-teiq_header {
        text-align: center;
        font-weight: bold;
        background-color: #0c5393;
        color: #FFF;
      }
      .table-teiq_header_aside {
        background-color: #5aa432;
        width: 120px;
        max-width: 120px;
        min-width: 120px;
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
    
    <script>
      <?php $i = 0; ?>
      $( document ).ready(function() {
        @foreach ($arrComp as $key=>$comp_data)
          
        var ctxs{{$i}} = document.getElementById("myChart-{{$i}}").getContext("2d", { willReadFrequently: true });
        //ctxs{{$i}}.forEach((element) => {
          new Chart(ctxs{{$i}}, {
            type: "pie",
            data: {
              labels: ['Nivel 1', 'Nivel 2', 'Nivel 3'],
              datasets: [{
                // label: "# of Votes",
                data: [
                  @foreach ($comp_data as $key2=>$comp_data2)
                  {{round($comp_data2*100/array_sum($comp_data), 2)}},
                  @endforeach
                ],
                backgroundColor: ["#0d5393", "#5693cb", "#8ca9c5"],
                borderWidth: 0
              }]
            },
            plugins: [ChartDataLabels],
            options: {
              /*layout: {
                padding: {
                  top: 17,
                  bottom: 17,
                },
              },*/
              responsive: true,
              plugins: {
                  legend: {
                      position: "bottom",
                      labels: {
                        font: {
                          size: 9,
                        },
                      },
                  },
                  datalabels: {
                      color: 'white',
                      textAlign: 'center',
                      font: {
                        //weight: 'bold',
                        size: 9,
                      },
                      display: function(context) {
                        return context.dataset.data[context.dataIndex] > 0;
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
        //});
        <?php $i++; ?>
        @endforeach


        // Grafica PPA - Perfil de Análisis Personal
        var hb1_labels = [];var hb1_values = [];
        var hb1_suma = 0;
        @foreach ($arrGrafica1 as $keyG1=>$objG1)
        hb1_labels.push("{{$keyG1}}");
        hb1_values.push({{$objG1}});
        hb1_suma += {{$objG1}};
        @endforeach

        for(i=0;i<hb1_values.length;i++){
          hb1_values[i] = (hb1_values[i]*100/hb1_suma).toFixed(2);
        }
        
        var ctxG1 = document.getElementById("horizontal-bars-1").getContext("2d", { willReadFrequently: true });
        new Chart(ctxG1, {
          type: "bar",
          data: {
            labels: hb1_labels,
            datasets: [
              {
                label: false,
                backgroundColor: ["#79e0ff", "#79e0ff", "#79e0ff", "#79e0ff"],
                data: hb1_values,
                borderRadius: 6,
              }
            ]
          },
            plugins: [ChartDataLabels],
          options: {
            responsive: true,
            indexAxis: "y",
            plugins: {
              legend: {
                display: false
              },
              datalabels: {
                color: '#0c5393',
                font: {
                  weight: 'bold'
                },
                formatter: function(value, ctx) {
                var index = ctx.dataIndex;
                var label = ctx.chart.data.labels[index];
                var new_label = value + '%';
                return new_label;
                }
              }
            },
            scales: {
              y: {
                ticks: {
                  color: "white",
                  crossAlign: "center",
                  font: {
                      size: 20,
                      weight: 'bold',
                  }
                },
                grid: {
                  display: false,
                  drawBorder: false
                },
                border: {display: false}
              },
              x: {
                ticks: {
                  display:false,
                  color: "white"
                },
                grid: {
                  display: false,
                  drawBorder: false
                },
                border: {display: false}
              },
            }
          }
        });

        // Gráfica TEIQ - Inteligencia Emocional
        
        var barcolors = ["#7a91c1", "#c3de8b", "#eb7730"];
        var hb2_valuesR = []; var total_conteo = 0;
        @foreach ($arrRasgos as $key=>$itemRasgo)
          var hb2_valuesR_{{str_replace(" ", "", $itemRasgo)}} = [];
          @if ($loop->first)
          total_conteo = {{$arrGrafica2[$itemRasgo]["data"]['Alto']["value"] + $arrGrafica2[$itemRasgo]["data"]['Bajo']["value"] + $arrGrafica2[$itemRasgo]["data"]['Promedio']["value"]}};
          @endif
        @endforeach
        @foreach ($arrLabelEstadoG2 as $key=>$item2)
        var hb2_values_{{$item2}} = [];
        @endforeach
        var hb2_labels = [];
        @foreach ($arrGrafica2 as $key2=>$objRasgo)
          var hb2_label_arr = [];
          hb2_label_arr.push('{{$objRasgo["label"]}}');
          hb2_labels.push(hb2_label_arr);
          
          @foreach ($objRasgo["data"] as $key3=>$itemEstado)
          hb2_values_{{$key3}}.push(Math.round(({{$itemEstado["value"]}}*100/total_conteo), 2));
          hb2_valuesR_{{str_replace(" ", "", $key2)}}.push({{$itemEstado["value"]}});
          @endforeach
        @endforeach 
        var ctxG2 = document.getElementById("horizontal-bars-2").getContext("2d", { willReadFrequently: true });
        new Chart(ctxG2, {
          type: "bar",
          data: {
            labels: hb2_labels,
            datasets: [
              <?php $xyz = 0; ?>
              @foreach ($arrLabelEstadoG2 as $key=>$item3)
              {
                label: "{{$item3}}",
                data: hb2_values_{{$item3}},
                backgroundColor: barcolors[{{$xyz}}],
                categoryPercentage: 0.5
              },
              <?php $xyz++; ?>
              @endforeach
            ]
          },
            plugins: [ChartDataLabels],
          options: {
            plugins: {
              legend: {
                display: true,
                font: {
                  weight: 'bold'
                },
              },
              datalabels: {
                color: 'white',
                display: function(context) {
                  return context.dataset.data[context.dataIndex] > 5;
                },
                font: {
                  weight: 'bold'
                },
                formatter: function(value, ctx) {
                  var index = ctx.dataIndex;
                  var label = ctx.chart.data.labels[index];
                  var new_label = value + '%';
                  return new_label;
                }
              }
            },
            responsive: true,
            indexAxis: "y",
            title: {
              display:true,
              text: "bar chart"
            },
            animation: {
              easing: "easeInOutQuad",
              duration: 520
            },
            elements: {
              line: {
                tension: 0.4
              }
            },
            scales: {
              x: {
                stacked: true,
                barThickness: 350,
                ticks: {
                  display:false,
                  color: "white"
                },
                grid: {
                  display: false,
                  drawBorder: false
                },
                min: 0,
                max: 100,
                border: {display: false},
              },
              y: {
                stacked: true,
                ticks: {
                  color: "#03090e",
                  font: {
                    size: 10,
                    weight: 'bold'
                  },
                  //crossAlign: "center",
                  mirror: true,
                  labelOffset: 16,
                },
                grid: {
                  display:false
                },
                border: {display: false}
              }
            }
          }
        });

        // Gráfica HPTI - Inteligencia Emocional
        var barcolors = ["#7a91c1", "#c3de8b", "#eb7730", "#7fbbe9"];
        var hb3_valuesR = []; var total_conteo = 0;
        @foreach ($arrRasgos3 as $key=>$itemRasgo)
          var hb3_valuesR_{{str_replace(" ", "", $itemRasgo)}} = [];
          @if ($loop->first)
          total_conteo = {{$arrGrafica3[$itemRasgo]["data"]['Moderado']["value"] + $arrGrafica3[$itemRasgo]["data"]['Bajo']["value"] + $arrGrafica3[$itemRasgo]["data"]['Excesivo']["value"] + $arrGrafica3[$itemRasgo]["data"]['Óptimo']["value"]}};
          @endif
        @endforeach
        @foreach ($arrLabelEstadoG3 as $key=>$item2)
        var hb3_values_{{$item2}} = [];
        @endforeach
        var hb3_labels = [];
        @foreach ($arrGrafica3 as $key2=>$objRasgo)
          var hb3_label_arr = [];
          hb3_label_arr.push('{{$objRasgo["label"]}}');
          hb3_labels.push(hb3_label_arr);
          
          @foreach ($objRasgo["data"] as $key3=>$itemEstado)
          hb3_values_{{$key3}}.push(Math.round(({{$itemEstado["value"]}}*100/total_conteo), 2));
          hb3_valuesR_{{str_replace(" ", "", $key2)}}.push({{$itemEstado["value"]}});
          @endforeach
        @endforeach 

        var ctxG3 = document.getElementById("horizontal-bars-3").getContext("2d", { willReadFrequently: true });
        new Chart(ctxG3, {
          type: "bar",
          data: {
            labels: hb3_labels,
            datasets: [
              <?php $xyz = 0; ?>
              @foreach ($arrLabelEstadoG3 as $key=>$item3)
              {
                label: "{{$item3}}",
                data: hb3_values_{{$item3}},
                backgroundColor: barcolors[{{$xyz}}],
                categoryPercentage: 0.5
              },
              <?php $xyz++; ?>
              @endforeach
            ]
          },
            plugins: [ChartDataLabels],
          options: {
            plugins: {
              legend: {
                display: true,
                font: {
                  weight: 'bold'
                },
              },
              datalabels: {
                color: 'white',
                display: function(context) {
                  return context.dataset.data[context.dataIndex] > 5;
                },
                font: {
                  weight: 'bold'
                },
                formatter: function(value, ctx) {
                  var index = ctx.dataIndex;
                  var label = ctx.chart.data.labels[index];
                  var new_label = value + '%';
                  return new_label;
                }
              }
            },
            responsive: true,
            indexAxis: "y",
            title: {
              display:true,
              text: "bar chart"
            },
            animation: {
              easing: "easeInOutQuad",
              duration: 520
            },
            elements: {
              line: {
                tension: 0.4
              }
            },
            scales: {
              x: {
                stacked: true,
                barThickness: 350,
                ticks: {
                  display:false,
                  color: "white"
                },
                grid: {
                  display: false,
                  drawBorder: false
                },
                min: 0,
                max: 100,
                border: {display: false},
              },
              y: {
                stacked: true,
                ticks: {
                  color: "#03090e",
                  font: {
                    size: 10,
                    weight: 'bold'
                  },
                  //crossAlign: "center",
                  mirror: true,
                  labelOffset: 16,
                },
                grid: {
                  display:false
                },
                border: {display: false}
              }
            }
          }
        });

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
          var arrPdfImgs = [];
          async function myAjax(selector, pdf) {
          }
          setTimeout(function(){
            var pdf = new jsPDF(jsPDFOpts);
            var div_anterior = 0;
            var slides = document.getElementsByClassName("pdf-page");
            var pdfWidth = pdf.internal.pageSize.getWidth();
            var pdfHeight = 0;
            for (var i = 0; i < slides.length; i++) {
                pdf.addPage('A4', 'portrait');
            }
            async function myAjax(selector, selector_index, pdf) {
              //console.log(selector);
              var pdfWidth = pdf.internal.pageSize.getWidth();
              var pdfHeight = 0;
              html2canvas(document.querySelector(selector), {
                      scale:4,
                      dpi: 300,
                    }).then(canvas => {
                    var img = canvas.toDataURL("image/jpeg");
                    const imgProps= pdf.getImageProperties(img);
                    pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                    console.log("PAGE : "+selector_index);
                    pdf.setPage(selector_index);
                    pdf.addImage(img, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                });
              return true
            }
            
            for (var i = 0; i < slides.length; i++) {
              myAjax("#"+slides[i].id, i+1, pdf).then((data) => {
              })
            }
            setTimeout(function(){ 
                //pdf.save('reporte_candidato.pdf'); 
                var pageCount = pdf.internal.getNumberOfPages();
                pdf.deletePage(pageCount);
                var blob = pdf.output('blob');
                console.log(blob);
                var formData = new FormData();
                formData.append('pdf', blob);
                formData.append('name', '{{ $report_name }}');
                formData.append('csrf_token', '{{ csrf_token() }}');
                let fetchRes = fetch('<?php echo route('pdf.uploadblob'); ?>?type=grupal&faculty={{$faculty}}&name={{$report_name}}', {
                    method: "POST", 
                    body: formData 
                });
                fetchRes.then(res => 
                        res.json()).then(d => { 
                            window.location.href = '<?php echo route("pdf.index_grupal", [ 'message' => 'archivo_importado']); ?>';
                        }) 
              //window.close();
            }, 4000);
          }, 3000);
        });
    </script>
    </div>
    <!-- /.col-->
  </div>
  <!-- /.row-->
@include('layouts.footerPDF')