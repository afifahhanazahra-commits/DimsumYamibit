<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_pelanggan', 'rating', 'komentar'])]
class Review extends Model
{
    //
}
