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
            <label for="name">Name</label>
            <input type='text'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="name" id="name">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="email">Email</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="email" id="email">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="password">Password</label>  
            <input type='password' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="password" id="password" :value="__('Password')">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="password_confirmation">Confirm Password</label>  
            <input type='password' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="password_confirmation" id="password_confirmation" :value="__('Confirm Password')">
        </div>
    </div>

    
    <div class="w-full my-4">
        <label class="font-bold align-start">Roles</label>
    </div>
    @foreach ($roles as $role)
    <div class="w-full mb-2">
        <div class="flex items-center">   
            <label class="w-2/12" for="roles"> {{$role->name}}</label>
            <input class="mx-4" type="radio" name="roles" value="{{$role->id}}">
        </div>
    </div>
        
    @endforeach
    <div class="w-full flex justify-start">
        <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Create">
    </div>
</div>
