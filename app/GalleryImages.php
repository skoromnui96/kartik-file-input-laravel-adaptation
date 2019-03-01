<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class GalleryImages extends Model
{
    protected $table = 'images';
    protected $fillable = ['original_filename', 'filename', 'size', 'mime'];
}