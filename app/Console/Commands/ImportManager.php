<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\CreditCard;
use Carbon\Carbon;

class ImportManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing the JSON content to the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $data = json_decode(file_get_contents('challenge.json'), false);

        ini_set('max_execution_time', 12000);
        DB::transaction(function() use ($data) {
            foreach($data as $client) {
                $dates = explode("/", $client->credit_card->expirationDate);

                $newCreditCard = new CreditCard();
                $newCreditCard->name = $client->credit_card->name;
                $newCreditCard->type = $client->credit_card->type;
                $newCreditCard->number = $client->credit_card->number;
                $newCreditCard->expirationDateDay = $dates[0];
                $newCreditCard->expirationDateMonth = $dates[1];
                $newCreditCard->save();

                $newClient = new Client();
                $newClient->credit_card_id = $newCreditCard->id;
                $newClient->name = $client->name;
                $newClient->address = $client->address;
                $newClient->checked = $client->checked;
                $newClient->description = $client->description;
                $newClient->interest = $client->interest;
                $newClient->email = $client->email;
                $newClient->account = $client->account;
                $dateSubstring = substr($client->date_of_birth, 0, 10);
                if (strpos($dateSubstring, "/")) {
                    $newClient->dateOfBirth = Carbon::createFromFormat('d/m/Y', $dateSubstring)->format('Y-m-d');
                } elseif(strpos($dateSubstring, "-")) {
                    $parsedDate = date("Y-m-d", strtotime($dateSubstring));
                    $newClient->dateOfBirth = $parsedDate;
                }
                $newClient->save();
            }
            echo 'JSON processed smoothly and data added to the database.';
        });
        
    }
}
