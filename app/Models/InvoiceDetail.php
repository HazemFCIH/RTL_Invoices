<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sections()
    {
        return $this->belongsTo(Section::class,'section','id');
    }
    public function invoices()
    {
        return $this->belongsTo(Invoice::class,'section','id');
    }
}
