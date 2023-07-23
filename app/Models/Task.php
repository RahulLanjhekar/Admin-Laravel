<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [ 'title', 'description', 'user_id', 'due_date' ];

    public $sortable = ['id', 'title', 'description'];

    protected $dates = ['due_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
