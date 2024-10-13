@extends('layouts.base')


@section('content')



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter Une Consultation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('+ Consultation ') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Le Nom De Patient S'affiche Automatiquement Aprés Deux Caractéres") }}
                        </p>
                    </header>

                    <form method="post" action="{{url('consultations')}}" class="mt-6 space-y-6">
                        @csrf

                        <div class="flex flex-col lg:flex-row lg:space-x-6">
                            <!-- Left side inputs -->
                            <div class="lg:w-1/2 space-y-6" style="width:500px">
                                <div>
                                    <x-input-label :value="__('Nom & Prénom')" />
                                    @if( isset($namec))

                                    <x-text-input id="name" name="name" value="{{$namec}}" type="text" class="mt-1 block w-full" required autocomplete="off" />
                                 @else
                                 <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autocomplete="off" />
                                    
                                
                                @endif 
                                
                                    <input type="hidden" id="idpatient" name="idpatient" />
                                </div>
                                <div>
                                    <x-input-label :value="__('Date Consultation')" />
                                    <x-text-input id="dateC" name="dateC" type="date" class="mt-1 block w-full" required autocomplete="off" />
                                </div>
                                <div>
                                    <x-input-label :value="__('Heure Consultation')" />
                                    <x-text-input id="heureC" name="heureC" type="time" class="mt-1 block w-full" required autocomplete="off" />
                                </div>
                            </div>
                            
                            <!-- Right side inputs -->
                            <div class="lg:w-1/2 space-y-6" style=" margin-top :50px; padding-left:100px">
                                <div>
                                    <x-input-label :value="__('Examen')" />
                                    <textarea id="examen" name="examen" class="mt-1 block w-full" required autocomplete="off"></textarea>
                                </div>
                                <div>
                                    <x-input-label :value="__('Anticidents Personnel')" />
                                    <textarea id="antiP" name="antiP" class="mt-1 block w-full" required autocomplete="off"></textarea>
                                </div>
                                <div>
                                    <x-input-label :value="__('Anticidents Famillial')" />
                                    <textarea id="antiF" name="antiF" class="mt-1 block w-full" required autocomplete="off"></textarea>
                                </div>
                                <div>
                                    <x-input-label :value="__('Allergies')" />
                                    <textarea id="allergy" name="allergy" class="mt-1 block w-full" required autocomplete="off"></textarea>
                                </div>
                                <div>
                                    <x-input-label :value="__(' '  )" /><br>
            
                                   <select style="width:578px" class="selectstatus" name="typeC" >
                                   <option value="">Type De Consultation</option>          
                            <option value="Consultation">Consultation</option>
                            <option value="Controle">Controle</option>
                            
                            <option value="Reconsultation">Reconsultation</option>
                           
                                    </select>
        </div>
                                <div>
                                    <x-input-label :value="__('Montant')" />
                                    <x-text-input id="montant" name="montant" type="text" class="mt-1 block w-full" required autocomplete="off" placeholder="MAD" style="width:250px"/>
                                </div>

                            </div>
                        </div>

                        

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
  

    .space-y-6 > :not([hidden]) ~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
    }

    textarea {
        display: block;
        width: 100%;
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db; /* Light gray border */
        background-color: #f9fafb; /* Light background */
        resize: vertical;
    }
</style>

<script>
        $(function() {
            $("#name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('/patients/names') }}",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            //response(data.name);
                            console.log(data)

                           /**start new */ response(data.map(function(patient) {
                        return {
                            label: "Patient  :" +patient.name + " -  CIN : " + patient.cin, // Display both name and cin
                            value: patient.name, // Set the input field's value to the selected name
                            idpat:patient.id
                        };
                    }));/** end new code */


                        }//end success
                        
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#name').val(ui.item.value);
                    $('#idpatient').val(ui.item.idpat);
                }
            });
        });
    </script>
@endsection