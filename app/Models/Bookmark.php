<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'ad_id'];

    public function ad():BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
