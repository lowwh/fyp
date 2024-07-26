<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Models\Bid;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BidPlacedNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher;

class PaymentController extends Controller
{

    public function index($userid, $serviceid, $freelancerid, $price)
    {
        // Fetch the authenticated user
        $user = User::findOrFail(Auth::user()->id);



        // Fetch all vouchers
        $vouchers = Voucher::all();

        // Determine which vouchers to show based on access_count
        $accessCount = $user->access_count;
        $availableVouchers = collect([]);

        if ($accessCount >= 5) {
            // Show all vouchers, including discount30, for users with access_count 5 or more
            $availableVouchers = $vouchers->filter(function ($voucher) {
                return in_array($voucher->code, ['DISCOUNT10', 'DISCOUNT20', 'DISCOUNT30']);
            });
        } elseif ($accessCount == 4) {
            // Show vouchers with discount20 and below for users with access_count 4
            $availableVouchers = $vouchers->filter(function ($voucher) {
                return in_array($voucher->code, ['DISCOUNT10', 'DISCOUNT20']);
            });
        } elseif ($accessCount == 3) {
            // Show only the DISCOUNT10 voucher for users with access_count 3
            $availableVouchers = $vouchers->filter(function ($voucher) {
                return $voucher->code === 'DISCOUNT10';
            });
        } else {
            // No vouchers for users with access_count below 3
            $availableVouchers = collect([]);
        }

        return view('operations.payment', compact('userid', 'serviceid', 'freelancerid', 'price', 'availableVouchers'));
    }



    public function createInvoice(Request $request)
    {
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        $invoice = Invoice::create([
            'user_id' => $request->user()->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $request->amount,
            'status' => 'paid',
            'payment_method' => $request->card_type

        ]);

        return response()->json($invoice);
    }

    public function payInvoice(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->update(['status' => 'paid']);

        Payment::create([
            'invoice_id' => $invoice->id,
            'user_id' => $request->user()->id,
            'payment_method' => 'simulated',
            'payment_status' => 'completed',
        ]);

        return response()->json(['message' => 'Payment successful']);
    }


    public function processPayment($userid, $serviceid, $freelancerid, $serviceprice, Request $request)
    {
        $user = User::findOrFail($userid);

        $bidderuserid = User::findOrFail(Auth::user()->id);
        $bidderuserid->increment('access_count');



        $bid = new Bid();
        $bid->user_id = $user->id;
        $bid->bidder_id = auth()->id();
        $bid->bidder_name = Auth::user()->name;
        $bid->service_id = $serviceid;
        $bid->freelancer_id = $freelancerid;
        $bid->service_price = $serviceprice;

        $bid->save();

        $user->notify(new BidPlacedNotification($bid));

        $invoiceNumber = 'INV-' . strtoupper(uniqid());
        $finalPrice = $request->input('final_price');

        Invoice::create([
            'user_id' => $request->user()->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $finalPrice,
            'status' => 'paid',
            'payment_method' => $request->input('card_type')
        ]);

        return back()->with('bid', 'Your bid is pending. Please wait for the freelancer to review and confirm your bid. You will be notified once the freelancer has made a decision');

    }


    public function showCheckout()
    {
        $vouchers = Voucher::all(); // Fetch all available vouchers
        return view('operations.payment', compact('vouchers'));
    }

    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $servicePrice = $request->input('service_price');
        $voucher = Voucher::where('code', $voucherCode)->first();

        if ($voucher) {
            $discount = $voucher->discount_percentage;
            $finalPrice = $servicePrice - ($servicePrice * $discount / 100);
            return response()->json(['success' => true, 'final_price' => $finalPrice]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid voucher code']);
        }
    }


    public function check($serviceid, $userid)
    {
        $user = User::find($userid);
        $service = Service::find($serviceid);

        $paymentCount = Payment::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->count();

        echo "User {$user->name} has paid for the service '{$service->name}' {$paymentCount} times.";

    }
}

