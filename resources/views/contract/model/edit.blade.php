<style>
    input{
        width: 100%;
    }
    .links{
        color : rgb(27, 98, 229);
    }
    .links:hover{
        color : rgb(0, 0, 0);
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
        height: 50vh;
    }

    ul {
        display: flex;
        justify-content: space-between;
    }

    </style>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modèles de contrat') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <form action="{{ route('model-contracts.update',[$model->id, Auth::user()->id]) }}" method="POST">
                        <h2>Modifier un modèle</h2>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nom du modèle</label>
                            <input type="text" name="name" required value="{{$model->name}}">
                        </div>
                        <div class="form-group">
                            <label>Contenu</label>
                            <p class="hint">Utiliser # pour utiliser les variables</p>
                            <ul class="hint">
                                <div>
                                    <li>#user.name : votre nom</li>
                                </div>

                                <div>
                                    <li>#tenant.first_name : Le prénom du locataire</li>
                                    <li>#tenant.last_name : Le nom du locataire</li>
                                    <li>#tenant.address : L'adresse du locataire</li>
                                    <li>#tenant.email : Le mail du locataire</li>
                                    <li>#tenant.phone : Le téléphone du locataire</li>
                                    <li>#tenant.bank_account : Le compte bancaire du locataire</li>
                                </div>
                                
                                <div>
                                    <li>#box.price : Le prix du box</li>
                                    <li>#box.img : L'image du box</li>
                                    <li>#box.address : L'adresse du box</li>
                                </div>
                            </ul>
                            <textarea name="content" >{{$model->content}}</textarea>
                        </div>
                        <input class="links" type="submit" value="Enregistrer">
                        <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>