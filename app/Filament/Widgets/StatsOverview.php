<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\News;
use App\Models\NewsComment;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $query = News::query();
        
        // If author, only count their own news
        if (!auth()->user()->isAdmin()) {
            $query->where('author_id', auth()->id());
            $totalComments = NewsComment::whereHas('news', function($q) {
                $q->where('author_id', auth()->id());
            })->count();
        } else {
            $totalComments = NewsComment::count();
        }

        $totalNews = (clone $query)->count();
        $totalViews = (clone $query)->sum('views_count');
        $totalDrafts = (clone $query)->where('isPublished', false)->count();

        return [
            Stat::make('Total Berita', $totalNews)
                ->description('Semua berita yang dibuat')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Total Kunjungan', number_format($totalViews))
                ->description('Akumulasi pembaca berita')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
            Stat::make('Total Komentar', $totalComments)
                ->description('Komentar dari pembaca')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('warning'),
            Stat::make('Menunggu Publikasi', $totalDrafts)
                ->description('Berita berstatus Draft')
                ->descriptionIcon('heroicon-m-clock')
                ->color($totalDrafts > 0 ? 'danger' : 'gray'),
        ];
    }
}
