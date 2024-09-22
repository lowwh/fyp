@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon far fa-plus-square"></i> Admin Control</li>
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
                                            <option value="kedah" {{ old('state') == 'kedah' ? 'selected' : '' }}>Kedah
                                            </option>
                                            <option value="kelantan" {{ old('state') == 'kelantan' ? 'selected' : '' }}>
                                                Kelantan</option>
                                            <option value="malacca" {{ old('state') == 'malacca' ? 'selected' : '' }}>
                                                Malacca</option>
                                            <option value="negeri-sembilan" {{ old('state') == 'negeri-sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                            <option value="pahang" {{ old('state') == 'pahang' ? 'selected' : '' }}>Pahang
                                            </option>
                                            <option value="penang" {{ old('state') == 'penang' ? 'selected' : '' }}>Penang
                                            </option>
                                            <option value="perak" {{ old('state') == 'perak' ? 'selected' : '' }}>Perak
                                            </option>
                                            <option value="perlis" {{ old('state') == 'perlis' ? 'selected' : '' }}>Perlis
                                            </option>
                                            <option value="sabah" {{ old('state') == 'sabah' ? 'selected' : '' }}>Sabah
                                            </option>
                                            <option value="sarawak" {{ old('state') == 'sarawak' ? 'selected' : '' }}>
                                                Sarawak</option>
                                            <option value="selangor" {{ old('state') == 'selangor' ? 'selected' : '' }}>
                                                Selangor</option>
                                            <option value="terengganu" {{ old('state') == 'terengganu' ? 'selected' : '' }}>Terengganu</option>
                                            <option value="kuala-lumpur" {{ old('state') == 'kuala-lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                            <option value="putrajaya" {{ old('state') == 'putrajaya' ? 'selected' : '' }}>
                                                Putrajaya</option>
                                            <option value="labuan" {{ old('state') == 'labuan' ? 'selected' : '' }}>Labuan
                                            </option>
                                        </select>
                                        @error('state')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Language Select -->
                                <div class="form-group mb-4">
                                    <label for="language" class="font-weight-bold">Language</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                        </div>
                                        <select id="language"
                                            class="form-control @error('language') is-invalid @enderror" name="language"
                                            required>
                                            <option value="" disabled selected>Select Language</option>
                                            <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>
                                                English</option>
                                            <option value="malay" {{ old('language') == 'malay' ? 'selected' : '' }}>Malay
                                            </option>
                                            <!-- Add other languages here -->
                                        </select>
                                        @error('language')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="form-group mb-5">
                                    <label for="role" class="font-weight-bold">Role</label>
                                    <select id="role" class="form-control @error('role') is-invalid @enderror"
                                        name="role" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Service Type -->
                                <div id="serviceTypeContainer" class="form-group mb-4" style="display: none;">
                                    <label for="serviceType" class="font-weight-bold">Service Type</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tools"></i></span>
                                        </div>
                                        <select id="serviceType"
                                            class="form-control @error('serviceType') is-invalid @enderror"
                                            name="serviceType">
                                            <option value="" disabled selected>Select Service Type</option>
                                            <option value="painting" {{ old('serviceType') == 'painting' ? 'selected' : '' }}>Painting</option>
                                            <option value="electrician" {{ old('serviceType') == 'electrician' ? 'selected' : '' }}>Electrician</option>
                                            <!-- Add other service types here -->
                                        </select>
                                        @error('serviceType')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Freelancer ID Input -->
                                <div id="freelancerIdContainer" class="form-group mb-4" style="display: none;">
                                    <label for="freelancerId" class="font-weight-bold">Freelancer ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        </div>
                                        <input id="freelancerId" type="text"
                                            class="form-control @error('freelancerId') is-invalid @enderror"
                                            name="freelancerId" value="{{ old('freelancerId') }}"
                                            placeholder="Enter Freelancer ID">
                                        @error('freelancerId')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Password Input -->
                                <div class="form-group mb-4">
                                    <label for="password" class="font-weight-bold">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required placeholder="Enter your password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password Input -->
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

                                <div class="form-group mb-4 text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const serviceTypeContainer = document.getElementById('serviceTypeContainer');
        const freelancerIdContainer = document.getElementById('freelancerIdContainer');

        roleSelect.addEventListener('change', function () {
            if (this.value === 'freelancer') {
                serviceTypeContainer.style.display = 'block';
                freelancerIdContainer.style.display = 'block';
            } else {
                serviceTypeContainer.style.display = 'none';
                freelancerIdContainer.style.display = 'none';
            }
        });
    });

</script>
@endsection