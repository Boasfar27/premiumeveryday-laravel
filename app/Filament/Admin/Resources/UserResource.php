<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengguna')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nama'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(20)
                                    ->label('Nomor Telepon'),
                            ]),
                    ]),
                
                Section::make('Keamanan')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->maxLength(255)
                                    ->label('Password'),
                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->label('Email Terverifikasi Pada'),
                            ]),
                    ]),
                
                Section::make('Status dan Peran')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('role')
                                    ->required()
                                    ->options([
                                        0 => 'Pengguna',
                                        1 => 'Admin',
                                    ])
                                    ->default(0)
                                    ->label('Peran'),
                                Forms\Components\Toggle::make('is_active')
                                    ->required()
                                    ->default(true)
                                    ->label('Aktif'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('Nomor Telepon'),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '0' => 'Pengguna',
                        '1' => 'Admin',
                        default => 'Tidak Diketahui',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'info',
                        '1' => 'success',
                        default => 'gray',
                    })
                    ->sortable()
                    ->label('Peran'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Aktif'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->boolean()
                    ->sortable()
                    ->label('Email Terverifikasi')
                    ->getStateUsing(fn ($record): bool => filled($record->email_verified_at)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->label('Dibuat Pada'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        0 => 'Pengguna',
                        1 => 'Admin',
                    ])
                    ->label('Peran'),
                Tables\Filters\Filter::make('is_active')
                    ->toggle()
                    ->label('Aktif')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Tables\Filters\Filter::make('email_verified')
                    ->toggle()
                    ->label('Email Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('impersonate')
                    ->label('Login Sebagai')
                    ->icon('heroicon-o-identification')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (User $user) {
                        auth()->user()->impersonate($user);
                        return redirect()->route('filament.admin.pages.dashboard');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\SubscriptionsRelationManager::class,
            RelationManagers\LicensesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengguna';
    }
}
