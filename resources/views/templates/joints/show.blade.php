<!-- resources/views/joints/show.blade.php -->


@extends('layouts.base')


@section('content')

<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Details Piéce Jointe
            </h2>
            <div style="text-align:right">
            <a href="javascript:history.back()">
    <x-primary-button>{{ __('Retour') }}</x-primary-button>
</a>

            </div>
        </x-slot>
    <div>
    @if ($joint->file)
        @if (in_array(pathinfo($joint->file, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'svg']))
        <div style="text-align:center;">
        <img src="{{ asset($joint->file) }}" alt="File" style="max-width: 950px; max-height: 850px;">
        </div>
           
        @else
            <a href="{{ asset($joint->file) }}" target="_blank">Télécharger Fichier</a>
        @endif
    @endif
    <!-- Other joint details -->
    </div>
 
</x-app-layout>
@endsection