# INTRAM PHP SDK


Bibliothèque [PHP](https://www.php.net) pour [INTRAM (intram.com)](https://intram.com).

Construit sur l'API HTTP INTRAM (bêta).

## Génération de vos clés API
Les clés d'API sont vos références numériques auprès des systèmes d'Intram. 
Nous les utilisons afin d'identifier vos différents comptes marchands.
 Ces clés sont nécessaires pour toute intégration des APIs de paiements Intram. 
 Voici chronologiquement la marche à suivre :
 * [Créez](https://account.intram.org/register) et 
 valider (en faisant la configuration dans vos paramètres [Paramètre](https://account.intram.org/settings)) 
 votre compte Intram si ce n'est pas encore fait;
 * Connectez-vous à votre compte et cliquez sur Développeurs, ensuite 
 [Api](https://account.intram.org/developers/api) 
 au niveau du menu à gauche;
 * Choisissez le mode qui vous convient au niveau du menu à gauche, par défaut vous êtes en mode `TEST`, vous pouvez passer en mode `LIVE` quand vous voulez;
 

 
## Installation 

##### Installation via composer
Composer est un outil de gestion des dépendances en PHP.
 Il vous permet de déclarer les bibliothèques dont dépend votre 
 projet et il les gérera (installera / mettra à jour) pour vous.
 Dans notre cas, votre projet utilisera la bibliothèque d'Intram pour gérer
 les paiements, Intram est donc une dépendance de votre projet. Afin d'avoir plus
 de détail, vous pouvez consulter [le site officiel de composer](https://getcomposer.org/). 
```sh
composer require intram-sdk/php
```

##### Installation manuelle
[Cliquez ici](https://github.com/intram-sdk/php) pour télécharger la dernière version de notre client PHP. Ensuite décompressez le fichier puis copiez le contenu dans un emplacement du dossier contenant le code source de votre application.


## API configuration
Dans votre espace de travail Intram, récupérez différentes clés API.

##### Cas d'une installation manuelle
###### Prérequis
Vous pouvez créer un fichier de configuration globale contenant les paramètres ci-dessous et l'inclure par la suite dans chacun de vos fichiers nécessitant de faire appel à l'API. Pensez premièrement à inclure le client PHP de Intram au niveau du fichier de configuration globale.
```sh
require('chemin_vers_le_dossier_du_client_php_intram/PayCfa.php');
```

###### Configuration
En utilisant vos différents clés obtenues sur votre tableau de board, initialiser Intram PayCfa.
Le mode est `true` pour le mode test et `false` pour le mode live.
```php
\intram\PayCfa\PayCfa::setPublicKey("02ce7648a3688f1077b8d4a9607c9f3a2bc169d3f490e7815ce9121f19cef98a");
\intram\PayCfa\PayCfa::setPrivateKey("tpk_6b0a542e36fdbdce9024412e5d75943136ee25edcaaa2abc3fac0d589cea53ca");
\intram\PayCfa\PayCfa::setSecretKey("tsk_266e9e7946e9be2becfc8f727312fadb0fcfba89a6fe7e3a1ef0571836549bea");
\intram\PayCfa\PayCfa::setMarchandKey("601bbe97cc481829fa1237fd");
\intram\PayCfa\PayCfa::setSandbox(true);
```

##### Cas d'une installation via composer
###### Prérequis
Il vous suffit d'inclure le fichier vendor/autoload.php
 ```sh
require('vendor/autoload.php');
```
###### Configuration
En utilisant vos différents clés obtenues sur votre tableau de board, initialiser Intram PayCfa.
Le mode est `true` pour le mode test et `false` pour le mode live.
```php
 PayCfa::setPublicKey("02ce7648a3688f1077b8d4a9607c9f3a2bc169d3f490e7815ce9121f19cef98a");
 PayCfa::setPrivateKey("tpk_6b0a542e36fdbdce9024412e5d75943136ee25edcaaa2abc3fac0d589cea53ca");
 PayCfa::setSecret("tsk_266e9e7946e9be2becfc8f727312fadb0fcfba89a6fe7e3a1ef0571836549bea");
 PayCfa::setMarchandId("601bbe97cc481829fa1237fd");
 PayCfa::setSandbox(true);
```



## Configurez les informations de votre service / entreprise
Vous pouvez configurer les informsetTemplateations de votre service / entreprise comme illustré ci-dessous. 
Intram utilise ces paramètres afin de configurer les informations qui s'afficheront sur la page de paiement, 
les factures PDF et les reçus imprimés.
Vous pouvez inclure également ces informations au niveau du fichier de configuration globale.

##### Cas d'une installation manuelle
```php
\intram\PayCfa\PayCfa::setNameStore("JShop"); //nom de la boutique
\intram\PayCfa\PayCfa::setPostalAdressStore("BP 35"); // l'adresse postale 
\intram\PayCfa\PayCfa::setLogoUrlStore("https://jshop.com/logo.png"); //l'URL du logo de la boutique
\intram\PayCfa\PayCfa::setWebSiteUrlStore("https://jshop.com"); //site Web de la boutique
\intram\PayCfa\PayCfa::setPhoneStore("97000000");  // numéro de téléphone 
```

##### Cas d'une installation via composer
```php
PayCfa::setNameStore("JShop");  //nom de la boutique (obligatoire)
PayCfa::setPostalAdressStore("BP 35"); // l'adresse postale 
PayCfa::setLogoUrlStore("https://jshop.com/logo.png"); //l'URL du logo de la boutique
PayCfa::setWebSiteUrlStore("https://jshop.com"); //site Web de la boutique
PayCfa::setPhoneStore("97000000"); // numéro de téléphone 
```

##Créer une transaction de paiement
Afin de permettre à l'utilisateur d'effectuer un paiement sur votre boutique, 
vous devez créer la transaction puis retourner l'url de paiement ou le code qr à scanner.
Pour cela :
Ajouter les différents produits de l'achat (obligatoire)
##### Cas d'une installation manuelle
```php
\intram\PayCfa\PayCfa::setItems([
            ['name'=>"T-shirt",'qte'=>"2",'price'=>"500",'totalamount'=>"1000"],
            ['name'=>"trouser",'qte'=>"1",'price'=>"12500",'totalamount'=>"12500"],
        ]);
```
##### Cas d'une installation via composer 
```php
PayCfa::setItems([
            ['name'=>"T-shirt",'qte'=>"2",'price'=>"500",'totalamount'=>"1000"],
            ['name'=>"trouser",'qte'=>"1",'price'=>"12500",'totalamount'=>"12500"],
        ]);
```

Définir le montant total de la transaction
##### Cas d'une installation manuelle

```php
\intram\PayCfa\PayCfa::setAmount(13600);
```
##### Cas d'une installation via composer 

```php
PayCfa::setAmount(13600);
```

Définir la devise de paiement (obligatoire). Pour en savoir plus sur les différentes
devises intégrées par intram, vueillez consulter
 [la documentation](https://developer.intram.org/).
##### Cas d'une installation manuelle
```php
\intram\PayCfa\PayCfa::setCurrency("XOF");
```
##### Cas d'une installation via composer 
```php
PayCfa::setCurrency("XOF");
```

Définir le thème à utiliser sur votre portail de paiement  (obligatoire), pour avoir accès aux
différentes thème que vous pouvez utiliser consulter votre tableau de bord  cliquez sur
 Développeurs, ensuite  [Api](https://account.intram.org/developers/api) puis Template.
 Ajouter des templates gratuits et / ou payants à votre compte. A partir de ce moment,
 vous pouvez utiliser le code ce template dans la méthode ci-dessous. Au cas où vous voulez utiliser le
 thème par défaut d'intram, veuillez utiliser la valeur `default`. 

##### Cas d'une installation manuelle                                                            
```php
\intram\PayCfa\PayCfa::setTemplate("default");

```
##### Cas d'une installation via composer 
```php
PayCfa::setTemplate("default");

```


Ajouter une description de l'opération (obligatoire)
##### Cas d'une installation manuelle 
```php
\intram\PayCfa\PayCfa::setDescription("Pretty and suitable for your waterfall");
```
##### Cas d'une installation via composer 
```php
PayCfa::setDescription("Pretty and suitable for your waterfall");
```

Appliquer une TVA (optionnel)
##### Cas d'une installation manuelle 
```php
\intram\PayCfa\PayCfa::setTva([["name" => "VAT (18%)", "amount" => 1000],["name" => " other VAT", "amount" => 500]]);
```
##### Cas d'une installation via composer  
```php
PayCfa::setTva([["name" => "VAT (18%)", "amount" => 1000],["name" => " other VAT", "amount" => 500]]);
```


Ajouter de données personnalisées (optionnel)
##### Cas d'une installation manuelle 
```php
\intram\PayCfa\PayCfa::setCustomData([['CartID',"32393"],['PERIOD',"TABASKI"]]);
```
##### Cas d'une installation via composer 
```php
PayCfa::setCustomData([['CartID',"32393"],['PERIOD',"TABASKI"]]);
```
Définir l'URL de redirection de la boutique après paiement(optionnel)
##### Cas d'une installation manuelle 
```php
\intram\PayCfa\PayCfa::setRedirectionUrl("https://jshop.com/redirection-url");
```
##### Cas d'une installation via composer 
```php
PayCfa::setRedirectionUrl("https://jshop.com/redirection-url");
```
Définir l'URL de retour de votre site
(optionnel)
##### Cas d'une installation manuelle 
```php
\intram\PayCfa\PayCfa::setReturnUrl("https://jshop.com/return-url");
```

##### Cas d'une installation via composer 
```php
PayCfa::setReturnUrl("https://jshop.com/return-url");
```
Définir l'URL d'annulation de votre site
(optionnel)
```php
\intram\PayCfa\PayCfa::setCancelUrl("https://jshop.com/cancel-url");
```
Créer enfin la transaction pour permettre le paiement à l'utilisateur
(obligatoire)
##### Cas d'une installation manuelle 
```php
$response = json_decode(\intram\PayCfa\PayCfa::setRequestPayment());
```

##### Cas d'une installation via composer 
```php
$response = json_decode(PayCfa::setRequestPayment());
```


##### Réponse attendue

```json

{
  "status":"PENDING",
  "transaction_id":"602fd5463f1edd6264e4107c",
  "receipt_url":"https://account.intram.org/payment/gate/602fd5463f1edd6264e4107c",
  "total_amount":1000,
  "message":"Transaction created successfully",
  "error":false
}

```

##### Récupération des données
```php
$transaction_id = $response->transaction_id;
$status = $response->status;
$receipt_url = $response->receipt_url;
$total_amount = $response->total_amount;
$message = $response->message;
$error = $response->error;
```

### Vérifier les informations de la transaction
Passer l'identifiant de la transaction comme argument à la fonction (obligatoire)

##### Cas d'une installation manuelle 

```php
\intram\PayCfa\PayCfa::getTransactionVerify(5f2d7a96b97d9d3fea912c11); 
```
##### Cas d'une installation via composer 

Passer l'identifiant de la transaction comme
 argument à la fonction (obligatoire)
```php
PayCfa::getTransactionVerify(5f2d7a96b97d9d3fea912c11); 
```

##### Réponse attendue

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

## License
MIT