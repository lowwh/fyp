@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon far fa-plus-square"></i> Admin Control</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-plus nav-icon"></i> Register User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-lg mt-5">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="font-weight-bold my-4">Register a New User</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <!-- Name Input -->
                                <div class="form-group mb-4">
                                    <label for="name" class="font-weight-bold">Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autofocus placeholder="Enter your name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Age Input -->
                                <div class="form-group mb-4">
                                    <label for="age" class="font-weight-bold">Age</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input id="age" type="number"
                                            class="form-control @error('age') is-invalid @enderror" name="age"
                                            value="{{ old('age') }}" required placeholder="Enter your age">
                                        @error('age')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Input -->
                                <div class="form-group mb-4">
                                    <label for="email" class="font-weight-bold">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required placeholder="Enter your email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Gender Select -->
                                <div class="form-group mb-4">
                                    <label for="gender" class="font-weight-bold">Gender</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        </div>
                                        <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                            name="gender" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- State Select -->
                                <div class="form-group mb-4">
                                    <label for="state" class="font-weight-bold">State</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <select id="state" class="form-control @error('state') is-invalid @enderror"
                                            name="state" required>
                                            <option value="" disabled selected>Select State</option>
                                            <option value="johor" {{ old('state') == 'johor' ? 'selected' : '' }}>Johor
                                            </option>
                                            <!-- Add other states -->
                                        </select>
                                        @error('state')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Service Type -->
                                <div class="form-group mb-4">
                                    <label for="serviceType" class="font-weight-bold">Service Type</label>
                                    <input id="serviceType" type="text"
                                        class="form-control @error('serviceType') is-invalid @enderror"
                                        name="serviceType" value="{{ old('serviceType') }}" required
                                        placeholder="Enter the service type">
                                    @error('serviceType')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4">
                                    <label for="password" class="font-weight-bold">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required placeholder="Enter a strong password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="form-group mb-4">
                                    <label for="password-confirm" class="font-weight-bold">Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required placeholder="Confirm your password">
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="form-group mb-5">
                                    <label for="role" class="font-weight-bold">Role</label>
                                    <select id="role" class="form-control @error('role') is-invalid @enderror"
                                        name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection