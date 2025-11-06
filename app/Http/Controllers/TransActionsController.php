<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransActionsController extends Controller
{
      public function index(){
        $transactions =Transaction::orderByDesc('created_at')->paginate(5);
        return view('transactions.index',compact('transactions'));
    }
}
