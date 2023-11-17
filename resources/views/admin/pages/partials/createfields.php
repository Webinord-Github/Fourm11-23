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
            <label for="title">Title</label>
            <input type='text'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="title" id="title" value="{{$model->title}}">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="url">Url</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="url" id="url" value="{{$model->url}}">
        </div>
    </div>
    <div class="w-full mb-2 justify-center">
        <div class="flex justify-center flex-col">   
            <label for="content">Contenu</label>
            <textarea class="editor w-full border rounded py-2 text-gray-700 focus:outline-none" name="content" id="editor" cols="30" rows="10" value="{{$model->content}}">{{$model->content}}</textarea>
        </div>
    </div> 
 
    <div class="w-full flex justify-start">
        <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Publier">
    </div>
</div>

<style>
.dragContent {
    height: 500px;
    border: 3px solid #000;
}
</style>

