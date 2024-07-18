<?php

namespace App\Filament\Resources\JiraResource\Pages;

use App\Filament\Resources\JiraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJira extends EditRecord
{
    protected static string $resource = JiraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
