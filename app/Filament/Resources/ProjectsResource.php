<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use App\Models\Projects;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectsResource extends Resource
{
    protected static ?string $model = Projects::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')->schema([
                    Forms\Components\TextInput::make('account')
                        ->label('Account')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('application')
                        ->label('Application')
                        ->required()
                        ->options([
                            'Zoho' => 'Zoho',
                            'SugarCRM' => 'SugarCRM',
                            'SuiteCRM' => 'SuiteCRM'
                        ]),
                    Forms\Components\Select::make('project_type')
                        ->label('Project Type')
                        ->options([
                            'Fix Bid' => 'Fix Bid',
                            'Premium Support' => 'Premium Support',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('assigned_project_manager')
                        ->label('Assigned Project Manager')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('assigned_developer')
                        ->label('Assigned Developers')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('assigned_qa')
                        ->label('Assigned QA')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('assigned_account_manager')
                        ->label('Assigned Account Manager')
                        ->required()
                        ->maxLength(255),
                ])->columns(2),
                Forms\Components\Section::make('Test Plan')->schema([
                    Forms\Components\TextInput::make('test_plan')
                        ->label('Test Plan')
                        ->disabled()
                        ->required()
                        ->visibleOn('view')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('project_name')
                        ->label('Project Name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('author_id')
                    ->label('Author')
                    ->disabled()
                    ->visibleOn('view'),
                    Forms\Components\Textarea::make('computing_environment')
                    ->label('Type of Computing Environment'),
                    Forms\Components\Textarea::make('software_type')
                    ->label('Type of Software'),
                    Forms\Components\Textarea::make('testing_purposes')
                        ->label('Purpose of testing')
                        ->required(),
                    Forms\Components\Textarea::make('user_demo_graphics')
                    ->label('User Demo Graphics'),
                    Forms\Components\Textarea::make('assumptions')
                        ->label('Assumption')
                        ->required(),
                    Forms\Components\Textarea::make('testing_phases')
                        ->label('Phases of Testing'),
                    Forms\Components\Textarea::make('testing_scope')
                        ->label('Scope of Testing')
                        ->required(),
                    Forms\Components\Textarea::make('critical_success_factor')
                        ->label('Critical Success Factors')
                        ->required(),
                    Forms\Components\Textarea::make('type_of_testing')
                        ->label('Type of Testing')
                        ->required(),
                    Forms\Components\Textarea::make('tester_profile')
                        ->label('Tester Profile'),
                    Forms\Components\Textarea::make('test_reference')
                        ->label('Test Reference'),
                    Forms\Components\Textarea::make('test_deliverable')
                        ->label('Test Deliverable')
                        ->required(),
                    Forms\Components\Textarea::make('development_test_tools')
                        ->label('Development, and Test Tools'),
                    Forms\Components\Textarea::make('business_operational_concern')
                        ->label('Business/Operational Concern'),
                    Forms\Components\Textarea::make('risk')
                        ->label('Risk'),
                    Forms\Components\Textarea::make('other')
                        ->label('Other'),
                ]),
                Forms\Components\Section::make('System Information')->schema([
                    Forms\Components\TextInput::make('created_by'),
                    Forms\Components\TextInput::make('updated_by'),
                    Forms\Components\TextInput::make('deleted_by'),
                ])
                    ->columns(2)
                    ->visibleOn('view')
                    ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account'),
                Tables\Columns\TextColumn::make('application'),
                Tables\Columns\TextColumn::make('project_type'),
                Tables\Columns\TextColumn::make('assigned_qa'),
                Tables\Columns\TextColumn::make('assigned_account_manager'),
                Tables\Columns\TextColumn::make('test_plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.name'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProjects::route('/create'),
            'view' => Pages\ViewProjects::route('/{record}'),
            'edit' => Pages\EditProjects::route('/{record}/edit'),
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
