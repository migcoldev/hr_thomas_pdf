<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.index');
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
        /*foreach ($request->archivos as $archivo) {
            $fullname = $archivo->getClientOriginalName();
            $name = explode('.', $fullname)[0]; // Filename 'filename'
            $extension = $archivo->getClientOriginalExtension();
            $new_name = $name."-".time().".".$extension;
            $filename = $archivo->storeAs(
                'originales', $new_name
            );
            $archivos_originales[] = $new_name;
        }
        return view('pdf.convertir', ["archivos_originales" => $archivos_originales]);
        */
        $fullname = $request->file('archivos')->getClientOriginalName();
        $name = explode('.', $fullname)[0]; // Filename 'filename'
        $extension = $request->file('archivos')->getClientOriginalExtension();
        $new_name = $name."-".time().".".$extension;
        $filename = $request->file('archivos')->storeAs(
            'originales', $new_name
        );
        return redirect()->action(
            [PDFController::class, 'usiltemplate'], ['new_name' => $new_name]
        );
        //return view('pdf.convertir', ["new_name" => $new_name]);
        //return redirect()->action([PDFController::class, 'importar']);
    }
    
    public function usiltemplate(Request $request)
    {
        /*$this->validate($request, [
            'archivos'=>'required',
        ]);*/
        
        //foreach ($request->archivos as $archivo) {
          
        return view('pdf.usil', ['name' => $request->new_name]);
        //return redirect()->action([PDFController::class, 'importar']);
    }
    
    public function uploadblob(Request $request)
    {
        $name = explode('.', trim($request->name))[0]; // Filename 'filename'
        Storage::put("reportes/".$name.".pdf", $request->pdf);
        return response()->json(['file' => "reportes/".$name.".pdf"]);
    }

}