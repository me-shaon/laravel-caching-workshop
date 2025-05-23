<?php

namespace App\Filament\Resources;

use App\Components\CacheKey;
use App\Filament\Resources\UserReportResource\Pages;
use App\Models\UserReport;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Cache;

class UserReportResource extends Resource
{
    protected static ?string $model = UserReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'spam' => 'gray',
                        'harassment' => 'danger',
                        'inappropriate' => 'warning',
                        default => 'info',
                    }),
                IconColumn::make('is_locked')
                    ->label('Locked')
                    ->boolean()
                    ->getStateUsing(function (UserReport $record): bool {
                        $lockInfo = Cache::get(CacheKey::reportReviewLock($record->id));
                        return $lockInfo !== null;
                    })
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('danger')
                    ->falseColor('success'),
                TextColumn::make('reviewing_user')
                    ->label('Currently Reviewing')
                    ->getStateUsing(function (UserReport $record): ?string {
                        $lockInfo = Cache::get(CacheKey::reportReviewLock($record->id));
                        if (!$lockInfo) return null;
                        return \App\Models\User::find($lockInfo['user_id'])?->name;
                    }),
                TextColumn::make('reporter.name')
                    ->searchable(),
                TextColumn::make('reportedUser.name')
                    ->searchable(),
                TextColumn::make('review_action')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'warning' => 'warning',
                        'ban' => 'danger',
                        'no_action' => 'success',
                        'under_review' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('reviewer.name')
                    ->searchable(),
                TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'spam' => 'Spam',
                        'harassment' => 'Harassment',
                        'inappropriate' => 'Inappropriate Content',
                        'other' => 'Other',
                    ]),
                SelectFilter::make('review_action')
                    ->options([
                        'warning' => 'Warning',
                        'ban' => 'Ban',
                        'no_action' => 'No Action',
                        'under_review' => 'Under Review',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserReports::route('/'),
            'view' => Pages\ViewUserReport::route('/{record}'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Report Details')
                    ->schema([
                        TextEntry::make('type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'spam' => 'gray',
                                'harassment' => 'danger',
                                'inappropriate' => 'warning',
                                default => 'info',
                            }),
                        TextEntry::make('reason')
                            ->markdown(),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Section::make('Users Involved')
                    ->schema([
                        TextEntry::make('reporter.name')
                            ->label('Reported By'),
                        TextEntry::make('reportedUser.name')
                            ->label('Reported User'),
                    ])
                    ->columns(2),
            ]);
    }
}