<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecords extends Model
{
    use HasFactory;

    public function certificateRequest()
    {
        return $this->belongsTo(CertificateRequest::class, 'certificate_request_id');
    }
}
