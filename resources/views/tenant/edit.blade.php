
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
  .box_address{
    max-width: 219px;
}
input{
    width: 100%
  }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Locataires') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Tel</th>
                        <th>Mail</th>
                        <th>Adresse</th>
                        <th>Compte bancaire</th>
                        <th>Box</th>
                        <th>Action</th>
                    </tr>
                    <form action="{{ route('tenant.update', [$tenant->id, $tenant_box->owner_id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" value="{{$tenant->first_name}}" name="first_name">
                            </td>
                            <td>
                                <input type="text" value="{{$tenant->last_name}}" name="last_name">
                            </td>
                            <td>
                                <input type="number" value="{{$tenant->phone}}" name="phone" required>
                            </td>
                            <td>
                                <input type="text" value="{{$tenant->email}}" name="email">
                            </td>
                            <td>
                                <textarea type="text"  name="address" required>{{$tenant->address}}</textarea>
                            </td>
                            <td>
                                <input type="text" name="bank_account" value="{{$tenant->bank_account}}" required>
                            </td>
                            <td>
                                <select name="box" class="box_address" required>
                                    @foreach ($boxes as $box)
                                        @if (!$box->tenant)
                                            <option value="{{$box->id}}">{{$box->address}}</option>
                                        @else
                                            <option selected="selected" value="{{$box->id}}">{{$box->address}}</option>
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