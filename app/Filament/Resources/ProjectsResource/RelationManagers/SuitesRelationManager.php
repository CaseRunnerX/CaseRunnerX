<?php

namespace App\Filament\Resources\ProjectsResource\RelationManagers;

use App\Models\Milestone;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Contracts\HasRelationshipTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuitesRelationManager extends RelationManager
{
    protected static string $relationship = 'suites';

    protected static ?string $recordTitleAttribute = 'suite_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('milestone_id')
                        ->label('Milestone')
                        ->options(fn(RelationManager $livewire) => Milestone::all()->where('test_plan_id', $livewire->ownerRecord->id)->pluck('milestone_name', 'id'))
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
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        return $livewire->getRelationship()->create($data);
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['created_by'] = User::find($data['created_by'])?->name ?? null;
                        $data['updated_by'] = User::find($data['updated_by'])?->name ?? null;
                        return $data;
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
