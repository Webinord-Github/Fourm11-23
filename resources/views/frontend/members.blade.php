<div class="members__container">
    <div class="h1__container">
        <a href="/" class="arrow">&#8592;</a>
        <h1>Les membres<span>Les membres</span></h1>
    </div>
    <div class="members">
        @foreach($users as $user)
        @if(!$user->isAdmin())
        <div class="member__card" data-user-id="{{$user->id}}">
            <div class="infos__container">
                <div class="img__content">
                    <img src="{{$user->profilePicture->path . $user->profilePicture->name}}" alt="">
                </div>
                <div class="info__content">
                    <p id="user__name"><strong>{{$user->firstname . " " . $user->lastname}}</strong></p>
                    <p id="title"><strong>Titre</strong>: {{$user->title}}</p>
                    <p id="job"><strong>Emploi:</strong> {{$user->environment}}</p>
                    @php
                    $createdAt = new DateTime($user->created_at);
                    $currentDate = new DateTime();

                    $interval = $currentDate->diff($createdAt);
                    $daysSinceRegistration = $interval->format('%a');
                    @endphp
                    <p id="created_at"><strong>Membre depuis: </strong>{{$daysSinceRegistration}} jours</p>
                </div>
            </div>
            @auth
            @php
            $existingFollow = App\Models\UserFollow::where('following_id', $user->id)->where('follower_id', auth()->user()->id)->first();
            if($existingFollow) {
            @endphp
            <button id="user__follow" class="follow__trigger" data-follow="true">Ne plus suivre <i class="fa fa-minus fa__follow"></i></button>
            @php } else {
            @endphp
            <button id="user__follow" class="follow__trigger" data-follow="false">Suivre <i class="fa fa-plus fa__follow"></i></button>
            @php } @endphp
            @endauth

        </div>
        @endif
        @endforeach
        <div class="ghost__card"></div>
        <div class="ghost__card"></div>

    </div>
</div>
<style>
    .members__container .members .member__card {
        background-image: url('{{asset("storage/medias/chalk-800x300.jpg")}}');
    }
</style>
<script>
    document.addEventListener("click", fol => {
        if (fol.target.classList.contains('follow__trigger')) {
            let xhttp = new XMLHttpRequest();
            let user_id = fol.target.closest('.member__card').getAttribute('data-user-id')
            let Params = 'followingid=' + encodeURIComponent(user_id)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        if (fol.target.getAttribute('data-follow') == "false") {
                            fol.target.setAttribute('data-follow', 'true')
                            fol.target.innerHTML = "Ne plus suivre <i class='fa fa-minus fa__follow'></i>"
                        } else {
                            fol.target.setAttribute('data-follow', 'false')
                            fol.target.innerHTML = "Suivre <i class='fa fa-plus fa__follow'></i>"
                        }

                        xhttp = null;
                    } else {
                        console.error("Error");
                    }
                }
            };
            // Deleting the parent comment and its associated replies
            xhttp.open("POST", `{{ route('user.follow') }}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        }
        if (fol.target.classList.contains('fa__follow')) {
            let xhttp = new XMLHttpRequest();
            let user_id = fol.target.closest('.member__card').getAttribute('data-user-id')
            let Params = 'followingid=' + encodeURIComponent(user_id)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        if (fol.target.closest('.follow__trigger').getAttribute('data-follow') == "false") {
                            fol.target.closest('.follow__trigger').setAttribute('data-follow', 'true')
                            fol.target.closest('.follow__trigger').innerHTML = "Ne plus suivre <i class='fa fa-minus fa__follow'></i>"
                        } else {
                            fol.target.closest('.follow__trigger').setAttribute('data-follow', 'false')
                            fol.target.closest('.follow__trigger').innerHTML = "Suivre <i class='fa fa-plus fa__follow'></i>"
                        }

                        xhttp = null;
                    } else {
                        console.error("Error");
                    }
                }
            };
            // Deleting the parent comment and its associated replies
            xhttp.open("POST", `{{ route('user.follow') }}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        }
    })
</script>