<!-- frontend.filtered-forum.blade.php -->

@if(isset($selectedConversation))
    <div class="selected-conversation">
        <p>Selected Conversation Title: {{ $selectedConversation->title }}</p>
    </div>
@endif

<div class="thematiques__list">
    @foreach($allThematiques as $thematique)
        <li class="thematique">
            <a href="{{ route('conversations.filteredByThematique', $thematique->name) }}" 
               data-thematique-id="{{ $thematique->id }}">
               {{ $thematique->name }}
            </a>
        </li>
    @endforeach
</div>

<!-- Display filtered conversations -->
@foreach($conversations as $conversation)
    <!-- Display conversation details -->
@endforeach

{{ $conversations->links() }}

<p>{{$selectedThematique}}</p>