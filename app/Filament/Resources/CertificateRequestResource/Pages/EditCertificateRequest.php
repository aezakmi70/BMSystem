<?php

namespace App\Filament\Resources\CertificateRequestResource\Pages;

use App\Filament\Resources\CertificateRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Session;

class EditCertificateRequest extends EditRecord
{
    protected static string $resource = CertificateRequestResource::class;

    // Flag for determining if the record is saved
    protected function getHeaderActions(): array
    {
        // Check if the record has been saved or not from the session
        $recordSaved = Session::get('record_saved', false);
        Session::forget('record_saved');

        return [
            Actions\DeleteAction::make(),

            // Print action
            Actions\Action::make('print')
                ->label('Print Certificate')
                ->icon('heroicon-o-printer')
                ->color('secondary')
                ->url(fn () => route('print.certificate', ['id' => $this->record->id]))
                ->openUrlInNewTab()
                ->disabled(!$recordSaved), 

            // Download action
            Actions\Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('print.certificate', ['id' => $this->record->id]) . '?download=true')
                ->color('secondary')
                ->disabled(!$recordSaved), 
                
                
        ];
    }

    // Handle after saving the record
    protected function afterSave(): void
    {
        // Set the session to indicate that the record has been saved
        Session::put('record_saved', true);


        // Redirect to refresh the page and enable the buttons
        $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->record->getKey()]));
       
    }
}
