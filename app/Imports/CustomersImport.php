<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class CustomersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts
{
    private $errors = [];

    public function model(array $row)
    {
        // Nettoyage des données avant import
        $phone = trim(str_replace([' ', '-', '.'], '', (string)$row['phone']));

        return new Customer([
            'firstname'         => trim($row['firstname']),
            'lastname'          => trim($row['lastname']),
            'email'             => trim(strtolower($row['email'])),
            'phone'             => $phone,
            'customer_type_id'  => (int)$row['customer_type_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'email'             => 'required|email|unique:customers,email',
            'phone'             => 'nullable|string|min:10',
            'customer_type_id'  => 'required|integer|exists:customer_types,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'customer_type_id.exists' => 'The selected customer type does not exist in our database.',
            'phone.string' => 'The phone number must be a text value. Please format it as text in your Excel file.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $rowIndex = $failure->row() + 1; // Adding 1 because Excel rows start at 1
            foreach ($failure->errors() as $error) {
                $this->errors[] = "Row {$rowIndex}: {$error}";
            }
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
