<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [['name' => 'credit'], ['name' => 'debit']];
        DB::table('transaction_types')->insert($types);
    }
}
