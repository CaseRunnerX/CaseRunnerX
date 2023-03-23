<?php

namespace App\Filament\Resources\ProjectsResource\RelationManagers;

use App\Models\Suites;
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
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CasesRelationManager extends RelationManager
{
    protected static string $relationship = 'cases';

    protected static ?string $recordTitleAttribute = 'test_plan_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('case_number')
                        ->visibleOn('view')
                        ->disabled(),
                    Forms\Components\Select::make('suite_id')
                        ->options(fn(RelationManager $livewire) => Suites::all()->where('test_plan_id', $livewire->ownerRecord->id)->pluck('suite_name', 'id'))
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
                    Forms\Components\Select::make('status')
                        ->options([
                            'Passed' => 'Passed',
                            'Failed' => 'Failed',
                            'Retest' => 'Retest',
                            'Blocked' => 'Blocked',
                            'Skipped' => 'Skipped',
                            'To Be Determined' => 'To Be Determined'
                        ])->visibleOn('edit'),
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
                    ])
                        ->createItemButtonLabel('Add step'),
                    TinyEditor::make('expected_result')
                        ->required(),
                    Forms\Components\Card::make()->schema([
                        TinyEditor::make('actual_result')
                            ->required(),
                        TinyEditor::make('defect'),
                        TinyEditor::make('failure'),
                        TinyEditor::make('effect'),
                        TinyEditor::make('root_cause'),
                        Forms\Components\TextInput::make('issue_id')
                            ->label('Issue ID')
                            ->maxLength(255),
                    ])->visibleOn(['view', 'edit']),

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
                Tables\Columns\TextColumn::make('suite.suite_name')
                    ->label('Suites Name'),
                Tables\Columns\TextColumn::make('case_name'),
                Tables\Columns\TextColumn::make('priority'),
                Tables\Columns\TextColumn::make('case_type'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        return $livewire->getRelationship()->create($data);
                    }),
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['created_by'] = User::find($data['created_by'])?->name ?? null;
                        $data['updated_by'] = User::find($data['updated_by'])?->name ?? null;
                        return $data;
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
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
