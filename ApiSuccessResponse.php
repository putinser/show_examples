<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;

/**
 * Class ApiSuccessResponse.
 */
class ApiSuccessResponse extends ApiResponse
{
    public const OK = 'OK';
    public const CREATED = 'Created';
    public const ACCEPTED = 'Accepted';
    public const ALREADY_REPORTED = 'Already reported';

    public const CODES = [
        self::OK => 200,
        self::CREATED => 201,
        self::ACCEPTED => 202,
        self::ALREADY_REPORTED => 208,
    ];

    public const DEFAULT_CODE = self::OK;

    /**
     * ApiSuccessResponse constructor.
     *
     * @param null   $data
     * @param null   $service_data
     * @param string $code
     * @param string $module
     * @param string $message
     */
    public function __construct($data = null, $service_data = null, $code = self::OK, $module = '', $message = '')
    {
        if (!array_key_exists($code, self::CODES)) {
            $code = self::DEFAULT_CODE;
        }

        $http_code = self::CODES[$code];

        $response = [
            'code_http' => $http_code,
            'code_text' => $code,
            'message_key' => '',
        ];

        if (!empty($module)) {
            if (is_object($module)) {
                $module = $module->getPathInfo();
            }
            $module = $this->prepareModule($module);
        }

        if (!empty($module) && !empty($message)) {
            $response['message_key'] = $module . '.' . $message;
        } elseif (!empty($message)) {
            $response['message_key'] = $message;
        }

        if (!empty($service_data)) {
            $response['service_data'] = $service_data;
        }

        $response['data'] = $data ?? [];

        parent::__construct($response, $http_code);
    }
}
