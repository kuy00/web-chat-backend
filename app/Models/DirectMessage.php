<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('created_at');
    }

    public function directMessageContents()
    {
        return $this->hasMany(DirectMessageContent::class);
    }

    public function scopeCreateDirectMesage($query, $name, $users)
    {
        $directMessage = $query->create([
            'name' => $name,
        ]);
        $directMessage->users()->attach($users);

        return $directMessage;
    }
}
