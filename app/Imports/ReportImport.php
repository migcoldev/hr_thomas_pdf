<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            'RESULTADO1' => new FirstPageImport(),
            'RESULTADO2' => new SecondPageImport(),
        ];
    }
}