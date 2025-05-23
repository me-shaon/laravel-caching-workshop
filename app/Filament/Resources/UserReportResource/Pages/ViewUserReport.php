<?php

namespace App\Filament\Resources\UserReportResource\Pages;

use App\Filament\Resources\UserReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Carbon;

class ViewUserReport extends ViewRecord
{
    protected static string $resource = UserReportResource::class;

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