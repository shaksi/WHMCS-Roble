<?php

/**
 * WHMCS Sample Merchant Gateway Module
 *
 * This sample file demonstrates how a merchant gateway module supporting
 * 3D Secure Authentication, Captures and Refunds can be structured.
 *
 * If your merchant gateway does not support 3D Secure Authentication, you can
 * simply omit that function and the callback file from your own module.
 *
 * Within the module itself, all functions must be prefixed with the module
 * filename, followed by an underscore, and then the function name. For this
 * example file, the filename is "bixigateway" and therefore all functions
 * begin "bixigateway_".
 *
 * For more information, please refer to the online documentation.
 *
 * @see https://developers.whmcs.com/payment-gateways/
 *
 * @copyright Copyright (c) WHMCS Limited 2019
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related capabilities and
 * settings.
 *
 * @see https://developers.whmcs.com/payment-gateways/meta-data-params/
 *
 * @return array
 */
function bixigateway_MetaData()
{
    return array(
        'DisplayName' => 'Bixi',
        'APIVersion' => '1.1', // Use API Version 1.1
        'DisableLocalCreditCardInput' => true,
        'TokenisedStorage' => false,
    );
}

/**
 * Define gateway configuration options.
 *
 * The fields you define here determine the configuration options that are
 * presented to administrator users when activating and configuring your
 * payment gateway module for use.
 *
 * Supported field types include:
 * * text
 * * password
 * * yesno
 * * dropdown
 * * radio
 * * textarea
 *
 * Examples of each field type and their possible configuration parameters are
 * provided in the sample function below.
 *
 * @see https://developers.whmcs.com/payment-gateways/configuration/
 *
 * @return array
 */
function bixigateway_config()
{
    return array(
        // the friendly display name for a payment gateway should be
        // defined here for backwards compatibility
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Bixi',
        ),
        // a text field type allows for single line text input
        'companyID' => array(
            'FriendlyName' => 'Company ID',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your company ID here',
        ),

        // a password field type allows for masked text input
        'apiKey' => array(
            'FriendlyName' => 'Api Key',
            'Type' => 'password',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter Bixi Api Key',
        ),
        // the yesno field type displays a single checkbox option
        'testMode' => array(
            'FriendlyName' => 'Test Mode',
            'Type' => 'yesno',
            'Description' => 'Tick to enable test mode',
        ),
        // // the dropdown field type renders a select menu of options
        // 'dropdownField' => array(
        //     'FriendlyName' => 'Dropdown Field',
        //     'Type' => 'dropdown',
        //     'Options' => array(
        //         'option1' => 'Display Value 1',
        //         'option2' => 'Second Option',
        //         'option3' => 'Another Option',
        //     ),
        //     'Description' => 'Choose one',
        // ),
        // // the radio field type displays a series of radio button options
        // 'radioField' => array(
        //     'FriendlyName' => 'Radio Field',
        //     'Type' => 'radio',
        //     'Options' => 'First Option,Second Option,Third Option',
        //     'Description' => 'Choose your option!',
        // ),
        // // the textarea field type allows for multi-line text input
        // 'textareaField' => array(
        //     'FriendlyName' => 'Textarea Field',
        //     'Type' => 'textarea',
        //     'Rows' => '3',
        //     'Cols' => '60',
        //     'Description' => 'Freeform multi-line text input field',
        // ),
    );
}


// /**
//  * Capture payment.
//  *
//  * Called when a payment is to be processed and captured.
//  *
//  * The card cvv number will only be present for the initial card holder present
//  * transactions. Automated recurring capture attempts will not provide it.
//  *
//  * @param array $params Payment Gateway Module Parameters
//  *
//  * @see https://developers.whmcs.com/payment-gateways/merchant-gateway/
//  *
//  * @return array Transaction response status
//  */
// function bixigateway_capture($params)
// {
//     // Gateway Configuration Parameters
//     $companyID = $params['companyID'];
//     $apiKey = $params['apiKey'];
//     $testMode = $params['testMode'];
//     // $dropdownField = $params['dropdownField'];
//     // $radioField = $params['radioField'];
//     // $textareaField = $params['textareaField'];

//     // Invoice Parameters
//     $invoiceId = $params['invoiceid'];
//     $description = $params["description"];
//     $amount = $params['amount'];
//     $currencyCode = $params['currency'];

//     // Credit Card Parameters
//     $cardType = $params['cardtype'];
//     $cardNumber = $params['cardnum'];
//     $cardExpiry = $params['cardexp'];
//     $cardStart = $params['cardstart'];
//     $cardIssueNumber = $params['cardissuenum'];
//     $cardCvv = $params['cccvv'];

//     // Client Parameters
//     $firstname = $params['clientdetails']['firstname'];
//     $lastname = $params['clientdetails']['lastname'];
//     $email = $params['clientdetails']['email'];
//     $address1 = $params['clientdetails']['address1'];
//     $address2 = $params['clientdetails']['address2'];
//     $city = $params['clientdetails']['city'];
//     $state = $params['clientdetails']['state'];
//     $postcode = $params['clientdetails']['postcode'];
//     $country = $params['clientdetails']['country'];
//     $phone = $params['clientdetails']['phonenumber'];

//     // System Parameters
//     $companyName = $params['companyname'];
//     $systemUrl = $params['systemurl'];
//     $returnUrl = $params['returnurl'];
//     $langPayNow = $params['langpaynow'];
//     $moduleDisplayName = $params['name'];
//     $moduleName = $params['paymentmethod'];
//     $whmcsVersion = $params['whmcsVersion'];

//     //api post fields
//     $fields = [
//         "number"=>$phone,
//         "amount"=>$amount,
//         "companyId"=>$companyID,
//         "invoiceId"=> $invoiceId,
//         "description"=> $description
//     ];
//     // perform API call to capture payment and interpret result
//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//         CURLOPT_URL => 'https://api.bixi.so/api/1.0/evc/request',
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => '',
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 0,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => 'POST',
//         CURLOPT_POSTFIELDS => $fields,
//         CURLOPT_HTTPHEADER => array(
//             'Content-Type: application/json',
//             'Authorization: Bearer '.$apiKey,
//         ),
//     ));

//     $responseData = curl_exec($curl);
//     curl_close($curl);
//     if ($responseData->success == 1) {
//         $returnData = [
//             // 'success' if successful, otherwise 'declined', 'error' for failure
//             'status' => 'success',
//             // Data to be recorded in the gateway log - can be a string or array
//             'rawdata' => $responseData,
//             // Unique Transaction ID for the capture transaction
//             'transid' => $responseData['data']['id'],
//             // Optional fee amount for the fee value refunded
//             // 'fee' => $feeAmount,
//         ];
//     } else {
//         $returnData = [
//             // 'success' if successful, otherwise 'declined', 'error' for failure
//             'status' => 'declined',
//             // When not successful, a specific decline reason can be logged in the Transaction History
//             'declinereason' => $responseData['message'].': '.$responseData['data'],
//             // Data to be recorded in the gateway log - can be a string or array
//             'rawdata' => $responseData,
//         ];
//     }

//     return $returnData;
// }

function bixigateway_link($params)
{
    // Gateway Configuration Parameters
    $companyID = $params['companyID'];
    $apiKey = $params['apiKey'];
    $testMode = $params['testMode'];
    // $dropdownField = $params['dropdownField'];
    // $radioField = $params['radioField'];
    // $textareaField = $params['textareaField'];

    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $description = $params["description"];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];

    // Client Parameters
    $firstname = $params['clientdetails']['firstname'];
    $lastname = $params['clientdetails']['lastname'];
    $email = $params['clientdetails']['email'];
    $address1 = $params['clientdetails']['address1'];
    $address2 = $params['clientdetails']['address2'];
    $city = $params['clientdetails']['city'];
    $state = $params['clientdetails']['state'];
    $postcode = $params['clientdetails']['postcode'];
    $country = $params['clientdetails']['country'];
    $phone = $params['clientdetails']['phonenumber'];

    // System Parameters
    $companyName = $params['companyname'];
    $systemUrl = $params['systemurl'];
    $returnUrl = $params['returnurl'];
    $langPayNow = $params['langpaynow'];
    $moduleDisplayName = $params['name'];
    $moduleName = $params['paymentmethod'];
    $whmcsVersion = $params['whmcsVersion'];

    $url = 'https://api.bixi.so/api/1.0/gateway';

    $postfields = array();

    $postfields['amount'] = $amount;
    $postfields['companyId'] = $companyID;
    $postfields['testMode'] = $testMode;
    $postfields['invoice_id'] = $invoiceId;
    $postfields['description'] = $description;
    $postfields['amount'] = $amount;
    $postfields['currency'] = $currencyCode;
    $postfields['first_name'] = $firstname;
    $postfields['last_name'] = $lastname;
    $postfields['email'] = $email;
    $postfields['address1'] = $address1;
    $postfields['address2'] = $address2;
    $postfields['city'] = $city;
    $postfields['state'] = $state;
    $postfields['postcode'] = $postcode;
    $postfields['country'] = $country;
    $postfields['phone'] = $phone;
    $postfields['callback_url'] = rtrim($systemUrl) . '/modules/gateways/callback/' . $moduleName . '.php';
    $postfields['return_url'] = $returnUrl;

    $htmlOutput = '<form method="post" action="' . $url . '">';
    foreach ($postfields as $k => $v) {
        $htmlOutput .= '<input type="hidden" name="' . $k . '" value="' . urlencode($v) . '" />';
    }
    $htmlOutput .= '<input type="submit" value="' . $langPayNow . '" />';
    $htmlOutput .= '</form>';

    return $htmlOutput;
}


// /**
//  * Refund transaction.
//  *
//  * Called when a refund is requested for a previously successful transaction.
//  *
//  * @param array $params Payment Gateway Module Parameters
//  *
//  * @see https://developers.whmcs.com/payment-gateways/refunds/
//  *
//  * @return array Transaction response status
//  */
// function bixigateway_refund($params)
// {
//     // Gateway Configuration Parameters
//     $accountId = $params['accountID'];
//     $secretKey = $params['secretKey'];
//     $testMode = $params['testMode'];
//     $dropdownField = $params['dropdownField'];
//     $radioField = $params['radioField'];
//     $textareaField = $params['textareaField'];

//     // Transaction Parameters
//     $transactionIdToRefund = $params['transid'];
//     $refundAmount = $params['amount'];
//     $currencyCode = $params['currency'];

//     // Client Parameters
//     $firstname = $params['clientdetails']['firstname'];
//     $lastname = $params['clientdetails']['lastname'];
//     $email = $params['clientdetails']['email'];
//     $address1 = $params['clientdetails']['address1'];
//     $address2 = $params['clientdetails']['address2'];
//     $city = $params['clientdetails']['city'];
//     $state = $params['clientdetails']['state'];
//     $postcode = $params['clientdetails']['postcode'];
//     $country = $params['clientdetails']['country'];
//     $phone = $params['clientdetails']['phonenumber'];

//     // System Parameters
//     $companyName = $params['companyname'];
//     $systemUrl = $params['systemurl'];
//     $langPayNow = $params['langpaynow'];
//     $moduleDisplayName = $params['name'];
//     $moduleName = $params['paymentmethod'];
//     $whmcsVersion = $params['whmcsVersion'];

//     // perform API call to initiate refund and interpret result

//     return array(
//         // 'success' if successful, otherwise 'declined', 'error' for failure
//         'status' => 'success',
//         // Data to be recorded in the gateway log - can be a string or array
//         'rawdata' => $responseData,
//         // Unique Transaction ID for the refund transaction
//         'transid' => $refundTransactionId,
//         // Optional fee amount for the fee value refunded
//         'fee' => $feeAmount,
//     );
// }
