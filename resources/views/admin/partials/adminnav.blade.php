<div class="adminNav__container">
    <div class="adminNav">
        <div class="admin__logo">
            <img src="{{ asset('files/logo-webinord-clair.png') }}" alt="">
        </div>
        <div class="sectionDiv">
            <ul>
                <li class="navLink">
                    <a href="/" target="_blank"><i class="fa fa-globe mr-4  mt-0.5"></i>Voir le site</a>
                </li>
                <li class="navLink">
                    <a href="/admin"><i class="fa fa-home mr-4  mt-0.5"></i>Tableau de bord</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('pages.index') }}"><i class="fa fa-file-text mr-4 mt-0.5" aria-hidden="true"></i>Pages</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('pagesguard.index') }}"><i class="fa-solid fa-shield-halved mr-4 mt-0.5" aria-hidden="true"></i>Protection des pages</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('conversations.index') }}"><i class="far fa-comments mr-4 mt-0.5" aria-hidden="true"></i>Forum</a>
                </li>
                @can('SuperAdmin', App\Models\User::class)
                <li class="navLink">
                    <a href="{{ route('users.index') }}"><i class="fa fa-user mr-4 mt-0.5" aria-hidden="true"></i>Utilisateurs</a>
                </li>
                @endcan
                <li class="navLink">
                    <a href="{{ route('usersguard.index') }}"><i class="fa-solid fa-user-shield mr-4 mt-0.5" aria-hidden="true"></i>Vérification des utilisateurs</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('banusers.index') }}"><i class="fa fa-ban mr-4 mt-0.5" aria-hidden="true"></i>Utilisateurs rejetés</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('emails.index') }}"><i class="fa fa-envelope mr-4 mt-0.5" aria-hidden="true"></i>Courriels automatiques</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('posts.index') }}"><i class="fa-solid fa-newspaper mr-4 mt-0.5" aria-hidden="true"></i>Articles</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('blogguard.index') }}"><i class="fa-solid fa-newspaper mr-4 mt-0.5" aria-hidden="true"></i>Vérification des articles</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('events.index') }}"><i class="fa-solid fa-bell mr-4 mt-0.5" aria-hidden="true"></i>Évènements</a>
                </li>
                <li class="navLink admin__menu__dropdown">
                    <a class="dropdown__trigger" href="Javascript:void(0)"><i class='fa fa-lightbulb mr-4 mt-0.5 dropdown__trigger' aria-hidden="true"></i>Fiches <i class="fa fa-angle-down dropdown__trigger mt-1"></i></a>
                    <div class="admin__menu__dropdown__container">
                        <div class="admin__menu__dropdown__content">
                            <div class="submenu__links">
                                <a href="/admin/facts">Saviez-vous</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="navLink">
                    <a href="/admin/tools"><i class="fa-solid fa-wrench mr-4 mt-0.5" aria-hidden="true"></i>Outils</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('toolsguard.index') }}"><i class="fa-solid fa-user-shield mr-4 mt-0.5" aria-hidden="true"></i>Vérification des outils</a>
                </li>
                <li class="navLink">
                    <a href="/admin/thematiques"><i class="fa-solid fa-filter mr-4 mt-0.5" aria-hidden="true"></i>Thématiques</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('medias.index') }}"><i class="fa fa-download mr-4 mt-0.5" aria-hidden="true"></i>Médias</a>
                </li>
                <li class="navLink">
                    <a href="{{ route('signalements.index') }}"><i class='fas fa-key mr-4 mt-0.5' aria-hidden="true"></i>Signalements</a>
                </li>
                <li class="navLink admin__menu__dropdown">
                    <a class="dropdown__trigger" href="Javascript:void(0)"><i class='fa fa-lightbulb mr-4 mt-0.5 dropdown__trigger' aria-hidden="true"></i>Paramètres <i class="fa fa-angle-down dropdown__trigger mt-1"></i></a>
                    <div class="admin__menu__dropdown__container">
                        <div class="admin__menu__dropdown__content">
                            <div class="submenu__links">
                                <a href="{{ route('menu.index') }}">Menus</a>
                            </div>
                            <div class="submenu__links">
                                <a href="{{ route('parametres.index') }}">Paramètres</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="navLink">
                    <a href="{{ route('chatbot.index') }}" id="chatbot__menu"><i class="fa fa-robot mr-4 mt-0.5" aria-hidden="true"></i>Chatbot</a>
                </li>
                <li class="navLink">
                    <div class="logout__container">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="logout" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fa fa-sign-out mr-4 mt-0.5"></i>
                                {{ __('Déconnexion') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    getNewMessageNotifAdmin();
    setInterval(getNewMessageNotifAdmin, 2000);

    function getNewMessageNotifAdmin() {
        let xhttp = new XMLHttpRequest();
        let Params;
        let chatbotMenu = document.querySelector("#chatbot__menu")
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState === 4) {
                if (xhttp.status === 200) {
                    const response = JSON.parse(xhttp.responseText);
                    const messages = response.message;
                    if (messages.length > 0) {
                        chatbotMenu.classList.add("newNotif")

                    } else {
                        chatbotMenu.classList.remove("newNotif")
                    }

                } else {
                    console.error("Error");
                }
            }
        };
        xhttp.open("POST", `{{ route('getNewMessageNotif') }}`, true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(Params);
    }
</script>