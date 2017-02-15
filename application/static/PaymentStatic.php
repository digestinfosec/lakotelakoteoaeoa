<?php

class PaymentStatic
{
    const PAYMENT_METHOD_BANK = 1;
    const PAYMENT_METHOD_PAYPAL = 2;

    private static $model_rules = [
        'add' => [
            [
                'field' => 'user_id',
                'label' => 'Student',
                'rules' => 'required'
            ],
            [
                'field' => 'receipt_code',
                'label' => 'Receipt Code',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
        ],
        'edit' => [
            [
                'field' => 'bank_destination_name',
                'label' => 'Bank Tujuan',
                'rules' => 'required'
            ],
            [
                'field' => 'bank_name',
                'label' => 'Bank Anda',
                'rules' => 'required'
            ],
            [
                'field' => 'bank_account_name',
                'label' => 'Rekening atas nama',
                'rules' => 'required'
            ],
            [
                'field' => 'amount',
                'label' => 'amount',
                'rules' => 'required|integer'
            ]
        ]
    ];

    public static function get_rule($action, $param = array())
    {
        switch ($action) {
            default :
                $rule = self::$model_rules[$action];
        }

        return $rule;
    }
}
