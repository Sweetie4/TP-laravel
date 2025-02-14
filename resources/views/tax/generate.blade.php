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
        cursor: pointer;
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
    
    form h2, .taxes h2{
        font-size: 20px;
        margin: 2% 0;
    }
    
    textarea{
        height: 25vh;
    }
    
    ul {
        display: flex;
        justify-content: space-between;
    }

    .taxes{
        padding: 2%;
    }



    
    
    </style>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Impots') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if (isset($result))
                    <div class="taxes">
                        <h2>{{$result['system']}}</h2>
                        @if (isset($result['message']))
                        <p class="warning">{{$result['message']}}</p>
                        @endif
                        <p>Vous dever remplir <strong>{{$result['sum_to_inform']}} €</strong> à la <strong>{{$result['case']}}</strong>. <br>
                            Vous serez imposé sur <strong>{{$result['sum_taxed']}} €</strong>, soit <strong>{{$result['taxes']}} €</strong> de prévelés. </p>
                    </div>
                    @endif 
                    <form action="{{ route('taxes.calculate') }}" method="POST">
                        @csrf
                        @method('POST')
                        <h2>Générer ses impôts</h2>
                        <div class="form-group">
                            <select  name="system">
                                <option value="property">Régime micro-foncier</option>
                                <option value="real">Régime réel</option>
                            </select>
                        </div>
                        <input  class="links" type="submit" value="Générer">
                        <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>