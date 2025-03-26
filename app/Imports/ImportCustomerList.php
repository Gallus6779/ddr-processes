<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Card;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportCustomerList implements ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'customer_type_id' => 'required|exists:customer_types,id',
            'number' => 'required|numeric|unique:cards',
            'card_owner' => 'required|string',
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {

            dd(dd($row[0]));
            $customer = Customer::where('name', $request->name)->first();

            if(empty($customer)){

                $validatedData = $request->validate([
                    'name' => ['required','string', 'unique:customers,name'],
                    'customer_type_id' => 'required|exists:customer_types,id',
                    'number' => 'required|numeric|unique:cards',
                    'card_owner' => 'required|string',
                    'email' => 'required|email|unique:customers',
                    'phone' => 'required|numeric'
                ],[
                    'name.required' => 'Name field is required.',
                    'name.unique' => 'Name field is already taken.',
                    'email.unique' => 'Email field is already taken.',
                    'customer_type_id.required' => 'Customer Type field doesn\'t exist.',

                    'card_owner.required' => 'cardOwner field is required.',
                    'number.required' => 'Number field is required.',
                    'phone.required' => 'Phone field is required.',
                    'email.required' => 'Email field is required.'
                ]);

                $customer_data = $request->except(['number', 'card_owner']);
        
                DB::transaction(function () use ($request, $customer_data) {
                    $customer = Customer::create($customer_data);
        
                    $card = new Card();
        
                    $card->number = $request->number;
                    $card->card_owner = $request->card_owner;
                    $card->customer_id = $customer->id;
        
                    $card->save();
                });

            }else{
                $validatedData = $request->validate([
                    'name' => ['required','string'],
                    'customer_type_id' => 'required|exists:customer_types,id',
                    'number' => 'required|numeric|unique:cards',
                    'card_owner' => 'required|string'
                ],[
                    'name.required' => 'Name field is required.',
                    'card_owner.required' => 'cardOwner field is required.',
                    'number.required' => 'Number field is required.',
                    'phone.required' => 'Phone field is required.',
                    
                    'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
                ]);

                // $customer_data = $request->except(['number', 'card_owner']);
        
                // DB::transaction(function () use ($request, $customer_data) {
                DB::transaction(function () use ($request, $customer) {
                    // $customer = Customer::create($customer_data);
        
                    $card = new Card();
        
                    $card->number = $request->number;
                    $card->card_owner = $request->card_owner;
                    $card->customer_id = $customer->id;
        
                    $card->save();
                });
                return back()->with('success', 'Customer ' . $customer->name . ' card has been added successfully.');
            }
        }
    }

    public function import($file){
        if (isset($file)) {
            $inputFileName = $file['tmp_name'];
        
            try {
                $spreadsheet = IOFactory::load($inputFileName);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                
                foreach ($rows as $row) {
                    // if(is_null($row[0])){
                    //     break;
                    // }
                    
                    $customer = Customer::where('name', $row[0])->first();
                    if(empty($customer)){
    
                        // $validatedData = $request->validate([
                        //     'name' => ['required','string', 'unique:customers,name'],
                        //     'customer_type_id' => 'required|exists:customer_types,id',
                        //     'number' => 'required|numeric|unique:cards',
                        //     'card_owner' => 'required|string',
                        //     'email' => 'required|email|unique:customers',
                        //     'phone' => 'required|numeric'
                        // ],[
                        //     'name.required' => 'Name field is required.',
                        //     'name.unique' => 'Name field is already taken.',
                        //     'email.unique' => 'Email field is already taken.',
                        //     'customer_type_id.required' => 'Customer Type field doesn\'t exist.',
            
                        //     'card_owner.required' => 'cardOwner field is required.',
                        //     'number.required' => 'Number field is required.',
                        //     'phone.required' => 'Phone field is required.',
                        //     'email.required' => 'Email field is required.'
                        // ]);

                        // $companyName = $row[0];
                        // $customerType = $row[1];
                        // $email = $row[2];
                        // $phone = $row[3];
                        
                        $customer_data = [
                            'name' => $row[0],
                            'customer_type_id' => $row[1],
                            'email' => $row[2],
                            'phone' => $row[3]
                        ];
                
                        // DB::transaction(function () use ($request, $customer_data, $row) {
                        DB::beginTransaction();
                        try {
                            $customer = Customer::create($customer_data);

                            // $cardNumber = $row[4];
                            // $cardOwner = $row[5];
                            $card = new Card();
                
                            $card->number = $row[4];
                            $card->card_owner = $row[5];
                            $card->customer_id = $customer->id;                
                            $card->save();
                            // });
                            // Commit the transaction
                            DB::commit();

                            // return back()->with('success', 'Customer ' . $customer->name . ' card has been added successfully.');
                        } catch (\Exception $e) {
                            // Rollback the transaction
                            DB::rollBack();
                
                            // return redirect()->back()->withErrors(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
                            return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()], 500);
                        }
                    }else{
                        // $validatedData = $request->validate([
                        //     'name' => ['required','string'],
                        //     'customer_type_id' => 'required|exists:customer_types,id',
                        //     'number' => 'required|numeric|unique:cards',
                        //     'card_owner' => 'required|string'
                        // ],[
                        //     'name.required' => 'Name field is required.',
                        //     'card_owner.required' => 'cardOwner field is required.',
                        //     'number.required' => 'Number field is required.',
                        //     'phone.required' => 'Phone field is required.',
                            
                        //     'customer_type_id.required' => 'Customer Type field doesn\'t exist.'
                        // ]);
            
                        DB::beginTransaction();
                        try {

                            // $cardNumber = $row[4];
                            // $cardOwner = $row[5];
                            $card = new Card();
                
                            $card->number = $row[4];
                            $card->card_owner = $row[5];
                            $card->customer_id = $customer->id;                
                            $card->save();
                            // Commit the transaction
                            DB::commit();

                            // return response()->json(['success' => 'Customer ' . $customer->name . ' card has been added successfully.'], 200);
                            // return back()->with('success', 'Customer ' . $customer->name . ' card has been added successfully.');

                        } catch (\Exception $e) {
                            // Rollback the transaction
                            DB::rollBack();
                            
                            return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()], 500);
                
                            // return redirect()->back()->withErrors(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
                        }
                    }
                }
                return response()->json(['success' => 'Customer ' . $customer->name . ' card has been added successfully.'], 200);
        
                // return $file;

            } catch (Exception $e) {
                return die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
        }
    }

}
