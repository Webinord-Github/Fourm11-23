@extends('layouts.dashboard')

@section('content')

<div class="stats__container">
    <div class="active__users__container stats__div">
        <div>
            <p class="dashboard__title">Utilisateurs connectés actifs</p>
            <p id="active__users" class="stats__count">{{ count($activeusers) }}</p>
        </div>
    </div>
    <div class="new__users__container stats__div">
        <p class="dashboard__title">Utilisateurs à vérifier</p>
        @php
        $count = 0;
        @endphp
        @foreach($users as $user)
        @if($user->verified == 0 && $user->ban == 0)
        @php
        $count++;
        @endphp
        @endif
        @endforeach
        @if($count < 1) <p id="no__unverified__users" class="stats__count">0
            <i class="fa-solid fa-thumbs-up"></i>
            </p>

            @else
            <p id="unverified__users" class="stats__count">

                {{ $count }}
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            </p>
            @endif

            <a href="/admin/usersguard"><button class="admin__cta">VOIR</button></a>

    </div>
    <div class="new__users__container stats__div">
        <p class="dashboard__title">Utilisateurs actifs en <i>Real-Time</i></p>
        <p class="stats__count">N/A</p>

    </div>
</div>
<div class="dashboard__users__container">
    <p class="dashboard__title">Utilisateurs</p>
    <div class="dashboard__users__table__container">
        <div class="dasboard__users__table__search">
            <input id="user__search" type="search" placeholder="Rechercher un utilisateur">
            <i class="fa fa-search"></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>En ligne</th>
                    <th>Rôle</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Courriel</th>
                    <th>Dernière activité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td id="user__online">
                        @if($activeusers->contains($user))
                        <span id="online__bull" class="user__bull">&bull;</span>
                        @else
                        <span id="offline__bull" class="user__bull">&bull;</span>
                        @endif
                    </td>
                    @if($user->roles->first())
                    <td id="user__role">
                        {{$user->roles->first()->name}}
                    </td>
                    @else
                    <td style="color:red;font-weight:bold" id="user__role"> Aucun Rôle! </td>
                    @endif
                    <td id="user__image">
                    <img src="{{asset($user->image)}}" alt="">
                    </td>
                    <td id="user__name">
                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="underline">{{ $user->firstname }}</a>
                    </td>
                    <td id="user__email">
                        {{$user->email}}
                    </td>
                    <td id="user__activity">
                        {{ \Carbon\Carbon::parse($user->last_activity)->locale('fr')->diffForHumans() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
let userSearch = document.querySelector("#user__search");
let userFirstnames = document.querySelectorAll("#user__name");

userSearch.addEventListener("input", () => {
    let searchTerm = userSearch.value.trim().toLowerCase();

    userFirstnames.forEach(name => {
        let userName = name.textContent.toLowerCase();
        let parentElement = name.parentElement;

        if (userName.includes(searchTerm)) {
            parentElement.style.display = "table-row";
            let regExp = new RegExp(searchTerm, 'gi');
            name.childNodes[0].nextElementSibling.innerHTML = name.textContent.replace(regExp, "<mark style='background:lightgray;'>$&</mark>");
        } else {
            parentElement.style.display = "none";
        }
    });
});
</script>
@endsection
@section('admin-scripts')
@include('admin.partials.scripts')
@endsection