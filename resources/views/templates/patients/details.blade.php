@extends('layouts.base')

@section('content')

    
<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Détails Du Patient : ' .$pat->name) }}
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
                    <div class="">
                        <header style="color:#292184" >
                        <ion-icon name="document-attach-outline"></ion-icon> Identifiant De Dossier : {{$pat->id_patient_doss}}
                        </header>

                        <div class="containerx">
                            <div class="patient-details">
                                <div class="patient-info">
                                <div class="image-container">
                                    @if($pat->img)
                               <img src="" alt="Patient Image">
                                    @endif
                                      </div>
                                    

                                    <div class="consultation-schedule">
                                    <h1 style="color:black"><b> Patient : {{$pat->name}}</b></h1><br><br><br>
                                    <p><strong>CIN:</strong> {{$pat->cin}}</p>
                                    <p><strong>Adresse</strong> {{$pat->address}}</p>
                                    <p><strong>Status</strong> {{$pat->status}}</p>
                                    <p><strong>N° Session</strong> {{$pat->session}} </p>
                                
                                <p> </p>
                               </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="bag-add-outline"></ion-icon> <b> Motif </b></h1>
                                    <ul>
                                        <li>{{$pat->motif}} </li>
                                        
                                    </ul>
                                </div>

                            </div>
                            <!-- ***************************  start div 1--->

                            <div class="patient-details">
                                <div class="patient-info">
                                
                                   

                                    <div class="consultation-schedule">
                                <h2 style="color:#292184"><ion-icon name="copy-outline"></ion-icon> <b> Piéces Jointes</b></h2>
                                
                                <p> Vide</p>
                               </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="construct-outline"></ion-icon> <b> Action </b></h1>
                                    <ul style="text-align:right">
                                        <li > <a href="#" onclick="event.stopPropagation(); AttenteP({{$pat->id}})">
                                           <x-primary-button>{{ __("Ajouter En Liste D'attente") }}</x-primary-button>
                                               </a>
                                         </li>
                                        <li>
                                        <a class="status pending" href="{{url('patients/'.$pat->id.'/edit')}}" onclick="event.stopPropagation(); "> Modification </a>
                                        </li>
                                        <a class="status return" href="#" onclick="event.stopPropagation(); deletePatient({{$pat->id}})">Suppression</a>
                                        <li>

                                        </li>
                                    </ul>
                                </div>

                            </div>
                               <!-- ***************************  end div 1--->
                            
                                <!-- ***************************  start div 1--->

                            <div class="patient-details">
                                <div class="patient-info">
                                
                                   

                                <div class="consultation-schedule">
                              
                              <h2 style="color:#292184"><ion-icon name="reader-outline"></ion-icon> <b> Extra Information</b></h2>            
                              <p><strong>Prochain Visite:</strong> {{$pat->rdv}}</p>
                              <p><strong>Date Inscription</strong> {{$pat->created_at}}</p>                    
                              <p><strong>Contact Patient:</strong> {{$pat->tel}}</p>
                             
                              <p><strong>Date Mise à Jour:</strong> {{$pat->updated_at}}</p>
                             
                              
                              
                          </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="link-outline"></ion-icon> <b> Liens </b></h1>
                                    <ul style="text-align:right">
                                        <li > 
                                         </li>
                                        <li>
                                        
                                        </li>
                                        
                                        <li>

                                        </li>
                                    </ul>
                                </div>

                            </div>
                               <!-- ***************************  end div 1--->
                            
                            <!-- New section for consultation and schedule -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>

function deletePatient(patientId) {
    // Confirm deletion
    if (confirm('Êtes-vous sûr de vouloir supprimer ce patient ? !!')) {
      // Redirect to the delete endpoint (or you could use AJAX here)
      //window.location.href = `/patients/${patientId}/delete`;


fetch('/delet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: patientId }) 
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
           
            })
            .catch(error => {
                console.error('Error:', error);

                // Handle any errors
            });
          // Reload the current page
          window.location.href = `/patients`;

    }// end confirm
  }


  function AttenteP(patientId) {
   


fetch('/attenteS', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: patientId }) 
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
           
            })
            .catch(error => {
                console.error('Error:', error);

                // Handle any errors
            });
          // Reload the current page
          window.location.href = `/dashboard`;

    
  }
    </script>
@endsection




