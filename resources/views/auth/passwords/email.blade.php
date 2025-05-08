@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="card-header">Resetar Senha</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-primary">
                        Enviar Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
