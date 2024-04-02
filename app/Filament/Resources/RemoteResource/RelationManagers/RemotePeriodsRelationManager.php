<?php

namespace App\Filament\Resources\RemoteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RemotePeriodsRelationManager extends RelationManager
{
    protected static string $relationship = 'remotePeriods';

    protected static ?string $title = 'Remote Time';
    public function form(Form $form): Form
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start'),
                Tables\Columns\TextColumn::make('end'),
                Tables\Columns\TextColumn::make('total')
                    ->suffix(' h'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
               //
            ])
            ->bulkActions([
                //
            ]);
    }
}
