@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Receipt</title>

    <style>
        /* Invoice styles */
        .invoice-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .invoice-title {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details p {
            margin-bottom: 10px;
        }

        .print-button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container invoice-container">
        <h1 class="invoice-title">Invoice Receipt</h1>

        <div class="invoice-details">
            <p><strong>Freelancer ID:</strong> {{ $freelancerid }}</p>
            <p><strong>Service ID:</strong> {{ $serviceid }}</p>
            <p><strong>Price:</strong> ${{ number_format($price, 2) }}</p>
            <p><strong>Discount:</strong> {{ $discount }}%</p>
            <p><strong>Total Amount:</strong> ${{ number_format($totalAmount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $paymentMethod }}</p>
            <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
        </div>

        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>
</body>

</html>
@endsection