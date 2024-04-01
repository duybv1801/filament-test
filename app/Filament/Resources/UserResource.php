<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    // protected static ?string $navigationLabel = 'User';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    protected static ?string $navigationBadgeTooltip = 'The number of users';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getAvatarFormField(),
                static::getNameFormField(),
                static::getEmailFormField(),
                static::getPasswordFormField(),
                static::getPasswordConfirmFormField(),
                static::getRoleFormField(),
                static::getGenderFormField(),
                static::getStartDateFormField(),
                static::getPhoneFormField(),
                static::getBirthdayFormField(),
            ]);
    }

    public static function getAvatarFormField(): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make('avatar')
            ->visibleOn('edit')
            ->avatar()
            ->columnSpan('full');
    }

    public static function getNameFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->disabledOn('edit');
    }

    public static function getEmailFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('email')
            ->label('Email address')
            ->email()
            ->required()
            ->unique(ignoreRecord: true)
            ->autocomplete(false)
            ->maxLength(255)
            ->disabledOn('edit');
    }

    public static function getPasswordFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('password')
            ->password()
            ->required()
            ->autocomplete(false)
            ->revealable()
            ->visibleOn('create');
    }

    public static function getPasswordConfirmFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('password_confirmation')
            ->password()
            ->same('password')
            ->required()
            ->revealable()
            ->visibleOn('create');
    }

    public static function getRoleFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('role')
            ->relationship(name: 'role', titleAttribute: 'role')
            ->default(3)
            ->native(false)
            ->hiddenOn('edit');
    }

    public static function getGenderFormField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('gender')
            ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                'Other' => 'Other',
            ])
            ->default('Male')
            ->native(false);
    }

    public static function getStartDateFormField(): Forms\Components\DatePicker
    {
        return Forms\Components\DatePicker::make('start_date')
            ->closeOnDateSelection()
            ->minDate(now()->subYears(150))
            ->maxDate(now());
    }

    public static function getPhoneFormField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('phone')
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
            ->hiddenOn('create');
    }

    public static function getBirthdayFormField(): Forms\Components\DatePicker
    {
        return Forms\Components\DatePicker::make('birthday')
            ->closeOnDateSelection()
            ->minDate(now()->subYears(150))
            ->maxDate(now());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.role'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('birthday')
                    ->dateTime('d/m/Y')
                    ->sortable(),

            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
