<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuitesResource\Pages;
use App\Filament\Resources\SuitesResource\RelationManagers;
use App\Models\Milestone;
use App\Models\Suites;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuitesResource extends Resource
{
    protected static ?string $model = Suites::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('milestone')
                        ->options(Milestone::all()->pluck('milestone_name', 'id'))
                        ->required(),
                    Forms\Components\TextInput::make('suite_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('suite_number')
                        ->visibleOn('view')
                        ->disabled()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description'),
                ])->columns(1),
                Forms\Components\Card::make()->schema([

                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                    Forms\Components\TextInput::make('deleted_by'),
                ])
                    ->visibleOn('view')
                    ->columns(2)


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('milestone.milestone_name'),
                Tables\Columns\TextColumn::make('suite_name'),
                Tables\Columns\TextColumn::make('suite_number'),
                Tables\Columns\TextColumn::make('description'),
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
            'index' => Pages\ListSuites::route('/'),
            'create' => Pages\CreateSuites::route('/create'),
            'view' => Pages\ViewSuites::route('/{record}'),
            'edit' => Pages\EditSuites::route('/{record}/edit'),
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
