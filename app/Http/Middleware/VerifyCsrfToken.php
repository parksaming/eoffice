<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'model/import_confirm',
        'vanban/vanban_attachfile',
        'vanban/remove_file',
        'vanban/upload_file',
        'vanban/test',
        'process_import_tong_hop_thu_nhap',
        'import_update_thu_thue',
        'import_update_luong_phu_cap',
        'process_import_luong_phu_cap'
    ];
}
