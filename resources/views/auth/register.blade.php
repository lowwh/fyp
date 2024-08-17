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
                    <div class="card">

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                                    <div class="col-md-6">
                                        <input id="age" type="text"
                                            class="form-control @error('age') is-invalid @enderror" name="age"
                                            value="{{ old('age') }}" required autocomplete="name" autofocus>

                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label for="gender"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                    <div class="col-md-6">
                                        <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                            name="gender" required>
                                            <option value="" disabled selected>{{ __('Select Gender') }}</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                {{ __('Male') }}
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                {{ __('Female') }}
                                            </option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                                {{ __('Other') }}
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="state"
                                        class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>
                                    <div class="col-md-6">
                                        <select id="state" class="form-control @error('state') is-invalid @enderror"
                                            name="state" required>
                                            <option value="" disabled selected>{{ __('Select State') }}</option>
                                            <option value="johor" {{ old('state') == 'johor' ? 'selected' : '' }}>
                                                {{ __('Johor') }}
                                            </option>
                                            <option value="kedah" {{ old('state') == 'kedah' ? 'selected' : '' }}>
                                                {{ __('Kedah') }}
                                            </option>
                                            <option value="kelantan" {{ old('state') == 'kelantan' ? 'selected' : '' }}>
                                                {{ __('Kelantan') }}
                                            </option>
                                            <option value="malacca" {{ old('state') == 'malacca' ? 'selected' : '' }}>
                                                {{ __('Malacca') }}
                                            </option>
                                            <option value="negeri_sembilan" {{ old('state') == 'negeri_sembilan' ? 'selected' : '' }}>
                                                {{ __('Negeri Sembilan') }}
                                            </option>
                                            <option value="pahang" {{ old('state') == 'pahang' ? 'selected' : '' }}>
                                                {{ __('Pahang') }}
                                            </option>
                                            <option value="penang" {{ old('state') == 'penang' ? 'selected' : '' }}>
                                                {{ __('Penang') }}
                                            </option>
                                            <option value="perak" {{ old('state') == 'perak' ? 'selected' : '' }}>
                                                {{ __('Perak') }}
                                            </option>
                                            <option value="perlis" {{ old('state') == 'perlis' ? 'selected' : '' }}>
                                                {{ __('Perlis') }}
                                            </option>
                                            <option value="sabah" {{ old('state') == 'sabah' ? 'selected' : '' }}>
                                                {{ __('Sabah') }}
                                            </option>
                                            <option value="sarawak" {{ old('state') == 'sarawak' ? 'selected' : '' }}>
                                                {{ __('Sarawak') }}
                                            </option>
                                            <option value="selangor" {{ old('state') == 'selangor' ? 'selected' : '' }}>
                                                {{ __('Selangor') }}
                                            </option>
                                            <option value="terengganu" {{ old('state') == 'terengganu' ? 'selected' : '' }}>{{ __('Terengganu') }}
                                            </option>
                                            <option value="kuala_lumpur" {{ old('state') == 'kuala_lumpur' ? 'selected' : '' }}>{{ __('Kuala Lumpur') }}
                                            </option>
                                            <option value="labuan" {{ old('state') == 'labuan' ? 'selected' : '' }}>
                                                {{ __('Labuan') }}
                                            </option>
                                            <option value="putrajaya" {{ old('state') == 'putrajaya' ? 'selected' : '' }}>
                                                {{ __('Putrajaya') }}
                                            </option>
                                        </select>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="language"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Language') }}</label>
                                    <div class="col-md-6">
                                        <select id="language" class="form-control" @error('language') is-invalid
                                        @enderror" name="language" required>
                                            <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>
                                                {{ __('English') }}
                                            </option>
                                            <option value="Bahasa Malaysia" {{ old('language') == 'Bahasa Malaysia' ? 'selected' : '' }}>
                                                {{ __('Bahasa Malaysia') }}
                                            </option>
                                            <option value="Chinese" {{ old('language') == 'Chinese' ? 'selected' : '' }}>
                                                {{ __('Chinese') }}
                                            </option>
                                        </select>
                                        @error('language')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="serviceType"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Service Type') }}</label>

                                    <div class="col-md-6">
                                        <input id="serviceType" type="text"
                                            class="form-control @error('serviceType') is-invalid @enderror"
                                            name="serviceType" value="{{ old('serviceType') }}" required
                                            autocomplete="serviceType" autofocus>

                                        @error('serviceType')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>






                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <!-- Role Selection Dropdown -->
                                <div class="row mb-3">
                                    <label for="role"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                                    <div class="col-md-6">
                                        <div class="select-container">
                                            <select id="role" class="form-control @error('role') is-invalid @enderror"
                                                name="role" required>
                                                <option value="lecturer">Lecturer</option>
                                                <option value="admin">Admin</option>
                                                <option value="freelancer">Freelancer</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                </div>
                                <!-- End Role Selection Dropdown -->

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
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