<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Auth;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Arsip Dokumen';

    protected static ?string $pluralModelLabel = 'Arsip Dokumen';

    protected static ?string $navigationGroup = 'Manajemen Arsip';

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
                 * JENIS DOKUMEN
                 * ============================= */
                Select::make('document_type')
                    ->label('Jenis Dokumen')
                    ->options([
                        'ANC' => 'ANC',
                        'KB' => 'KB',
                        'NEONATAL' => 'Neonatal',
                        'LAINNYA' => 'Lainnya',
                    ])
                    ->required(),

                /* =============================
                 * UPLOAD FILE (R2)
                 * ============================= */
                FileUpload::make('file_path')
                    ->label('File Dokumen')
                    ->disk('r2')
                    ->directory('pasien')
                    ->visibility('private')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/jpeg',
                        'image/png',
                    ])
                    ->maxSize(5120) // 5 MB
                    ->preserveFilenames()
                    ->required(),

                /* =============================
                 * AUDIT FIELD
                 * ============================= */
                Hidden::make('uploaded_by')
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

                BadgeColumn::make('document_type')
                    ->label('Jenis')
                    ->colors([
                        'success' => 'ANC',
                        'warning' => 'KB',
                        'info' => 'NEONATAL',
                        'gray' => 'LAINNYA',
                    ]),

                TextColumn::make('file_name')
                    ->label('Nama File')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->file_name),

                TextColumn::make('uploader.name')
                    ->label('Diunggah Oleh')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->label('Jenis Dokumen')
                    ->options([
                        'ANC' => 'ANC',
                        'KB' => 'KB',
                        'NEONATAL' => 'Neonatal',
                        'LAINNYA' => 'Lainnya',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
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
            'index'  => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit'   => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
