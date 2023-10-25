<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportDocument;
use App\Models\GroupReportProfile;
use App\Models\GroupReportResults;
use App\Models\Faculty;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class PDFController extends Controller
{
    
    ###### REPORTE PERSONAL #######
    public function index(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        $documents = ReportDocument::where("file_type",'pdf_personal')->orderBy("id","desc")->get();
        return view('pdf.index', ['message' => $request->message, 'storage_url' => env('STORAGE_URL'), 'documents' => $documents]);
    }
    
    public function importar(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.importar');
    }
    
    public function convertir(Request $request)
    {
        $this->validate($request, [
            'archivos'=>'required',
        ]);
        
        $archivos_originales = [];

        $fullname = $request->file('archivos')->getClientOriginalName();
        $name = explode('.', $fullname)[0];
        $extension = $request->file('archivos')->getClientOriginalExtension();
        //$new_name = filter_var(($name."-".time()), FILTER_SANITIZE_STRING).".".$extension;
        $new_name = "reporte-personal-importado-".time().".".$extension;
        $filename = $request->file('archivos')->storeAs('originales', $new_name);
        session(['info_global' => []]);
        
        $rows = SimpleExcelReader::create(Storage::disk('local')->path($filename), 'xlsx')->trimHeaderRow()
        ->fromSheetName("Resultado1")
        ->useHeaders(['candidato','carrera','facultad','nivel_promedio','competencia','nivel','definicion'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            $arrAux = session('info_global', []);
            if(count($arrAux) === 0){
                $arrAux["candidato"] = $rowProperties["candidato"];
                session(['info_global' => $arrAux]);
            }
        });

        $arrResultGen = session('info_global', []);
        if(count($arrResultGen) > 0){
            $document = new ReportDocument([
                'id_user' => 1,
                'file_type' => 'pdf_personal',
                'person' => $arrResultGen["candidato"],
                'original_file' => $new_name,
                'converted_file' => '',
                'created_at' => now()
            ]);
            $document->save();
    
            return redirect()->action(
                [PDFController::class, 'usiltemplate'], ['doc_id' => $document->id]
            );
        }else{
            return redirect()->action(
                [PDFController::class, 'importar'], ['message' => 'error']
            );
        }
        //return view('pdf.convertir', ["new_name" => $new_name]);
        //return redirect()->action([PDFController::class, 'importar']);
    }
    
    public function usiltemplate(Request $request)
    {
        $this->validate($request, [
            'doc_id'=>'required',
        ]);
        $document = ReportDocument::where("id",intval($request->doc_id))->first();

        //Resultados Generales
        session(['report' => []]);
        $rows = SimpleExcelReader::create(Storage::disk('local')->path("originales/".$document->original_file), 'xlsx')->trimHeaderRow()
        ->fromSheetName("Resultado1")
        ->useHeaders(['candidato','carrera','facultad','nivel_promedio','competencia','nivel','definicion'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            $arrAux = session('report', []);
            if(count($arrAux) === 0){
                $data = [
                    'candidato' => $rowProperties["candidato"],
                    'carrera' => $rowProperties["carrera"],
                    'facultad' => $rowProperties["facultad"],
                    'nivel_promedio' => $rowProperties["nivel_promedio"],
                    'resultados_generales' => []
                ];
                session(['report' => $data]);
                $data = [];
                $arrAux = session('report', []);
            }
            $data = [
                'competencia' => $rowProperties["competencia"],
                'nivel' => $rowProperties["nivel"],
                'nivel_promedio' => $rowProperties["nivel_promedio"],
                'definicion' => $rowProperties["definicion"]
            ];
            $arrAux['resultados_generales'][$rowProperties["competencia"]] = $data;
            session(['report' => $arrAux]);
        });
        $rows = SimpleExcelReader::create(Storage::disk('local')->path("originales/".$document->original_file), 'xlsx')->trimHeaderRow()
        ->fromSheetName("Resultado2")
        ->useHeaders(['candidato','carrera','facultad','nivel_promedio','evaluación','rasgo','resultado','detalle','competencia'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            if($rowProperties["evaluación"] != ""){
                $arrAux = session('report', []);
                $data = [
                    'nivel_promedio' => $rowProperties["nivel_promedio"],
                    'evaluacion' => $rowProperties["evaluación"],
                    'rasgo' => $rowProperties["rasgo"],
                    'resultado' => $rowProperties["resultado"],
                    'detalle' => $rowProperties["detalle"],
                    'competencia' => $rowProperties["competencia"]
                ];
                $arrAux['perfil_ideal'][$rowProperties["competencia"]][$rowProperties["evaluación"]][] = $data;
                session(['report' => $arrAux]);
            }
        });
        $report_data = session('report', []);


        $total_nivel1 = 0;$total_nivel2 = 0;$total_nivel3 = 0;
        foreach ($report_data["resultados_generales"] as $key=>$resultados_generales) {
        //for($i=0;$i<count($report_data["resultados_generales"]);$i++){
            if(strtolower($resultados_generales["nivel"]) == "nivel 1" || $resultados_generales["nivel"] === 1){
                $total_nivel1++;
            }
            if(strtolower($resultados_generales["nivel"]) == "nivel 2" || $resultados_generales["nivel"] === 2){
                $total_nivel2++;
            }
            if(strtolower($resultados_generales["nivel"]) == "nivel 3" || $resultados_generales["nivel"] === 3){
                $total_nivel3++;
            }
        }
        $grafica1 = [];
        if($total_nivel1 > 0){ $grafica1[] = round($total_nivel1 * 100 / ($total_nivel1 + $total_nivel2 + $total_nivel3),2); }
        if($total_nivel2 > 0){ $grafica1[] = round($total_nivel2 * 100 / ($total_nivel1 + $total_nivel2 + $total_nivel3),2); }
        if($total_nivel3 > 0){ $grafica1[] = round($total_nivel3 * 100 / ($total_nivel1 + $total_nivel2 + $total_nivel3),2); }

        $grafica2 = []; $grafica3 = [];
        foreach ($report_data["perfil_ideal"] as $key=>$competenciasArr) {

            $total_fortalezas = 0;$total_oportunidades = 0;

            $grafica2[$key]["lista_fortalezas"] = [];
            $grafica2[$key]["lista_oportunidades"] = [];
            
            foreach ($competenciasArr as $key2=>$evaluacionArr) {
                foreach ($evaluacionArr as $key3=>$evaluacionObj) {
                
                    if(strtolower($evaluacionObj["resultado"]) == "fortaleza"){
                        $total_fortalezas++;
                        if (!in_array($evaluacionObj["rasgo"], $grafica2[$key]["lista_fortalezas"])){
                            $grafica2[$key]["lista_fortalezas"][] = $evaluacionObj["rasgo"];
                        }
                    }
                    if(strtolower($evaluacionObj["resultado"]) == "oportunidad de mejora"){
                        $total_oportunidades++;
                        if (!in_array($evaluacionObj["rasgo"], $grafica2[$key]["lista_oportunidades"])){
                            $grafica2[$key]["lista_oportunidades"][] = $evaluacionObj["rasgo"];
                        }
                    }
                }
            }
            $grafica3[$key]["total"] = $total_fortalezas + $total_oportunidades;
            $grafica3[$key]["fortalezas"] = $total_fortalezas;
            $grafica3[$key]["oportunidades"] = $total_oportunidades;
            if(($total_fortalezas + $total_oportunidades) === 0){
                $grafica3[$key]["fortalezas_porc"] = 0;
                $grafica3[$key]["oportunidades_porc"] = 0;
            }else{
                $grafica3[$key]["fortalezas_porc"] = round((100 * $total_fortalezas / ($total_fortalezas + $total_oportunidades)), 2);
                $grafica3[$key]["oportunidades_porc"] = round((100 * $total_oportunidades / ($total_fortalezas + $total_oportunidades)), 2);
            }
        }
          
        //var_dump($report_data["resultados_generales"]);
        $iterator_perfil_ideal = 0;
        if(count($report_data["perfil_ideal"]) > 5){ $iterator_perfil_ideal = 1; }

        return view('pdf.usil', ['name' => $document->original_file, 'report' => $report_data, 'grafica1' => $grafica1, 'count_grafica1' => count($grafica1), 'grafica2' => $grafica2, 'grafica3' => $grafica3, 'iterator_perfil_ideal' => $iterator_perfil_ideal, 'index' => 2, 'indexJS' => 2 ]);
        //return redirect()->action([PDFController::class, 'importar']);
    }

    ###### REPORTE GRUPAL #######
    public function indexgrupal(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        $documents = ReportDocument::where("file_type",'pdf_grupal')->orderBy("id","desc")->get();
        return view('pdf.indexgrupal', ['message' => $request->message, 'storage_url' => env('STORAGE_URL'), 'documents' => $documents]);
    }
    
    public function importar_grupal(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.importargrupal', ['message' => $request->message]);
    }
    
    public function generar_grupal(Request $request)
    {
        $faculties = Faculty::orderBy("name","asc")->get();
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.formgrupal', ['faculties' => $faculties]);
    }
    
    public function convertir_grupal(Request $request)
    {
        $this->validate($request, [
            'archivos'=>'required',
        ]);
        
        $archivos_originales = [];

        $fullname = $request->file('archivos')->getClientOriginalName();
        $name = explode('.', $fullname)[0];
        $extension = $request->file('archivos')->getClientOriginalExtension();
        $new_name = "reporte-grupal-importado-".time().".".$extension;
        $filename = $request->file('archivos')->storeAs('originales', $new_name);
        session(['info_global' => []]);
        
        GroupReportProfile::truncate();
        GroupReportResults::truncate();
        Faculty::truncate();

        $rows = SimpleExcelReader::create(Storage::disk('local')->path($filename), 'xlsx')->trimHeaderRow()
        ->fromSheetName("ResultadosSegúnPerfilIdeal")
        ->useHeaders(['Evaluación','Rasgo','Nombre Competencia','Nivel','Llave','Perfil','Fortaleza','Oportunidad','Facultad','Conteo','Total Estudiantes por Nivel, Competencia y Facultad'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            $arrAux = session('info_global', []);
            if(intval($rowProperties["Conteo"]) > 0){
                $faculty = Faculty::where("name", trim($rowProperties["Facultad"]))->first();
                if($faculty){ //Existe 
                }else{
                    $faculty = new Faculty([
                        'name' => trim($rowProperties["Facultad"]), 
                        'created_at' => now()
                    ]);
                    $faculty->save();
                }
                $group_profile = new GroupReportProfile([
                    'id_user' => 1,
                    'id_faculty' => $faculty->id,
                    'facultad' => trim($rowProperties["Facultad"]), 
                    'evaluacion' => trim($rowProperties["Evaluación"]),
                    'rasgo' => trim($rowProperties["Rasgo"]),
                    'competencia' => trim($rowProperties["Nombre Competencia"]),  
                    'nivel' => trim($rowProperties["Nivel"]),  
                    'llave' => trim($rowProperties["Llave"]),  
                    'perfil' => trim($rowProperties["Perfil"]),  
                    'fortaleza' => intval($rowProperties["Fortaleza"]),  
                    'fortaleza_descripcion' => trim($rowProperties["Fortaleza_Descripcion"]),  
                    'oportunidad' => intval($rowProperties["Oportunidad"]), 
                    'oportunidad_descripcion' => trim($rowProperties["Oportunidad_Descripcion"]),  
                    'conteo' => intval($rowProperties["Conteo"]),  
                    'total_estudiantes' => intval($rowProperties["Total Estudiantes por Nivel, Competencia y Facultad"]),  
                    'created_at' => now()
                ]);
                $group_profile->save();
            }
        });
        
        $rows = SimpleExcelReader::create(Storage::disk('local')->path($filename), 'xlsx')->trimHeaderRow()
        ->fromSheetName("ResultadosGrupales")
        ->useHeaders(['Facultad','Nivel Alcanzado','Estado','Cantidad Estudiantes','Rasgo','Evaluación'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            $arrAux = session('info_global', []);
            $faculty = Faculty::where("name", trim($rowProperties["Facultad"]))->first();
            if($faculty){ //Existe 
            }else{
                $faculty = new Faculty([
                    'name' => trim($rowProperties["Facultad"]), 
                    'created_at' => now()
                ]);
                $faculty->save();
            }

            $group_results = new GroupReportResults([
                'id_user' => 1,
                'id_faculty' => $faculty->id,
                'facultad' => trim($rowProperties["Facultad"]), 
                'nivel_alcanzado' => trim($rowProperties["Nivel Alcanzado"]),
                'estado' => trim($rowProperties["Estado"]),
                'cantidad_estudiantes' => trim($rowProperties["Cantidad Estudiantes"]),  
                'rasgo' => trim($rowProperties["Rasgo"]),  
                'evaluacion' => trim($rowProperties["Evaluación"]),  
                'created_at' => now()
            ]);
            $group_results->save();
        });
        return redirect()->action(
            [PDFController::class, 'importar_grupal'], ['message' => 'archivo_importado']
        );
    }
    
    public function usiltemplate_grupal(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        $this->validate($request, [
            'select_facultad'=>'required',
            'imagen_ppa'=>'required',
            'explicacion_ppa'=>'required',
            'imagen_teiq'=>'required',
            'explicacion_teiq'=>'required',
            'imagen_hpti'=>'required',
            'explicacion_hpti'=>'required',
        ]);
        $facultyObj = Faculty::where("id", intval($request->select_facultad))->first();
        $group_report_by_profile = GroupReportProfile::where("id_faculty",intval($request->select_facultad))->selectRaw("competencia, nivel, total_estudiantes")->groupBy("competencia", "nivel", "total_estudiantes")->get();
        $arrComp = [];$arrCompTotales = [];$dataCompetencias = [];
        foreach ($group_report_by_profile as $comp_data){
            $arrComp[$comp_data->competencia]["Nivel 1"] = 0;
            $arrComp[$comp_data->competencia]["Nivel 2"] = 0;
            $arrComp[$comp_data->competencia]["Nivel 3"] = 0;
        }
        foreach ($group_report_by_profile as $comp_data){
            $arrComp[$comp_data->competencia][$comp_data->nivel] = $comp_data->total_estudiantes;
            $arrCompTotales[$comp_data->competencia] = 0;
        }
        $group_report_by_profile_data = GroupReportProfile::where("id_faculty",intval($request->select_facultad))->get();
        foreach ($group_report_by_profile_data as $comp_data){
            if(trim($comp_data->perfil) != ""){
                $dataCompetencias[$comp_data->competencia][$comp_data->nivel]["total_rows"] = 0;
                $dataCompetencias[$comp_data->competencia][$comp_data->nivel]["data"][$comp_data->evaluacion][$comp_data->rasgo][$comp_data->perfil] = $comp_data;
            }
        }
        foreach ($group_report_by_profile_data as $comp_data){
            if(trim($comp_data->perfil) != ""){
                $dataCompetencias[$comp_data->competencia][$comp_data->nivel]["total_rows"]++;
            }
        }

        //Grafica Barra 1
        $grafica_barras_1 = GroupReportResults::where("id_faculty",intval($request->select_facultad))->where("evaluacion",'PPA')->selectRaw("rasgo, SUM(cantidad_estudiantes) as total_cantidad_estudiantes")->groupBy("rasgo")->get();
        $arrGrafica1 = [];$arrGrafica1["D"] = [];$arrGrafica1["I"] = [];$arrGrafica1["S"] = [];$arrGrafica1["C"] = [];
        foreach ($grafica_barras_1 as $obj){
            $letra = strtoupper(substr($obj->rasgo, 0, 1));
            if($letra == "E"){
                $letra = "S";
            }
            $arrGrafica1[$letra] = $obj->total_cantidad_estudiantes;
        }
        $grafica_barras_1_alta = GroupReportResults::where("id_faculty",intval($request->select_facultad))->where("evaluacion",'PPA')->where("estado",'Alto')->selectRaw("rasgo, SUM(cantidad_estudiantes) as total_cantidad_estudiantes")->groupBy("rasgo")->get();
        $arrGrafica1Alta = [];
        $totalGrafica1Alta = 0;
        foreach ($grafica_barras_1_alta as $obj){
            $letra = strtoupper(substr($obj->rasgo, 0, 1));
            if($letra == "E"){
                $letra = "S";
            }
            $arrGrafica1Alta[$letra] = $obj->total_cantidad_estudiantes;
            $totalGrafica1Alta += $obj->total_cantidad_estudiantes;
        }

        //Grafica Barra 2
        //Select rasgo, estado, SUM(cantidad_estudiantes) as total_cantidad_estudiantes from group_report_data_results where evaluacion = 'TEIQ' and id_faculty = 7 group by rasgo, estado
        $grafica_barras_2 = GroupReportResults::where("id_faculty",intval($request->select_facultad))->where("evaluacion",'TEIQ')->selectRaw("rasgo, estado, SUM(cantidad_estudiantes) as total_cantidad_estudiantes")->groupBy("rasgo", "estado")->get();
        $arrGrafica2 = [];$arrLabelEstadoG2 = [];$arrGrafica2Perc = [];$arrRasgos = [];
        foreach ($grafica_barras_2 as $obj){
            $arrRasgos[] = trim($obj->rasgo);
        }
        $arrRasgos = array_unique($arrRasgos);
        foreach ($arrRasgos as $objRasgo){
            $arrGrafica2[$objRasgo]["data"]["Alto"]["label"] = trim($obj->estado);
            $arrGrafica2[$objRasgo]["data"]["Alto"]["value"] = 0;
            $arrGrafica2[$objRasgo]["data"]["Alto"]["total"] = 0;
            $arrGrafica2[$objRasgo]["data"]["Bajo"]["label"] = trim($obj->estado);
            $arrGrafica2[$objRasgo]["data"]["Bajo"]["value"] = 0;
            $arrGrafica2[$objRasgo]["data"]["Bajo"]["total"] = 0;
            $arrGrafica2[$objRasgo]["data"]["Promedio"]["label"] = trim($obj->estado);
            $arrGrafica2[$objRasgo]["data"]["Promedio"]["value"] = 0;
            $arrGrafica2[$objRasgo]["data"]["Promedio"]["total"] = 0;
        }
        foreach ($grafica_barras_2 as $obj){
            $rasgo = trim($obj->rasgo);
            $arrGrafica2[trim($obj->rasgo)]["label"] = $rasgo;
            $arrGrafica2[trim($obj->rasgo)]["data"][trim($obj->estado)]["value"] = $obj->total_cantidad_estudiantes;
            $arrGrafica2[trim($obj->rasgo)]["data"][trim($obj->estado)]["total"] = 0;
            //if(array_search(trim($obj->estado), $arrLabelEstadoG2)<0){
            $arrLabelEstadoG2[] = trim($obj->estado);
            //}
        }
        $total_conteoG2 = 0;$c = 0;
        foreach ($grafica_barras_2 as $obj){
            if ($c === 0) {
                $total_conteoG2 = $arrGrafica2[trim($obj->rasgo)]["data"]['Alto']["value"] + $arrGrafica2[trim($obj->rasgo)]["data"]['Bajo']["value"] + $arrGrafica2[trim($obj->rasgo)]["data"]['Promedio']["value"];$c++;
            }
        }
        $arrLabelEstadoG2 = array_unique($arrLabelEstadoG2);

        $grafica_barras_3 = GroupReportResults::where("id_faculty",intval($request->select_facultad))->where("evaluacion",'HPTI')->selectRaw("rasgo, estado, SUM(cantidad_estudiantes) as total_cantidad_estudiantes")->groupBy("rasgo", "estado")->get();
        $arrGrafica3 = [];$arrLabelEstadoG3 = [];$arrGrafica3Perc = [];$arrRasgos3 = [];
        foreach ($grafica_barras_3 as $obj){
            $arrRasgos3[] = trim($obj->rasgo);
        }
        $arrRasgos3 = array_unique($arrRasgos3);
        foreach ($arrRasgos3 as $objRasgo){
            $arrGrafica3[$objRasgo]["data"]["Bajo"]["label"] = trim($obj->estado);
            $arrGrafica3[$objRasgo]["data"]["Bajo"]["value"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Bajo"]["total"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Moderado"]["label"] = trim($obj->estado);
            $arrGrafica3[$objRasgo]["data"]["Moderado"]["value"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Moderado"]["total"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Óptimo"]["label"] = trim($obj->estado);
            $arrGrafica3[$objRasgo]["data"]["Óptimo"]["value"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Óptimo"]["total"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Excesivo"]["label"] = trim($obj->estado);
            $arrGrafica3[$objRasgo]["data"]["Excesivo"]["value"] = 0;
            $arrGrafica3[$objRasgo]["data"]["Excesivo"]["total"] = 0;
        }
        foreach ($grafica_barras_3 as $obj){
            $rasgo = trim($obj->rasgo);
            $arrGrafica3[trim($obj->rasgo)]["label"] = $rasgo;
            $arrGrafica3[trim($obj->rasgo)]["data"][trim($obj->estado)]["value"] = $obj->total_cantidad_estudiantes;
            $arrGrafica3[trim($obj->rasgo)]["data"][trim($obj->estado)]["total"] = 0;
            $arrLabelEstadoG3[] = trim($obj->estado);
        }
        $arrLabelEstadoG3 = array_unique($arrLabelEstadoG3);
        $total_conteoG3 = 0;$c = 0;
        foreach ($grafica_barras_3 as $obj){
            if ($c === 0) {
                $total_conteoG3 = $arrGrafica3[trim($obj->rasgo)]["data"]['Moderado']["value"] + $arrGrafica3[trim($obj->rasgo)]["data"]['Bajo']["value"] + $arrGrafica3[trim($obj->rasgo)]["data"]['Óptimo']["value"] + $arrGrafica3[trim($obj->rasgo)]["data"]['Excesivo']["value"];$c++;
            }
        }

        return view('pdf.usilgrupal', [
            'faculty' => intval($request->select_facultad),'faculty_name' => trim($facultyObj->name),
            'report_name' => "reporte_grupal_".intval($request->select_facultad)."_".time(),
            'group_report_by_profile' => $dataCompetencias, 'arrComp' => $arrComp,
            'grafica_barras_1' => $grafica_barras_1,
            'arrGrafica1' => $arrGrafica1, 'arrGrafica1Alta' => $arrGrafica1Alta, 'totalGrafica1Alta' => $totalGrafica1Alta,
            'arrGrafica2' => $arrGrafica2, 'arrLabelEstadoG2' => $arrLabelEstadoG2, 'arrRasgos' => $arrRasgos, 'total_conteoG2' => $total_conteoG2,
            'arrGrafica3' => $arrGrafica3, 'arrLabelEstadoG3' => $arrLabelEstadoG3, 'arrRasgos3' => $arrRasgos3, 'total_conteoG3' => $total_conteoG3,
            'imagen_ppa' => $this->convert_to_64($request->imagen_ppa), 'explicacion_ppa' => trim($request->explicacion_ppa),
            'imagen_teiq' => $this->convert_to_64($request->imagen_teiq), 'explicacion_teiq' => trim($request->explicacion_teiq),
            'imagen_hpti' => $this->convert_to_64($request->imagen_hpti), 'explicacion_hpti' => trim($request->explicacion_hpti),
        ]);
    }

    
    public function uploadblob(Request $request)
    {
        $name = explode('.', trim($request->name))[0]; // Filename 'filename'
        $doc_name = $name.".pdf";
        //Storage::put("reportes/".$doc_name, $request->pdf, 'public');
        //Storage::disk('reportes')->put($doc_name, $request->pdf);
        $storagePath = storage_path('app/reportes');
        move_uploaded_file(
            $_FILES['pdf']['tmp_name'], 
            $storagePath."/".$doc_name
        );
        //file_put_contents($storagePath."/".$doc_name, $request->pdf);

        if($request->type == "personal"){
    
            $document = ReportDocument::where("original_file",trim($request->name))->first();
            $document->update([ 'converted_file' => $doc_name ]);
        }elseif($request->type == "grupal"){
            $faculty = Faculty::where("id", intval($request->faculty))->first();
            
            $document = new ReportDocument([
                'id_user' => 1,
                'file_type' => 'pdf_grupal',
                'person' => '',
                'facultad' => $faculty->name,
                'original_file' => '',
                'converted_file' => $doc_name,
                'created_at' => now()
            ]);
            $document->save();
        }

        return response()->json(['file' => $doc_name], 200);
    }

}