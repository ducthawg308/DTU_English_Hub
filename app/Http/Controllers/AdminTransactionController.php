<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PurchasedExercise;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = PurchasedExercise::with(['user:id,name', 'topic:id,name'])->get();
        $totalAmount = $transactions->sum('price');

        return view('admin.transaction.index', compact('transactions', 'totalAmount'));
    }
}

