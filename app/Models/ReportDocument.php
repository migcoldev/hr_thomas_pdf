<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class ReportDocument extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_document';
    //

    protected $fillable = [
        'id_user', 
        'file_type', 
        'person', 
        'original_file',  
        'converted_file',  
        'created_at'];
}
