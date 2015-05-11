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

    public function cases()
    {
        return $this->hasMany('App\VirtualCase', 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }
}
