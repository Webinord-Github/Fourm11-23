@extends('layouts.mainheader')
<x-auth-session-status class="mb-4" :status="session('status')" />
@if(session('status'))
    <div class="status-message">
        {{ session('status') }}
    </div>
@endif

@section('content')
<div class="login__container">
    <form class="login__form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="details__container">
            <i class="fa fa-user-circle-o"></i>
            <p>CONNEXION</p>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="input__container">
            <input id="email" class="form__input" type="email" name="email" :value="old('email')" placeholder="Courriel" required autofocus autocomplete="username" />

        </div>

        <!-- Password -->
        <div class="input__container">

            <input id="password" class="form__input" type="password" name="password" placeholder="Mot de passe" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="login__actions__container">
            <!-- Remember Me -->
            <div class="login__cta__container">
                <button class="login__cta">
                    {{ __('Se connecter') }}
                </button>
            </div>
            <div class="forgot__password__custom__container">
                @if (Route::has('password.request'))
                <a class="forgot__password__text" href="{{ route('password.request') }}">
                    Mot de passe oublié?
                </a>
                @endif
            </div>
            <div class="remember__me__container">
                <label for="remember_me" class="">
                    <input id="remember_me" type="checkbox" class="" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>
            <div class="register__custom__container">
                <p>Pas encore de compte? <a href="/sinscrire">Devenez membre</a></p>
            </div>


        </div>
    </form>
</div>
@endsection