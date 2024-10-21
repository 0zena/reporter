<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'speciality_id',
        'vacancy_image_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancyImage()
    {
        return $this->belongsTo(VacancyImage::class, 'vacancy_image_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

}