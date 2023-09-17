<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author'];
    public function toCsv(): array
    {
        return [
            'Title' => $this->title,
            'Author' => $this->author,
        ];
    }
}
