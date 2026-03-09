<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcation extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['order_id', 'payment_id', 'amount', 'status'];
    const UPDATED_AT = null;

}
