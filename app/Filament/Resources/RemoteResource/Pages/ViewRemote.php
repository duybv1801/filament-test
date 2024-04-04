<?php

namespace App\Filament\Resources\RemoteResource\Pages;

use App\Filament\Resources\RemoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class ViewRemote extends ViewRecord
{
    protected static string $resource = RemoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('list')
                ->url($this->getResource()::getUrl('index')),
            Actions\Action::make('Approve')
                ->action(function (Model $record, array $data) {
                    $data['status'] = 'Confirmed';
                    $record->update($data);
                    Notification::make()
                        ->success()
                        ->title('Remote approved')
                        ->body('The remote form has been approved successfully.')
                        ->send();
                    return redirect($this->getResource()::getUrl('index'));
                })
                ->color('info'),
            Actions\EditAction::make()
                ->form([
                    Forms\Components\Textarea::make('reject_reason')
                        ->required()
                        ->maxLength(255),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    $data['status'] = 'Reject';
             
                    return $data;
                })
                ->label('Reject')
                ->color('danger')
                ->successRedirectUrl($this->getResource()::getUrl('index'))
                ->successNotification(
                    Notification::make()
                         ->success()
                         ->title('Remote rejected')
                         ->body('The remote form has been rejected successfully.'),
                ),
        ];
    }
}
