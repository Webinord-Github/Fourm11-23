<div class="automatic__emails__content">
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
    @if (session('status'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
            @endif
    @foreach($emails as $email)
    <div class="form__container">
        <div class="acc__container acc__toggle">
            <h2 class="acc__toggle"><i class="fa fa-envelope"></i>{{$email->description}}</h2>
            <i class="fa fa-angle-down"></i>
        </div>
        <div class="form__target">
            <form action="{{ route('emails.update', ['email' => $email->id]) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="w-full mb-2 justify-center">
                    <div class="flex justify-center flex-col">
                        <textarea class="editor w-full border rounded py-2 text-gray-700 focus:outline-none" name="content" id="editor" cols="30" rows="10">{{$email->content}}</textarea>
                    </div>
                </div>

                <div class="w-full flex justify-start">
                    <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Publier">
                </div>
            </form>
        </div>
    </div>
    @endforeach


</div>