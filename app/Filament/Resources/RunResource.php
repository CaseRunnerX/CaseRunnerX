<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RunResource\Pages;
use App\Filament\Resources\RunResource\RelationManagers;
use App\Models\Milestone;
use App\Models\Run;
use App\Models\Suites;
use Filament\Forms;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class RunResource extends Resource
{
    protected static ?string $model = Run::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\DatePicker::make('test_run_date'),
                    Forms\Components\TextInput::make('test_run_name')
                        ->required()
                        ->disabledOn('edit')
                        ->maxLength(255),
                    TinyEditor::make('references')
                        ->required(),
                    Forms\Components\Select::make('milestone_id')
                        ->label('Milestone')
                        ->disabledOn('edit')
                        ->options(Milestone::all()->pluck('milestone_name', 'id'))
                        ->reactive()
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->required(),
                    Forms\Components\TextInput::make('assigned_qa')
                        ->label('Assigned QA'),
                    Forms\Components\Select::make('test_suite_id')
                        ->label('Test Suite')
                        ->multiple()
                        ->disabledOn('edit')
                        ->options(fn(\Closure $get) => Suites::all()->where('milestone_id', $get('milestone_id'))->pluck('suite_name', 'id'))
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'Passed' => 'Passed',
                            'Failed' => 'Failed',
                            'Blocked' => 'Blocked',
                            'Skipped' => 'Skipped',
                            'To be Tested' => 'To be Tested'
                        ])
                        ->default('To be Tested')
                        ->required(),
                ]),
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                    Forms\Components\TextInput::make('deleted_by'),
                ])
                    ->visibleOn('view')
                    ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('test_run_date')
                    ->date(),
                Tables\Columns\TextColumn::make('test_run_name'),
                Tables\Columns\TextColumn::make('assigned_qa'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RunCasesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRuns::route('/'),
            'create' => Pages\CreateRun::route('/create'),
            'view' => Pages\ViewRun::route('/{record}'),
            'edit' => Pages\EditRun::route('/{record}/edit'),
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
