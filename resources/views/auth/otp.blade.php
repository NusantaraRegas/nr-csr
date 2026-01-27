@extends('layout.master_auth')
@section('title', 'NR SHARE | Verifikasi OTP')

@section('content')
    <style>
        .otp-wrapper {
            padding: 0 30px;
        }

        .otp-input {
            width: 40px;
            height: 50px;
            font-size: 22px;
            font-weight: bold;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 6px;
            margin: 0 5px;
            line-height: 50px;
            padding: 0;
            color: #333;
            background-color: #fff;
        }

        .otp-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
            outline: none;
        }

        .shake {
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            50% {
                transform: translateX(4px);
            }

            75% {
                transform: translateX(-4px);
            }

            100% {
                transform: translateX(0);
            }
        }

        @media (max-width: 576px) {
            .otp-wrapper {
                padding: 0 15px;
            }

            .otp-input {
                width: 35px;
                height: 45px;
                font-size: 18px;
                margin: 0 3px;
            }
        }
    </style>

    @php
        $otpCreated = \Carbon\Carbon::parse(session('mfa_otp_created_at'));
        $expiresIn = 300 - now()->diffInSeconds($otpCreated);
        $expiresIn = $expiresIn > 0 ? $expiresIn : 0;
    @endphp

    <div class="login-box">
        <center>
            <img src="{{ asset('assets/images/logo-pertamina-gas-negara.png') }}" width="200px" alt="Logo NR">
            <h4 class="mt-4"><strong>Masukkan Kode OTP</strong></h4>
            <p class="text-muted text-center mb-4">
                Kami telah mengirimkan kode verifikasi ke email Anda. Silakan masukkan 6 digit kode OTP di bawah ini.
            </p>
        </center>
        <form method="post" action="{{ route('verifyOtp') }}" id="formOtp">
            @csrf

            <div class="d-flex justify-content-center gap-2 mb-3">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" class="form-control otp-input text-center" maxlength="1" pattern="\d*"
                        inputmode="numeric" required aria-label="Digit OTP" />
                @endfor
            </div>

            {{-- Hidden field to store merged OTP --}}
            <input type="hidden" name="otp" id="otp-hidden">

            @error('otp')
                <div class="text-danger text-center mb-3">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-login btn-block btn-lg">
                VERIFIKASI OTP
            </button>

            <div class="text-center mt-4">
                <div id="otp-timer" class="text-muted">
                    Kode akan kedaluwarsa dalam <span id="countdown">01:00</span>
                </div>
                <div id="resend-link" class="mt-2" style="display: none;">
                    <p class="mb-1 text-danger">Kode OTP telah kedaluwarsa.</p>
                    <a href="{{ route('resend-otp') }}" class="font-weight-bold"><i
                            class="feather icon-refresh-ccw font-weight-bold mr-2"></i>Kirim ulang kode</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        let duration = {{ $expiresIn }};
        const timerDisplay = document.getElementById('countdown');
        const otpTimer = document.getElementById('otp-timer');
        const resendLink = document.getElementById('resend-link');

        let countdown = setInterval(() => {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            timerDisplay.textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (duration <= 0) {
                clearInterval(countdown);
                otpTimer.style.display = 'none';
                resendLink.style.display = 'block';
                resetOtpInputs();
            }

            duration--;
        }, 1000);

        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otp-hidden');
        const form = document.getElementById('formOtp');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Update nilai OTP tersembunyi
        function updateHiddenInput() {
            let otp = '';
            inputs.forEach(input => otp += input.value);
            hiddenInput.value = otp;
            submitBtn.disabled = otp.length !== 6;
        }

        // Autofokus dan event input
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1); // hanya 1 digit angka

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateHiddenInput();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                } else if (e.key === 'ArrowLeft' && index > 0) {
                    inputs[index - 1].focus();
                } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        // ✅ Tambahan: Paste 6 digit ke input pertama
        inputs[0].addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/\D/g, '').slice(0, 6); // Ambil hanya angka, maksimal 6 digit

            if (digits.length === 6) {
                digits.split('').forEach((digit, idx) => {
                    if (inputs[idx]) inputs[idx].value = digit;
                });
                inputs[5].focus();
                updateHiddenInput();
            }
        });

        // Saat submit, pastikan nilai dikumpulkan ulang
        form.addEventListener('submit', (e) => {
            let otp = '';
            inputs.forEach(input => otp += input.value);
            hiddenInput.value = otp;

            if (otp.length !== 6) {
                e.preventDefault();
                alert('Silakan isi semua 6 digit kode OTP');
            }
        });

        // Autofocus saat page load
        window.addEventListener('DOMContentLoaded', () => {
            inputs[0].focus();
            submitBtn.disabled = true;
        });

        // Animasi shake jika OTP error
        @if ($errors->has('otp'))
            window.addEventListener('DOMContentLoaded', () => {
                inputs.forEach(input => input.classList.add('shake'));
                setTimeout(() => {
                    inputs.forEach(input => input.classList.remove('shake'));
                }, 400);
            });
        @endif
    </script>
@stop
