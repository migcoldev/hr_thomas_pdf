<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class GroupReportProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_report_data_by_profile';
    //
    protected $fillable = [
        'id_user', 
        'id_faculty',
        'facultad', 
        'evaluacion',
        'rasgo',
        'competencia',  
        'nivel',  
        'llave',  
        'perfil',  
        'fortaleza', 
        'fortaleza_descripcion',  
        'oportunidad',  
        'oportunidad_descripcion',  
        'conteo',  
        'total_estudiantes',  
        'created_at'];
}