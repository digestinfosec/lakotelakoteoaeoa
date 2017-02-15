<?php defined('BASEPATH') OR exit('No direct script access allowed');

// schedules

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// venue_id    int(10) No      venues -> id
// class_id    int(10) No      classes -> id
// date    date    No
// start_time  time    No
// end_time    time    No
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class ScheduleStatic
{
    private static $model_rules = [
        'add' => [
            [
                'field' => 'venue_id',
                'label' => 'Venue ID',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'class_id',
                'label' => 'Class ID',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'date',
                'label' => 'Date',
                'rules' => ['required', 'date', 'callback_check_date_after_today'],
                'errors' => [
                    'check_date_after_today' => "Date must be set after today"
                ]
            ],
            [
                'field' => 'start_time',
                'label' => 'Start Time',
                'rules' => 'required|time'
            ],
            [
                'field' => 'end_time',
                'label' => 'End Time',
                'rules' => 'required|time'
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
