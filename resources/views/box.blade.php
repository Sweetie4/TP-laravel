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
                                <input type="text" name="tenant_id">
                            </td>
                            <td>
                                <input type="submit" value="enregistrer">
                                <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                            </td>
                        </tr>
                    </form>
                    @foreach ($boxes as $box)
                    <tr>
                        <td>{{$box->id}}</td>
                        <td><img src="{{$box->img_url}}" width="80px" height="80px"> </td>
                        <td>{{$box->address}}</td>
                        <td>{{$box->price}}€    </td>
                        <td></td>
                        <td>
                            <button>Modifier</button>
                            <button>Supprimer</button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>