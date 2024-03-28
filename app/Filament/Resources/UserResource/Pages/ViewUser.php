<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('list')
                ->url($this->getResource()::getUrl('index')),
            Action::make('update')
                ->url($this->getResource()::getUrl('edit', ['record' => $this->getRecord()])),
            // Action::make('delete')
            //     ->requiresConfirmation()
            //     ->action(fn () => $this->post->delete()),
        ];
    }
}
