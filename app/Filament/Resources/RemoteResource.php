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
use Closure;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;

class RemoteResource extends Resource
{
    protected static ?string $model = Remote::class;

    protected static ?string $navigationIcon = 'heroicon-s-home';

    protected static ?int $navigationSort = 3;

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
                    ->required()
                    ->disabledOn('edit')
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            if (isStartTimeBeforeNow($get('time_range')) && $value === 'Have plan') {
                                $fail("The plan data is invalid.");
                            }
                        }]),
                Forms\Components\Select::make('approver_id')
                    ->options(
                        User::query()->where('role_id', 1)
                                    ->orWhere('role_id', 2)
                                    ->pluck('name', 'id')
                    )
                    ->required()
                    ->label('Approver')
                    ->disabledOn('edit'),
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
                    ->columnSpanFull()
                    ->visibleOn('create'),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->disabledOn('edit')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('remedies')
                    ->required()
                    ->disabledOn('edit')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('reject_reason')
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\TextColumn::make('approver.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Reject' => 'gray',
                        'Wait confirm' => 'warning',
                        'Confirmed' => 'success',
                        'Cancel' => 'danger',
                        'Pending' => 'info',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Wait confirm' => 'Wait confirm',
                        'Confirmed' => 'Confirmed',
                        'Reject' => 'Reject',
                        'Cancel' => 'Cancel',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
                ])
            ->bulkActions([
                //
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
            'view' => Pages\ViewRemote::route('/{record}'),
        ];
    }
}
