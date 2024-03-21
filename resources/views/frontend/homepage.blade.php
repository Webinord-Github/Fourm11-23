@if(auth()->check() && !auth()->user()->verified)
<div class="warning__container">
    <p>Votre compte est actuellement en attente d'approbation.</p>
    <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
    <p>Merci de votre patience.</p>
</div>
@endif
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
                    @auth
                    @if(count($homepageForums) < 1 || !auth()->user()->verified)
                        <p style="color:white">Aucune conversation à afficher pour l'instant!</p>
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
                                        <img src="{{asset($conversation->user->profilePicture->path . $conversation->user->profilePicture->name)}}" alt="">
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
                                        <a class="conv__href" href="/forum#c{{$conversation->id}}">Voir la conversation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @endauth
                        @if(!auth()->check())
                        <p style="color:white">Aucune conversation à afficher pour l'instant!</p>
                        @endif
                        <div class="forum__href__container">
                            @auth
                            <a class="href__forum" href="/forum">ACCÉDER AU FORUM <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            @else
                            <a class="href__forum" href="/mon-compte">ACCÉDER AU FORUM <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            @endauth
                        </div>
                </div>
            </div>
            <div class="second__content">
                <div class="users__container">
                    <h3>- DERNIERS MEMBRES -</h3>
                    @auth
                    @if(auth()->user()->verified)
                    <div class="users__list">
                        @foreach($users as $user)
                        @if(!$user->isAdmin())
                        <div class="single__user">
                            <div class="img__container">
                                <img src="{{$user->profilePicture->path . $user->profilePicture->name}}" alt="">
                            </div>
                            <div class="user__info__container">
                                <div class="user__created__at">
                                    <p class="created__at">{{ $user->created_at->format('d/m/y') }}</p>
                                </div>
                                <div class="user__title">
                                    <p class="name">{{$user->firstname}} {{$user->lastname}}</p>
                                    <p class="job">{{$user->title}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="no__member__container">
                        <p>Aucun membre à afficher!</p>
                    </div>
                    @endif
                    @else
                    <div class="no__member__container">
                        <p>Aucun membre à afficher!</p>
                    </div>
                    @endauth
                    <div class="member__href__container">
                        @auth
                        <a class="member__href" href="/les-membres">VOIR LES MEMBRES<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <a class="member__href" href="mon-compte">VOIR LES MEMBRES<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="second__static__content">
            <div class="about__container">
                <div class="text__container">
                    <h2>À PROPOS</h2>
                    <p>L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de
                        lutte à l'intimidation. Tou·tes professionnel·les et bénévoles œuvrant au Québec pouvant être
                        confronté·es à des enjeux liés à l'intimidation et souhaitant s'informer, échanger ou découvrir des
                        outils sont invité·es à joindre la communauté de pratique. C'est par le dialogue que tou·tes
                        pourront enrichir leurs connaissances et déterminer les meilleures pratiques à adopter pour lutter
                        contre l'intimidation dans leur milieu respectif.</p>
                    <p>Ce projet de communauté de pratique a été rendu possible grâce au soutien financier du
                        ministère de la Famille du Gouvernement du Québec.</p>
                </div>
                <div class="img__container">

                </div>
            </div>
            <div class="register__info__container">
                <div class="img__container">
                    <img src="{{ asset('storage/medias/inscription-homepage-600x400.jpg') }}" alt="">
                </div>
                <div class="text__container">
                    <h2>POURQUOI S'INSCRIRE</h2>
                    <p>La Foumilière s'adresse aux professionnel·les et bénévoles du Québec œuvrant au sein de
                        milieux pouvant être confrontés à des enjeux liés à l'intimidation et souhaitant s&#39;informer,
                        échanger ou découvrir des outils pour prévenir les situations à risque et intervenir lors
                        d'incidences d'intimidation. Les membres de la communauté de pratique de La Foumilière
                        s'impliquent dans l'échange de discussions et dans le partage d'outils et de pratiques de
                        prévention et de lutte à l'intimidation dans un esprit collaboratif. Il est souhaité que cet outil de
                        réseautage et d'entraide professionnelle permette aux utilisateur·ices de contribuer à la
                        plateforme tout en en bénéficiant.</p>
                    <div class="register__actions__container">
                        @if(!auth()->check())
                        <a class="register" href="">DEVENIR MEMBRE <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @endif
                        <a class="login" href="">déjà inscrit? se connecter</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="third__static__content">
            <div class="blogs__container">
                <h2>- Blogs - </h2>
                @auth
                @if(count($posts) < 1) <p style="color:white;text-align:center;">Aucun blog à afficher pour l'instant!</p>
                    @else
                    @foreach($posts as $post)
                    <div class="single__blog" id="{{$post->id}}">
                        <div class="img__container">
                            <img src="{{$post->media->path . $post->media->name}}" alt="">
                        </div>
                        <div class="text__container">
                            @php
                            $truncateBlog = $post->body;
                            $truncatedBlog = Str::limit($truncateBlog, 120, '...');
                            @endphp
                            <h3>{{$post->title}}</h3>
                            <p class="blog__body">{{$truncatedBlog}}</p>
                            <div class="actions__container">
                                <div class="tags__container">
                                    @foreach($post->thematiques as $index => $thematique)
                                    @if($index < 2) <a class="tags" href="">{{$thematique->name}}</a>
                                        @else
                                        @break
                                        @endif
                                        @endforeach
                                </div>
                                <div class="read__container">
                                    <a class="read" href="{{ route('post.show', ['post' => $post]) }}">lire</a>
                                </div>
                            </div>
                            @php
                                $existingPostmark = App\Models\Postmark::where('user_id', auth()->user()->id)->where('post_id', $post->id)->first();
                            @endphp
                            @if($existingPostmark)
                            <div class="post__bookmark__container">
                                <i id="post__bookmark" class="fa fa-bookmark bookmarked"></i>
                            </div>
                            @else 
                            <div class="post__bookmark__container bookmarked">
                                <i id="post__bookmark" class="fa fa-bookmark"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @endauth
                    @if(!auth()->check())
                    <p style="color:white;text-align:center;">Aucun blog à afficher pour l'instant!</p>
                    @endif
                    <div class="blog__href__container">
                        @auth
                        <a class="blog__href" href="/blogue">ACCÉDER AU BLOG<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <a class="blog__href" href="/mon-compte">ACCÉDER AU BLOG<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @endauth
                    </div>
            </div>
            <div class="tools__container">
                <h2>- Nouveaux outils -</h2>
                @auth
                @if(count($tools) < 1) <p style="color:white;text-align:center;">Aucun outil à afficher pour l'instant!</p>
                    @else
                    @foreach($tools as $tool)
                    <div class="single__tool" data-tool-id="{{$tool->id}}">
                        @php
                        $truncateTool = $tool->desc;
                        $truncatedTool = Str::limit($truncateTool, 120, '...');
                        @endphp
                        <h3>{{$tool->title}}</h3>
                        <p>{{$truncatedTool}}</p>
                        <div class="actions__container">
                            <div class="tags__container">
                                @foreach($tool->thematiques as $index => $thematique)
                                @if($index < 3) <a class="tags" href="">{{$thematique->name}}</a>
                                    @else
                                    @break
                                    @endif
                                    @endforeach
                            </div>
                            <div class="read__container">
                                <a class="read" href="/boite-a-outils#t{{$tool->id}}">en savoir plus</a>
                            </div>
                        </div>
                        <div class="tool__bookmark__container">
                            @if($tool->signets->contains('user_id', auth()->user()->id))
                            <i id="tool__bookmark" class="fa fa-bookmark bookmarked"></i>
                            <span class="bookmark__hover saved">Retirer</span>
                            @else
                            <i id="tool__bookmark" class="fa fa-bookmark"></i>
                            <span class="bookmark__hover ">Sauvegarder</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @endauth
                    @if(!auth()->check())
                    <p style="color:white;text-align:center;">Aucun outil à afficher pour l'instant!</p>
                    @endif
                    <div class="tool__href__container">
                        @auth
                        <a class="tool__href" href="/boite-a-outils">ACCÉDER AUX OUTILS<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @else
                        <a class="tool__href" href="/mon-compte">ACCÉDER AUX OUTILS<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        @endauth
                    </div>
            </div>
        </div>
    </div>
</div>
<style>
    .homepage__container .home__banner__container {
        background-image: url('{{asset("storage/medias/Banniere_LaFourmiliere470_2.png")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 50% 50%;
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
        background-image: url('{{asset("storage/medias/banner-1200x800.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .homepage__container .about__container .img__container {
        background-image: url('{{asset("storage/medias/apropos-homepage-800x400.jpg")}}');
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