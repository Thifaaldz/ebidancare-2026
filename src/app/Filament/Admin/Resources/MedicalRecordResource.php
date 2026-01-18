<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MedicalRecordResource\Pages;
use App\Models\MedicalRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationLabel = 'Rekam Medis';

    protected static ?string $pluralModelLabel = 'Rekam Medis';

    protected static ?string $navigationGroup = 'Layanan Medis';

    /**
     * =========================
     * FORM (CREATE & EDIT)
     * =========================
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                /* =============================
                 * PASIEN
                 * ============================= */
                Select::make('patient_id')
                    ->label('Pasien')
                    ->relationship('patient', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                /* =============================
                 * JENIS LAYANAN
                 * ============================= */
                Select::make('type')
                    ->label('Jenis Layanan')
                    ->options([
                        'ANC' => 'ANC (Ibu Hamil)',
                        'KB' => 'KB',
                        'NEONATAL' => 'Neonatal',
                    ])
                    ->required(),

                /* =============================
                 * TANGGAL PEMERIKSAAN
                 * ============================= */
                DatePicker::make('tanggal_pemeriksaan')
                    ->label('Tanggal Pemeriksaan')
                    ->required(),

                /* =============================
                 * CATATAN MEDIS
                 * ============================= */
                Textarea::make('catatan')
                    ->label('Catatan Medis')
                    ->rows(5)
                    ->required(),

                /* =============================
                 * AUDIT (HIDDEN)
                 * ============================= */
                Hidden::make('created_by')
                    ->default(fn () => Auth::id()),
            ]);
    }

    /**
     * =========================
     * TABLE (LIST DATA)
     * =========================
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('patient.nama')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('type')
                    ->label('Layanan')
                    ->colors([
                        'success' => 'ANC',
                        'warning' => 'KB',
                        'info' => 'NEONATAL',
                    ]),

                TextColumn::make('tanggal_pemeriksaan')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label('Dicatat Oleh')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Waktu Input')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Layanan')
                    ->options([
                        'ANC' => 'ANC',
                        'KB' => 'KB',
                        'NEONATAL' => 'Neonatal',
                    ]),
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

    /**
     * =========================
     * RELATIONS
     * =========================
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * =========================
     * PAGES
     * =========================
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMedicalRecords::route('/'),
            'create' => Pages\CreateMedicalRecord::route('/create'),
            'edit'   => Pages\EditMedicalRecord::route('/{record}/edit'),
        ];
    }
}
