<?php

namespace App\Filament\Resources\ProjectsResource\RelationManagers;

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

class MilestoneRelationManager extends RelationManager
{
    protected static string $relationship = 'milestone';

    protected static ?string $title = 'Project Milestone';

    protected static ?string $recordTitleAttribute = 'milestone_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('milestone_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('assigned_qa')
                        ->label('Assigned QA')
                        ->options(User::all()->pluck('name', 'id'))
                        ->required(),
                    Forms\Components\Textarea::make('description'),
                    Forms\Components\DatePicker::make('start_date'),
                    Forms\Components\DatePicker::make('end_date'),
                ])->columns(1),
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                ])
                    ->visibleOn('view')
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.test_plan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('milestone_name')
                    ->limit(50),
                Tables\Columns\TextColumn::make('qa.name')
                    ->label('Assigned QA'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        return $livewire->getRelationship()->create($data);
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['assigned_qa'] = auth()->id();

                        return $data;
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
