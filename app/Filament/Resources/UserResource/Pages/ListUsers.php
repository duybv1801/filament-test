<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Admin' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role_id', 1)),
            'Manager' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role_id', 2)),
            'Member' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role_id', 3)),
        ];
    }
}
