<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Them_cvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'noidung' => 'required',
            'tencongviec' => 'required',
            'nguoigiamsat' => 'required',
            'tinhchat' => 'required',
            'ngaybd' => 'required',
            'ngaykt' => 'required',
            'noidung' => 'required',
            'file' => 'max:20480',
            'nd_chitiet' => 'required',
            'nguoiphutrach' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'noidung.required' => 'Vui lòng nhập nội dung',
            'tencongviec.required' => 'Vui lòng nhập tên công việc',
            'nguoigiamsat.required' => 'Vui lòng chọn người giám sát',
            'tinhchat.required' => 'Vui lòng chọn độ ưu tiên',
            'ngaybd.required' => 'Vui lòng chọn ngày bắt đầu công việc chung',
            'ngaykt.required' => 'Vui lòng chọn ngày kết thúc công việc chung',
            'noidung.required' => 'Vui lòng nhập nội dung công việc chung',
            'file.max' => 'Kích thước tệp gới hạn < 20m',
            'nd_chitiet.required' => 'Vui lòng nhập nội dung chi tiết',
            'nguoiphutrach.required' => 'Vui lòng chọn người phụ trách',
        ];
    }
}
