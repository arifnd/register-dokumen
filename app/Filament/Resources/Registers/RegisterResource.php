<?php

namespace App\Filament\Resources\Registers;

use App\Filament\Resources\Registers\Pages\ManageRegisters;
use App\Models\Register;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RegisterResource extends Resource
{
    protected static ?string $model = Register::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $slug = 'register';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->closeOnDateSelection()
                    ->displayFormat('d F Y')
                    ->native(false)
                    ->required(),
                TextInput::make('perihal')
                    ->required()
                    ->maxLength(255),
                TextInput::make('keterangan')
                    ->maxLength(255),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->defaultGroup(
                Group::make('tanggal')
                    ->getTitleFromRecordUsing(
                        fn (Register $record): string => $record->tanggal->translatedFormat('d F Y')
                    )
                    ->orderQueryUsing(
                        fn (Builder $query, string $direction) => $query->orderBy('tanggal', 'desc')
                    )
                    ->titlePrefixedWithLabel(false),
            )
            ->columns([
                TextColumn::make('tanggal')
                    ->date('d F Y'),
                TextColumn::make('nomor')
                    ->copyable()
                    ->copyMessage('Nomor sudah disalin')
                    ->icon('heroicon-m-document-duplicate')
                    ->iconPosition(IconPosition::After)
                    ->weight(FontWeight::Bold),
                TextColumn::make('perihal')
                    ->grow()
                    ->searchable(),
                TextColumn::make('keterangan'),
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->visible(fn (): bool => Auth::id() === 1),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRegisters::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->owned();
    }
}
