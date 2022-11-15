<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingCash extends Model
{
    use HasFactory;
    protected $table = 'incoming_cash';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'invoice_number';
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
