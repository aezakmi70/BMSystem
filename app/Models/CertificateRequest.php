<?php

namespace App\Models;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateRequest extends Model
{
    use HasFactory;

    /**
     
     * @var array<int, string>
     */
    protected $table = 'clearance_tbl';
    protected $fillable = [
        'residentid',
        'resident_age',
        'resident_birthdate',
        'resident_name',
        'certificate_to_issue',
        'purpose',
        'or_no',
        'samount',
        'date_recorded',
        'recorded_by',
        'status',
        'business_name',
        'business_address',
        'typeOf_business',
        'present_official',
        'official_position',
    ];


public function income()
    {
        return $this->hasOne(Income::class, 'certificate_request_id', 'id');
    }
    
public function resident()
{
    return $this->belongsTo(Residents::class, 'residentid'); 
}
public function official()
{
    return $this->belongsTo(Official::class, 'officialid'); 
}

public function generatePdf($id)
{

    $record = CertificateRequest::findOrFail($id);
    $data = $record->toArray();


    $certificateType = $record->certificateToIssue;  
    

    $certificateTemplate = $this->getCertificateTemplate($certificateType);
    

    $pdf = Pdf::loadView($certificateTemplate, ['record' => $data]);


    if (request()->has('download')) {
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'certificate_request_' . now()->format('YmdHis') . '.pdf'
        );
    }


    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="certificate_request_' . now()->format('YmdHis') . '.pdf"');
}


protected function getCertificateTemplate($certificateType)
{

    $templates = [
        0 => 'certificates.indigency',      // Certificate of Indigency
        1 => 'certificates.clearance',      // BRGY. Clearance
        2 => 'certificates.residency',      // Certificate of Residency
        3 => 'certificates.low_income',     // Certificate of Low Income
        4 => 'certificates.business_clearance', // Business Clearance
        5 => 'certificates.business_permit',   // Business Permit
        6 => 'certificates.cedula',            // Cedula
        7 => 'certificates.cutting_permit',    // Cutting Permit
    ];

    return $templates[$certificateType] ?? 'certificates.default';
}
        protected $casts = [
        'dateRecorded' => 'datetime',
    ];
   
    
}
