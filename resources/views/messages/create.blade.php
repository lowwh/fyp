@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-primary text-white rounded-top d-flex align-items-center">

            <h1 class="mb-0">Send Message to {{ $user->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('messages.sendMessage') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">

                <div class="mb-4">
                    <label for="content" class="form-label">Message</label>
                    <textarea name="content" id="content" class="form-control border-secondary rounded-lg shadow-sm"
                        rows="6" placeholder="Type your message here..." required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary shadow-sm">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    .card {
        border: none;
        border-radius: 1rem;
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
    }

    .card-header {
        border-bottom: 1px solid #e0e0e0;
        border-radius: 1rem 1rem 0 0;
        background: #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header img {
        border: 3px solid #ffffff;
    }

    .form-label {
        font-weight: bold;
        font-size: 1.2rem;
        color: #333;
    }

    .form-control {
        padding: 1rem;
        font-size: 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-primary:focus,
    .btn-primary:active {
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }

    @media (max-width: 576px) {
        .card-header img {
            width: 50px;
            height: 50px;
        }

        .form-label {
            font-size: 1rem;
        }

        .form-control {
            font-size: 0.9rem;
        }

        .btn-primary {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>