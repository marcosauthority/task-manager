<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [ 'name', 'description', 'priority', 'completed', 'date_due', 'user_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
