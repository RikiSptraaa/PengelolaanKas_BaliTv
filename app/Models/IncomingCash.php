<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingCash extends Model
{
    use HasFactory;


    public function getRouteKeyName()
    {
        return 'invoice_number';
    }
    protected $table = 'incoming_cash';
    protected $guarded = ['id'];
    protected $fillable = [
        'invoice_number',
        'user_id',
        'client',
        'acc_type',
        'paid_date',
        'total',
        'note'

    ];


    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
