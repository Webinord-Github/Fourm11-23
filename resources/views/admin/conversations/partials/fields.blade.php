{!! csrf_field() !!}



<div class="px-12 pb-8 flex flex-col items-center w-10/12">
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
            <label for="title">Titre</label>
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="title" id="title" value="{{$model->title}}">
        </div>
    </div>
    <div class="w-full mb-2 justify-center">
        <div class="flex justify-center flex-col">
            <label for="body">Contenu</label>
            <textarea class="editor w-full border rounded py-2 text-gray-700 focus:outline-none" name="body" id="editor" cols="30" rows="10" value="{{$model->body}}">{{$model->body}}</textarea>
        </div>
    </div>
    <div class="w-full mb-2">
        <x-label :value="__('Thématiques')"></x-label>
        @foreach ($thematiques as $thematique)
        <div class="flex items-center">
            <input style="cursor:pointer;" class="thematiques__checkbox" type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
            <label class="ml-1" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
        </div>
        @endforeach
    </div>
    <div class="w-full flex justify-start">
        <input type="submit" class="w-60 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Publier">
    </div>
</div>
<script>
    document.addEventListener("click", e => {
        if (e.target.classList.contains("thematiques__checkbox")) {
            let checkedThematiques = document.querySelectorAll(".thematiques__checkbox:checked");

            if (checkedThematiques.length > 2) {
                let allThematiques = document.querySelectorAll(".thematiques__checkbox")
                for (let checkbox of allThematiques) {
                    if (!checkbox.checked) {
                        checkbox.disabled = true
                        checkbox.style.cursor = "not-allowed"
                        checkbox.style.opacity = "0.3"
                    }
                }
            } if (checkedThematiques.length < 3) {
                let allThematiques = document.querySelectorAll(".thematiques__checkbox")
                console.log('true')
                for (let checkbox of allThematiques) {
                    if (!checkbox.checked) {
                        checkbox.disabled = false
                        checkbox.style.cursor = "pointer"
                        checkbox.style.opacity = 1
                    }
                }
            }
        }
    })
</script>