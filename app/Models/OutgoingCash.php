<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingCash extends Model
{
    use HasFactory;
    protected $table = 'outgoing_cash';

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return "note_number";
    }
}
