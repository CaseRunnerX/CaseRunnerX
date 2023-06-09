<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RunResource\Pages;
use App\Filament\Resources\RunResource\RelationManagers;
use App\Models\Milestone;
use App\Models\Projects;
use App\Models\Run;
use App\Models\Suites;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class RunResource extends Resource
{
    protected static ?string $model = Run::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\TextInput::make('test_run_name')
                            ->required()
                            ->disabledOn('edit')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('test_run_date')
                            ->disabledOn('edit')
                            ->withoutTime()
                            ->reactive()
                            ->default(now()->toDateString()),
                        Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->disabledOn('edit')
                            ->options(Projects::all()->pluck('project_name', 'id'))
                            ->reactive()
                            ->afterStateHydrated(function (\Closure $get, \Closure $set, $state) {
                                $date = $get('test_run_date');
                                $formatted = $date.' - '.Projects::find($state)?->project_name;
                                $set('test_run_name', $formatted);
                            })
                            ->afterStateUpdated(function (\Closure $get, \Closure $set, $state) {
                                $date = Carbon::parse($get('test_run_date'))->toDateString();
                                $formatted = $date.' - '.Projects::find($state)?->project_name;
                                $set('test_run_name', $formatted);
                            })
                            ->required(),
                        Forms\Components\Select::make('milestone_id')
                            ->label('Milestone')
                            ->multiple()
                            ->disabledOn('edit')
                            ->options(fn (\Closure $get) => Milestone::all()->where('test_plan_id', $get('project_id'))->pluck('milestone_name', 'id'))
                            ->reactive()
                            ->required(),
                        Forms\Components\Select::make('test_suite_id')
                            ->label('Test Suite')
                            ->multiple()
                            ->disabledOn('edit')
                            ->options(fn (\Closure $get) => Suites::all()->whereIn('milestone_id', $get('milestone_id'))->pluck('suite_name', 'id'))
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Active' => 'Active',
                                'Non-Active' => 'Non-Active',
                                'Idle' => 'Idle',
                            ])
                            ->default('Active')
                            ->required(),
                        Forms\Components\Select::make('assigned_qa')
                            ->options(User::all()->pluck('name', 'id'))
                            ->default(auth()->id())
                            ->label('Assigned QA'),
                        Forms\Components\TextInput::make('references')
                            ->required(),
                    ])->columns(2),
                    Forms\Components\Textarea::make('description')
                        ->required(),
                ]),
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                    Forms\Components\TextInput::make('deleted_by'),
                ])
                    ->columns(2)
                    ->visibleOn('view')
                    ->disabled(),
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
            RelationManagers\RunCasesRelationManager::class,
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
