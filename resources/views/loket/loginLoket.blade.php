<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loket PLN</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/loginloket.css') }}">
</head>
<body>
    <div class="login-container">
        <h1>Loket PLN</h1>

        {{-- Menampilkan error jika email atau password salah --}}
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                });
            </script>
        @endif

        <!-- Form Container Start -->
        <div class="form-wrapper">
            <!-- Form Starts -->
            <form class="form" method="POST" action="{{ route('loginloket') }}">
                @csrf
                <!-- Email Field -->
                <div class="flex-column">
                    <label for="email">Email</label>
                </div>
                <div class="inputForm">
                    <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
                    <input type="text" id="email" name="email" class="input" placeholder="Enter your Email" value="{{ old('email') }}" required>
                </div>

                <!-- Password Field -->
                <div class="flex-column">
                    <label for="password">Password</label>
                </div>
                <div class="inputForm">
                    <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>
                    <input type="password" id="password" name="password" class="input" placeholder="Enter your Password" required>
                    <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex-row">
                    <div>
                        <input type="checkbox" name="remember">
                        <label>Remember me</label>
                    </div>
                    <span class="span">Forgot password?</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="button-submit">Sign In</button>

                <!-- Sign Up Prompt -->
                <p class="p">Don't have an account? <span class="span">Sign Up</span></p>
                <p class="p line">Or With</p>

                <!-- Social Sign-In Buttons -->
                <div class="flex-row">
                    <button class="btn google">
                        <svg version="1.1" width="20" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <path style="fill:#FBBB00;" d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456C103.821,274.792,107.225,292.797,113.47,309.408z"></path>
                            <path style="fill:#518EF8;" d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.12-74.948h-38.229l-9.213,64.017c-15.548-9.687-33.622-15.1-52.93-15.1c-40.715,0-77.727,21.233-98.237,53.035l-73.407-10.559l-33.145,68.88c15.947,29.898,45.736,51.708,81.775,51.708c47.978,0,87.171-39.197,87.171-87.177c0-7.285-0.776-14.412-2.151-21.347C465.318,256.211,482,224.512,507.527,208.176z"></path>
                            <path style="fill:#28B446;" d="M28.624,117.732c-3.005,0-5.989,0.263-8.908,0.702l-16.297-63.104l-10.654,0.303l-7.514,50.375c-0.076-0.03-0.139-0.075-0.215-0.108C10.324,82.483,0,121.545,0,256c0,43.9,11.042,85.211,28.624,117.732c3.285-0.502,6.659-0.949,10.008-1.445l11.935-71.74L53.795,209.78C61.378,213.936,67.886,218.117,74.566,223.092l-45.949-68.153C51.622,187.97,56.708,208.801,28.624,117.732z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <!-- Form Container End -->
    </div>
</body>
</html>
