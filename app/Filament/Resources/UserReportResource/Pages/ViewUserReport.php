<?php

namespace App\Filament\Resources\UserReportResource\Pages;

use App\Components\CacheKey;
use App\Filament\Resources\UserReportResource;
use App\Models\User;
use App\Models\UserReport;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ViewUserReport extends ViewRecord
{
    protected static string $resource = UserReportResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        $report = UserReport::findOrFail($record);
        
        $lockKey = CacheKey::reportReviewLock($report->id);
        $lockInfo = Cache::get($lockKey);

        // If the report is locked by another user
        if ($lockInfo && $lockInfo['user_id'] !== auth()->id()) {
            $reviewerName = User::find($lockInfo['user_id'])?->name;
            $this->notify('warning', "This report is currently being reviewed by {$reviewerName}");
            $this->redirect(static::getResource()::getUrl('index'));
            return;
        }

        // Set or refresh the lock for the current user
        Cache::put($lockKey, [
            'user_id' => auth()->id(),
            'locked_at' => now(),
        ], now()->addMinutes(10));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->color('success')
                ->icon('heroicon-o-check')
                ->action(function () {
                    $this->record->update([
                        'review_action' => 'no_action',
                        'reviewed_by' => auth()->id(),
                        'review_notes' => 'Report approved - No action required',
                        'reviewed_at' => Carbon::now(),
                    ]);
                    
                    // Remove the lock when approved
                    Cache::forget(CacheKey::reportReviewLock($this->record->id));
                    $this->notify('success', 'Report approved successfully');
                })
                ->requiresConfirmation()
                ->modalHeading('Approve Report')
                ->modalDescription('Are you sure you want to approve this report? This will mark the report as reviewed with no action required.')
                ->modalSubmitActionLabel('Yes, approve report')
                ->visible(fn () => !$this->record->reviewed_at),

            Actions\Action::make('reject')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->action(function () {
                    $this->record->update([
                        'review_action' => 'warning',
                        'reviewed_by' => auth()->id(),
                        'review_notes' => 'Report rejected - Warning issued',
                        'reviewed_at' => Carbon::now(),
                    ]);
                    
                    // Remove the lock when rejected
                    Cache::forget(CacheKey::reportReviewLock($this->record->id));
                    $this->notify('success', 'Report rejected successfully');
                })
                ->requiresConfirmation()
                ->modalHeading('Reject Report')
                ->modalDescription('Are you sure you want to reject this report? This will mark the report as reviewed and issue a warning.')
                ->modalSubmitActionLabel('Yes, reject report')
                ->visible(fn () => !$this->record->reviewed_at),
        ];
    }
}