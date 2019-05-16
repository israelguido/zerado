<?php
/**
 * Created by PhpStorm.
 * User: israel
 * Date: 2019-03-22
 * Time: 15:06
 */

namespace Appstronaut\Braspag\Model;

class Braspag extends \Magento\Payment\Model\Method\Cc
{
    const CODE = 'appstronaut_braspag';

    protected $_code = self::CODE;

    protected $_canAuthorize = true;
    protected $_canCapture = true;


    /**
     * Capture Payment.
     *
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     */
    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        try {
            //check if payment has been authorized
            if (is_null($payment->getParentTransactionId())) {
                $this->authorize($payment, $amount);
            }

            //build array of payment data for API request.
            $request = [
                'capture_amount' => $amount,
                //any other fields, api key, etc.
            ];

            //make API request to credit card processor.
            $response = $this->makeCaptureRequest($request);

            //todo handle response

            //transaction is done.
            $payment->setIsTransactionClosed(1);
        } catch (\Exception $e) {
            $this->debug($payment->getData(), $e->getMessage());
        }

        return $this;
    }

    /**
     * Authorize a payment.
     *
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     */
    public function authorize(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        try {

            ///build array of payment data for API request.
            $request = [
                'cc_type' => $payment->getCcType(),
                'cc_exp_month' => $payment->getCcExpMonth(),
                'cc_exp_year' => $payment->getCcExpYear(),
                'cc_number' => $payment->getCcNumberEnc(),
                'amount' => $amount
            ];

            //check if payment has been authorized
            $response = $this->makeAuthRequest($request);
        } catch (\Exception $e) {
            $this->debug($payment->getData(), $e->getMessage());
        }

        if (isset($response['transactionID'])) {
            // Successful auth request.
            // Set the transaction id on the payment so the capture request knows auth has happened.
            $payment->setTransactionId($response['transactionID']);
            $payment->setParentTransactionId($response['transactionID']);
        }

        //processing is not done yet.
        $payment->setIsTransactionClosed(0);

        return $this;
    }

    /**
     * Set the payment action to authorize_and_capture
     *
     * @return string
     */
    public function getConfigPaymentAction()
    {
        return self::ACTION_AUTHORIZE_CAPTURE;
    }

    /**
     * Test method to handle an API call for authorization request.
     *
     * @param $request
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function makeAuthRequest($request)
    {
        $response = ['transactionId' => 123]; //todo implement API call for auth request.

        if (!$response) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Failed auth request.'));
        }

        return $response;
    }

    /**
     * Test method to handle an API call for capture request.
     *
     * @param $request
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function makeCaptureRequest($request)
    {
        //montar o objeto
        $params = "{  
   \"MerchantOrderId\":\"2017051002\",
   \"Customer\":{  
      \"Name\":\"Israel Guido\",
      \"Identity\":\"35564894812\",
      \"IdentityType\":\"CPF\",
      \"Email\":\"comprador@braspag.com.br\",
      \"Birthdate\":\"1991-01-02\",
      \"Address\":{  
         \"Street\":\"Alameda Xingu\",
         \"Number\":\"512\",
         \"Complement\":\"27 andar\",
         \"ZipCode\":\"12345987\",
         \"City\":\"São Paulo\",
         \"State\":\"SP\",
         \"Country\":\"BRA\",
         \"District\":\"Alphaville\"
      },
      \"DeliveryAddress\":{  
         \"Street\":\"Alameda Xingu\",
         \"Number\":\"512\",
         \"Complement\":\"27 andar\",
         \"ZipCode\":\"12345987\",
         \"City\":\"São Paulo\",
         \"State\":\"SP\",
         \"Country\":\"BRA\",
         \"District\":\"Alphaville\"
      }
   },
   \"Payment\":{  
      \"Provider\":\"Simulado\",
      \"Type\":\"CreditCard\",
      \"Amount\":10000,
      \"Currency\":\"BRL\",
      \"Country\":\"BRA\",
      \"Installments\":1,
      \"Interest\":\"ByMerchant\",
      \"Capture\":true,
      \"Authenticate\":false,
      \"Recurrent\":false,
      \"SoftDescriptor\":\"Mensagem\",
      \"DoSplit\":false,
      \"CreditCard\":{  
         \"CardNumber\":\"4551870000000181\",
         \"Holder\":\"Nome do Portador\",
         \"ExpirationDate\":\"12/2021\",
         \"SecurityCode\":\"123\",
         \"Brand\":\"Visa\",
         \"SaveCard\":\"false\",
         \"Alias\":\"\"
      },
      \"Credentials\":{  
         \"code\":\"9999999\",
         \"key\":\"D8888888\",
         \"password\":\"LOJA9999999\",
         \"username\":\"#Braspag2018@NOMEDALOJA#\",
         \"signature\":\"001\"
      },
      \"ExtraDataCollection\":[  
         {  
            \"Name\":\"NomeDoCampo\",
            \"Value\":\"ValorDoCampo\"
         }
      ]
   }
}";
        $requestData = $this->mountObject($params);


        //fazer a chada para o braspag

        //capturar a resposta do gateway
        $response = ['success']; //todo implement API call for capture request.

        if (!$response) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Failed capture request.'));
        }

        return $response;
    }

    public function mountObject($orderData)
    {
        return json_decode($orderData);
    }
}
