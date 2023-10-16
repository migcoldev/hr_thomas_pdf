<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Faculty extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faculty';
    //

    protected $fillable = [
        'name', 
        'created_at'];
}
