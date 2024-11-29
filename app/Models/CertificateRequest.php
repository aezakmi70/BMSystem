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
        'residentAge',
        'residentBirthdate',
        'residentName',
        'certificateToIssue',
        'purpose',
        'orNo',
        'samount',
        'dateRecorded',
        'recordedBy',
        'status',
        'businessName',
        'businessAddress',
        'typeOfBusiness',
    ];

    public function getResidentNameAttribute()
{
    // Assuming the 'resident' relationship is defined, concatenate the first, middle, and last names.
    return $this->resident ? "{$this->resident->firstname} {$this->resident->middlename} {$this->resident->lastname}" : null;
}
public function resident()
{
    return $this->belongsTo(Residents::class, 'residentid'); 
}

public function generatePdf($id)
{
    // Fetch the certificate request
    $record = CertificateRequest::findOrFail($id);
    $data = $record->toArray();

    // Get the certificate type selected
    $certificateType = $record->certificateToIssue;  // Assuming 'certificateToIssue' holds the index of the selected certificate
    
    // Match the certificate type with the templates
    $certificateTemplate = $this->getCertificateTemplate($certificateType);
    
    // Generate PDF using the Blade template
    $pdf = Pdf::loadView($certificateTemplate, ['record' => $data]);

    // Check if the user wants to download the file
    if (request()->has('download')) {
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'certificate_request_' . now()->format('YmdHis') . '.pdf'
        );
    }

    // Default: display the PDF inline in the browser
    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="certificate_request_' . now()->format('YmdHis') . '.pdf"');
}

// Helper function to return the Blade view for the selected certificate
protected function getCertificateTemplate($certificateType)
{
    // Map the selected certificate type to its Blade template
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

    // Return the corresponding Blade view or a default one if not found
    return $templates[$certificateType] ?? 'certificates.default';
}
        protected $casts = [
        'dateRecorded' => 'datetime',
    ];
   
    
}
