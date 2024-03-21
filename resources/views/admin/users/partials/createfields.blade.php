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
            <label for="birthdate">Date de naissance</label>
            <input type='date'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="birthdate" id="birthdate">
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
            <label for="pronom">Pronom</label>
            <input type='text'class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="pronoun" id="pronoun">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="used_agreements">Accord utilisés</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="used_agreements" id="used_agreements">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col">
            <label for="gender">Genre</label>
            <select style="border-radius:5px;" name="gender" id="status">
                <option value="Homme" selected>Homme</option>
                <option value="Femme">Femme</option>
                <option value="Non-binaire">Non-binaire</option>
                <option value="Préfère ne pas répondre">Préfère ne pas répondre</option>
            </select>
        </div>
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
            <label for="years_xp">Nombre d'années de travail</label>  
            <input type='number' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="years_xp" id="years_xp">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="work_city">Ville de travail</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="work_city" id="work_city">
        </div>
    </div>
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="work_phone">Téléphone de travail</label>  
            <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none" name="work_phone" id="work_phone">
        </div>
    </div>
    <div class="w-full my-4">
        <label class="font-bold align-start">Audiences</label>
    </div>
    <div class="w-full mb-2">
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Enfants</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Enfants">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Adultes</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Adultes">
        </div>
        <div class="flex items-center">   
            <label class="w-2/12" for="audience">Personnes aîné·es</label>
            <input class="mx-4" type="checkbox" name="audience[]" value="Personnes aîné·es">
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
