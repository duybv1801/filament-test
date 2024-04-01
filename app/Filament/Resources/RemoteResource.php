<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RemoteResource\Pages;
use App\Filament\Resources\RemoteResource\RelationManagers;
use App\Models\Remote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class RemoteResource extends Resource
{
    protected static ?string $model = Remote::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('have_plan')
                    ->label('Plan')
                    ->options([
                        'Have plan' => 'Have plan',
                        'Not plan' => 'Not plan',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('approver_id')
                    ->options(
                        User::query()->where('role_id', 1)
                                    ->orWhere('role_id', 2)
                                    ->pluck('name', 'id')
                    )
                    ->required(),
                
                Forms\Components\Repeater::make('time_range')
                    ->schema([
                        Forms\Components\DatePicker::make('remotePeriods.date')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required(),
                        Forms\Components\TimePicker::make('remotePeriods.start')
                            ->native(false)
                            ->minutesStep(15)
                            ->seconds(false)
                            ->native(false)
                            ->before('remotePeriods.end')
                            ->required(),
                        Forms\Components\TimePicker::make('remotePeriods.end')
                            ->native(false)
                            ->minutesStep(15)
                            ->seconds(false)
                            ->native(false)
                            ->required(),
                    ])->columns(3)
                    ->reorderable(false)
                    ->addActionLabel('Add time range')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('remedies')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('reject_reason')
                    ->columnSpanFull()
                    ->visibleOn('approve'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('have_plan'),
                Tables\Columns\TextColumn::make('approver_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RemotePeriodsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRemotes::route('/'),
            'create' => Pages\CreateRemote::route('/create'),
            'edit' => Pages\EditRemote::route('/{record}/edit'),
        ];
    }
}
