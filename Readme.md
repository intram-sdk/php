# INTRAM PHP SDK


Bibliothèque [PHP](https://www.php.net) for [INTRAM (intram.com)](https://intram.com).

Construit sur l'API HTTP INTRAM (bêta).

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
              +"status": "PENDING"
              +"transaction_id": "5f2d7a96b97d9d3fea912c11"
              +"receipt_url": "localhost:3000/payment/gate/5f2d7a96b97d9d3fea912c11"
              +"total_amount": 1000
              +"message": "Transaction created successfully"
              +"error": false
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
  +"error": false
  +"status": "PENDING"
  +"transaction": {
    +"_status": "PENDING"
    +"_channels": []
    +"_created_at": "2020-09-15T14:56:10.316Z"
    +"_id": "5f60d7a0573bc71854bf095e"
    +"_type": "DEBIT"
    +"marchand": {
      +"_statut": true
      +"_state_id": "5f31a47a38111e135ae7b7f3"
      +"_valide": true
      +"_settingtransaction": array:2 [▼
        0 => "5f2fbca2c5e9d61f980574ff"
        1 => "5f31aab338111e135ae7b7fb"
      ]
      +"_env": "sandbox"
      +"_created_at": "2020-07-23T10:01:42.667Z"
      +"_id": "5f19604cd7e0114103d4ced3"
      +"_user_id": "5f195d842860e81da7d82f3a"
      +"__v": 0
      +"_base_url_site_web": "www.afarath.com"
      +"_company": "AraTech"
      +"_email": "fath@aratech.com"
      +"_web_site": "www.afarath.com"
      +"_template": array:2 [
        0 => "5f3577573ac8c46963470639"
        1 => "5f35773e3ac8c46963470637"
      ]
    }
    +"_store": {
      +"name": "Sodjinnin Store"
      +"postal_adress": "BP 35"
      +"logo_url": "https://www.google.com/webhp?hl=fr&sa=X&ved=0ahUKEwi7kZ3Qpt_qAhWxC2MBHVFZDDgQPAgH"
      +"web_site_url": "https://www.random.org/"
      +"phone": "94784784"
      +"template": "default"
    }
    +"_reference": "SaCsEhzMFc"
    +"_amount": 1000
    +"_country_code": "BJ"
    +"_qrcode": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHQAAAB0CAYAAABUmhYnAAAAAklEQVR4AewaftIAAAL9SURBVO3BQQ7jCAhFwZcvi6NyKI7KgkyWrCxZdtLdDFWv9wdrDLFGEWsUsUYRaxSxRhFrFL ▶"
    +"__v": 0
    +"invoice": {
      +"custom_datas": []
      +"_created_at": "2020-09-15T14:56:10.335Z"
      +"_id": "5f60d7a0573bc71854bf095f"
      +"currency": "XOF"
      +"items": array:1 [
        0 => {
          +"_id": "5f60d7a0573bc71854bf0960"
          +"name": "short"
          +"price": 500
        }
      ]
      +"taxes": array:1 [
        0 => {
          +"_id": "5f60d7a0573bc71854bf0961"
          +"name": "tva"
          +"amount": 100
        }
      ]
      +"amount": 1000
      +"description": "At vero eos et accusam et justo duo dolores"
      +"transaction": "5f60d7a0573bc71854bf095e"
      +"__v": 0
    }
  }
  +"message": "statut de la transaction"
}
```



# Running Tests
To run tests just setup the API configuration environment variables. An internet connection is required for some of the tests to pass.

## License
MIT