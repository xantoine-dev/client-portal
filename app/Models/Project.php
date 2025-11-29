<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'status',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }

    public function changeRequests()
    {
        return $this->hasMany(ChangeRequest::class);
    }
}
