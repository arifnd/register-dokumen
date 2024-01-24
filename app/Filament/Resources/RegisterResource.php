<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterResource\Pages;
use App\Models\Register;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegisterResource extends Resource
{
    protected static ?string $model = Register::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $slug = 'register';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->required(),
                Forms\Components\TextInput::make('perihal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan')
                    ->maxLength(255),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->defaultGroup(
                Tables\Grouping\Group::make('tanggal')
                    ->getTitleFromRecordUsing(
                        fn (Register $record): string => $record->tanggal->translatedFormat('d F Y')
                    )
                    ->orderQueryUsing(
                        fn (Builder $query, string $direction) => $query->orderBy('tanggal', 'desc')
                    )
                    ->titlePrefixedWithLabel(false),
            )
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d F Y'),
                Tables\Columns\TextColumn::make('nomor')
                    ->copyable()
                    ->copyMessage('Nomor sudah disalin')
                    ->icon('heroicon-m-document-duplicate')
                    ->iconPosition(IconPosition::After)
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('perihal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->visible(fn (): bool => auth()->id() === 1),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRegisters::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->owned();
    }
}
