<?php

namespace App\Filament\Resources\RegisterResource\Pages;

use App\Filament\Resources\RegisterResource;
use App\Models\Register;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ManageRegisters extends ManageRecords
{
    protected static string $resource = RegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false)
                ->using(function (array $data, string $model): Model {
                    $register = $this->generateRegister($data['tanggal']);
                    $data['user_id'] = auth()->id();
                    $data['nomor_surat'] = $register['number'];
                    $data['urut'] = $register['index'];

                    return $model::create($data);
                }),
        ];
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

    public function getTabs(): array
    {
        $tabs = [];
        $oldest = Register::owned()->oldest('tanggal')->first()->tanggal->year ?? now()->year;

        for ($year = now()->year; $year >= $oldest; $year--) {
            $tabs[$year] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('tanggal', $year));
        }

        return $tabs;
    }
}
