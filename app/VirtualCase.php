<?php  namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualCase extends Model
{
    protected $table = 'cases';

    protected $fillable = ['virtual_slide_provider_id', 'clinical_data', 'category_id'];

    public function slides()
    {
        return $this->hasMany('App\VirtualSlide', 'case_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function provider()
    {
        return $this->belongsTo('App\VirtualSlideProvider', 'virtual_slide_provider_id');
    }
} 