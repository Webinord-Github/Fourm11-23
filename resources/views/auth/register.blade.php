@extends('layouts.mainheader')
@section('content')
<div class="login__container register__container">
    <form class="register__form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <!-- Email Address -->
        <div class="details__container">
            <i class="fa fa-user-circle-o"></i>
            <p>INSCRIPTION</p>
        </div>
        <div class="divider__container">
            <div class="divider"></div>
        </div>
        <div class="existing__user">
            <p>Déjà membre? <a href="/mon-compte">Connectez-vous</a></p>
        </div>
        <div class="general__informations">
            <div class="title">
                <p>Informations générales</p>
            </div>
            <div class="column__container">
                <div class="column">
                    <label class="required" for="firstname">Prénom</label>
                    <input class="form__input" id="firstname" type="text" name="firstname" required>
                    <x-input-error :messages="$errors->get('firstname')" style="font-size:11px;margin-bottom:5px;" />

                    <label class="required" for="lastname">Nom de famille</label>
                    <input class="form__input" id="lastname" type="text" name="lastname" required>
                </div>
                <div class="column">
                    <div class="img__container">
                        <img id="user__avatar" src="{{ asset('storage/avatars/fourmis-bleu.jpg') }}" alt="">
                        <button id="avatar__selection">Choisir un avatar</button>
                        <div class="drop__zone">
                            <label for="avatar" id="file__selection">ou <span>téléverser une image</span></label>
                            <input type='file' name="file" id="avatar" hidden>
                            <input type="hidden" name="avatar_url" id="avatar__url" value="fourmis-bleu.jpg">
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="work__informations">
            <div class="title">
                <p>Informations sur le travail</p>
            </div>
            <div class="column__container">
                <div class="column">
                    <label class="required" for="title">Titre</label>
                    <input class="form__input" type="text" name="title" id="title" required>
                </div>
                <div class="column">
                    <label class="required" for="environment">Organisme/Milieu</label>
                    <input class="form__input" type="text" name="environment" id="environment" required>
                </div>
            </div>
            <div class="column__container">
                <div class="column">
                    <label class="required" for="work_city">Ville de travail</label>
                    <input class="form__input" type="text" name="work_city" id="work_city" required>
                </div>
            </div>
            <div class="column flex__column mt-4">
                <div class="title">
                    <p>
                        Vous travaillez principalement auprès de :
                    </p>
                </div>
                <div class="column__container">
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience1" value="Petite enfance">
                        <label for="enfants">Petite enfance</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience2" value="Enfance">
                        <label for="enfants">Enfance</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience3" value="Adolescence">
                        <label for="enfants">Adolescence</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience4" value="Jeunes adultes">
                        <label for="adultes">Jeunes adultes</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience5" value="Adultes">
                        <label for="adultes">Adultes</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="audience[]" id="audience6" value="Aîné·es">
                        <label for="personnes_aines">Aîné·es</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="autres" type="text" name="other_audience" placeholder="Autres">
                    </div>
                </div>
            </div>
            <div class="column flex__column mt-4">
                <div class="title">
                    <p>
                        Que venez-vous chercher sur la plateforme?
                    </p>
                </div>
                <div class="column__container mt-2">
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="interests[]" id="interests1" value="Partager votre expérience">
                        <label for="audience">Partager votre expérience</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="interests[]" id="interests2" value="Lire sur le sujet">
                        <label for="interests">Lire sur le sujet</label>
                    </div>
                </div>
                <div class="column__container mt-2">
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="interests[]" id="interest3" value="Chercher des réponses à vos questions">
                        <label for="interests">Chercher des réponses à vos questions</label>
                    </div>
                </div>
                <div class="column__container">
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="interests[]" id="interests4" value="Chercher des outils pour vous aider">
                        <label for="interest">Chercher des outils pour vous aider</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="autres" type="text" name="other_interests" placeholder="Autres">
                    </div>
                </div>
            </div>
            <div class="column flex__column mt-4">
                <div class="title">
                    <p>
                        Comment avez-vous entendu parler de cette communauté de pratique?
                    </p>
                </div>
                <div class="column__container">
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="hear_about[]" id="hear_about1" value="Petite enfance">
                        <label for="enfants">Réseaux sociaux</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="hear_about[]" id="hear_about2" value="Médias traditionnels">
                        <label for="enfants">Médias traditionnels</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="hear_about[]" id="hear_about1" value="Moteur de recherche">
                        <label for="enfants">Moteur de recherche</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="hear_about[]" id="hear_about1" value="Réseaux professionnels">
                        <label for="enfants">Réseaux professionnels</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input type="checkbox" name="hear_about[]" id="hear_about1" value="Réseaux personnels">
                        <label for="enfants">Réseaux personnels</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="autres" type="text" name="other_interests" placeholder="Autres">
                    </div>
                </div>
            </div>

            <div class="column flex__column mt-4">
                <div class="title">
                    <p>
                        Information de connexion
                    </p>
                </div>
                <div class="column__container">
                    <div class="column w__full">
                        <div class="column w__full">
                            <x-text-input id="email" class="form__input" type="email" name="email" :value="old('email')" placeholder="Courriel" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>


                        <!-- PASSWORD  -->
                        <div class="column w__full password__input">
                            <x-text-input id="password" class="form__input" type="password" name="password" placeholder="Mot de passe" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <i class="fa fa-eye" id="toggle__password"></i>
                        </div>
                        <!-- PASSWORD CONFIRMATION -->
                        <div class="column w__full password__input">
                            <x-text-input id="password_confirmation" class="form__input" type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            <i class="fa fa-eye" id="toggle__confirmation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column flex__column mt-4">
                <div class="title">
                    <p>
                        Vous travaillez principalement auprès de :
                    </p>
                </div>
                <div class="column__container">
                    <div class="column w__full">
                        <div class="flex__column w__full">
                            <input type="checkbox" name="newsletter" id="newsletter">
                            <label for="newsletter">Je veux m'abonner à l'infolettre de L'Anonyme</label>
                        </div>
                        <div class="flex__column w__full">
                            <input type="checkbox" name="notifications" id="notifications">
                            <label for="notifications">Je veux recevoir mes notifications par courriel</label>
                        </div>
                        <div class="flex__column w__full">
                            <input type="checkbox" name="conditions" id="conditions" required>
                            <label class="required" for="conditions">J'accepte les conditions*</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login__cta__container">
                <button class="login__cta">
                    S'INSCRIRE
                </button>
            </div>
        </div>
        <div class="avatar__popup__container">
            <div class="avatar__popup">
                <div class="img__container">
                    @foreach($avatars as $avatar)
                    <div class="img__content">
                        <img class="avatar__img" src="{{ asset($avatar->path . $avatar->name) }}" data-src="{{ $avatar->name }}" alt="">
                    </div>
                    @endforeach


                </div>
                <div class="avatar__confirm__container">
                    <span class="avatar__confirm">Choisir</span>
                    <p class="av-error">Veuillez choisir une image</p>
                </div>
                <div class="close__container">
                    <i id="avatar__popup__close" class="fa fa-close"></i>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    custom_file_selection();
    avatar_popup();



    function custom_file_selection() {
        const fileInput = document.querySelector('#avatar');
        const customButton = document.querySelector('#file__selection')
        let avatarInput = document.querySelector("#avatar__url")
        let userAvatar = document.querySelector("#user__avatar")
        customButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default behavior of the label click
            fileInput.click();
        });
        fileInput.addEventListener('change', function() {
            const selectedFile = this.files[0];

            // Check if a file is selected
            if (selectedFile) {
                const fileSize = selectedFile.size; // Get the file size in bytes
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp']; // Allowed file types

                // Check file type and size
                if (allowedTypes.includes(selectedFile.type) && fileSize <= 8 * 1024 * 1024) {
                    const reader = new FileReader(); // Create a FileReader object

                    reader.onload = function(event) {
                        userAvatar.src = event.target.result; // Set the avatar's src to the selected file
                        avatarInput.value = "";
                    };

                    reader.readAsDataURL(selectedFile); // Read the selected file as a data URL
                } else {
                    // Display an error message for invalid file type or size
                    alert("Sélectionnez un fichier de format JPG, PNG, ou WebP  et plus léger que 8MB.");
                    this.value = null; // Clear the file input
                }
            }
        });

        // Click event on document to close the file input when clicking outside the button
        // document.addEventListener('click', function(event) {
        //     const isClickInsideButton = event.target === customButton || customButton.contains(event.target);
        //     if (!isClickInsideButton) {
        //         fileInput.value = ''; // Clear the file input value if click is not on or inside the custom button
        //     }
        // });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('toggle__password');
        const toggleConfirmation = document.getElementById('toggle__confirmation');

        togglePassword.addEventListener('click', function() {
            togglePasswordField('password');
        });

        toggleConfirmation.addEventListener('click', function() {
            togglePasswordField('password_confirmation');
        });

        function togglePasswordField(fieldId) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    });


    document.querySelector("#description").addEventListener("keyup", e => {
        char_count();
    })

    function char_count() {
        let maxLength = 400;
        let textArea = document.querySelector("#description")
        let charCount = document.querySelector("#char__count")
        charCount.innerHTML = (maxLength - textArea.value.length) + "/400"
    }

    function avatar_popup() {
        let imgs = document.querySelectorAll(".avatar__img")
        let avatarSelection = document.querySelector("#avatar__selection")
        let avatarPopup = document.querySelector(".avatar__popup__container")
        let avatarConfirm = document.querySelector(".avatar__confirm")
        let avatarInput = document.querySelector("#avatar__url")
        let userAvatar = document.querySelector("#user__avatar")
        let avError = document.querySelector(".av-error")
        let close = document.querySelector("#avatar__popup__close")
        let selected = false;
        let dataSrc;
        avatarSelection.addEventListener("click", av => {
            av.preventDefault();
            avatarPopup.classList.add("flex")
        })
        avatarConfirm.addEventListener("click", s => {
            if (selected) {
                avatarInput.value = dataSrc;

                userAvatar.src = `{{asset('/storage/avatars/' . '${dataSrc}')}}`;
                document.querySelector("#avatar__url").value = dataSrc;
                avatarPopup.classList.remove("flex")
            } else {
                avError.style.display = "block"
            }
        })
        close.addEventListener("click", c => {
            avatarPopup.classList.remove("flex")
        })
        for (let i = 0; i < imgs.length; i++) {
            imgs[i].addEventListener("click", e => {
                avError.style.display = "none"
                selected = true
                for (let img of imgs) {
                    img.style.border = "1px solid #fff"
                    img.style.transform = "scale(1)"
                }
                e.target.style.border = "4px solid green"
                e.target.style.transform = "scale(1.3)"
                e.target.style.transition = "transform 0.2s linear"
                dataSrc = e.target.getAttribute('data-src');
            })
        }
    }
</script>
@endsection