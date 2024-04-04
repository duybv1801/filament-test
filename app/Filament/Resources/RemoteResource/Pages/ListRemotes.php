<?php

namespace App\Filament\Resources\RemoteResource\Pages;

use App\Filament\Resources\RemoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListRemotes extends ListRecords
{
    protected static string $resource = RemoteResource::class;

    protected static ?string $model = Remote::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $userId = auth()->id();
        return [
            'My form' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', $userId)),
            'Manager' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('approver_id', $userId))
                ->icon('heroicon-m-user-group')
                ->badge(static::getModel()::query()->where('approver_id', $userId)
                    ->where(function($query) {
                        $query->where('status', '=', 'pending')
                            ->orWhere('status', '=', 'wait cofirmm');
                    })->count())
                ->badgeColor('danger'),
        ];
    }
}
