@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content here -->
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

        /* Loading icon styles */
        .loading-icon {
            display: none;
            margin-left: 10px;
        }

        .tick-icon {
            display: none;
            color: #28a745;
            font-size: 2em;
            font-weight: bold;
            margin-left: 10px;
        }

        /* Progress bar styles */
        .progress-container {
            margin-top: 20px;
        }

        progress {
            width: 100%;
            height: 20px;
            -webkit-appearance: none;
        }

        progress::-webkit-progress-bar {
            background-color: #e9ecef;
            border-radius: 5px;
        }

        progress::-webkit-progress-value {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Order summary styles */
        .order-summary {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .order-summary p {
            margin-bottom: 10px;
        }

        #orderTotal {
            font-weight: bold;
            color: #007bff;
        }

        /* Terms and conditions styles */
        .terms-container {
            margin-top: 20px;
            font-size: 0.9em;
        }

        .terms-container a {
            color: #007bff;
            text-decoration: none;
        }

        .terms-container a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .checkout-container {
                padding: 20px;
            }

            .card-body {
                padding: 15px;
            }
        }

        /* No voucher message styles */
        .no-voucher-message {
            text-align: center;
            padding: 20px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            color: #721c24;
            margin-top: 20px;
            font-weight: bold;
            font-size: 1.2em;
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

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="title">Order Summary</h3>
            <p><strong>Freelancer ID:</strong> {{ $freelancerid }}</p>
            <p><strong>Service ID:</strong> {{ $serviceid }}</p>
            <p><strong>Original Price:</strong> ${{ number_format($price, 2) }}</p>
            <p><strong>Discount:</strong> <span id="voucherDiscount">0%</span></p>
            <p><strong>Total Amount:</strong> $<span id="orderTotal">{{ number_format($price, 2) }}</span></p>
        </div>

        <!-- Payment Form -->
        <div class="row">
            <div class="col-md-6">
                <div class="card service-details">
                    <input type="hidden" id="originalPrice" value="{{ $price }}">
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('payment.process', ['userid' => $userid, 'serviceid' => $serviceid, 'freelancerid' => $freelancerid, 'serviceprice' => $price]) }}"
                        method="POST" id="paymentForm">
                        @csrf

                        <div class="form-group">
                            <label for="cardOptions" class="form-label">Select a payment method</label>
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
                                @if($availableVouchers->isEmpty())
                                    <div class="no-voucher-message">
                                        <h1>No available vouchers</h1>
                                    </div>
                                @else
                                    @foreach($availableVouchers as $voucher)
                                        <li class="voucher-item" data-code="{{ $voucher->code }}"
                                            data-discount="{{ $voucher->discount_percentage }}">
                                            <span class="voucher-code">{{ $voucher->code }}</span>
                                            <span class="voucher-discount">{{ $voucher->discount_percentage }}% off</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>


                        <div class="mb-3">
                            <label for="finalPrice" class="form-label">Final Price</label>
                            <p id="finalPrice">${{ number_format($price, 2) }}</p>
                            <span id="removeVoucher" class="remove-voucher" style="display:none;">Remove Voucher</span>
                            <input type="hidden" id="finalPriceInput" name="final_price" value="{{ $price }}">
                        </div>

                        <div class="terms-container">
                            <p>By proceeding, you agree to our <a href="{{ route('terms') }}" target="_blank">Terms and
                                    Conditions</a>.</p>
                        </div>

                        <div id="formErrors" class="alert alert-danger" style="display:none;"></div>

                        <button type="submit" class="btn btn-primary">Pay Now</button>
                        <img src="{{ asset('images/loading.gif') }}" alt="Loading" class="loading-icon"
                            id="loadingIcon">
                        <span class="tick-icon" id="successTick">&#10003;</span>
                    </form>
                    <div>
                        <form method="post" action="/check/{{$serviceid}}/{{$userid}}">
                            @csrf
                            <button>Check</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Feedback -->
        <div class="feedback-container">
            <h3 class="title">Additional Information</h3>
            <p>Ensure that you review the final price and voucher details before submitting your payment.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const voucherItems = document.querySelectorAll('.voucher-item');
            const voucherCodeInput = document.getElementById('voucherCode');
            const finalPriceInput = document.getElementById('finalPriceInput');
            const finalPriceElement = document.getElementById('finalPrice');
            const removeVoucherButton = document.getElementById('removeVoucher');
            const orderTotalElement = document.getElementById('orderTotal');
            const voucherDiscountElement = document.getElementById('voucherDiscount');
            const progress = document.getElementById('progress');
            const loadingIcon = document.getElementById('loadingIcon');
            const successTick = document.getElementById('successTick');
            const formErrors = document.getElementById('formErrors');

            voucherItems.forEach(item => {
                item.addEventListener('click', function () {
                    const code = this.dataset.code;
                    const discount = this.dataset.discount;
                    voucherCodeInput.value = code;
                    const discountedPrice = calculateDiscountedPrice(discount);
                    finalPriceInput.value = discountedPrice;
                    finalPriceElement.textContent = `$${discountedPrice}`;
                    orderTotalElement.textContent = `$${discountedPrice}`;
                    voucherDiscountElement.textContent = `${discount}%`;
                    removeVoucherButton.style.display = 'inline';
                });
            });

            removeVoucherButton.addEventListener('click', function () {
                voucherCodeInput.value = '';
                finalPriceInput.value = document.getElementById('originalPrice').value;
                const originalPrice = finalPriceInput.value;
                finalPriceElement.textContent = `$${originalPrice}`;
                orderTotalElement.textContent = `$${originalPrice}`;
                voucherDiscountElement.textContent = '0%';
                this.style.display = 'none';
            });

            function calculateDiscountedPrice(discount) {
                const originalPrice = parseFloat(document.getElementById('originalPrice').value);
                return (originalPrice - (originalPrice * (discount / 100))).toFixed(2);
            }

            document.getElementById('paymentForm').addEventListener('submit', function (event) {
                const errors = [];
                const cardType = document.querySelector('input[name="card_type"]:checked');

                if (!cardType) {
                    errors.push('Please select a payment method.');
                }

                if (errors.length > 0) {
                    event.preventDefault();
                    formErrors.innerHTML = errors.join('<br>');
                    formErrors.style.display = 'block';
                } else {
                    formErrors.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
@endsection