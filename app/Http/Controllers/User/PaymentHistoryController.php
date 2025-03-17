<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PaymentHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Perbaikan: tidak menggunakan $this->middleware disini
    }

    /**
     * Display payment history for the authenticated user
     */
    public function index()
    {
        try {
            // Check if payments table exists
            if (!Schema::hasTable('payments')) {
                return view(
                    (new Agent())->isMobile() ? 'pages.mobile.payments.history' : 'pages.desktop.payments.history',
                    ['payments' => collect([])->paginate(10)]
                );
            }

            // Lakukan raw query untuk menghindari error foreign key constraint
            $rawPayments = DB::table('payments')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            // Transform data jika perlu
            $agent = new Agent();
            return view(
                $agent->isMobile() ? 'pages.mobile.payments.history' : 'pages.desktop.payments.history',
                ['payments' => $rawPayments]
            );
        } catch (\Exception $e) {
            // Tangani error dengan mengembalikan view kosong
            $agent = new Agent();
            return view(
                $agent->isMobile() ? 'pages.mobile.payments.history' : 'pages.desktop.payments.history',
                ['payments' => collect([])->paginate(10)]
            )->with('error', 'Error loading payment history: ' . $e->getMessage());
        }
    }
} 