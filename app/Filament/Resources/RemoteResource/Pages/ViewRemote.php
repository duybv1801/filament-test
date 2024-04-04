<?php

namespace App\Filament\Resources\RemoteResource\Pages;

use App\Filament\Resources\RemoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;

class ViewRemote extends ViewRecord
{
    protected static string $resource = RemoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->form([
                    Forms\Components\Textarea::make('reject_reason')
                        ->required()
                        ->maxLength(255),
                ])
                ->successNotification(
                    Notification::make()
                         ->success()
                         ->title('User updated')
                         ->body('The user has been saved successfully.'),
                 ),
        ];
    }
}
