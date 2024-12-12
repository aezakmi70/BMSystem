<?php

namespace App\Filament\Resources\CertificateRequestResource\Pages;

use App\Filament\Resources\CertificateRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificateRequest extends CreateRecord
{
    
    protected static string $resource = CertificateRequestResource::class;
    
    protected function getHeaderActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            
                                                
        ]);
    }

    
}

