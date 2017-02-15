<?php

class OrderStatic
{
    const ORDER_WAIT_FOR_PAYMENT = 0;
    const ORDER_WAIT_FOR_CONFIRMATION = 1;
    const ORDER_PAYMENT_CONFIRMED = 2;
    const ORDER_SUCCESS = 3;
    const ORDER_CANCEL = 4;
    const ORDER_ERROR = 5;

    const ORDER_STATUS_HASH =
    [
        self::ORDER_WAIT_FOR_PAYMENT => "Wait for Payment",
        self::ORDER_WAIT_FOR_CONFIRMATION => "Wait for Confirmation",
        self::ORDER_PAYMENT_CONFIRMED => "Payment Confirmed",
        self::ORDER_SUCCESS => "Paid",
        self::ORDER_CANCEL => "Order Cancel",
        self::ORDER_ERROR => "Order Error"
    ];

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
