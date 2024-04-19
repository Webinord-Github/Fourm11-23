@if(auth()->check() && !auth()->user()->verified)
<div class="warning__container">
    <p>Votre compte est actuellement en attente d'approbation.</p>
    <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
    <p>Merci de votre patience.</p>
</div>
@endif
<div class="events__container">
    <div class="events__content">
        @if (session('status'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('status') }}</p>
        </div>
        @endif
        <div class="h1__container">
            <a href="/" class="arrow">&#8592;</a>
            <h1>Évènements</h1>
        </div>
        <div class="img_wrapper">
            <img src="{{ asset('storage/medias/evenements.jpg') }}" alt="">
        </div>
        <div class="add__event__container">
            @if(auth()->check() && auth()->user()->verified)
            <button class="add__event add__new__event">Soumettre un événement</button>
            @endif
            @if(auth()->check() && !auth()->user()->verified || !auth()->check())
            <p class="add__event__notallowed">Soumettre un événement</p>
            @endif
        </div>
        @php
        $eventsCount = $events->where('published', 1)->count();
        @endphp
        @if(!auth()->check())
        <p>Aucun événement à afficher pour l'instant!</p>
        @endif
        @auth
        @if($eventsCount < 1 || $events->count() < 1 || !auth()->user()->verified)
                <p>Aucun événement à afficher pour l'instant!</p>
                @else
                @foreach($events as $event)
                @if($event->published == true)
                <div class="single__event" data-event-id="{{$event->id}}" id="e{{$event->id}}">
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
                        <div class="event__bookmark__container">
                            @php
                            $existingBookmark = App\Models\eventBookmark::where('event_id', $event->id)->where('user_id', auth()->user()->id)->first();
                            @endphp
                            @if($existingBookmark)

                            <i class="fa fa-bookmark event__bookmark bookmarked"></i>
                            @else
                            <i class="fa fa-bookmark event__bookmark"></i>
                            @endif

                        </div>
                    </div>
                    <div class="event__divider">
                        <div class="divider"></div>
                    </div>
                </div>
                @endif
                @endforeach
                @endif
                @endauth


    </div>
    <div class="new__event__container">
        <div class="new__event__content">
            <div class="new__event">
                <div class="h3__container">
                    <h3 class="add__new__event">Soumettre un nouvel événement</h3>
                </div>
                <form class="w-full flex justify-center" action="{{ route('new.user.event') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="px-12 pb-8 flex flex-col items-center w-10/12 inputs__container">
                        @if (!$errors->isEmpty())
                        <div role="alert" class="w-full pb-8">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                Empty Fields
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                @foreach ($errors->all() as $message)
                                <ul class="px-4">
                                    <li class="list-disc">{{$message}}</li>
                                </ul>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="title" :value="__('Titre')"></x-label>
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="desc" :value="__('Description')"></x-label>
                                <textarea style="resize: none; border-radius: 5px;height:100px" name="desc">{{ old('desc') }}</textarea>
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="address" :value="__('Adresse')"></x-label>
                                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="link" :value="__('Lien')"></x-label>
                                <x-input id="link" class="block mt-1 w-full" type="url" name="link" :value="old('link')" required autofocus />
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="image" :value="__('Image: jpeg, png, jpg, webp')" />
                                <input type="file" id="image" name="image">
                            </div>
                        </div>
                        <div class="w-full mb-2">
                            <div class="flex justify-center flex-col">
                                <x-label for="start_at" :value="__('Date du début')"></x-label>
                                <x-input id="start_at" class="block mt-1 w-full form-control" type="datetime-local" name="start_at" :value="old('start_at')" required autofocus />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Créer') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="close__container">
                <i class="fa fa-close"></i>
            </div>
        </div>
    </div>
</div>
</div>
<style>
    .add__event__container {
        background-image: url('{{asset("storage/medias/banner-1200x400.jpg")}}');
    }
</style>

<script>
    let evBookmarks = document.querySelectorAll(".event__bookmark")
    for (let evBookmark of evBookmarks) {
        evBookmark.addEventListener("click", evfol => {
            let xhttp = new XMLHttpRequest();
            let eventId = evfol.target.closest('.single__event').getAttribute('data-event-id')
            let Params = 'eventid=' + encodeURIComponent(eventId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        evfol.target.classList.toggle('bookmarked')
                        evfol.taret.closest('')
                        xhttp = null;
                    } else {
                        console.error("Error");
                    }
                }
            };
            // Deleting the parent comment and its associated replies
            xhttp.open("POST", `{{ route('event.bookmark') }}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }
</script>