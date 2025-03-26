<?php

namespace App\Imports;

use App\Models\Consumption;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;

class ConsumptionsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts
{
    private $errors = [];

    public function model(array $row)
    {
        return new Consumption([
            'customer_id' => (int)$row['customer_id'],
            'card_id' => (int)$row['card_id'],
            'wallet_id' => (int)$row['wallet_id'],
            'quantity' => (float)$row['quantity'],
            'date_consumption' => Carbon::parse($row['date_consumption'])->format('Y-m-d'),
        ]);
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'card_id' => 'required|exists:cards,id',
            'wallet_id' => 'required|exists:wallets,id',
            'quantity' => 'required|numeric|min:0',
            'date_consumption' => 'required|date',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'customer_id.exists' => 'Customer ID does not exist.',
            'card_id.exists' => 'Card ID does not exist.',
            'wallet_id.exists' => 'Wallet ID does not exist.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Row {$failure->row()}: {$failure->errors()[0]}";
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
