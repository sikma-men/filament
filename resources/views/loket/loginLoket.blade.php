<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loket PLN</title>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* General Reset and Box-Sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: #f4f4f4; /* Light background for the body */
        }

        /* Wrapper to split the background and form */
        .wrapper {
            display: flex;
            height: 100%;
            width: 100%;
        }

        /* Background Image Section */
        .background {
            flex: 1;
            background-image: url('https://bisnistoday.co.id/wp-content/uploads/2021/12/C7F6E2DE-CD0F-428D-A695-AFC03EDE7A0A_1_201_a.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Login container styling */
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background-color: #ffffff; /* White background for form */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Stronger shadow to create separation */
            border-radius: 20px;
            text-align: center;
            z-index: 1; /* Form stays on top */
            margin: 50px; /* Add margin to separate the form from edges */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Header styling */
        h1 {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
        }

        /* Form styling */
        .form {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 20px; /* Increased gap between form elements */
        }

        /* Input field styling */
        .inputForm {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Aligning input fields to the left */
            width: 100%;
        }

        .inputForm input {
            border: none;
            outline: none;
            width: 100%;
            padding: 15px;
            font-size: 1rem;
            background-color: #f9f9f9;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        .inputForm input:focus {
            border: 1px solid #0073e6; /* Focused border color */
        }

        /* Button styling */
        .button-submit {
            background-color: #151717;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
            width: 100%; /* Make button stretch full width */
        }

        .button-submit:hover {
            background-color: #252727;
        }

        /* Flex-row for layouts */
        .flex-row {
            display: flex;
            justify-content: flex-start; /* Align to the left */
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            width: 100%; /* Take full width */
        }

        /* Flex-column for input labels */
        .flex-column {
            display: flex;
            flex-direction: column;
            margin-bottom: 25px; /* Reduced margin for better spacing */
            font-weight: bold;
            text-align: left;
            color: #333;
            align-items: flex-start;
        }

        /* Other text styling */
        .span {
            color: #0073e6;
            cursor: pointer;
            font-size: 0.9rem;
        }

        /* Adjust for smaller screens */
        @media (max-width: 500px) {
            .login-container {
                padding: 30px; /* Reduced padding for smaller screens */
            }

            .form {
                gap: 20px;
            }

            .button-submit {
                padding: 12px;
                font-size: 1rem;
            }

            .span {
                font-size: 0.85rem;
            }
        }

        /* Positioning the logo */
        .pln-logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 90px; /* Set logo size */
            height: auto;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Background Image Section -->
        <div class="background"></div>

        <!-- PLN Logo -->
        <img src="https://1.bp.blogspot.com/-XjhgtORKCCE/XmD03YvnoeI/AAAAAAAABrE/5iqWTF-Cnvsi-DsuehAspe49AbWHqRjCACLcBGAsYHQ/s1600/Logo%2Bpln.png" alt="PLN Logo" class="pln-logo">

        <!-- Login Form Section -->
        <div class="login-container">
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
                <h1>Loket PLN</h1>

                <!-- Form Starts -->
                <form class="form" method="POST" action="{{ route('loket.login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="flex-column">
                        <label for="email">Email</label>
                        <div class="inputForm">
                            <input type="text" id="email" name="email" class="input" placeholder="Enter your Email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="flex-column">
                        <label for="password">Password</label>
                        <div class="inputForm">
                            <input type="password" id="password" name="password" class="input" placeholder="Enter your Password" required>
                        </div>
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
                    <button type="submit" class="button-submit">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
