<?php

namespace App\ContractorPanel\Resources\Job;

use App\ContractorPanel\Resources\Job\JobResource\Pages;
use Iotronlab\FilamentMultiGuard\Concerns\ContextualResource;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Models\City;
use App\Models\JobModel;
use App\Models\Skill;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JobResource extends Resource
{
    use ContextualResource;
    protected static ?string $model = JobModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull(),
                MarkdownEditor::make('description')
                            ->required()
                            ->minLength(10)
                            ->columnSpanFull(),
                Select::make('location')
                            ->options(City::all()->pluck('name', 'name'))
                            ->searchable()
                            ->required(),
                TextInput::make('min_experience')
                            ->label('Minimum Experience')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(20),
                TagsInput::make('skills')
                            ->suggestions(Skill::all()->pluck('name', 'id'))
                            ->required(),
                DatePicker::make('starting_date'),
                TagsInput::make('tags')
                            ->suggestions(Tag::all()->pluck('name', 'id')),
                Select::make('company_id')
                            ->label('Company')
                            ->options(array(Auth::guard('customer')->user()->id => Auth::guard('customer')->user()->id))  
                            ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageJobs::route('/'),
        ];
    }    
}
