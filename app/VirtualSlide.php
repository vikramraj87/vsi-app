<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualSlide extends Model
{
    protected $fillable = ['url', 'stain', 'remarks'];
}
