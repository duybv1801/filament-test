<?php

namespace App\Filament\Resources\RemoteResource\Pages;

use App\Filament\Resources\RemoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class EditRemote extends EditRecord
{
    protected static string $resource = RemoteResource::class;

    protected static string $view = 'filament.resources.remotes.pages.edit-remote';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Approve')
                ->successRedirectUrl($this->getResource()::getUrl('index'))
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Approved')
                        ->body('The remote form has been approved successfully.'),
                )
                ->action(function (Model $record, array $data) {
                    $data['status'] = 'Confirmed';
                    $record->update($data);
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Approved')
            ->body('The remote form has been approved successfully.');
    }
}
