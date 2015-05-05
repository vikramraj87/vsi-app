<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'category'
    ];

    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }


}
