@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-20">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-home nav-icon"></i> Home</li>
                    </ol>
                </div>
            </div>

            <h1>Freelancers List</h1>

            <!-- Loading Icon -->
            <div id="loading-icon" class="spinner" style="display: none;">
            </div>

            <div class="row">
                @foreach($freelancers as $freelancer)
                    <div class="col-md-4 mb-4">
                        <div class="card"
                            style="width: 100%; background-color: white; padding: 5px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <div class="card-body d-flex justify-content-between flex-column">
                                <div style="margin-bottom: 10px;">
                                    @if($freelancer->serviceimage)
                                        <div>
                                            <img src="{{ asset('storage/' . $freelancer->serviceimage) }}" alt="Service Image"
                                                style="max-width: 200px; height: auto;">
                                        </div>
                                    @endif
                                    <br>
                                    @if($freelancer->image_path)
                                        <div>
                                            <img src="{{ asset('storage/' . $freelancer->image_path) }}" alt="Freelancer Image"
                                                class="rounded-circle" style="width: 50px; height: 50px;">
                                        </div>
                                    @endif
                                    <div style="margin-bottom: 10px;">
                                        <h5 class="card-title mb-0"
                                            style="display: inline; font-weight: bold; font-size: 1.2rem;">Gig ID:</h5>
                                        <p style="display: inline; margin-left: 10px; font-size: 1.2rem;">
                                            {{ $freelancer->serviceid }}
                                        </p>
                                        <br>
                                        <h5 class="card-title mb-0"
                                            style="display: inline; font-weight: bold; font-size: 1.2rem;">Gig Title:</h5>
                                        <p style="display: inline; margin-left: 10px; font-size: 1.2rem;">
                                            {{ $freelancer->title }}
                                        </p>
                                        <br>
                                    </div>
                                </div>
                                <div class="ml-auto"
                                    style="align-self: flex-end; background-color: #f0f8ff; padding: 5px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                    <h5 class="card-title" style="display: inline;">From:</h5>
                                    <p style="display: inline; margin-left: 10px;">{{ $freelancer->price }}</p>
                                </div>

                                <a href="/viewprofile/{{ $freelancer->main_id }}"
                                    class="btn btn-primary mt-auto view-profile-button">View
                                    Profile</a>
                                <a href="/viewservice/{{ $freelancer->main_id }}/{{ $freelancer->serviceid }}"
                                    class="btn btn-secondary mt-auto view-service-button">View Service</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const viewProfileButtons = document.querySelectorAll('.view-profile-button');
        const viewServiceButtons = document.querySelectorAll('.view-service-button');

        const showLoading = () => {
            document.getElementById('loading-icon').style.display = 'block';
        };

        const redirectToUrl = (url) => {
            setTimeout(() => {
                window.location.href = url;
            }, 300); // Adjust delay as needed
        };

        viewProfileButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                showLoading();
                const url = event.target.href;
                redirectToUrl(url);
            });
        });

        viewServiceButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                showLoading();
                const url = event.target.href;
                redirectToUrl(url);
            });
        });
    });
</script>
<style>
    .spinner {
        display: none;
        /* Hidden by default */
        position: fixed;
        top: 50%;
        left: 50%;
        width: 80px;
        height: 80px;
        margin: -40px 0 0 -40px;
        border: 8px solid rgba(0, 0, 0, 0.1);
        border-top: 8px solid #3498db;
        border-radius: 50%;
        border-top-color: red;
        animation: spin 1s linear infinite;
        z-index: 1000;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection