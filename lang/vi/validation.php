<?php

return [
    'required' => ':attribute là thông tin bắt buộc.',
    'email' => ':attribute chưa đúng định dạng email.',
    'string' => ':attribute chưa đúng định dạng.',
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
    ],
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
    ],
    'confirmed' => ':attribute nhập lại chưa khớp.',
    'unique' => ':attribute đã được sử dụng.',
    'url' => ':attribute chưa đúng định dạng liên kết.',
    'integer' => ':attribute phải là số nguyên.',

    'attributes' => [
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'name' => 'Họ và tên',
        'customer_name' => 'Họ và tên',
        'customer_phone' => 'Số điện thoại',
        'customer_email' => 'Email',
        'requirements' => 'Nội dung yêu cầu',
        'message' => 'Nội dung tin nhắn',
        'student_name' => 'Họ và tên',
        'student_phone' => 'Số điện thoại',
        'topic' => 'Tên đề tài',
        'preferred_contact_channel' => 'Kênh liên hệ ưu tiên',
        'service_type' => 'Loại nhu cầu',
    ],
];
