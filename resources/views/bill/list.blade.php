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

    .month{
        text-align: center;
    }
    
    form{
        padding: 2%;
    }
    
    form h2{
        font-size: 20px;
    }
    
    textarea{
        height: 25vh;
    }
    
    ul {
        display: flex;
        justify-content: space-between;
    }

    .nav-month-btn{
        border: 1px rgb(27, 98, 229) solid;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .nav-month-btn:hover{
        border: 1px rgb(0,0,0) solid;
    }

    
    
    </style>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des paiements') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Contrat</label>
                            <select name="contract">
                                @foreach ($contracts as $contract)
                                <option value="{{$contract->id}}">{{$contract->model->name}} - {{$contract->tenant->first_name}} {{$contract->tenant->last_name}} - Box {{$contract->box->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mois</label>
                            <input  name="month" type="date">
                        </div>

                        <input class="links" type="submit" value="Générer une facture"/>
                        <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                    </form>
                    <table>
                        <tr>
                            <td class="month"><a class="nav-month-btn links"  href="{{route('bills.show', [$owner_id, date("m-Y", strtotime("-1 month", DateTime::createFromFormat("m-Y", $month)->getTimestamp()))])}}"><</a></button></td>
                            <td colspan="3" class="month">{{$month}}</td>
                            <td class="month"><a class="nav-month-btn links" href="{{route('bills.show', [$owner_id, date("m-Y", strtotime("+1 month", DateTime::createFromFormat("m-Y", $month)->getTimestamp()))])}}">></a></td>
                        </tr>
                        <tr>
                            <th>Locataire</th>
                            <th>Box</th>
                            <th>Montant</th>
                            <th>Nom</th>
                            <th>Action</th>
                        </tr>
                        @if (count($payments)>0)
                        @foreach ($payments as $payment)
                        <tr>
                            <td>{{$payment['contract']->tenant->first_name}} {{$payment['contract']->tenant->last_name}}</td>
                            <td>{{$payment['contract']->box->name}} au {{$payment['contract']->box->address}}</td>
                            <td>{{$payment['contract']->monthly_price}} €</td>
                            <td>{{explode('/',$payment['payment']->file_path)[2]}}</td>
                            <td>
                                <a class="links" href="{{ $payment['payment']->file_path }}" target="_blank">Voir</a> <br>
                                <a href="{{ route('bills.download', [explode('/',$payment['payment']->file_path)[2]]) }}" class="links" >Télécharger</a><br>
                                <form action="{{ route('bills.destroy', [$payment['payment']->id, Auth::user()->id, $month]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="links" type="submit">Supprimer</button>
                                </form> 
                            </td>
                        </tr>
                        @endforeach
                        @else 
                        <tr>
                            <td colspan="5" class="month"> Aucune donnée à afficher</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </x-app-layout>