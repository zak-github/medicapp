@extends('layouts.base')

@section('content')
@if (!isset($pat) || !isset($pat->patient) || !isset($pat->patient->name))

    <?php
    session()->flash('messageSearch', 'Ce Patient ayant pas encors une Consultation.');
    ?>
    <script>
        window.location.href = `/consultations`;
    </script>
@else

<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Détails Consultation Du Patient : ' .$pat->patient->name) }}
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
                        <ion-icon name="document-attach-outline"></ion-icon> Identifiant De Dossier : {{$pat->patient->id_patient_doss}}
                        </header>

                        <div class="containerx">
                            <div class="patient-details">
                                <div class="patient-info">
                                <div class="image-container">
                                    @if($pat->img)
                               <img src="" alt="Patient Image">
                                    @endif
                                      </div>
                                    <h1 style="color:black"><b> Patient : {{$pat->patient->name}}</b></h1><br><br><br>
                                    <p><strong>Type de consultation:</strong> {{$pat->type}}</p>
                                    <p><strong>Date Consultation</strong> {{$pat->dateC}}</p>
                                    <p><strong>Heure Consultation</strong> {{$pat->heureC}}</p>
                                    <p><strong></strong> </p>

                                    <div class="consultation-schedule">
                                <h2 style="color:#292184"><ion-icon name="bed-outline"></ion-icon> <b> Examen</b></h2>
                                
                                <p> {{$pat->examen}}</p>
                               </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="bag-add-outline"></ion-icon> <b> Medical Historique</b></h1>
                                    <ul>
                                        <li><strong>Antecedent Personnel</strong> {{$pat->antecedent_per}}</li>
                                        <li><strong>Antecedent Familliale</strong> {{$pat->antecedent_fam}}</li>
                                        <li><strong>Allergies</strong> {{$pat->allergies}}</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- ***************************  start div 1--->

                            <div class="patient-details">
                                <div class="patient-info">
                                
                                   

                                    <div class="consultation-schedule">
                                <h2 style="color:#292184"><ion-icon name="copy-outline"></ion-icon> <b> Piéces Jointes</b></h2>
                                <!-- start ****************** -->
                                
                                <form action="{{ route('joints.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Other form fields -->

        <div class="consultation-schedule" style="background-color:white">
            <label for="file"></label>
            <x-text-input type="file" style="display:none" name="file"  id="file" accept=".jpeg,.jpg,.png,.gif,.svg,.pdf,.doc,.docx"/>
<!-- Custom button -->
<button type="button" class="custom-file-button" onclick="document.getElementById('file').click();
"> <ion-icon name="attach-outline"></ion-icon>Ajouter</button>
<!-- Element to display selected file name -->
<span id="file-name"></span>
            <input type="hidden" name="id_cons" value="{{$pat->id}}">
            <input type="hidden" name="table_src" value="consultation"><br><br>
            <button type="submit" id="subbtn" style="display:none" class="btng">Enregistrer</button>
        </div>

        
    </form>


                                <!-- end ************************* -->
                                <p> 
                         
                                @include('templates.joints.index')

                                </p>
                               </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="construct-outline"></ion-icon> <b> Action Consultation</b></h1>
                                    <ul style="text-align:right">
                                        <li > <a href="{{url('consultations/'.$pat->patient->name.'/createC')}}">
                                           <x-primary-button>{{ __('Ajouter') }}</x-primary-button>
                                               </a>
                                         </li>
                                        <li>
                                        <a class="status pending" href="{{url('consultations/'.$pat->id.'/edit')}}" onclick="event.stopPropagation(); "> Modification </a>
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
                              <p><strong>Prochain Visite:</strong> {{$pat->patient->rdv}}</p>
                              <p><strong>Date Inscription</strong> {{$pat->created_at}}</p>                    
                              <p><strong>Contact Patient:</strong> {{$pat->patient->tel}}</p>
                              <p><strong>Montant Consultation:</strong> {{$pat->montant}}</p>
                              <p><strong>Date Mise à Jour:</strong> {{$pat->updated_at}}</p>
                              <p><strong>Date Premiére Visite:</strong> {{$pat->patient->created_at}}</p>
                              
                              
                          </div>
                             </div>

                               
                                <div class="patient-history">
                                    <h1 style="color:#292184"><ion-icon name="link-outline"></ion-icon> <b> Liens Consultation</b></h1>
                                    
                                       <table class="table">
                                        <thead>
                                            <tr>
                                               
                                            <td style="color:darkblue"> Date </td>
                                            
                                            <td style="color:darkblue"> Heure </td>
                                              
                                            <td style="color:darkblue"> type </td>
                                            <td></td>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @foreach($cons as $con)
                                            <tr>
                                                
                                            <td> {{$con->dateC}} </td> 
                                            

                                            <td> {{$con->heureC}} </td>
                                           

                                            <td>{{$con->type}} </td>
                                            <td><ion-icon name="enter-outline"></ion-icon> <a href="{{url('/consultations/'.$con->id.'/details')}}"> Afficher</a>  </td>
                                            </tr>
                                           @endforeach
                                         </tbody>
                                          </table>

                                   
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


fetch('/consultations/delet', {
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
  window.location.href = `/consultations`;

    }// end confirm
  }



    // Update file name display when file is selected
    document.getElementById('file').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name').textContent =' || '+ fileName;
        document.getElementById('subbtn').style.display = 'block';
    });


    $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000); // 3 seconds before fade out
        });
    </script>
@endsection

@endif


