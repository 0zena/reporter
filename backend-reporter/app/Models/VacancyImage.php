<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id', 
        'image_path'
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
