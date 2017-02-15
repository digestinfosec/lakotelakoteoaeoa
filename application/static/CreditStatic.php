<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CreditStatic
{
    const REASON_TEACHER_CANCELLED = "teacher_cancel";
    const REASON_STUDENT_CANCELLED = "student_cancel";
    const REASON_CLASS_DELETED = "class_delete";
    const REASON_NOT_ATTENDING = "not_attending";

    const HISTORY_CANCELLATION_TEACHER = "cancellation_by_teacher";
    const HISTORY_CANCELLATION_STUDENT = "cancellation_by_student";
    const HISTORY_NOT_ATTENDING_CLASSES = "not_attending";
    const HISTORY_PAYMENT = "used_for_payment";
    const HISTORY_EXPIRED = "credit_expired";

    private static $model_rules = [
//        'add' => [
//            [
//                'field' => 'entity',
//                'label' => 'Entity',
//                'rules' => 'required'
//            ],
//            [
//                'field' => 'entity_id',
//                'label' => 'Entity ID',
//                'rules' => 'required|integer'
//            ],
//            [
//                'field' => 'filename',
//                'label' => 'Filename',
//                'rules' => 'required'
//            ]
//        ]
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
