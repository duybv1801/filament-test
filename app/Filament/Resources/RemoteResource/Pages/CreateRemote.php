<?php

namespace App\Filament\Resources\RemoteResource\Pages;

use App\Filament\Resources\RemoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateRemote extends CreateRecord
{
    protected static string $resource = RemoteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'Wait censorship';
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Remote registered')
            ->body('The remote form has been created successfully.');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create($data);
        foreach($data['time_range'] as $periodData) {
            $periodData['remotePeriods']['total'] = 
                calculator_working_hours($periodData['remotePeriods']['start'], $periodData['remotePeriods']['end']);
            $record->remotePeriods()->create($periodData['remotePeriods']);
        }

        return $record;
    }
}
