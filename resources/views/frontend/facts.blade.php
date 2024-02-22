<div class="main_container">
    <div class="facts-container">
        <div class="facts-content">
            <div class="top-div">
                <span class="arrow">&#8592;</span>
                <h1>Saviez-vous?<span>Saviez-vous?</span></h1>
            </div>
            <div class="content ">
                <div class="facts">
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