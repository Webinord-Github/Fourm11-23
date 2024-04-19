@if(auth()->check() && !auth()->user()->verified)
<div class="warning__container">
    <p>Votre compte est actuellement en attente d'approbation.</p>
    <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
    <p>Merci de votre patience.</p>
</div>
@endif
<div class="main_container">
    <div class="facts-container">
        <div class="facts-content">
            <div class="top-div">
                {{-- <span class="arrow">&#8592;</span> --}}
                <h1>Saviez-vous?</h1>
            </div>
            <div class="content ">
                <div class="img_wrapper">
                    <img src="{{ asset('storage/medias/saviez_vous.jpg') }}" alt="">
                </div>
                <div class="facts">
                    @if(count($facts) == 0)
                        <div class="empty">
                            <h3>Aucun saviez-vous? disponible pour le moment</h3>
                        </div>
                    @endif
                    @foreach($facts as $fact)
                    <div class="fact">
                        <div class="circle-wrapper">
                            <div class="circle">
                                <p>?</p>
                            </div>
                        </div>
                        <p class="desc">{{ $fact->desc }}</p>
                        <div class="source">
                            <p class="source-name">Source: {{ $fact->source_name }}</p>
                            <a target="_blank" href="{{ $fact->source_url }}" class="source-url">{{ $fact->source_url }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>