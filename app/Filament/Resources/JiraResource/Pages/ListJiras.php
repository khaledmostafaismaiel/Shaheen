<?php

namespace App\Filament\Resources\JiraResource\Pages;

use App\Filament\Resources\JiraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJiras extends ListRecords
{
    protected static string $resource = JiraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
