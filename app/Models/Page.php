<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id'); // One parent
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id'); // Multiple children
    }
}
