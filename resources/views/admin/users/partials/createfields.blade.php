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
            <label for="firstname">Prénom</label>
            <input type='text'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="firstname" id="firstname" required>
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col">
            <label for="lastname">Nom de famille</label>
            <input type='text'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="lastname" id="lastname" required>
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col">
            <label for="email">Courriel</label>
            <input type='email'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="email" id="email" required>
        </div>
    </div>
    <div class="w-full mb-2">
        <label for="password">Mot de passe</label>
        <input id="password" class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" type="password" name="password" required/>
    </div>
    <div class="w-full mb-2">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input id="password_confirmation" class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" type="password" name="password_confirmation" required/>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="title">Titre professionnel</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="title" id="title">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="environment">Organisme</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="environment" id="environment">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="work_city">Ville de travail</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="work_city" id="work_city">
        </div>
    </div>
    <div class="w-full my-4">
        <label class="font-bold align-start">Audiences</label>
    </div>
    <div class="w-full mb-2">
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Petite enfance</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Petite enfance">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Enfance</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Enfance">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Adolescence</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Adolescence">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Jeunes adultes</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Jeunes adultes">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Adultes</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Adultes">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Aîné·es</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Aîné·es">
        </div>
        <div class="flex items-center">
            <input class="w-full border rounded py-2 text-gray-700 focus:outline-none" type="text" name="other_audience" placeholder="Autres" >
        </div>
    </div>
    <div class="w-full my-4">
        <label class="font-bold align-start">Intérets</label>
    </div>
    <div class="w-full mb-2">
        <div class="flex items-center">   
            <label class="w-5/12" for="interests">Partager votre expérience</label>
            <input class="mx-4" type="checkbox" name="interests[]" value="Partager votre expérience">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="interests">Lire sur le sujet</label>
            <input class="mx-4" type="checkbox" name="interests[]" value="Lire sur le sujet">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="interests">Chercher des réponses à vos questions</label>
            <input class="mx-4" type="checkbox" name="interests[]" value="Chercher des réponses à vos questions">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="interests">Chercher des outils pour vous aider</label>
            <input class="mx-4" type="checkbox" name="interests[]" value="Chercher des outils pour vous aider">
        </div>
        <div class="flex items-center">
            <input class="w-full border rounded py-2 text-gray-700 focus:outline-none" type="text" name="other_interests" placeholder="Autres" >
        </div>
    </div>
    <div class="w-full my-4">
        <label class="font-bold align-start">Comment avez-vous entendu parler de cette communauté?</label>
    </div>
    <div class="w-full mb-2">
        <div class="flex items-center">   
            <label class="w-5/12" for="hear_about">Réseaux sociaux</label>
            <input class="mx-4" type="checkbox" name="hear_about[]" value="Réseaux sociaux">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="hear_about">Médias traditionnels</label>
            <input class="mx-4" type="checkbox" name="hear_about[]" value="Médias traditionnels">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="hear_about">Moteur de recherche</label>
            <input class="mx-4" type="checkbox" name="hear_about[]" value="Moteur de recherche">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="hear_about">Réseaux professionnels</label>
            <input class="mx-4" type="checkbox" name="hear_about[]" value="Réseaux professionnels">
        </div>
        <div class="flex items-center">   
            <label class="w-5/12" for="hear_about">Réseaux personnels</label>
            <input class="mx-4" type="checkbox" name="hear_about[]" value="Réseaux personnels">
        </div>
        <div class="flex items-center">
            <input class="w-full border rounded py-2 text-gray-700 focus:outline-none" type="text" name="other_about" placeholder="Autres" >
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
        <a href="/admin/users">Retour</a>
        <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Créer">
    </div>
</div>
