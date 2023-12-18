@extends('layouts.mainheader')
@section('content')
<div class="login__container">
    <form class="login__form" method="POST" action="{{ route('password.email') }}">
        <x-auth-session-status style="text-align:center;" class="mb-4" :status="session('status')" />
        @csrf

        <!-- Email Address -->
        <div class="details__container">
            <i class="fa fa-user-circle-o"></i>
            <p>réinitialisation du mot de passe</p>
            <p style="text-align:center;font-size:16px;">Mot de passe oublié? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.</p>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="input__container">
            <x-input-label for="email" value="Courriel" />
            <x-text-input id="email" class="form__input" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="login__actions__container">
            <div class="login__cta__container">
                <x-primary-button class="login__cta">
                    Lien de réinitialisation du mot de passe par e-mail
                </x-primary-button>
            </div>
        </div>
    </form>
</div>
@endsection