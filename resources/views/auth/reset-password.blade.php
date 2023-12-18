@extends('layouts.mainheader')
@section('content')
<div class="login__container">
    <form class="login__form" method="POST" action="{{ route('password.store') }}">
        @csrf
        @if (session('status'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('status') }}</p>
        </div>
        @endif

        <!-- Email Address -->
        <div class="details__container">
            <i class="fa fa-user-circle-o"></i>
            <p>Réinitialiser le mot de passe</p>
        </div>
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="input__container">
        <p style="color:#fff;margin-left:10px;">Réinitialiser le mot de passe pour : {{ old('email', $request->email) }}</p>
            <x-text-input id="email" class="form__input" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" hidden />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input__container">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="form__input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="input__container">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

            <x-text-input id="password_confirmation" class="form__input" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="reset__actions__container">
            <div class="reset__cta__container">
                <button class="reset__cta">
                    {{ __('Réinitialiser') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection