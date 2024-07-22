@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <style>
        /* General styles */
        body {
            background-color: #f1f1f1;
            font-family: 'Arial', sans-serif;
        }

        .checkout-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .card-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-option img {
            width: 50px;
            margin-right: 10px;
        }

        .card-option input {
            margin-right: 10px;
        }

        /* Voucher styles */
        .vouchers-container {
            margin-top: 20px;
        }

        .voucher-list {
            list-style: none;
            padding: 0;
        }

        .voucher-item {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            transition: background-color 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .voucher-item:hover {
            background-color: #f9f9f9;
            transform: scale(1.02);
        }

        .voucher-code {
            font-weight: bold;
            font-size: 1.1em;
        }

        .voucher-discount {
            color: #28a745;
            font-weight: bold;
        }

        /* Final price styles */
        #finalPrice {
            font-size: 1.5em;
            color: #333;
        }

        /* Remove voucher button */
        .remove-voucher {
            cursor: pointer;
            color: #dc3545;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container checkout-container">
        @if (session('bid'))
            <div class="alert alert-info" id="bidAlert">
                {{ session('bid') }}
            </div>
        @endif
        <h2 class="title">Checkout</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card service-details">
                    <div class="card-body">
                        <h4 class="card-title">Service Details</h4>
                        <p><strong>Freelancer ID:</strong> {{ $freelancerid }}</p>
                        <p><strong>Service ID:</strong> {{ $serviceid }}</p>
                        <p><strong>Price:</strong> ${{ number_format($price, 2) }}</p>
                        <!-- Hidden input to store original price -->
                        <input type="hidden" id="originalPrice" value="{{ $price }}">
                    </div>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('payment.process', ['userid' => $userid, 'serviceid' => $serviceid, 'freelancerid' => $freelancerid, 'serviceprice' => $price]) }}"
                        method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="cardOptions" class="form-label">Select a Card</label>
                            <div class="card-option">
                                <input type="radio" id="visa" name="card_type" value="visa">
                                <label for="visa"><img src="{{ asset('images/visa.webp') }}" alt="Visa">Visa</label>
                            </div>
                            <div class="card-option">
                                <input type="radio" id="mastercard" name="card_type" value="mastercard">
                                <label for="mastercard"><img src="{{ asset('images/mastercard.png') }}"
                                        alt="MasterCard">MasterCard</label>
                            </div>
                            <div class="card-option">
                                <input type="radio" id="duitnow" name="card_type" value="duitnow">
                                <label for="duitnow"><img src="{{ asset('images/duitnow.png') }}"
                                        alt="DuitNow">DuitNow</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="voucherCode" class="form-label">Voucher Code</label>
                            <input type="text" class="form-control" id="voucherCode" name="voucher_code" readonly>
                        </div>

                        <div class="vouchers-container">
                            <label for="availableVouchers" class="form-label">Available Vouchers</label>
                            <ul class="voucher-list" id="availableVouchers">
                                @foreach($vouchers as $voucher)
                                    <li class="voucher-item" data-code="{{ $voucher->code }}"
                                        data-discount="{{ $voucher->discount_percentage }}">
                                        <span class="voucher-code">{{ $voucher->code }}</span>
                                        <span class="voucher-discount">{{ $voucher->discount_percentage }}% off</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="finalPrice" class="form-label">Final Price</label>
                            <p id="finalPrice">${{ number_format($price, 2) }}</p>
                            <span id="removeVoucher" class="remove-voucher" style="display:none;">Remove Voucher</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block w-100" id="payNowButton">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.voucher-item').forEach(function (item) {
            item.addEventListener('click', function () {
                if (document.querySelector('.voucher-item.selected')) {
                    alert('You have already applied a voucher.');
                    return;
                }

                const voucherCode = item.getAttribute('data-code');
                const discountPercentage = parseFloat(item.getAttribute('data-discount'));
                document.getElementById('voucherCode').value = voucherCode;

                const originalPrice = parseFloat(document.getElementById('originalPrice').value);
                const discountAmount = (originalPrice * discountPercentage) / 100;
                const finalPrice = originalPrice - discountAmount;

                document.getElementById('finalPrice').innerText = `$${finalPrice.toFixed(2)}`;

                // Mark the selected voucher
                document.querySelectorAll('.voucher-item').forEach(voucher => voucher.classList.remove('selected'));
                item.classList.add('selected');
                item.style.pointerEvents = 'none';  // Disable further clicks on this voucher

                // Show remove voucher link
                document.getElementById('removeVoucher').style.display = 'inline';
            });
        });

        document.getElementById('removeVoucher').addEventListener('click', function () {
            const originalPrice = parseFloat(document.getElementById('originalPrice').value);

            // Reset final price to original price
            document.getElementById('finalPrice').innerText = `$${originalPrice.toFixed(2)}`;
            document.getElementById('voucherCode').value = '';

            // Remove selected voucher styling
            document.querySelectorAll('.voucher-item').forEach(voucher => {
                if (voucher.classList.contains('selected')) {
                    voucher.classList.remove('selected');
                    voucher.style.pointerEvents = 'auto';  // Enable clicks again
                }
            });

            // Hide remove voucher link
            document.getElementById('removeVoucher').style.display = 'none';
        });
    </script>
</body>

</html>
@endsection