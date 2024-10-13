



    
    

@if (session('success'))
    <div class="alert " style="background-color:rgba(233, 210, 86, 0.8)">
        {{ session('success') }}
    </div>
@endif
<style>
    .table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

.table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tr:hover {
    background-color: #f1f1f1;
}

.table img {
    max-width: 50px;
    max-height: 50px;
    border-radius: 4px;
}

.table a.btn {
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
    margin-right: 5px;
}

.table a.btn-info {
    background-color: #17a2b8;
    color: white;
}

.table a.btn-warning {
    background-color: #ffc107;
    color: white;
}

.table a.btn-danger, .table form button.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    cursor: pointer;
}

.table form {
    display: inline;
}

.table form button.btn-danger:hover, .table a.btn:hover {
    opacity: 0.8;
}

</style>


    <table class="table">
        <tr>
            <th>ID</th>
            <th>Fichier</th>
            <th>Actions</th>
        </tr>
        @foreach ($joints as $joint)
            <tr>
                <td>{{ $joint->id }}</td>
                <td>
                    @if ($joint->file)
                        @if (in_array(pathinfo($joint->file, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'svg']))
                        <a href="{{ route('joints.show', $joint->id) }}" >
                            <img src="{{ asset($joint->file) }}" alt="File" style="max-width: 50px; max-height: 50px;">
                        </a>
                        @else
                            <a href="{{ asset($joint->file) }}" target="_blank">Télécharger</a>
                        @endif
                    @endif
                </td>
                <td>
                    
                    <a href="{{ route('joints.edit', $joint->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('joints.destroy', $joint->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

