<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportDocument;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class PDFController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        $documents = ReportDocument::where("file_type",'pdf')->orderBy("id","desc")->get();
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
        $new_name = "reporte-importado-".time().".".$extension;
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
                'file_type' => 'pdf',
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
                /*$data['info_global']['candidato'] = $rowProperties["candidato"];
                $data['info_global']['carrera'] = $rowProperties["carrera"];
                $data['info_global']['facultad'] = $rowProperties["facultad"];
                $data['info_global']['nivel_promedio'] = $rowProperties["nivel_promedio"];*/
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
                'definicion' => $rowProperties["definicion"]
            ];
            $arrAux['resultados_generales'][] = $data;
            session(['report' => $arrAux]);
        });
        $rows = SimpleExcelReader::create(Storage::disk('local')->path("originales/".$document->original_file), 'xlsx')->trimHeaderRow()
        ->fromSheetName("Resultado2")
        ->useHeaders(['candidato','carrera','facultad','nivel_promedio','Evaluación','Rasgo','Resultado','Detalle'])
        ->getRows();
        $rows->each(function(array $rowProperties) {
            if($rowProperties["Evaluación"] != ""){
                $arrAux = session('report', []);
                $data = [
                    'evaluacion' => $rowProperties["Evaluación"],
                    'rasgo' => $rowProperties["Rasgo"],
                    'resultado' => $rowProperties["Resultado"],
                    'detalle' => $rowProperties["Detalle"]
                ];
                $arrAux['perfil_ideal'][] = $data;
                session(['report' => $arrAux]);
            }
        });
        $report_data = session('report', []);


        $total_nivel1 = 0;$total_nivel2 = 0;$total_nivel3 = 0;
        for($i=0;$i<count($report_data["resultados_generales"]);$i++){
            if(strtolower($report_data["resultados_generales"][$i]["nivel"]) == "nivel 1" || $report_data["resultados_generales"][$i]["nivel"] === 1){
                $total_nivel1++;
            }
            if(strtolower($report_data["resultados_generales"][$i]["nivel"]) == "nivel 2" || $report_data["resultados_generales"][$i]["nivel"] === 2){
                $total_nivel2++;
            }
            if(strtolower($report_data["resultados_generales"][$i]["nivel"]) == "nivel 3" || $report_data["resultados_generales"][$i]["nivel"] === 3){
                $total_nivel3++;
            }
        }
        $grafica1 = [
            'total_nivel1' => $total_nivel1,
            'total_nivel2' => $total_nivel2,
            'total_nivel3' => $total_nivel3,
        ];

        $total_fortalezas = 0;$total_oportunidades = 0;
        for($i=0;$i<count($report_data["perfil_ideal"]);$i++){
            if(strtolower($report_data["perfil_ideal"][$i]["resultado"]) == "fortaleza"){
                $total_fortalezas++;
            }
            if(strtolower($report_data["perfil_ideal"][$i]["resultado"]) == "oportunidad de mejora"){
                $total_oportunidades++;
            }
        }
        $grafica3 = [
            'fortalezas' => $total_fortalezas,
            'oportunidades' => $total_oportunidades,
            'total' => $total_fortalezas + $total_oportunidades,
            'fortalezas_porc' => round((100 * $total_fortalezas / ($total_fortalezas + $total_oportunidades)), 2),
            'oportunidades_porc' => round((100 * $total_oportunidades / ($total_fortalezas + $total_oportunidades)), 2)
        ];
          
        return view('pdf.usil', ['name' => $document->original_file, 'report' => $report_data, 'grafica1' => $grafica1, 'grafica3' => $grafica3 ]);
        //return redirect()->action([PDFController::class, 'importar']);
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

        $document = ReportDocument::where("original_file",trim($request->name))->first();
        $document->update([ 'converted_file' => $doc_name ]);

        return response()->json(['file' => $doc_name], 200);
    }

}