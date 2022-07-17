<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudyRequest extends Model
{
   use HasFactory;

   protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'phone',
      'case_study_title',
      'case_study_emailed',
   ];

   protected $casts = [
      'case_study_emailed' => 'boolean'
   ];
}
