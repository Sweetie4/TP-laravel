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
    width: 100%
}
select{
    text-overflow: ellipsis;
}
.links{
    color : rgb(27, 98, 229);
}
.links:hover{
    color : rgb(0, 0, 0);
}

.contract{
    max-height: 50px;
    text-overflow: ellipsis;
    white-space: pre-wrap;
}

.hint{
    font-size: 12px;
}
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Locataires') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('model-contracts.store') }}" method="POST">
                    <h2>Créer un modèle</h2>
                    @csrf
                    <div>
                        <label>Nom du modèle</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label>Contenu</label>
                        <p class="hint">Utiliser # pour utiliser les varaibles</p>
                        <textarea name="content"></textarea>
                    </div>
                    <input class="links" type="submit" value="Enregistrer">
                    <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                </form>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Contenu</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($models as $model)
                    <tr>
                        <td>{{$model->name}}</td>
                        <td class="contract">{{$model->content}}</td>
                        <td>
                            {{-- <a href="{{ route('tenant.edit', $tenant->tenant->id) }}" class="links" >Modifier</a>
                            <form action="{{ route('tenant.destroy', [$tenant->tenant->id, $tenant->owner_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="links" type="submit">Supprimer</button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>