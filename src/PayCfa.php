<?php
/**
 * Created by PhpStorm.
 * User: sodjinnin
 * Date: 21/07/20
 * Time: 13:47
 */


namespace intram\PayCfa;

class PayCfa
{
    // Public Api key
    private static $public_key;

    // Account Private Key
    private static $private_key;

    // Account Secret
    private static $secret_key;

    // Account Marchand
    private static $marchand_key;


    private static $sandbox;

    private static $curl;

    private static $const;

    private static $redirectionUrl;
    private static $items;
    private static $amount;
    private static $devise;
    private static $cancelUrl;
    private static $returnUrl;
    private static $generateUrl;
    private static $tva;
    private static $description;
    private static $nameStore;
    private static $postalAdressStore;
    private static $phoneStore;
    private static $logoUrlStore;
    private static $webSiteUrlStore;
    private static $header;
    private static $keys;
    private static $currency;
    private static $template;
    private static $customData;

    private static $BASE_URL = "https://webservices.intram.org:4002/api/v1/";
    private static $BASE_URLSANBOX = "https://webservices.intram.org:4002/api/v1/";
    private static $verify_URL = "transactions/confirm/";
    private static $Payout_URL = "payments/request";


    /**
     * PayCfa constructor.
     * @param $public_key
     * @param $private_key
     * @param $secret
     * @param $sandbox
     */
    public function __construct()
    {
    }

    public static function getTransactionVerify($transactionId)
    {

        $reponse = null;

        if (
            !isset($transactionId) ||
            self::getPrivateKey() == null ||
            self::getPublicKey() == null ||
            self::getSecretKey() == null
        ) {
            $response = json_encode(array(
                "error" => true,
                "message" => "Rassurez-vous de passer les arguments
                suivants : 'transactionId','public_key',
                'private_key','secret'"));;
            return $response;
        }


        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => self::getConst() . self::getVerifyURL() . "" . $transactionId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY:" . self::getPublicKey(),
                    "X-PRIVATE-KEY: " . self::getPrivateKey(),
                    "X-SECRET-KEY:" . self::getSecretKey(),
                    "X-MARCHAND-KEY: " . self::getMarchandKey(),
                    'Content-Type: Application/json'
                ]
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                $response = json_encode(array("error" => true, "message" => $err));;
            }

        } catch (\Exception $e) {
            $response = json_encode(array("error" => true));
        }
        return $response;

    }


    public static function setRequestPayment()
    {

        $reponse = null;

        if (
            self::getCurrency() == null ||
            self::getItems() == null ||
            self::getAmount() == null ||
            self::getNameStore() == null ||
            self::getTemplate() == null ||
            self::getPrivateKey() == null ||
            self::getPublicKey() == null ||
            self::getSecretKey() == null
        ) {
            $response = json_encode(array(
                "error" => true,
                "message" => "Rassurez vous de passer les arguments suivants : 'currency','items','amount','nameStore', 'template','public key', 'private key','secret key'"));;
            return $response;
        }


        try {

            $invoice = null;
            $actions = null;
            $store = null;
            $invoice = [
                "keys" => [
                    'public' => self::getPublicKey(),
                    'private' => self::getPrivateKey(),
                    'secret' => self::getSecretKey(),
                ],
                "currency" => self::getCurrency(),
                "items" => self::getItems(),
                "taxes" => self::getTva(),
                "amount" => self::getAmount(),
                "description" => self::getDescription(),
                "custom_datas" => self::getCustomData()
            ];
            $actions = [
                "cancel_url" => self::getCancelUrl(),
                "return_url" => self::getReturnUrl(),
                "callback_url" => self::getRedirectionUrl()
            ];

            $store = [
                "name" => self::getNameStore(),
                "postal_adress" => self::getPostalAdressStore(),
                "logo_url" => self::getLogoUrlStore(),
                "web_site_url" => self::getWebSiteUrlStore(),
                "phone" => self::getPhoneStore(),
                "template" => self::getTemplate()
            ];


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => self::getConst() . self::getPayoutURL(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(["invoice" => $invoice, "store" => $store, "actions" => $actions]),
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY:" . self::getPublicKey(),
                    "X-PRIVATE-KEY: " . self::getPrivateKey(),
                    "X-SECRET-KEY:" . self::getSecretKey(),
                    "X-MARCHAND-KEY: " . self::getMarchandKey(),
                    'Content-Type: Application/json'
                ]
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $response = json_encode(array("error" => true, "message" => $err));;
            }

        } catch (\Exception $e) {
            $response = json_encode(array("error" => true, "message" => $e->getMessage()));
        }
        return $response;
    }


    /**
     * @return mixed
     */
    public static function getCurrency()
    {
        return self::$currency;
    }

    /**
     * @param mixed $currency
     */
    public static function setCurrency($currency)
    {
        self::$currency = $currency;
    }


    /**
     * @return null
     */
    public static function getDescription()
    {
        return self::$description;
    }

    /**
     * @param null $description
     */
    public static function setDescription($description)
    {
        self::$description = $description;
    }


    /**
     * @return mixed
     */
    public static function getPublicKey()
    {
        return self::$public_key;
    }

    /**
     * @param mixed $public_key
     */
    public static function setPublicKey($public_key)
    {
        self::$public_key = $public_key;
    }

    /**
     * @return mixed
     */
    public static function getPrivateKey()
    {
        return self::$private_key;
    }

    /**
     * @param mixed $private_key
     */
    public static function setPrivateKey($private_key)
    {
        self::$private_key = $private_key;
    }

    /**
     * @return mixed
     */
    public static function getSecretKey()
    {
        return self::$secret_key;
    }

    /**
     * @param mixed $secret
     */
    public static function setSecretKey($secret)
    {
        self::$secret_key = $secret;
    }

    /**
     * @return mixed
     */
    public static function getSandbox()
    {

        return self::$sandbox;
    }

    /**
     * @param mixed $sandbox
     */
    public static function setSandbox($sandbox)
    {
        self::$sandbox = $sandbox;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public static function getCurl()
    {
        return self::$curl;
    }

    /**
     * @param \GuzzleHttp\Client $curl
     */
    public static function setCurl($curl)
    {
        self::$curl = $curl;
    }

    /**
     * @return string
     */
    public static function getConst()
    {
        return !self::getSandbox() ? self::getBASEURL() : self::getBASEURLSANBOX();
    }

    /**
     * @param string $const
     */
    public static function setConst($const)
    {
        self::$const = $const;
    }

    /**
     * @return mixed
     */
    public static function getRedirectionUrl()
    {
        return self::$redirectionUrl;
    }

    /**
     * @param mixed $redirectionUrl
     */
    public static function setRedirectionUrl($redirectionUrl)
    {
        self::$redirectionUrl = $redirectionUrl;
    }

    /**
     * @return mixed
     */
    public static function getItems()
    {
        return self::$items;
    }

    /**
     * @param mixed $items
     */
    public static function setItems($items)
    {
        self::$items = $items;
    }

    /**
     * @return mixed
     */
    public static function getAmount()
    {
        return self::$amount;
    }

    /**
     * @param mixed $amount
     */
    public static function setAmount($amount)
    {
        self::$amount = $amount;
    }

    /**
     * @return mixed
     */
    public static function getDevise()
    {
        return self::$devise;
    }

    /**
     * @param mixed $devise
     */
    public static function setDevise($devise)
    {
        self::$devise = $devise;
    }

    /**
     * @return mixed
     */
    public static function getCancelUrl()
    {
        return self::$cancelUrl;
    }

    /**
     * @param mixed $cancelUrl
     */
    public static function setCancelUrl($cancelUrl)
    {
        self::$cancelUrl = $cancelUrl;
    }

    /**
     * @return mixed
     */
    public static function getReturnUrl()
    {
        return self::$returnUrl;
    }

    /**
     * @param mixed $returnUrl
     */
    public static function setReturnUrl($returnUrl)
    {
        self::$returnUrl = $returnUrl;
    }

    /**
     * @return mixed
     */
    public static function getGenerateUrl()
    {
        return self::$generateUrl;
    }

    /**
     * @param mixed $generateUrl
     */
    public static function setGenerateUrl($generateUrl)
    {
        self::$generateUrl = $generateUrl;
    }

    /**
     * @return null
     */
    public static function getNameStore()
    {
        return self::$nameStore;
    }

    /**
     * @param null $nameStore
     */
    public static function setNameStore($nameStore)
    {
        self::$nameStore = $nameStore;
    }

    /**
     * @return mixed
     */
    public static function getPostalAdressStore()
    {
        return self::$postalAdressStore;
    }

    /**
     * @param mixed $postalAdressStore
     */
    public static function setPostalAdressStore($postalAdressStore)
    {
        self::$postalAdressStore = $postalAdressStore;
    }

    /**
     * @return null
     */
    public static function getPhoneStore()
    {
        return self::$phoneStore;
    }

    /**
     * @param null $phoneStore
     */
    public static function setPhoneStore($phoneStore)
    {
        self::$phoneStore = $phoneStore;
    }

    /**
     * @return null
     */
    public static function getLogoUrlStore()
    {
        return self::$logoUrlStore;
    }

    /**
     * @param null $logoUrlStore
     */
    public static function setLogoUrlStore($logoUrlStore)
    {
        self::$logoUrlStore = $logoUrlStore;
    }

    /**
     * @return null
     */
    public static function getWebSiteUrlStore()
    {
        return self::$webSiteUrlStore;
    }

    /**
     * @param null $webSiteUrlStore
     */
    public static function setWebSiteUrlStore($webSiteUrlStore)
    {
        self::$webSiteUrlStore = $webSiteUrlStore;
    }

    /**
     * @return mixed
     */
    public static function getTemplate()
    {
        return self::$template;
    }

    /**
     * @param mixed $template
     */
    public static function setTemplate($template)
    {
        self::$template = $template;
    }

    /**
     * @return mixed
     */
    public static function getCustomData()
    {
        return self::$customData;
    }

    /**
     * @param mixed $customData
     */
    public static function setCustomData($customData)
    {
        self::$customData = $customData;
    }

    /**
     * @return array
     */
    public static function getTva()
    {
        return self::$tva;
    }

    /**
     * @param array $tva
     */
    public static function setTva($tva)
    {
        self::$tva = $tva;
    }

    /**
     * @return mixed
     */
    public static function getMarchandKey()
    {
        return self::$marchand_key;
    }

    /**
     * @param mixed $marchand_id
     */
    public static function setMarchandKey($marchand_key): void
    {
        self::$marchand_key = $marchand_key;
    }


    /**
     * @return string
     */
    public static function getBASEURL(): string
    {
        return self::$BASE_URL;
    }

    /**
     * @param string $BASE_URL
     */
    public static function setBASEURL(string $BASE_URL): void
    {
        self::$BASE_URL = $BASE_URL;
    }

    /**
     * @return string
     */
    public static function getBASEURLSANBOX(): string
    {
        return self::$BASE_URLSANBOX;
    }

    /**
     * @param string $BASE_URLSANBOX
     */
    public static function setBASEURLSANBOX(string $BASE_URLSANBOX): void
    {
        self::$BASE_URLSANBOX = $BASE_URLSANBOX;
    }

    /**
     * @return string
     */
    public static function getVerifyURL(): string
    {
        return self::$verify_URL;
    }

    /**
     * @param string $verify_URL
     */
    public static function setVerifyURL(string $verify_URL): void
    {
        self::$verify_URL = $verify_URL;
    }

    /**
     * @return string
     */
    public static function getPayoutURL(): string
    {
        return self::$Payout_URL;
    }

    /**
     * @param string $Payout_URL
     */
    public static function setPayoutURL(string $Payout_URL): void
    {
        self::$Payout_URL = $Payout_URL;
    }


}
