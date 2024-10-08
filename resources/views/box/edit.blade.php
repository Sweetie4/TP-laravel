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
                        <th>Locataire</th>
                        <th>Action</th>
                    </tr>
                    <form action="{{ route('box.update',[$box->id, $box->owner_id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <tr>
                            <td></td>
                            <td>
                                <input type="url" value="{{$box->img_url}}" name="img_url">
                            </td>
                            <td>
                                <textarea type="text"  name="address" required>{{$box->address}}</textarea>
                            </td>
                            <td>
                                <input type="number" value="{{$box->price}}" name="price" required>
                            </td>
                            <td>
                                <select  name="tenant_id">
                                    <option value=""></option>
                                    @foreach ($boxes as $tenant) 
                                        @if ($tenant->tenant)
                                            @if($box->tenant && $box->tenant->id == $tenant->tenant->id)
                                                <option selected="selected" value="{{$tenant->tenant->id}}">{{$tenant->tenant->first_name}} {{$tenant->tenant->last_name}}</option>
                                            @else
                                                <option value="{{$tenant->tenant->id}}">{{$tenant->tenant->first_name}} {{$tenant->tenant->last_name}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input class="links" type="submit" value="Enregistrer">
                                <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>