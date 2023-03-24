<?php

namespace App\Filament\Resources\RunResource\RelationManagers;

use App\Models\Cases;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Awcodes\FilamentBadgeableColumn\Components\BadgeField;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class RunCasesRelationManager extends RelationManager
{
    protected static string $relationship = 'runCases';
    protected static ?string $title = "Test Cases";

    protected static ?string $recordTitleAttribute = 'case_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('case_id')
                    ->label('Test Cases')
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Untested' => 'Untested',
                        'Passed' => 'Passed',
                        'Failed' => 'Failed',
                        'Retest' => 'Retest',
                        'Blocked' => 'Blocked',
                        'Skipped' => 'Skipped',
                        'To Be Determined' => 'To Be Determined'
                    ])
                    ->reactive()
                    ->default('Untested')
                    ->required(),
                TinyEditor::make('actual_result'),
                Forms\Components\Card::make()->schema([
                    TinyEditor::make('defect')
                        ->required(),
                    TinyEditor::make('failure')
                        ->required(),
                    TinyEditor::make('effect')
                        ->required(),
                    TinyEditor::make('root_cause')
                        ->required(),
                    Forms\Components\TextInput::make('issue_id')
                        ->label('Issue ID')
                        ->required()
                        ->maxLength(255),
                ])
                ->visible(fn (\Closure $get) => $get('status') === 'Failed')
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('testCase.case_number')
                    ->label('Test Cases Number'),
                Tables\Columns\TextColumn::make('testCase.case_name')
                    ->label('Test Cases'),
                BadgeableColumn::make('status')
                    ->badges([
                        BadgeField::make('status')
                            ->options([
                                'Untested' => 'Untested',
                                'Passed' => 'Testing Passed',
                                'Failed' => 'Failed',
                                'Retest' => 'Retest',
                                'Blocked' => 'Blocked',
                                'Skipped' => 'Skipped',
                                'To Be Determined' => 'To Be Determined'
                            ])
                            ->colors([
                                '#fff' => 'Untested',
                                '#16A34A' => 'Passed',
                                '#DC2626' => 'Failed',
                                '#DB2777' => 'Retest',
                                '#52525B' => 'Blocked',
                                '#CA8A04' => 'Skipped',
                                '#7C3AED' => 'To Be Determined'
                            ]),
                    ]),

            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['case_id'] = Cases::find($data['case_id'])?->case_name ?? null;
                        return $data;
                    }),
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['case_id'] = Cases::find($data['case_id'])?->case_name ?? null;
                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data, Model $record): array {
                        $data['case_id'] =  $record->case_id;
                        return $data;
                    }),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('UpdateStatus')
                ->label('Mass Update Status')
                    ->action(function (Collection $records, array $data): void {
                        foreach ($records as $record) {
                            $record->status = $data['status_update'];
                            $record->save();
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('status_update')
                            ->label('Status')
                            ->options([
                                'Untested' => 'Untested',
                                'Passed' => 'Passed',
                                'Retest' => 'Retest',
                                'Blocked' => 'Blocked',
                                'Skipped' => 'Skipped',
                                'To Be Determined' => 'To Be Determined'
                            ])
                            ->reactive()
                            ->default('Untested')
                            ->required(),
                    ])
                    ->deselectRecordsAfterCompletion()
            ]);
    }
}
