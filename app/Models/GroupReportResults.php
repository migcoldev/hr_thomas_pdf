<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class GroupReportResults extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_report_data_results';
    //
    protected $fillable = [
        'id_user', 
        'id_faculty',
        'facultad', 
        'nivel_alcanzado',
        'estado',
        'cantidad_estudiantes',  
        'rasgo',  
        'evaluacion',  
        'created_at'];
}
