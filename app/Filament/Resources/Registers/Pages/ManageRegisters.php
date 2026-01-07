<?php

namespace App\Filament\Resources\Registers\Pages;

use App\Filament\Resources\Registers\RegisterResource;
use App\Models\Register;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ManageRegisters extends ManageRecords
{
    protected static string $resource = RegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false)
                ->using(function (array $data, string $model): Model {
                    $register = $this->generateRegister($data['tanggal']);
                    $data['user_id'] = Auth::id();
                    $data['nomor'] = $register['number'];
                    $data['urut'] = $register['index'];

                    return $model::create($data);
                }),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];
        $oldest = Register::owned()->oldest('tanggal')->first()->tanggal->year ?? now()->year;

        logger($oldest);

        for ($year = now()->year; $year >= $oldest; $year--) {
            $tabs[$year] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('tanggal', $year));
        }

        return $tabs;
    }

    protected function generateRegister(string $date): array
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $index = Register::whereDate('tanggal', $date)->max('urut') + 1;
        $index = $index > 9 ? $index : "0{$index}";
        $number = "{$date->format('m.d.')}{$index}";

        return [
            'number' => $number,
            'index' => $index,
        ];
    }
}
