@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="pagesContainer reports__container">
        <h1 class="text-4xl font-bold pb-6">Signalements</h1>
        @if (session('status'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('status') }}</p>
        </div>
        @endif

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Image</th>
                    <th scope="col" class="px-6 py-3">Nom de l'utilisateur</th>
                    <th scope="col" class="px-6 py-3">Commentaire</th>
                    <th scope="col" class="px-6 py-3">Conversation</th>
                    <th scope="col" class="px-6 py-3">Date de signalement</th>
                    <th scope="col" class="px-6 py-3">Accepter</th>
                    <th scope="col" class="px-6 py-3">Supprimer</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($reports as $report)
                <tr class="bg-white border-b">
                    <td class="px-6 py-4" style="word-break:break-all;">
                        @php
                        $user = App\Models\User::where('id', $report->reported_author_user_id)->firstOrFail();
                        @endphp
                        <img style="width:60px;object-fit:cover;border-radius:100%;" src="{{$user->profilePicture->path . $user->profilePicture->name}}" alt="">
                    </td>
                    <td class="px-6 py-4" style="word-break:break-all;">
                        @php
                        $user = App\Models\User::where('id', $report->reported_author_user_id)->firstOrFail();
                        @endphp
                        {{$user->firstname}} {{$user->lastname}}
                    </td>

                    <td style="height:100px;" class="px-6 py-4">
                        {{ mb_strlen($report->report) > 60 ? mb_substr($report->report, 0, 60) . '...' : $report->report }}
                    </td>

                    <td class="px-6 py-4">
                        <a href="/forum#c{{$report->conversation_id}}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">VOIR</a>
                    </td>
                    <td class="px-6 py-4">
                        <p style="color:red;font-weight:bold;">{{$report->created_at}}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if(!$report->fixed)
                        <form method="POST" action="{{route('signalements.update', ['signalement' => $report->id])}}">
                            @csrf
                            @method('PUT')
                            <input type="submit" value="Message accepté" class="accepted__reply form__button" onclick="return confirm('Confirmer la résolution du signalement?')">
                        </form>
                        @else
                        <p style="color:green;font-weight:bold;font-size:20px;">Résolu</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if(!$report->fixed)
                        <form method="POST" action="{{route('deleted-reply', ['signalement' => $report->id])}}">
                            @csrf
                            @method('PUT')
                            <input type="submit" value="Message supprimé" class="deleted__reply form__button" onclick="return confirm('Confirmer la résolution du signalement?')">
                        </form>
                        @else
                        <p style="color:green;font-weight:bold;font-size:20px;">Résolu</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="loading__container">
            <div class="loading"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('admin.reports.reports-scripts')
@include('admin.users.partials.scripts')
@include('admin.partials.scripts')
@endsection