<?php defined('BASEPATH') OR exit('No direct script access allowed');

// addresses

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// address_line1   longtext    No
// address_line2   longtext    Yes     NULL
// unit_number varchar(10) Yes     NULL
// postal_code varchar(10) No
// city    varchar(255)    No
// state   varchar(255)    No
// country varchar(255)    No
// name    varchar(100)    Yes     NULL
// latitude    varchar(100)    Yes     NULL
// longitude   varchar(100)    Yes     NULL
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class AddressStatic
{
    const CODE = [
        'singapore' => 'SGP',
        'jakarta' => 'JKT',
        'yogyakarta' => 'YGK',
        'bali' => 'BAL',
        'surabaya' => 'SBY',
        'semarang' => 'SMG',
        'bandung' => 'BDG'
    ];
    private static $model_rules = [
        'add' => [
            [
                'field' => 'address_line1',
                'label' => 'Address Line 1',
                'rules' => 'required'
            ],
            [
                'field' => 'postal_code',
                'label' => 'Postal Code',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'city',
                'label' => 'City',
                'rules' => 'required'
            ],
            [
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required'
            ],
            [
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'required'
            ],
            // [
            //     'field' => 'name',
            //     'label' => 'Name',
            //     'rules' => 'required'
            // ],
            [
                'field' => 'unit_number',
                'label' => 'Unit Number',
                'rules' => 'integer'
            ]
        ],
        'edit' => [
            [
                'field' => 'postal_code',
                'label' => 'Postal Code',
                'rules' => 'integer'
            ],
            [
                'field' => 'unit_number',
                'label' => 'Unit Number',
                'rules' => 'integer'
            ]
        ]

        // TODO: max_length for address_line1, address_line2, name;
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
