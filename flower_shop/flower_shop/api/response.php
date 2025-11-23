<?php
/**
 * response.php - File phụ trợ định dạng JSON trả về từ API
 * Giúp standardize các response từ backend
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

/**
 * Class Response - Xử lý các kiểu response
 */
class Response {
    
    /**
     * Response thành công
     */
    public static function success($message = 'Thành công', $data = null, $code = 200) {
        http_response_code($code);
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response lỗi
     */
    public static function error($message = 'Có lỗi xảy ra', $data = null, $code = 400) {
        http_response_code($code);
        return [
            'status' => 'error',
            'message' => $message,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response xác thực thất bại
     */
    public static function unauthorized($message = 'Không được phép truy cập') {
        http_response_code(401);
        return [
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response không tìm thấy
     */
    public static function notFound($message = 'Không tìm thấy dữ liệu') {
        http_response_code(404);
        return [
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response validation lỗi
     */
    public static function validation($errors) {
        http_response_code(422);
        return [
            'status' => 'error',
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $errors,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response dữ liệu trống
     */
    public static function empty($message = 'Không có dữ liệu') {
        http_response_code(204);
        return [
            'status' => 'success',
            'message' => $message,
            'data' => [],
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Response phân trang
     */
    public static function paginated($data, $total, $page, $per_page, $message = 'Thành công') {
        $total_pages = ceil($total / $per_page);
        http_response_code(200);
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $per_page,
                'total_pages' => $total_pages
            ],
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Output JSON response
     */
    public static function json($response) {
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}

/**
 * Hàm hỗ trợ nhanh
 */
function send_success($message = 'Thành công', $data = null, $code = 200) {
    Response::json(Response::success($message, $data, $code));
}

function send_error($message = 'Có lỗi xảy ra', $data = null, $code = 400) {
    Response::json(Response::error($message, $data, $code));
}

function send_notfound($message = 'Không tìm thấy dữ liệu') {
    Response::json(Response::notFound($message));
}

function send_validation($errors) {
    Response::json(Response::validation($errors));
}

function send_paginated($data, $total, $page, $per_page, $message = 'Thành công') {
    Response::json(Response::paginated($data, $total, $page, $per_page, $message));
}

/**
 * Validate POST request
 */
function validate_post_request() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        send_error('Chỉ chấp nhận POST request', null, 405);
    }
    
    if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
        send_error('Content-Type phải là application/json', null, 415);
    }
}

/**
 * Validate GET request
 */
function validate_get_request() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        send_error('Chỉ chấp nhận GET request', null, 405);
    }
}

/**
 * Get input JSON
 */
function get_json_input() {
    return json_decode(file_get_contents('php://input'), true);
}

/**
 * Validate required fields
 */
function validate_required($data, $required_fields) {
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            $errors[$field] = ucfirst($field) . ' là bắt buộc';
        }
    }
    
    if (!empty($errors)) {
        send_validation($errors);
    }
}

/**
 * Sanitize input
 */
function sanitize_input($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize_input($value);
        }
        return $data;
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Log API request
 */
function log_request($action, $data = null) {
    $log_file = __DIR__ . '/../logs/api.log';
    
    if (!file_exists(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }
    
    $log_message = date('Y-m-d H:i:s') . " | Action: $action | Data: " . json_encode($data) . " | IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}
?>