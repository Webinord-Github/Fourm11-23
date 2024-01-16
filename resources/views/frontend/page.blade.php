@extends('layouts.mainheader')

@section('content')

<div class="container">
    @if($page->content)
    <p>{!! $page->content !!}</p>
    @endif

</div>



<!-- PAGE ACCUEIL -->
@if($page->id == 1)
<div class="homepage__container">
    <div class="home__banner__container">
    </div>
    <div class="homepage__content">
        <div class="first__static__content">
            <div class="first__content">
                <div class="infos__content">
                    <h1>La Fourmilière</h1>
                    <div class="text__content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat esse inventore aperiam perspiciatis, sint ipsa aliquam autem! Explicabo nisi itaque deserunt optio repellat laudantium labore culpa aliquid ut, perspiciatis consectetur.orem ipsum dolor sit amet consectetur adipisicing elit. Quaerat esse inventore aperiam perspiciatis, sint ipsa aliquam autem! Explicabo nisi itaque deserunt optio repellat laudantium labore culpa aliquid ut, perspiciatis consecteturorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat esse inventore aperiam perspiciatis, sint ipsa aliquam autem! Explicabo nisi itaque deserunt optio repellat laudantium labore culpa aliquid ut, perspiciatis consecteturorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat esse inventore aperiam perspiciatis, sint ipsa aliquam autem! Explicabo nisi itaque deserunt optio repellat laudantium labore culpa aliquid ut, perspiciatis consectetur</p>
                    </div>
                </div>
                <div class="conversations__container">
                    <h2>- Les conversation en cours -</h2>
                    @if(count($homepageForums) < 1) <p style="color:white">Aucune conversation à afficher pour l'instant!</p>
                        @else
                        @foreach($homepageForums as $conversation)
                        <div class="single__conversation__container">
                            <div class="conv__title__container">
                                @php
                                $title = $conversation->title;
                                $body = $conversation->body;
                                $truncatedTitle = Str::limit($title, 200, '...');
                                $truncatedBody = Str::limit($body, 500, '...');
                                @endphp
                                <p>{{$truncatedTitle}}</p>
                            </div>
                            <div class="infos__container">
                                <div class="stamp__container">
                                    <div class="conv__author">
                                        <img src="{{asset($conversation->user->image)}}" alt="">
                                        <p class="author">{{$conversation->user->firstname}}</p>
                                    </div>
                                    <div class="timestamp">
                                        <p>{{$conversation->created_at}}</p>
                                    </div>
                                </div>
                                <div class="body__container">
                                    <p>{{$truncatedBody}}</p>
                                </div>
                                <div class="action__container">
                                    <div class="tags__container">
                                        <a class="tags" href="">Adolescant.es</a>
                                    </div>
                                    <div class="conv__href__container">
                                        <a class="conv__href" href="">Voir la conversation</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                        @endif
                        <div class="forum__href__container">
                            <a class="href__forum" href="">ACCÉDER AU FORUM <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                </div>
            </div>
            <div class="second__content">
                <div class="users__container">
                    <h3>- DERNIERS MEMBRES -</h3>
                    <div class="users__list">
                        @foreach($users as $user)
                        <div class="single__user">
                            <div class="img__container">
                                <img src="{{$user->image}}" alt="">
                            </div>
                            <div class="user__info__container">
                                <div class="user__created__at">
                                    <p class="created__at">{{ $user->created_at->format('d/m/y') }}</p>
                                </div>
                                <div class="user__title">
                                    <p class="name">{{$user->firstname}} {{$user->lastname}}</p>
                                    <p class="job">{{$user->title}}Test</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="member__href__container">
                        <a class="member__href" href="">VOIR LES MEMBRES<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="second__static__content">
            <div class="about__container">
                <div class="text__container">
                    <h2>À PROPOS</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae porro consequuntur cum repellat perferendis enim ipsam totam libero dicta, sit architecto soluta sint laboriosam ut quasi praesentium ea magnam alias.</p>
                </div>
                <div class="img__container">
                    <img src="https://placehold.co/800x400" alt="">
                </div>
            </div>
            <div class="register__info__container">
                <div class="img__container">
                    <img src="https://placehold.co/600x400" alt="">
                </div>
                <div class="text__container">
                    <h2>POURQUOI S'INSCRIRE</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quas reprehenderit atque ipsum praesentium nulla perspiciatis laboriosam, at rerum recusandae fuga, deserunt modi ut suscipit non ullam, maxime commodi accusamus iste?</p>
                    <div class="register__actions__container">
                        <a class="register" href="">DEVENIR MEMBRE <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        <a class="login" href="">déjà inscrit? se connecter</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="third__static__content">
            <div class="blogs__container">
                <h2>- Blogs - </h2>
                @if(count($posts) < 1) <p style="color:white;">Aucun blog à afficher pour l'instant!</p>
                    @endif
                    <div class="single__blog">
                        <div class="img__container">
                            <img src="https://placehold.co/150x150" alt="">
                        </div>
                        <div class="text__container">
                            @php
                            $truncateBlog = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea quam expedita autem ab molestias nulla suscipit, consequatur velit in perferendis et corporis error id sit eius placeat dolorum nam possimus!";
                            $truncatedBlog = Str::limit($truncateBlog, 120, '...');
                            @endphp
                            <h3>Titre post blogue</h3>
                            <p class="blog__body">{{$truncatedBlog}}</p>
                            <div class="actions__container">
                                <div class="tags__container">
                                    <a class="tags" href="">Adolescent.es</a>
                                </div>
                                <div class="read__container">
                                    <a class="read" href="">lire</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__href__container">
                        <a class="blog__href" href="">ACCÉDER AU BLOG<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    </div>
            </div>
            <div class="tools__container">
                <h2>- Nouveaux outils -</h2>
                @if(count($tools) < 1) <p style="color:white">Aucun outil à afficher pour l'instant!</p>
                    @endif
                    <div class="single__tool">
                        @php
                        $truncateTool = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea quam expedita autem ab molestias nulla suscipit, consequatur velit in perferendis et corporis error id sit eius placeat dolorum nam possimus!";
                        $truncatedTool = Str::limit($truncateTool, 120, '...');
                        @endphp
                        <h3>Titre de l'outil</h3>
                        <p>{{$truncatedTool}}</p>
                        <div class="actions__container">
                            <div class="tags__container">
                                <a class="tags" href="">Adolescent.es</a>
                            </div>
                            <div class="read__container">
                                <a class="read" href="">en savoir plus</a>
                            </div>
                        </div>
                    </div>
                    <div class="tool__href__container">
                        <a class="tool__href" href="">ACCÉDER AUX OUTILS<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    </div>
            </div>
        </div>
    </div>
</div>
<style>
    .homepage__container .home__banner__container {
        background-image: url('https://placehold.co/1920x1080');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .first__content .infos__content {
        background-image: url('{{asset("storage/medias/banner-1200x400v2.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .conversations__container {
        background-image: url('{{asset("storage/medias/banner-1200x800.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .users__container {
        background-image: url('{{asset("storage/medias/banner-400x1200.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .blogs__container {
        background-image: url('{{asset("storage/medias/banner-1200x800.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .tools__container {
        background-image: url('{{asset("storage/medias/banner-1200x800.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
@endif

<!-- PAGE FOURMILIÈRE -->
@if($page->id == 3)
<div class="fourm__container">
    <div class="fourm__content">
        <div class="h1__container">
            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            <h1>LA FOURMILIÈRE</h1>
        </div>
        <div class="first__content">
            <div class="text__content">
                <h2>Raison d'être</h2>
                <div class="text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A, praesentium rerum minima molestiae deleniti, beatae debitis at eveniet, iusto recusandae cumque adipisci quasi illo. Repellat sequi ea sunt possimus ducimus?</p>
                </div>
            </div>
            <div class="text__content">
                <p class="subtitle">La plateforme met à votre disposition: </p>
                <div class="list__container">
                    <li>Un forum pour échanger sur les meilleures pratiques, obtenir du soutien, bonifier vos réflexions, partager vos bons coups et relever vos défis et créer des contacts avec d’autres intervenant·es et bénévoles à travers la province;</li>
                    <li>Une banque d’outils évolutive alimentée par les membres de la communauté;</li>
                    <li>Un soutien par clavardage offert par des intervenant·es de L’Anonyme;</li>
                </div>
            </div>
        </div>
        <div class="text__img__container">
            <div class="img__container">
                <img src="https://placehold.co/645x430" alt="">
            </div>
            <div class="text__content">
                <h2>Netiquette</h2>
                <div class="text">
                    <p>Cet espace vise l’échange de pratiques en lien avec l’intimidation. Il se veut un lieu de discussion où vous pourrez chercher du soutien auprès d’intervenant·es, professionnel·les et bénévoles de divers régions et milieux.
                        <br><br>
                        Les règles du forum visent d’assurer un climat de respect où tou·tes se sentent en sécurité et de permettre des échanges efficaces. Rappelez-vous qu’il s’agit d’un lieu d’échanges sur l’intimidation, il serait dommage d’y retrouver des propos violents et intimidants.
                        <br><br>
                        Les propos inappropriés ou violents seront retirés dans les plus brefs délais et leur auteur·rice recevra un avis. La personne qui publie à nouveau des propos qui ne respectent pas la netiquette se verra exclue de la communauté de pratiques.
                    </p>
                </div>
            </div>
        </div>
        <div class="dropdown__container">
            <div class="dropdown__content">
                <h2>Climat du forum</h2>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Indulgence</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Les utilisateur·ices de la plateforme proviennent de différents milieux et cumulent une expertise diversifiée quant à l’intimidation. Bien qu’il s’agisse d’une grande richesse, il se peut que les points de vue et les connaissances sur un sujet spécifique divergent entre les individu·es. Il importe de cultiver une ouverture d’esprit et une curiosité envers les propos partagés sur la plateforme, comme tou·te individu·e détient le droit de s’exprimer selon ses connaissances et d’être respecté·e. Les désaccords amènent à se questionner et à améliorer les pratiques.
                            <br><br>
                            Si des propos semblent enfreindre le code de vie de La Fourmilière, merci d’en faire part à l’équipe de gestion de la plateforme pour qu’une modération soit effectuée.
                        </p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Courtoisie</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Il est demandé à tou·tes utilisateur·ices d’user de civisme, de politesse, de bienveillance et de bon goût dans leur utilisation de la plateforme et dans leurs échanges. Il est strictement interdit d’adopter intentionnellement tout comportement ou attitude ayant pour but de se moquer, de rabaisser ou de ridiculiser une personne contributrice ou ses propos. De tels propos feront l’objet d’une prise d’action par l’équipe de gestion de la plateforme allant jusqu’à l’expulsion définitive de La Fourmilière.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Convivialité</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Une attention particulière est à porter au langage utilisé et au ton des messages. Afin d’éviter tout malentendu et pour que les échanges demeurent agréables et conviviaux, il est recommandé d’utiliser un ton neutre (faire attention au sarcasme) et d’écrire dans un vocabulaire clair et précis en évitant les doubles-sens et l’utilisation d’expressions ou d’acronymes sans explication.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Signalement</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Si des propos semblent enfreindre le code de vie de La Fourmilière, créent un inconfort, un malaise ou provoquent de vives réactions émotionnelles chez les utilisateur·ices, merci de signaler les messages ou la discussion à l’équipe de gestion de la plateforme pour qu’une modération soit effectuée. L’équipe de La Fourmilière s’engage à faire une veille régulière de la plateforme pour assurer la convivialité de cette dernière et prendre action dans les plus brefs délais, au besoin.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Contenu des publications</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Les interventions sur un même sujet gagnent à être regroupées. Avant de créer une nouvelle publication, il est encouragé de faire une recherche sur la plateforme afin de vérifier si le sujet d'intérêt a déjà été abordé et si des réponses pourraient répondre aux questionnements actuels. Il est également encouragé de commenter les échanges déjà publiés afin que ces derniers deviennent la ressource du sujet dont il est question. De ce fait, il est recommandé de donner un titre clair et précis aux nouvelles publications afin de faciliter les recherches ultérieures sur le thème spécifique. Bien que l’intimidation soit un sujet vaste qui puisse toucher plusieurs enjeux connexes (affirmation de soi, résolution de conflits, violence, etc.), il importe que les publications, les échanges et les questions soient directement liées au thème général de l’intimidation pour éviter toute confusion ou superflu dans les informations mises en lumière.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .dropdown {
        background-image: url('{{asset("storage/medias/banner-1200x400v2.jpg")}}');
    }
</style>
<script>
    window.addEventListener("click", e => {
        if (e.target.classList.contains("drop__trigger")) {
            console.log(e.target.parentElement.childNodes)
            let dropContent = e.target.parentElement.nextElementSibling
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            dropContent.classList.toggle('open')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.parentElement.childNodes[3].classList.toggle('rotate')
        }
        if (e.target.classList.contains("drop__trigger__parent")) {
            let dropContent = e.target.nextElementSibling
            dropContent.classList.toggle('open')
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.childNodes[3].classList.toggle('rotate')
        }

    })
</script>
@endif

<!-- PAGE FORUM  -->
@if($page->id == 5)
@include('frontend.forum')
@include('frontend.partials.scripts')
@endif

<!-- PAGE ÉVÉNEMENTS  -->
@if($page->id == 7)

<div class="events__container">
    <div class="events__content">
        <div class="h1__container">
            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            <h1>Évènements</h1>
        </div>
        @if(count($events) < 1) <p>Aucun événement à afficher pour l'instant</p>
            @else
            <div class="add__event__container">
                <button class="add__event">Soumettre un événement</button>
            </div>
            @foreach($events as $event)
            <div class="single__event">
                <div class="infos__container">
                    <div class="date__location">
                        @php
                        $carbonDate = Carbon\Carbon::parse($event->start_at)->locale('fr');
                        $formattedDate = $carbonDate->isoFormat('DD MMMM YYYY');
                        @endphp
                        <p class="date">{{ $formattedDate }}</p>
                        <p class="location"><i class="fa fa-map-marker"></i><a href="https://www.google.ca/maps/place/{{$event->address}}" target="_blank">{{$event->address}}</a></p>
                    </div>
                    <div class="title__container">
                        <h3>{{$event->title}}</h3>
                    </div>
                    <div class="text">
                        @php
                        $desc = $event->desc;
                        $truncatedDesc = Str::limit($desc, 200, '...');
                        @endphp
                        <p>{{$truncatedDesc}}</p>
                    </div>
                    <div class="event__register__container">
                        <a class="event__register" href="{{$event->link}}" target="_blank">Inscription</a>
                    </div>
                </div>
                <div class="img__container">
                    <img src="{{$event->image->path . $event->image->name}}" alt="">
                </div>
            </div>
            @endforeach
            @endif
    </div>
    <div class="new__event__container">
        <div class="new__event"></div>
    </div>
</div>
<style>
    .add__event__container {
        background-image: url('{{asset("storage/medias/banner-1200x400.jpg")}}');
    }
</style>
@endif

@endsection