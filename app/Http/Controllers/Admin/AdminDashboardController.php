<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Payment;



class AdminDashboardController extends Controller
{


    public function index()
    {


        $stats = [


            'users' => User::count(),


            'merchants' => Merchant::count(),


            'pending_merchants' => Merchant::where(
                'status',
                'pending'
            )->count(),



            'verified_merchants' => Merchant::where(
                'status',
                'verified'
            )->count(),



            'payments' => Payment::count(),



            'revenue' => Payment::where(
                'status',
                'paid'
            )->sum('amount'),


        ];



        return inertia(
            'Admin/Dashboard',
            [

                'stats' => $stats

            ]
        );


    }


}
