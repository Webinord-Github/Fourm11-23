@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Utilisateurs Bannis</h1>
        @if (session('success'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nom</th>
                    <th scope="col" class="px-6 py-3">Courriel</th>
                    <th scope="col" class="px-6 py-3">Rôle</th>
                 
                    <th scope="col" class="px-6 py-3">Débloquer</th>
                </tr>
            </thead>
            <form method="POST" action="{{ route('usersguard.store') }}">
                @csrf
                <tbody>
                    @foreach ($users as $user)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="underline">{{ $user->name }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->roles->first()->name }}</td>
                        <td class="px-6 py-4">
                            <button data-user-id="{{$user->id}}" data-user-name="{{$user->name}}" class="user__unban" href="">Débloquer l'utilisateur</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <div>
                    <button class="form__submit" type="submit">SAUVEGARDER</button>
                </div>
            </form>

        </table>
        {{$users->links()}}
    </div>
</div>
</div>
<div class="ban__container">
    <div class="ban__popup">
        <h2>Voulez-vous débloquer l'utilisateur suivant?</h2>
        <p class="user__info" id="user__name"></p>
        <p class="user__info" id="user__id"></p>
        <div class="ban__ctas">
            <button id="yes">Oui</button>
            <button id="no">Non</button>
        </div>
    </div>
</div>
<script>
    let userBans = document.querySelectorAll(".user__unban")
    let cancelBan = document.querySelector("#no")
    let submitBan = document.querySelector("#yes")
    let userName;
    let userId;
    for (let userBan of userBans) {
        userBan.addEventListener("click", e => {
            e.preventDefault();
            document.querySelector(".ban__container").classList.toggle('flex')
            userName = e.target.getAttribute('data-user-name')
            userId = e.target.getAttribute('data-user-id')
            document.querySelector("#user__id").innerHTML = "<u>ID</u>:<br> " + userId
            document.querySelector("#user__name").innerHTML = "<u>Nom de l'utilisateur</u><br> " + userName
        })
    }
    cancelBan.addEventListener("click", c => {
        document.querySelector(".ban__container").classList.toggle('flex')
    })


    submitBan.addEventListener("click", ev => {
            let xhttp = new XMLHttpRequest()
            let sParams = 'userId=' + encodeURIComponent(userId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        console.log('Notifications updated')
                        location.reload();
                    } else {
                        console.error("Error updating notifications.");
                    }
                }
            };
            xhttp.open("POST", `/unbanuser/`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(sParams)
    })
</script>

@endsection
@section('scripts')

@include('admin.users.partials.scripts')

@endsection