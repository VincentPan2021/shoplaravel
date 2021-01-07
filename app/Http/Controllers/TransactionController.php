<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop\Entity\Transaction;

class TransactionController extends Controller
{
    //transactionListPage
    public function transactionListPage(){
        $user_id = session()->get('user_id');

        $row_per_page = 1;

        $Transactions = Transaction::where('user_id', $user_id)
                                    ->orderby('created_at', 'desc')
                                    ->with('Merchandise')
                                    ->paginate($row_per_page);
        
        foreach($Transactions as &$Transaction){
            if(!is_null($Transaction->Merchandise->photo)){
                $Transaction->Merchandise->photo = 
                        url($Transaction->Merchandise->photo);
            }else{
                $Transaction->Merchandise->photo = '/images/noimage.jpg';
            }
        }

        $binding = [
            'title' => '交易紀錄',
            'Transactions' => $Transactions
        ];

        return view('transaction.listUserTransaction', $binding);
    }
}
