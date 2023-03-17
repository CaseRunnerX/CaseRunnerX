<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CasesResource\Pages;
use App\Filament\Resources\CasesResource\RelationManagers;
use App\Models\Cases;
use App\Models\Suites;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CasesResource extends Resource
{
    protected static ?string $model = Cases::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('case_number')
                        ->visibleOn('view')
                        ->disabled(),
                    Forms\Components\Select::make('suite_id')
                        ->options(Suites::all()->pluck('suite_name', 'id'))
                        ->label('Test Suite Name'),
                    Forms\Components\TextInput::make('case_name')
                        ->required()
                        ->maxLength(255),
                    TinyEditor::make('prerequisite'),
                    Forms\Components\Select::make('priority')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High'
                        ]),
                    Forms\Components\Select::make('case_type')
                        ->options([
                            'Acceptance' => 'Acceptance',
                            'Accessibility' => 'Accessibility',
                            'Automated' => 'Automated',
                            'Compatibility' => 'Compatibility',
                            'Destructive' => 'Destructive',
                            'Functional' => 'Functional',
                            'Performance' => 'Performance',
                            'Regression' => 'Regression',
                            'Security' => 'Security',
                            'Smoke & Sanity' => 'Smoke & Sanity',
                            'Usability' => 'Usability',
                            'Other' => 'Other'
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('reference')
                        ->maxLength(255),
                    Forms\Components\Repeater::make('steps')->schema([
                        Forms\Components\TextInput::make('Step count')
                            ->required()
                            ->integer(),
                        TinyEditor::make('Steps description')
                    ]),
                    TinyEditor::make('expected_result')
                        ->required(),
                ])->columns(1),
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                    Forms\Components\TextInput::make('deleted_by'),
                ])->visibleOn('view')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('case_number'),
                Tables\Columns\TextColumn::make('case_name'),
                Tables\Columns\TextColumn::make('prerequisite'),
                Tables\Columns\TextColumn::make('priority'),
                Tables\Columns\TextColumn::make('case_type'),
                Tables\Columns\TextColumn::make('reference'),
                Tables\Columns\TextColumn::make('steps'),
                Tables\Columns\TextColumn::make('expected_result'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('created_by'),
                Tables\Columns\TextColumn::make('updated_by'),
                Tables\Columns\TextColumn::make('deleted_by'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCases::route('/'),
            'create' => Pages\CreateCases::route('/create'),
            'view' => Pages\ViewCases::route('/{record}'),
            'edit' => Pages\EditCases::route('/{record}/edit'),
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
