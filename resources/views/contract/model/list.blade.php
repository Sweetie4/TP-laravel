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
.box_address{
    max-width: 219px;
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
                    <form action="{{ route('tenant.store') }}" method="POST">
                        @csrf
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" name="first_name" required>
                            </td>
                            <td>
                                <input type="text" name="last_name" required>
                            </td>
                            <td>
                                <input type="number" name="phone" required>
                            </td>
                            <td>
                                <input type="text" name="email" required>
                            </td>
                            <td>
                                <input type="text" name="address" required>
                            </td>
                            <td>
                                <input type="text" name="bank_account" required>
                            </td>
                            <td>
                                {{-- <select name="box" class="box_address" required>
                                    @foreach ($tenants as $tenant)
                                        @if (!$tenant->tenant)
                                            <option value="{{$tenant->id}}">{{$tenant->address}}</option>
                                        @endif
                                    @endforeach
                                </select> --}}
                            </td>
                            <td>
                                <input class="links" type="submit" value="Enregistrer">
                                <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                            </td>
                        </tr>
                    </form>
                    {{-- @foreach ($tenants as $tenant)
                    @if ($tenant->tenant)
                    <tr>
                        <td>{{$tenant->tenant->id}}</td>
                        <td>{{$tenant->tenant->first_name}}</td>
                        <td>{{$tenant->tenant->last_name}}</td>
                        <td>{{$tenant->tenant->phone}}</td>
                        <td>{{$tenant->tenant->email}}</td>
                        <td>{{$tenant->tenant->address}}</td>
                        <td>{{$tenant->tenant->bank_account}}</td>
                        <td><a  href="{{ route('box.edit', $tenant->id) }}" class="links" >{{$tenant->address}}</a> </td>
                        <td>
                            <a href="{{ route('tenant.edit', $tenant->tenant->id) }}" class="links" >Modifier</a>
                            <form action="{{ route('tenant.destroy', [$tenant->tenant->id, $tenant->owner_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="links" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach --}}
                </table>
            </div>
        </div>
    </div>
</x-app-layout>