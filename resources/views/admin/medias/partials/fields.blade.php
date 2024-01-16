


@csrf
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
            <label for="file">Fichier</label>
            <div class="dropzoneContainer flex-col border-2 px-2 border-solid border-black w-6/12 py-4 px-3">
                <div class="dropzone flex items-center relative">
                    <input type='file'class="w-full py-2 text-gray-700 focus:outline-none items-center cursor-pointer" name="file" id="file" value="">
                    <span id="delete_file_value" class="text-white py-1 px-2 cursor-pointer bg-red-500 rounded-md border-black border-2 border-solid">retirer</span>
                </div>
                <p class="text-xs text-gray-500">Un fichier seulement.</p>
                <p class="text-xs text-gray-500">Limite de 8 MB.</p>
            </div>
            <p class="mt-4 font-bold">Lien de prévisualisation</p>
            <a href="/storage/media/{{ $model->url }}" id="preview_file_link" target="_blank" class="text-blue-500 underline">{{ $model->url }}</a>
        </div>  
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="description">Texte alternatif</label>  
            <input type='text' class="w-8/12 border rounded py-2 text-gray-700 focus:outline-none" name="description" id="description" value="{{ $model->description }}">
        </div>
    </div>
    <div class="w-full flex justify-start">
        <div class="flex items-center justify-end mt-4">
            <a href="/admin/medias">Retour</a>
            <input type="submit" class="w-60 ml-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Publier">
        </div>
    </div>
</div>


