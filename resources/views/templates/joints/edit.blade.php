<!-- resources/views/joints/edit.blade.php -->

@extends('layouts.base')

@section('content')

<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edition Piéce Jointe
            </h2>
            <div style="text-align:right">
            <a href="javascript:history.back()">
    <x-primary-button>{{ __('Retour') }}</x-primary-button>
</a>
</div>
        </x-slot>

        <div>
     

   


    <form action="{{ route('joints.update', $joint->id)  }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Other form fields -->

        <div class="consultation-schedule" style="background-color:white">
            <label for="file"></label>
            <x-text-input type="file" style="display:none" name="file"  id="file" accept=".jpeg,.jpg,.png,.gif,.svg,.pdf,.doc,.docx"/>
<!-- Custom button -->
<button type="button" class="btn btn-secondary" onclick="document.getElementById('file').click();
"> <ion-icon name="attach-outline"></ion-icon>Modifier Piéce Jointe</button>
<!-- Element to display selected file name -->
<span id="file-name"></span>
            
            <button type="submit" id="subbtn" style="display:none" class="btng">Enregistrer</button>
        </div>

        
    </form>
        </div>
  
</x-app-layout>

<script>

      // Update file name display when file is selected
      document.getElementById('file').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name').textContent =' || '+ fileName;
        document.getElementById('subbtn').style.display = 'block';
    });
</script>
@endsection
