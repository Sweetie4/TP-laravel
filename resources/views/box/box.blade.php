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
  .links{
    color : rgb(27, 98, 229);
  }
  .links:hover{
    color : rgb(0, 0, 0);
  }

</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boxes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <table>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Adresse</th>
                        <th>Location par mois</th>
                        <th>Locataire actuel</th>
                        <th>Action</th>
                    </tr>
                    <form action="{{ route('box.store') }}" method="POST">
                        @csrf
                        <tr>
                            <td></td>
                            <td>
                                <input type="url" name="img_url">
                            </td>
                            <td>
                                <input type="text" name="address" required>
                            </td>
                            <td>
                                <input type="number" name="price" required>
                            </td>
                            <td>
                            </td>
                            <td>
                                <input class="links" type="submit" value="Enregistrer">
                                <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                            </td>
                        </tr>
                    </form>
                    @foreach ($boxes as $box)
                    <tr>
                        <td>{{$box->id}}</td>
                        <td><img src="{{$box->img_url}}" width="80px" height="80px"> </td>
                        <td>{{$box->address}}</td>
                        <td>{{$box->price}}€ </td>
                        @if ($box->tenant)
                            <td><a class="links" href="{{ route('tenant.edit', $box->tenant->id) }}">{{$box->tenant->first_name}} {{$box->tenant->last_name}}</a></td>
                        @else
                            <td></td>
                        @endif
                        <td>
                            <a class="links" href="{{ route('contrats.show', ['box', $box->id]) }}">Générer un contrat</a>
                            <a class="links" href="{{ route('box.edit', $box->id) }}">Modifier</a>
                            <form action="{{ route('box.destroy', [$box->id, $box->owner_id]) }}" method="POST">
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