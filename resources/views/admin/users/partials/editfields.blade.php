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
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="name" id="name" value="{{$model->name}}">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col">
            <label for="email">Email</label>
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="email" id="email" value="{{$model->email}}">
        </div>
    </div>
    <div class="w-full my-4">
        <label class="font-bold align-start">Roles</label>
    </div>
    @if($authuser == $model->id && $authUserIsSuperAdmin)
    @foreach ($roles as $role)
    <div class="w-full mb-2">
        <div class="flex items-center">
            <label class="w-2/12 checkBoxLabel" for="roles"> {{$role->name}}</label>
            <input class="mx-4 checkBox" type="radio" name="roles" value="{{$role->id}}" disabled="disabled" {{$model->hasRole($role->name)?'checked':''}}>
        </div>
    </div>
    @endforeach

    <style>
        .checkBox:checked {
            color: lightgray;
        }

        .checkBox {
            background: lightgray;
            border: none;
        }

        .checkBoxLabel {
            color: grey;
        }
    </style>
    @else
    @foreach ($roles as $role)
    <div class="w-full mb-2">
        <div class="flex items-center">
            <label class="w-2/12" for="roles"> {{$role->name}}</label>
            <input class="mx-4" type="radio" name="roles" value="{{$role->id}}" {{$model->hasRole($role->name)?'checked':''}}>
        </div>
    </div>
    @endforeach
    @endif
    <div class="w-full my-4">
        <label class="font-bold align-start">Vérifié</label>
    </div>
    <div class="w-full mb-10">
        <div class="flex items-center">
            <input type="checkbox" name="checkbox" id="toggle" class="toggle-checkbox" {{ $model->verified == 1 ? 'checked' : '' }}>
            <label for="toggle" class="toggle-label"></label>
            <input type="hidden" name="" value="{{$model->id}}">
        </div>
    </div>

    <div class="flex items-center gap-4 w-full py-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'user-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
        @endif
    </div>
</div>