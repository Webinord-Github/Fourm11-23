@extends('layouts.admin')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

@if (session('status'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
            @endif
<div class="sortable__menu__container">
    <h1>Gestion des menus</h1>
    <div id="sortable-menu">
        <ul class="sortable-list">
            @foreach($pages as $page)
                @if ($page->parent_id === null)
                    {{-- Render top-level items --}}
                    <li class="sortable-item" data-page-id="{{ $page->id }}" data-page-title="{{ $page->title }}" data-page-url="{{ $page->url }}">
                        <i class="fa fa-arrows"></i>{{ $page->title }}
                        <ul class="sortable-list">
                            {{-- Render nested items --}}
                            @foreach($pages as $nestedPage)
                                @if ($nestedPage->parent_id === $page->id)
                                    <li class="sortable-item" data-page-id="{{ $nestedPage->id }}" data-parent-id="{{ $page->id }}" data-page-title="{{ $nestedPage->title }}" data-page-url="{{ $nestedPage->url }}">
                                        <i class="fa fa-arrows"></i>{{ $nestedPage->title }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="save__container">
        <button id="update">Save</button>
        <p class="saved__success">Menu sauvegardé!</p>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var nestedSortables = document.querySelectorAll('.sortable-list');
    var parentItemId; // Declare a variable to store the parentItemId

    // Initialize SortableJS for each element
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,

            onEnd: function(evt) {
                // Update parent_id when an item is dropped into a nested sortable
                var parentList = evt.to.closest('.sortable-list');
                var parentItem = parentList.closest('.sortable-item');
                parentItemId = parentItem ? parentItem.dataset.pageId : null; // Update the parentItemId
                // If it's a nested sortable, update the parent ID for the dropped item
                if (parentItem) {
                    var parentID = parentItem.dataset.pageId;
                    evt.item.dataset.parentId = parentID || null;
                } else {
                    // If the item is removed from its parent, update the parentId to null
                    evt.item.dataset.parentId = null;
                }
            }
        });
    }

    let save = document.querySelector("#update");
    save.addEventListener("click", ev => {
        let xhttp = new XMLHttpRequest();
        let order = [];

        // Extract page IDs and parent IDs in the new order
        document.querySelectorAll('.sortable-item').forEach((item) => {
            order.push({
                pageId: item.dataset.pageId,
                parentId: item.dataset.parentId !== 'null' ? parseInt(item.dataset.parentId) : null,
            });
        });
;

        let sParams = 'order=' + encodeURIComponent(JSON.stringify(order))

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    document.querySelector(".saved__success").style.display = "block"
                    setTimeout(() => {
                        document.querySelector(".saved__success").style.display = "none"

                    }, 2000);
                } else {
         
                }
            }
        };

        xhttp.open("POST", "/update-menu-order", true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(sParams);
    });
});


</script>

@endsection