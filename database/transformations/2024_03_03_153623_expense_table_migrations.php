<?php

use App\Models\Attachment;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class ExpenseTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('expense')->orderBy('id')->chunk(100, function ($expenses) {
            foreach ($expenses as $expense) {
                $first_admin_id = User::where('role', 'admin')->first()->id;
                try {
                    // Create a new model instance
                    $localExpense = new Expense();
                    $localExpense->id = (int) $expense->id;
                    $localExpense->user_id = $first_admin_id;
                    $localExpense->amount = $expense->expenseAmount;
                    $localExpense->date = $expense->expenseDate;
                    $localExpense->description = $expense->expenseDescription;
                    $localExpense->save();

                    if ($expense->fileNames && $expense->fileNames != '') {
                        $url = env('REMOTE_APP_URL') . "/" . $expense->folderName . "/" . $expense->fileNames;
                        try {
                            $client = new Client([
                                'verify' => false
                            ]);
                            $response = $client->get($url);

                            // Get file metadata
                            $size = (int) $response->getHeader('Content-Length')[0];
                            $mimeType = $response->getHeader('Content-Type')[0];
                            $extension = pathinfo($url, PATHINFO_EXTENSION);
                            // Generate a unique filename
                            $filename = uniqid() . '.' . $extension;
                            // Store the file
                            Storage::put('expenses/' . $filename, $response->getBody());
                            // Get the full path to the stored file
                            $filePath = 'expenses/' . $filename;
                            // You can now use $filePath, $size, $mimeType, and $extension
                            // for further processing or database storage

                            $attachment['type'] = 'expense';
                            $attachment['ref_id'] = (int) $expense->id;
                            $attachment['name'] = $expense->fileNames;
                            $attachment['extension'] = $extension;
                            $attachment['mime_type'] = $mimeType;
                            $attachment['size'] = $size;
                            $attachment['url'] = $filePath;
                            Attachment::create($attachment);
                        } catch (\Exception $e) {
                            // Handle exceptions
                            echo $e->getMessage();
                        }
                    }
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for expense ID ' . $expense->id . '. Mapping added_by to ID 1.');
                        $localExpense->user_id = 1;
                        $localExpense->save();
                    } else {
                        // Rethrow the exception if it's not the specific foreign key constraint violation
                        throw $e;
                    }
                }
            }
        });
    }

    public function down()
    {
        // Define the rollback logic if necessary
    }
}
