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

        ini_set('max_execution_time', 120000);
        DB::transaction(function() use ($data) {
            $counter = 0;
            foreach($data as $client) {
                $counter++;

                $newCreditCard = self::creditCardFactory(
                    $client->credit_card->name, 
                    $client->credit_card->type,
                    $client->credit_card->number,
                    $client->credit_card->expirationDate
                );

                $newClient = self::clientFactory(
                    $client->name, 
                    $client->address,
                    $client->checked,
                    $client->description, 
                    $client->interest,
                    $client->email, 
                    $client->account
                );

                $dateSubstring = substr($client->date_of_birth, 0, 10);
                $isBetween18and65 = true;
                if (strpos($dateSubstring, "/")) {
                    $parsedDate = Carbon::createFromFormat('d/m/Y', $dateSubstring)->format('Y-m-d');
                    $newClient->dateOfBirth = $parsedDate;
                    $isBetween18and65 = self::isBetween18and65($parsedDate);
                } elseif(strpos($dateSubstring, "-")) {
                    $parsedDate = date("Y-m-d", strtotime($dateSubstring));
                    $newClient->dateOfBirth = $parsedDate;
                    $isBetween18and65 = self::isBetween18and65($parsedDate);
                }
                if ($isBetween18and65) {
                    $newCreditCard->save();
                    $newClient->credit_card_id = $newCreditCard->id;
                    $newClient->save();
                }
                if ($counter === 500) {
                    $counter = 0;
                    echo 'Added 500 records' . PHP_EOL;
                }
            }
            echo 'JSON processed smoothly and data added to the database.';
        });
        
    }

    public static function creditCardFactory(string $name, string $type, string $number, string $expirationDate): CreditCard 
    {
        $creditCard = new CreditCard();
        $dates = explode("/", $expirationDate);
        $creditCard->name = $name;
        $creditCard->type = $type;
        $creditCard->number = $number;
        $creditCard->expirationDateDay = $dates[0];
        $creditCard->expirationDateMonth = $dates[1];
        return $creditCard;
    }

    public static function clientFactory(string $name, ?string $address, string $checked, ?string $description, ?string $interest, ?string $email, string $account): Client 
    {
        $client = new Client();
        $client->name = $name;
        $client->address = $address;
        $client->checked = $checked;
        $client->description = $description;
        $client->interest = $interest;
        $client->email = $email;
        $client->account = $account;
        return $client;
    }

    public static function isBetween18and65(string $date): bool
    {
        $now = date("Y-m-d");
        $date18years = date('Y-m-d', strtotime('-18 years', strtotime($now)));
        $date65years = date('Y-m-d', strtotime('-65 years', strtotime($now)));
        if (strtotime($date65years) < strtotime($date) && strtotime($date) < strtotime($date18years)) {
            return true;
        } else {
            return false;
        }
    }
}
