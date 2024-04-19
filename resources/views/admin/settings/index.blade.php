@extends('layouts.admin')

@section('content')
@if (session('status'))
<div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6 ml-12 w-6/12" role="alert">
    <p class="font-bold">{{ session('status') }}</p>
</div>
@endif
<form class="w-full flex justify-center" action="{{ route('parametres.store') }}" method="post">
    @csrf
    <div class="px-12 pb-8 flex flex-col items-center w-10/12">
        @if (!$errors->isEmpty())
        <div role="alert" class="w-full pb-8">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Champs manquants
            </div>

        </div>
        @endif

        <div class="w-full mb-2">
            <p style="font-size:25px;font-weight:bold;">Paramètres SMTP</p>
            <div class="flex justify-center flex-col">
                <label for="">Host</label>
                <input type='text' class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none items-center" name="host" id="host" value="{{ $mailSetting->host ?? '' }}">
                @if ($errors->has('host'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('host') }}</p>
                @endif
            </div>
        </div>
        <div class="w-full mb-2">
            <div class="flex justify-center flex-col">
                <label for="port">Port</label>
                <input type='number' class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none" name="port" id="port" value="{{ $mailSetting->port ?? '' }}">
                @if ($errors->has('port'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('port') }}</p>
                @endif
            </div>
        </div>
        <div class="w-full mb-2">
            <div class="flex justify-center flex-col">
                <label for="username">Username</label>
                <input type='text' class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none" name="username" id="username" value="{{ $mailSetting->username ?? '' }}">
                @if ($errors->has('username'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('username') }}</p>
                @endif
            </div>
        </div>
        <div class="w-full mb-2">
            <div class="flex justify-center flex-col">
                <label for="password">Password</label>
                <input type='text' class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none" name="password" id="password" value="{{ $mailSetting->password ?? '' }}">
                @if ($errors->has('password'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>
        </div>
        <div class="w-full mb-2">
            <div class="flex justify-center flex-col">
                <label for="encryption">Encryption</label>
                <input type='text' class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none" name="encryption" id="encryption" value="{{ $mailSetting->encryption ?? '' }}">
                @if ($errors->has('encryption'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('encryption') }}</p>
                @endif
            </div>
        </div>


        <div class="w-full flex justify-start">
            <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Sauvegarder">
        </div>
    </div>
</form>

<form class="w-full flex justify-center" action="{{ route('enable-chatbot') }}" method="POST">
    @php
    $chatbotactive = App\Models\ChatbotActive::where('id', 1)->first();
    @endphp
    @csrf
    <div class="px-12 pb-8 flex flex-col items-center w-10/12">
        <div class="w-full mb-2">
            <p style="font-size:25px;font-weight:bold;">Activer le chatbot</p>
            <div class="flex justify-center flex-col">
                <input type="checkbox" name="chatbotactive" id="chatbotactive" class="toggle-checkbox" {{ $chatbotactive->active == true ? 'checked' : '' }}>
                <label for="chatbotactive" class="toggle-label"></label>
                <input type="hidden" name="chatbot_acive">
            </div>
        </div>
        <div class="w-full flex justify-start">
            <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Sauvegarder">
        </div>
    </div>
</form>

<form class="w-full flex justify-center" action="{{ route('maintenance.mode') }}" method="post">
    @csrf
    <div class="px-12 pb-8 flex flex-col items-center w-10/12">

        <div class="w-full mb-2">
            <p style="font-size:25px;font-weight:bold;">Mode Maintenance</p>
            <div class="flex justify-start flex-col">
                <label for="maintenance">Mettre le site en maintenance</label>
                <input type="checkbox" name="maintenance" id="maintenance" class="cursor-pointer mt-4" style="width:20px;height:20px;" @if($maintenance->maintenance == true) checked @endif>
            </div>
        </div>

        <div class="w-full flex justify-start">
            <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Sauvegarder">
        </div>
    </div>
</form>

<form class="w-full flex justify-center" action="{{ route('cookie-script') }}" method="post">
    @csrf
    <div class="px-12 pb-8 flex flex-col items-center w-10/12">
        <div class="w-full mb-2">
            <p style="font-size:25px;font-weight:bold;">Cookie Script</p>
            <div class="flex justify-start flex-col">
                <label for="cookie">Cookie script</label>
                <input type='text' name="cookie" id="cookie" class="w-6/12 border rounded py-2 text-gray-700 focus:outline-none" name="password" id="password" value="{{$cookie->cookie_script}}">
            </div>
        </div>

        <div class="w-full flex justify-start">
            <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Sauvegarder">
        </div>
    </div>
</form>
@endsection
@section('scripts')
@include('admin.partials.scripts')
@endsection