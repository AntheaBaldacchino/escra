<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IdeaDesk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
        }

        .left-panel {
            background: #a3c4c4;
        }

        .info-box {
            background: rgba(252, 252, 252, 1);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 1px 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 1.1rem;
        }

        .code-card {
            background: #3b6a75;
            border-radius: 1.5rem;
        }

        .digit-input {
            width: 60px;
            height: 56px;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
        }
        .center-arrow {
            position: absolute;
            top: 53%;
            left: 47%;
            transform: translate(-50%, -50%) scale(1.35);
            width: 260px;        
            z-index: 10;
            pointer-events: none;
            
        }
        .row {
            position: relative;
        }

        @media (max-width: 768px) {
            .center-arrow {
                display: none;
            }
        }


    </style>
</head>

<body class="bg-light">

<div class="container-fluid min-vh-100">
    <div class="row min-vh-100">

        {{-- LEFT --}}
        <div class="col-md-6 d-flex flex-column justify-content-between align-items-center p-5 left-panel">
            <div class="text-center mt-4">
                <div class="mb-2 fw-bold fs-1">Escra</div>
            </div>

            <div class="info-box text-center shadow-sm">
                Start drafting ideas, notes, or stories — everything you write is saved automatically and tied to your code.
                <br><br>
                No accounts, no logins — just your words, instantly.
            </div>
        </div>

        <img
        src="{{ asset('images/image 3.svg') }}"
        alt=""
        class="center-arrow"
        />


        {{-- RIGHT --}}
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-4">

            <div class="code-card text-white shadow p-4 p-md-5 mb-4 w-100" style="max-width: 520px;">
                <h2 class="text-center mb-4">Insert Code</h2>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('code.enter') }}" id="codeForm">
                    @csrf

                    <div class="d-flex justify-content-center gap-3 mb-4">
                        @for($i = 0; $i < 4; $i++)
                            <input
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                class="form-control digit-input"
                                required
                            >
                        @endfor
                    </div>

                    {{-- Hidden combined code --}}
                    <input type="hidden" name="code" id="code">

                    <button class="btn btn-light btn-lg w-100 fw-semibold">
                        Enter
                    </button>
                </form>
            </div>

            <div class="info-box text-center" style="max-width: 520px;">
                Enter your unique 4-digit code to access your personal writing space.
            </div>

        </div>
    </div>
</div>

<script>
    const inputs = document.querySelectorAll('.digit-input');
    const hidden = document.getElementById('code');

    inputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
            updateHidden();
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });
    });

    function updateHidden() {
        hidden.value = Array.from(inputs).map(i => i.value).join('');
    }
</script>

</body>
</html>
