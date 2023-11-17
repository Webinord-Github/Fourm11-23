@extends('layouts.mainheader')
@section('content')
<div class="forgot__password__container">
    <div class="forgot__password__content">
        <div class="forgot__password__text">
            Mot de passe oublié? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form class="forgot__password__form" method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Courriel" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-primary-button>
                    Lien de réinitialisation du mot de passe par e-mail
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection