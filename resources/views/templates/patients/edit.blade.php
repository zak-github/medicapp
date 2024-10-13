@extends('layouts.base')


@section('content')
<link rel="stylesheet" href="{{ asset('scripts/styless.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editer Un Patient') }}
        </h2>
        <div style="text-align:right">
      <a href="{{url('patients')}}">
        <x-primary-button>{{ __('Retour') }}</x-primary-button>
      </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
           
                <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Modifier Données Patient ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Assurez-vous que votre Information est bien saisie') }}
        </p>
    </header>

    <form method="post" action="{{url('patients/'.$pat->id)}}" class="mt-6 space-y-6">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div>
            <x-input-label :value="__(' Nom & Prénom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{$pat->name}}" autocomplete="" required />
           
        </div>

        <div>
            <x-input-label :value="__('CIN')" />
            <x-text-input id="cin" name="cin" type="text" class="mt-1 block w-full" autocomplete="" value="{{$pat->cin}}" required />
           
        </div>

        <div>
            <x-input-label :value="__(' Numéros Téléphone')" />
            <x-text-input id="tel" name="tel" type="text" class="mt-1 block w-full" autocomplete="" value="{{$pat->tel}}" required />
           
        </div>

        <div>
            <x-input-label :value="__(' Adresse')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" value="{{$pat->address}}" autocomplete=""  />
           
        </div>
        <div>
            <x-input-label :value="__(' Motif')" />
            <x-text-input id="motif" name="motif" type="text" class="mt-1 block w-full" value="{{$pat->motif}}" autocomplete=""  />
           
        </div>
        <div class="autocomplete">
        <x-input-label :value="__('Type D\'assurence')" />
        <x-text-input id="insuranceInput" type="text" name="assurence" value="{{$pat->assurence}}" placeholder="Choisir une assurance" autocomplete="" />
        </div>
        <div>
            <x-input-label :value="__(' Session')" />
            <x-text-input id="session" name="session" type="text" class="mt-1 block w-full" value="{{$pat->session}}" autocomplete=""  />
           
        </div>

        <div>
            <x-input-label :value="__(' Rendez-Vous   :'. $pat->rdv)" />
            <x-text-input id="rdv" name="rdv" type="date" class="mt-1 block w-full" value="{{$pat->rdv}}" autocomplete=""  />
           
        </div>

        <div>
            <x-input-label :value="__(' Status Précédent  : '. $pat->status)" />
            
            <select style="width:578px" name="status" class="mt-1 block w-full" >
            <option value="En Attente" {{ $pat->status == 'En Attente'? 'selected' : '' }}>Non Définis</option>
        <option value="Consultation" {{ $pat->status == 'Consultation' ? 'selected' : '' }}>Consultation</option>
        <option value="Session Terminé" {{ $pat->status == 'Session Terminé' ? 'selected' : '' }}>Session Terminé</option>
        <option value="Session Renvoyé" {{ $pat->status == 'Session Renvoyé' ? 'selected' : '' }}>Session Renvoyé</option>
        <option value="Reconsultation" {{ $pat->status == 'Reconsultation' ? 'selected' : '' }}>Reconsultation</option>
        <option value="Annuler" {{ $pat->status == 'Annuler' ? 'selected' : '' }}>Annuler</option>
    </select>
        </div>


        <div class="flex items-center gap-4">
            <x-danger-button>{{ __('Modifier Le Patient') }}</x-danger-button>

            
        </div>
    </form>

                
                </div>
            </div>

            

            
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('scripts/script.js') }}"></script>
@endsection

