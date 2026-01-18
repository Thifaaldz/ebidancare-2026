<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationGroup = 'Keuangan';

    /**
     * =========================
     * FORM
     * =========================
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('patient_id')
                    ->label('Pasien')
                    ->relationship('patient', 'nama')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('layanan')
                    ->label('Jenis Layanan')
                    ->required()
                    ->maxLength(150),

                TextInput::make('nominal')
                    ->label('Nominal (Rp)')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                DatePicker::make('tanggal')
                    ->label('Tanggal Transaksi')
                    ->required(),

                Hidden::make('created_by')
                    ->default(fn () => Auth::id()),
            ]);
    }

    /**
     * =========================
     * TABLE
     * =========================
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('patient.nama')
                    ->label('Pasien')
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('layanan')
                    ->label('Layanan')
                    ->searchable(),

                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR', true)
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label('Dicatat Oleh')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('tanggal', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('tanggal', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit'   => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
