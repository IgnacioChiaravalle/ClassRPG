@extends('layouts.app')

@section('content')

<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>


@if (Session::has('success'))
	<div class="alert-toast" id="login-alert-toast">
		<div>{{ session('success') }}</div>
		<div class="toast-closer" onclick="closeToast('login-alert-toast')">X</div>
	</div>
@endif
@if (Session::has('message'))
	<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
@endif

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Ingresar</div>

				<div class="card-body">
					<form method="POST" action="{{ route('login') }}">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">Dirección de Correo Electrónico</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="ejemplo@mail.com" required autocomplete="email" autofocus>

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password">

								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

									<label class="form-check-label" for="remember">
										Recordar mis datos
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Ingresar
								</button>

								@if (Route::has('password.request'))
									<a class="btn btn-link" href="{{ route('password.request') }}">
										¿Olvidaste tu contraseña?
									</a>
								@endif
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
