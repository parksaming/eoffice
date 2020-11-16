<?php

namespace App\Libs;

/**
 * Description of Constants
 */
class Constants {
    /**
     * isAbsence
     */
    public static $isAbsence = [
        'present'                 => 0,

    ];
    /**
     *
     *
     * Max working time (minute)
     */
    public static $max_working_time = 430;

    /**
     * user role
     */
    public static $user_role = [
        'admin'                 => 1,
        'client'                => 2,
        'super_admin'           => 3
    ];
    
    /**
     * user type
     */
    public static $user_type = [
        'quan_ly'               => 1,
        'cong_nhan'             => 2
    ];
    
    /**
     * request type
     */
    public static $type_request = [
        'add'                => 1,
        'return'             => 2
    ];
    
    /**
     * line type
     */
    public static $role = [
        'Administrator' => 1,
        'Redactor'   => 2
    ];
    
    /**
     * status using
     */
    public static $status_using = [
        'not_using'             => 0,
        'is_using'              => 1,
        'deleted'               => 2
    ];

    /**
     * status
     */
    public static $status = [
        'deactive'              => 0,
        'active'                => 1,
        'deleted'               => 2,
        'rest'                => 3
    ];
    public static $clients = [
        'deleted'               => ''
    ];

    /**
     * dailylot
     */
    public static $dailylot = [
        'pick_up'                => 0,
        'pick_uped'              => 1,
        'pass'                   => 2,
        'fail'                   => 3,
        'trans_to_stock'         => 4,
        'trans_to_line_sorting'  => 5,
        'retrans_to_oqc'         => 6,
    ];


    /**
     * status plan
     */
    public static $status_plan = [
        'disapproved'               => 0,
        'approved'                  => 1,
        'denied'                    => 2,
        'deleted'                   => 3,
        'reviewed'                  => 4,
        'sent_stock'                => 5
    ];
    
    /**
     * status request
     */
    public static $status_request = [
        'disapproved'               => 0,
        'approved'                  => 1,
        'denied'                    => 2,
        'deleted'                   => 3,
        'supplied_addition'         => 4,
        'returned_material'         => 5,

    ];
    
    public static $status_lot = [
        'kho'                       => 2,
        'line_sorting'              => 3
    ];
    
    public static $status_supply_material = [
        'disapproved'               => 0,
        'approved'                  => 1,
        'denied'                    => 2
    ];
    
    /**
     * alt
     */
    public static $alt = [
        'vtu_thaythe'               => 1,
        'vtu_chinh'                 => 0
    ];
    
    /**
     * gender
     */
    public static $gender = [
        'male'                  => 0,
        'female'                => 1
    ];
    
    /**
     * function role
     */
    public static $function_role = [
        'admin'                  => 1,
        'website'                => 2
    ];
    
    /**
     * ismodel
     */
    public static $ismodel = [
        'ismodel' => 1,
        'partno' => 0
    ];
    
    public static $format_date_display = [
        'datetime'  => 'd/m/Y H:i:s',
        'date'      => 'd/m/Y',
        'time'      => 'H:i',
    ];

    public static $toLineIdQOC = 0;
    
    public static $lot_pass = [
        'passed'            => 1,
        'failed'            => 0
    ];
    
    public static $actions = [
        'daily_plan_produce_view'               => 'PcController@daily_plan_produce',
        'daily_plan_produce_add'                => 'PcController@add_daily_plan_produce',
        'daily_plan_produce_edit'               => 'PcController@edit_daily_plan_produce',
        'daily_plan_produce_send_approve'       => 'PcController@send_approve_daily_plan_produce',
        'daily_plan_produce_approve'            => 'PcController@approve_daily_plan_produce',
        'daily_plan_produce_send_to_stock'      => 'PcController@send_to_stock_daily_plan_produce',
        'daily_plan_produce_export'             => 'PcController@export_daily_plan',
        
        'request_addition_material_view_list'   => 'PcController@list_request_addition_material',
        'request_addition_material_view_detail' => 'PcController@view_detail_request_material',
        'request_addition_material_approve'     => 'PcController@approve_request_addition_material',
        'request_return_material_view_list'     => 'PcController@list_request_return_material',
        'request_return_material_approve'       => 'PcController@approve_request_return_material',
    ];
}
