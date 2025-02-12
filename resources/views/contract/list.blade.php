<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
input{
    width: 100%;
}
.links{
    color : rgb(27, 98, 229);
}
.links:hover{
    color : rgb(0, 0, 0);
}

.contract{
    white-space: pre-wrap;
}

.hint{
    font-size: 12px;
}

.form-group{
    display: flex;
    flex-direction: column;
    margin:15px 0
    
}

form{
    padding: 2%;
}

form h2{
    font-size: 20px;
    text-align: center;
}

textarea{
    height: 25vh;
}

ul {
    display: flex;
    justify-content: space-between;
}

</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contrats') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($contracts as $contract)
                    <tr>
                        <td>{{$contract->name}}</td>
                        <td>
                            <a class="links" href="{{ $contract->file_path }}" target="_blank">Voir</a>
                            <a href="{{ route('contract.download', [$contract->name]) }}" class="links" >Télécharger</a>
                            <form action="{{ route('contracts.destroy', [$contract->id, $contract->owner_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="links" type="submit">Supprimer</button>
                            </form> 
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>