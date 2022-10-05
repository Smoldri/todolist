<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;


    protected $fillable = [
        "description",
        "user_id"

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @return Builder
     */
    public function scopeStatus($query)
    {
        if (request('status')) {
            $query
                ->where('completed', 'like', '%' . request('status') . '%');
}

    }
    public function scopeDescription($query)
    {
        if (request('search-description')) {
            $query
                ->where('description', 'like', '%' . request('search-description') . '%');
        }

    }


}
