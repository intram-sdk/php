# INTRAM PHP SDK


Bibliothèque [PHP](https://www.php.net) pour [INTRAM (intram.com)](https://intram.com).

Construit sur l'API HTTP INTRAM (bêta).

## Génération de vos clés API




## Installation via composer

```sh
composer require intram-sdk/php
```

## API configuration

Configurez les clés d'API intram.
```php
$paycfa = new \intram\PayCfa\PayCfa(
            "5b06f06a0aad7d0163c414926b635ee9cdf41438de0f09d70a4acf153083b7ed375a691e3513b42544530469e1ff8657b34508dc61927048444dd6dc9ccbb87f",
            "pk_9c0410014969f276e8b3685fec7b1b2ab41fc760db2976c75e32ec0fdc3b7d5575a7087f9aeb4d8a29a949ac4cac11363b39ff6a6d9dc3bc6ce0f328c62c3c58",
            "sk_08bd75f9468b484d8a9f24daddff4638d6513fdcf3ff4dd533e72ce55c22eac3207c12af49400ecddb1969ad3db152b0c338c0050c4540f9d0cb8c3cd3cb8c26",
            "marchand_id",
            true)
```
Connectez-vous à votre compte Intram, cliquez sur Développeur, puis sur API à ce niveau, récupérez les clés API et donnez-les comme arguments au contrôleur.
Initialisez Intram PayCfa en entrant dans l'ordre: `PUBLIC_KEY`,` PRIVATE_KEY`, `INTRAM_SECRET`,` INTRAM_MARCHAND_KEY`, `MODE`
Le mode: `true` pour le mode live et` false` pour le mode test.


##Configurez les informations de votre service / entreprise



###### Définition du nom de la boutique
(requis)
```php
$paycfa->setNameStore("Suntech Store"); 
```



###### Définition de l'URL du logo de la boutique

```php
$paycfa->setLogoUrlStore("https://www.suntechshop/logo.png");
```



###### Configuration du site Web de la boutique

```php
$paycfa->setWebSiteUrlStore("https://www.suntechshop");
```



###### Configuration du numéro de téléphone 

```php
$paycfa->setPhoneStore("97000000");
```



###### Configuration de l'adresse postale 

```php
$paycfa->setPostalAdressStore("BP 35");
```

##Créer une transaction de paiement
Afin de permettre à l'utilisateur d'effectuer un paiement sur votre boutique, vous devez créer la transaction puis lui envoyer l'url de paiement ou le code qr à scanner.
Pour ça :

###### Add Invoice Items
Ajouter les différents produits de l'achat (obligatoire)
```php
$paycfa->setItems([
            ['name'=>"T-shirt",'qte'=>"2",'price'=>"500",'totalamount'=>"1000"],
            ['name'=>"trouser",'qte'=>"1",'price'=>"12500",'totalamount'=>"12500"],
        ]);
```

###### Configuration du montant de la TVA
TVA (optionnel)
```php
payfa->setTva([["name" => "VAT (18%)", "amount" => 1000],["name" => " other VAT", "amount" => 500]]);
```


###### Ajout de données personnalisées
(optionnel)
```php
$paycfa->setCustomData([['CartID',"32393"],['PERIOD',"TABASKI"]]);
```



###### Définition du montant total
Total de la commande (obligatoire)
```php
$paycfa->setAmount(13600);
```
###### Définition de la devise 
Devise de paiement (obligatoire)
```php
$paycfa->setCurrency("XOF");
```

######  Description 
Description de l'opération (obligatoire)
```php
$paycfa->setDescription("Pretty and suitable for your waterfall");
```


###### Template a utilisé sur le portail de paiement
 (obligatoire)
```php
$paycfa->setTemplate("default");
```


###### Définition de l'URL de redirection de la boutique
(optionnel)
```php
$paycfa->setRedirectionUrl("https://www.suntechshop/redirection-url");
```


###### Définition de l'URL de retour du magasin
(optionnel)
```php
$paycfa->setReturnUrl("https://www.suntechshop/return-url");
```


###### Définition de l'URL d'annulation du magasin
(optionnel)
```php
$paycfa->setCancelUrl("https://www.suntechshop/cancel-url");
```


###### Faire la demande de paiement
(obligatoire)
```php
$response = json_decode($paycfa->setRequestPayment());
```
###### Réponse attendue

```php
{
              "status": "PENDING",
              "transaction_id": "5f2d7a96b97d9d3fea912c11",
              "receipt_url": "localhost:3000/payment/gate/5f2d7a96b97d9d3fea912c11",
              "total_amount": 1000,
              "message": "Transaction created successfully",
              "error": false
}
```

###### Récupération des données
```php
$transaction_id = $response->transaction_id;
$status = $response->status;
$receipt_url = $response->receipt_url;
$total_amount = $response->total_amount;
$message = $response->message;
$error = $response->error;
```

##Obtenir le statut de la transaction

Passer l'identifiant de la transaction comme argument à la fonction (obligatoire)
```php
$paycfa->getTransactionStatus(5f2d7a96b97d9d3fea912c11); 
```

###### Réponse attendue

```php
{
  "error":false,
  "status":"PENDING",
  "transaction":{
    "_status":"PENDING",
    "_channels":[
    ],
    "_created_at":"2021-02-16T16:56:56.488Z",
    "_id":"602fd5463f1edd6264e4107c",
    "_env":"sandbox",
    "_type":"DEBIT",
    "marchand":{
      "_statut":true,
      "_principal":true,
      "_state_id":"5f31a47a38111e135ae7b7f3",
      "_valide":true,
      "customers":[
        "602e587a3f1edd6264e4107a"
      ],
      "_settingtransaction":[
      ],
      "_template":[
      ],
      "_env":"sandbox",
      "_created_at":"2021-02-16T11:44:58.649Z",
      "_id":"602bb0987b66df8e97a4ef9e",
      "_reason":null,
      "_usermeanspaiement":[
        "602e3380b937b529ebfbf23f",
        "602e36178fca9830534e5271"
      ],
      "_settingreversement":null,
      "wallet":"602bb0997b66df8e97a4ef9f",
      "_user_id":"601bbe97cc481829fa1237fd",
      "_web_site":"https:://speedcash.com",
      "_company":"SpeedCash",
      "_email":"speedcash@gmail.com",
      "_categorie_id":"60268a988835ed5bff34de89",
      "country":"6013d5f9c477f8777270787b",
      "__v":1
    },
    "_actions":{
      "cancel_url":"https://jshop.com/",
      "return_url":"https://jshop.com/",
      "callback_url":"https://jshop.com/"
    },
    "_store":{
      "name":"JShop",
      "postal_adress":"BP 35",
      "logo_url":"https://jshop.com/logo.png",
      "web_site_url":"https://jshop.com/logo.png",
      "phone":"97000000",
      "template":"default"
    },
    "_reference":"QW9PHIeVyL",
    "_amount":1000,
    "_country_code":"BJ",
    "_qrcode":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHQAAAB0CAYAAABUmhYnAAAAAklEQVR4AewaftIAAAK2SURBVO3BQW7sWAwEwSxC979yjpdcPUCQur/NYUT8wRqjWKMUa5RijVKsUYo1SrFGKdYoxRqlWKMUa5RijVKsUYo1SrFGKdYoFw8l4ZtUTpLQqXRJ6FROkvBNKk8Ua5RijVKsUS5epvKmJJwkoVM5UXlC5U1JeFOxRinWKMUa5eLDknCHyh0qJ0m4Q+WOJNyh8knFGqVYoxRrlIv/GZXJijVKsUYp1igXf1wSTlS6JJyo/GXFGqVYoxRrlIsPU/kklZMknKg8ofKbFGuUYo1SrFEuXpaEb0pCp3Ki0iWhUzlJwm9WrFGKNUqxRok/WGMUa5RijVKsUS4eSkKn0iWhU+mS0Kl0SehUTpLQqZwkoVO5IwmdykkSOpU3FWuUYo1SrFEufpkkdCpdEjqVTqVLwolKl4QTlU6lS0KncpKETuWJYo1SrFGKNcrFy5LQqXRJOFHpktCpdEn4piQ8odIl4U3FGqVYoxRrlPiDfygJncoTSehUuiScqHRJ6FTelIRO5YlijVKsUYo1SvzBA0k4UemS0Kl0SThR6ZLwhModSXhC5ZOKNUqxRinWKPEHf1gS7lD5piScqLypWKMUa5RijXLxUBK+SaVTOUnCSRLuUHlTEjqVJ4o1SrFGKdYoFy9TeVMS7khCp3Ki0iWhU3mTSpeENxVrlGKNUqxRLj4sCXeo3JGEJ5LwRBI6lX+pWKMUa5RijXLxx6l0SeiScKLSJeEOlS4JnUqXhE7lTcUapVijFGuUiz8uCW9S6ZLQqXRJuEOlS0Kn8kSxRinWKMUa5eLDVD5JpUvCHUk4UemS0KmcJOGbijVKsUYp1igXL0vCNyXhCZWTJHQqXRLuUOmS8KZijVKsUYo1SvzBGqNYoxRrlGKNUqxRijVKsUYp1ijFGqVYoxRrlGKNUqxRijVKsUYp1ij/AQf/C/ZESO1HAAAAAElFTkSuQmCC",
    "x_currency":"6013e6c0a948101dcda9acd9",
    "__v":0,
    "invoice":{
      "custom_datas":[
        [
          "CartID",
          "32393"
        ],
        [
          "PERIOD",
          "TABASKI"
        ]
      ],
      "_created_at":"2021-02-16T16:56:58.771Z",
      "_id":"602fd5473f1edd6264e4107d",
      "currency":"XOF",
      "items":[
        {
          "_id":"602fd5473f1edd6264e4107e",
          "name":"short",
          "price":500
        }
      ],
      "taxes":[
        {
          "_id":"602fd5473f1edd6264e4107f",
          "name":"VAT (18%)",
          "amount":1000
        },
        {
          "_id":"602fd5473f1edd6264e41080",
          "name":"other VAT",
          "amount":500
        }
      ],
      "amount":1000,
      "description":"At vero eos et accusam et justo duo dolores",
      "transaction":"602fd5463f1edd6264e4107c",
      "__v":0
    }
  },
  "message":"statut de la transaction"
}
```



# Running Tests
To run tests just setup the API configuration environment variables. An internet connection is required for some of the tests to pass.

## License
MIT