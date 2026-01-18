<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Pasien';

    protected static ?string $pluralModelLabel = 'Pasien';

    protected static ?string $navigationGroup = 'Manajemen Pasien';

    /**
     * =========================
     * FORM (CREATE & EDIT)
     * =========================
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                TextInput::make('nama')
                    ->label('Nama Pasien')
                    ->required()
                    ->maxLength(150),

                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'P' => 'Perempuan',
                        'L' => 'Laki-laki',
                    ])
                    ->required(),

                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(3),

                TextInput::make('no_hp')
                    ->label('No. HP')
                    ->tel()
                    ->maxLength(20),
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

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->formatStateUsing(fn ($state) => $state === 'P' ? 'Perempuan' : 'Laki-laki'),

                TextColumn::make('tanggal_lahir')
                    ->label('Tgl Lahir')
                    ->date('d M Y'),

                TextColumn::make('no_hp')
                    ->label('No. HP'),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y'),
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
     * RELATIONS (NANTI)
     * =========================
     */
    public static function getRelations(): array
    {
        return [
            // Akan diisi MedicalRecordsRelationManager
            // Akan diisi DocumentsRelationManager
        ];
    }

    /**
     * =========================
     * PAGES
     * =========================
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit'   => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
