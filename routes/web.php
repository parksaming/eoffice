<?php

// Home
Route::get('/',function () {
    if (session('user')) {
        return redirect(route('import_luong'));
    }else{
        return redirect('dang-nhap');
    }
});

// Language
Route::get('/test_feature', 'TestController@test');

Route::get('language/{lang}', 'LanguageController')
    ->where('lang', implode('|', config('app.languages')));

Route::get('dang-nhap', 'Auth\LoginController@index');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('login-by-sso', 'Auth\LoginController@login_by_sso');
Route::get('logout-by-sso', 'Auth\LoginController@logout_by_sso');
Route::post('forgotPassword','Auth\ForgotPasswordController@forgotPassword');
Route::get('quick-login/{json}', 'Auth\LoginController@quick_login');
Auth::routes();


Route::group(['middleware' => ['role_admin']], function () {
    Route::get('/dashboard', 'BaocaoController@dashboard');
    Route::get('guibaocao', 'BaocaoController@guibaocao');
    Route::post('baocao/gui_bao_cao', 'BaocaoController@gui_bao_cao');
//    Route::get('baocao/gui_bao_cao', 'BaocaoController@gui_bao_cao');
    Route::post('baocao/xem_bao_cao', 'BaocaoController@xem_bao_cao');

    Route::get('baocao/sua_bao_cao/{id}','BaocaoController@sua_bao_cao');
    Route::post('baocao/sua_bao_cao','BaocaoController@cap_nhat_bao_cao');

    Route::get('baocao/xem_noi_dung_bao_cao', 'BaocaoController@xem_noi_dung_bao_cao');
    Route::post('baocao/xem_noi_dung_bao_cao', 'BaocaoController@xem_nd_bao_cao');
    Route::get('baocao/bao_cao_da_gui', 'BaocaoController@bao_cao_da_gui');
    Route::post('baocao/bao_cao_da_gui', 'BaocaoController@kq_bao_cao_da_gui');
    //lãnh đạo
    
    Route::post('baocao/congviec ','BaocaoController@kq_congviec');
    //Lên kế hoạch
    Route::get('baocao/len_ke_hoach','BaocaoController@len_ke_hoach');
    Route::post('baocao/len_ke_hoach','BaocaoController@store_len_ke_hoach');
    Route::get('baocao/xem_chi_tiet_ke_hoach','BaocaoController@xem_chi_tiet_ke_hoach');
    Route::post('baocao/xem_ke_hoach', 'BaocaoController@xem_ke_hoach');
    Route::get('baocao/sua_ke_hoach/{id}','BaocaoController@sua_ke_hoach');
    Route::post('baocao/sua_ke_hoach','BaocaoController@cap_nhat_ke_hoach');

    //Báo cáo công việc 
    Route::post('baocao/report_work_detail','BaocaoController@report_work_detail');
    Route::post('baocao/viewDetail_report','BaocaoController@viewDetail_report');
    Route::post('baocao/agreement_report','BaocaoController@agreement_report');
    Route::get('baocao/commonBaocao_congviecs','BaocaoController@commonBaocao_congviecs');
    Route::get('baocao/view_baocao_notifi','BaocaoController@view_baocao_notifi');
    Route::get('baocao/view_agreement_report','BaocaoController@view_agreement_report');

    Route::get('baocao/thong-ke-theo-don-vi', 'BaocaoController@thong_ke_theo_don_vi')->name('baocao.thong_ke_theo_don_vi');
    Route::get('baocao/thong-ke-theo-ca-nhan', 'BaocaoController@thong_ke_theo_ca_nhan')->name('baocao.thong_ke_theo_ca_nhan');

    Route::get('baocao/thong_ke_van_ban/don_vi', 'BaocaoController@baoCaoThongKeDonVi')->name('baocaothongke.donvi');
    Route::get('baocao/thong_ke_van_ban/ca_nhan', 'BaocaoController@baoCaoThongKeCaNhan')->name('baocaothongke.canhan');
    Route::get('baocao/xem_thong_ke_van_ban', 'BaocaoController@xemBaoCaoThongKe')->name('baocaothongke.danhsach');

    //Thay đổi mật khẩu

    Route::get('cap_nhat_thong_tin', 'Auth\LoginController@cap_nhat_thong_tin');
    Route::get('cong-viec-da-giao', 'BaocaoController@cong_viec_da_giao');
    Route::get('dieu-hanh', 'BaocaoController@dieu_hanh');
    Route::get('doi-mat-khau/{id}', 'Auth\LoginController@doi_mat_khau');
    Route::post('doi-mat-khau/{id}', 'Auth\LoginController@cap_nhat_mat_khau');

    Route::get('danh_sach_phong_hop','PhongHopController@PhongHop')->name('phonghop.danhsachphonghop'); 
    Route::get('dang_ky_lich_tuan','PhongHopController@dang_ky_lich_tuan')->name('phonghop.dangkylichtuan');
    Route::post('save_dang_ky_lich_tuan', 'PhongHopController@save_dang_ky_lich_tuan')->name('phonghop.savedangkylichtuan');
    Route::post('them_phong_hop', 'PhongHopController@ThemPhongHop')->name('phonghop.themphonghop');
    Route::get('danh-sach-dang-ky-lich-tuan', 'PhongHopController@list_dang_ky_lich_tuan')->name('phonghop.danhsachdangkylichtuan');
    Route::get('sua-dang-ky-lich-tuan/{lichtuanId}', 'PhongHopController@edit_dang_ky_lich_tuan')->name('editdangkylichtuan'); 
    Route::post('duyet-dang-ky-lich-tuan', 'PhongHopController@approve_dang_ky_lich_tuan')->name('phonghop.duyetdangkylichtuan');

    // Công việc
    Route::group(['prefix' => 'congviec'], function () {
        Route::get('danhsach','BaocaoController@congviec')->name('danhsachcongviec');
        Route::get('get-danh-sach', 'CongviecController@get_danh_sach_cong_viec')->name('congviec.danhsach');
        Route::get('axjaxLoadDetail_Congviec','CongviecController@axjaxLoadDetail');
        Route::get('chung','CongviecController@congviec_chung');
        Route::get('phancong','CongviecController@congviec_phancong');
        Route::post('congviec_file','CongviecController@congviec_file');
        Route::get('remove_session_work','CongviecController@remove_session_work');
        Route::get('fullcalendar','CongviecController@fullcalendar');
        Route::get('getUser_Unit','CongviecController@getUser_Unit');
        Route::get('sua_congviec','CongviecController@sua_congviec');
        Route::post('sua_congviec','CongviecController@sua_congviecPost');
        Route::get('view_work','CongviecController@view_work');
        Route::get('view_report_detail','CongviecController@view_report_detail');
        Route::get('work_search_keyup','CongviecController@work_search_keyup');
        Route::get('work_search_all','CongviecController@work_search_all');
        Route::post('draft_report','CongviecController@draft_report');
        Route::get('view_dailyReport','CongviecController@view_dailyReport');
        Route::get('get-view-change-status','CongviecController@get_view_change_status')->name('congviec.get_view_change_status');
        Route::post('change-status','CongviecController@change_status')->name('congviec.change_status');
    });
    
    // Công việc chi tiết
    Route::group(['prefix' => 'congviec_chitiet'], function () {
        Route::get('ajaxAdd_workDetail','CongviecChiTietController@ajaxAdd_workDetail');
        Route::post('delete_work_detail','CongviecChiTietController@delete_work_detail');
        Route::get('update_work_detail','CongviecChiTietController@get_update_work_detail');
        Route::post('update_work_detail','CongviecChiTietController@post_update_work_detail');
        Route::post('ajaxUploadDocs_workDetail','CongviecChiTietController@ajaxUploadDocs_workDetail');
        Route::post('axjaxLoadDetail_WorkJoin','CongviecChiTietController@axjaxLoadDetail_WorkJoin');
        Route::get('ajaxLoad_document','CongviecChiTietController@ajaxLoad_document');
    });

    Route::group(['prefix' => 'congviec_messages'], function () {
        Route::post('ajaxSend_WorkMessages','CongviecMessageController@store');
        Route::get('ajaxList_WorkMessages','CongviecMessageController@show');
    });

    Route::group(['prefix' => 'congviec_file'], function () {
        Route::post('ajaxRemove_file','CongviecFileController@ajaxRemove_file');
    });

    Route::group(['prefix'=>'vanban'],function(){
        Route::get('nhap_van_ban_den_donvi',[
            'as' => 'add.van.ban.den_donvi',
            'uses'=>'VanBanDonViController@addVanBanDen'
        ]);
        Route::get('danh_sach_van_ban_den_donvi',[
            'as' =>'danhsach.vanbanden_donvi',
            'uses' => 'VanBanDonViController@dsVanbanden'
        ]);
        Route::post('add_vanban_donvi',[
            'as'    =>  'add.vanban_donvi',
            'uses'  =>  'VanBanDonViController@addVanban'
        ]);
        Route::get('danh_sach_van_ban_di_donvi',[
            'as'    =>  'danhsach.vanbandi_donvi',
            'uses'  =>  'VanBanDonViController@dsVanbandi'
        ]);
        Route::get('danh_sach_van_ban_den_donvi',[
            'as' =>'danhsach.vanbanden_donvi',
            'uses' => 'VanBanDonViController@dsVanbanden'
        ]);
        Route::get('chi-tiet-vban-den_donvi/{id}',[
            'as'    =>  'chitiet_vanban_donvi',
            'uses'  =>  'VanBanDonViController@detailVanbanden'
        ]);
        Route::get('chuyen-xu-ly-vban_donvi/{id}',[
            'as'    =>  'chuyen_xu_ly_van_ban_donvi',
            'uses'  =>  'VanBanDonViController@chuyen_xu_ly_van_ban'
        ]);
        Route::post('ajax_dsvanban_donvi',[
            'as' => 'ajax_dsvanban_donvi',
            'uses' => 'VanBanDonViController@ajaxDsVanban'
        ]);
        Route::post('check-xu-ly-vanban_donvi', [
            'as'    =>  'vanban.check_xu_ly_vanban_donvi',
            'uses'  =>  'VanBanDonViController@check_xu_ly_vanban'
        ]);
        Route::post('cap-nhat-trang-thai-xu-ly_donvi', [
            'as'    =>  'vanban.cap_nhat_trang_thai_xu_ly_donvi',
            'uses'  =>  'VanBanDonViController@cap_nhat_trang_thai_xu_ly'
        ]);
        Route::get('quy_trinh_chuyen_tiep_donvi', 'VanBanDonViController@quy_trinh_chuyen_tiep');
        Route::post('luu-xu-ly-van-ban_donvi',[
            'as'    =>  'luu_xu_ly_van_ban_donvi',
            'uses'  =>  'VanBanDonViController@luu_xu_ly_van_ban'
        ]);
        Route::get('sua-van-ban_donvi/{vanbanId}', [
            'as' => 'edit_vanban_donvi',
            'uses'=>'VanBanDonViController@edit_vanban'
        ]);
        Route::post('gui-lai-mail_donvi/{vanbanId}', [
            'as'    =>  'gui_lai_mail_donvi',
            'uses'  =>  'VanBanDonViController@gui_lai_mail'
        ]);
        Route::post('save-y-kien_donvi',[
            'as'    =>  'trinh_lanh_dao.save_ykien_donvi',
            'uses'  =>  'VanBanDonViController@save_ykien'
        ]);
        Route::get('get-number-vbden-new_donvi', [
            'as' => 'getvanbandennew_donvi',
            'uses'=>'VanBanDonViController@get_number_vbden_new'
        ]);
        Route::post('save_vanban_donvi', [
            'as'    =>  'save.vanban_donvi',
            'uses'  =>  'VanBanDonViController@save_vanban'
        ]);
        Route::get('nhap_van_ban_di_donvi',[
            'as' => 'add.van.ban.di_donvi',
            'uses' => 'VanBanDonViController@VanBanDi'
        ]);
        Route::post('addVanbandi_donvi',[
            'as' => 'add.vanban.di_donvi',
            'uses' => 'VanBanDonViController@save_vanban_di'
        ]);
        Route::get('chi-tiet-van-ban-di_donvi/{id}', [
            'as'    =>  'chi_tiet_van_ban_di_donvi',
            'uses'  =>  'VanBanDonViController@chi_tiet_van_ban_di'
        ]);
        Route::get('sua-van-ban-di_donvi/{vanbanId}', [
            'as' => 'edit_vanban_di_donvi',
            'uses'=>'VanBanDonViController@edit_vanban_di'
        ]);
        Route::post('gui_mail_vbdi_donvi', [
            'as'    =>  'guimailvbdi_donvi',
            'uses'  =>  'VanBanDonViController@guimailvbdi'
        ]);
        Route::post('xoa-vanban_donvi', [
            'as' => 'vanban.delete_donvi',
            'uses' => 'VanBanDonViController@delete_vanban'
        ]);
    });
    Route::group(['prefix'=>'vanban'],function(){
        Route::get('nhap_van_ban_den',[
            'as' => 'add.van.ban.den',
            'uses'=>'VanBanController@addVanBanDen'
        ]);
        Route::get('sua-van-ban/{vanbanId}', [
            'as' => 'edit_vanban',
            'uses'=>'VanBanController@edit_vanban'
        ]);
        Route::get('sua-van-ban-di/{vanbanId}', [
            'as' => 'edit_vanban_di',
            'uses'=>'VanBanController@edit_vanban_di'
        ]);
        Route::post('ajax_user',[
           'as' =>'ajax.user',
           'uses' => 'VanBanController@getUser'
        ]);
        Route::get('danh_sach_van_ban_den',[
            'as' =>'danhsach.vanbanden',
            'uses' => 'VanBanController@dsVanbanden'
        ]);
        Route::get('get-number-vbden-new', [
            'as' => 'getvanbandennew',
            'uses'=>'VanBanController@get_number_vbden_new'
        ]);
        Route::get('get-number-vbnoibo-new', [
            'as' => 'getvanbannoibonew',
            'uses'=>'VanBanController@get_number_vbnoibo_new'
        ]);
        Route::get('van-ban-den-xu-ly',[
            'as' =>'danhsach.vanbandenxuly',
            'uses' => 'VanBanController@van_ban_den_xu_ly'
        ]);
        Route::get('danh_sach_van_ban_den_da_gui',[
            'as' =>'danhsach.vanbandendagui',
            'uses' => 'VanBanController@vanbandendagui'
        ]);
        Route::get('danh_sach_van_ban_di',[
            'as'    =>  'danhsach.vanbandi',
            'uses'  =>  'VanbanController@dsVanbandi'
        ]);
        Route::post('gui_mail_vbdi', [
            'as'    =>  'guimailvbdi',
            'uses'  =>  'VanbanController@guimailvbdi'
        ]);
        Route::post('postdsVanbandi',[
            'as'    =>  'postdsVanbandi',
            'uses'  =>  'VanbanController@postdsVanbandi'
        ]);

        Route::post('vanban_attachfile',[
            'as' => 'attachfile',
            'uses' => 'VanbanController@attachfile'
        ]);
        Route::post('remove_file',[
            'as' => 'removefile',
            'uses' => 'VanbanController@removeFile'
        ]);
        Route::post('add_vanban',[
            'as'    =>  'add.vanban',
            'uses'  =>  'VanbanController@addVanban'
        ]);
        Route::post('save_vanban', [
            'as'    =>  'save.vanban',
            'uses'  =>  'VanbanController@save_vanban'
        ]);
        Route::post('gui-lai-mail/{vanbanId}', [
            'as'    =>  'gui_lai_mail',
            'uses'  =>  'VanbanController@gui_lai_mail'
        ]);
        Route::post('upload_file',[
            'as'    =>  'upload.file',
            'uses'  =>  'VanbanController@uploadFile'
        ]);
        Route::post('ajax_dsvanban',[
           'as' => 'ajax_dsvanban',
           'uses' => 'VanbanController@ajaxDsVanban'
        ]);
        Route::get('nhap_van_ban_di',[
           'as' => 'add.van.ban.di',
           'uses' => 'VanbanController@VanBanDi'
        ]);
        Route::post('addVanbandi',[
            'as' => 'add.vanban.di',
            'uses' => 'VanbanController@save_vanban_di'
        ]);
        Route::post('xoa-vanban', [
            'as' => 'vanban.delete',
            'uses' => 'VanbanController@delete_vanban'
        ]);
        Route::get('cau_hinh_don_vi_nhan',[
            'as'    =>  'cauhinh.donvi.nhan',
            'uses'  => 'VanbanController@settingUnit'
        ]);
        Route::post('addCauhinh',[
            'as'    =>  'add.cauhinh',
            'uses'  =>  'VanbanController@addCauhinh'
        ]);
        Route::post('check.donvi',[
            'as'    =>  'check.donvi',
            'uses'  =>  'VanbanController@checkDonvi'
        ]);
        Route::get('email_vanbandi',[
           'as' =>  'emails.vanban',
            'uses' => 'VanbanController@email'
        ]);
        Route::get('chi-tiet-van-ban-den/{id}',[
            'as'    =>  'chitiet_vanban',
            'uses'  =>  'VanbanController@detailVanbanden'
        ]);
        Route::get('chi-tiet-van-ban-di/{id}', [
            'as'    =>  'chi_tiet_van_ban_di',
            'uses'  =>  'VanbanController@chi_tiet_van_ban_di'
        ]);
        Route::get('chi-tiet-van-ban-den-da-gui/{id}',[
            'as'    =>  'chi_tiet_van_ban_den_da_gui',
            'uses'  =>  'VanbanController@chi_tiet_van_ban_den_da_gui'
        ]);
        Route::get('view_log/{id}',[
            'as'    =>  'view_log',
            'uses'  =>  'VanbanController@view_log'
        ]);
        Route::get('gui-but-phe-van-ban-den/{id}',[
            'as'    =>  'gui_but_phe_van_ban_den',
            'uses'  =>  'VanbanController@gui_but_phe_van_ban_den'
        ]);
        Route::post('save_but_phe_van_ban_den',[
            'as'    =>  'save_but_phe_van_ban_den',
            'uses'  =>  'VanbanController@save_but_phe_van_ban_den'
        ]);

        Route::get('chi_tiet_van_ban_luu/{id}',[
            'as'    =>  'chitiet_vanban_luu',
            'uses'  =>  'VanBanController@detailVanbanluu'
        ]);
        //Dowload File Đính Kèm
        Route::get('dowload_file/{name}',[
            'as'    =>  'dowload.file',
            'uses'  =>  'VanbanController@dowloadFile'
        ]);

        Route::get('van_ban_luu',[
            'as'    =>  'vanban.luu',
            'uses'  =>  'VanbanController@dsVanbanluu'
        ]);

        Route::get('edit_van_ban_luu/{id}',[
            'as'    =>  'edit_van_ban_luu',
            'uses'  =>  'VanbanController@editVanbanluu'
        ]);

        Route::post('edit_van_ban_luu',[
            'as'    =>  'edit_vanban_luu',
            'uses'  =>  'VanbanController@addEditvanban'
        ]);

        Route::post('test',[
            'as'    =>'test',
            'uses'  =>  'VanbanController@test'
        ]);
        Route::get('edit_van_ban_da_gui/{id}',[
            'as'    =>  'edit_van_ban_da_gui',
            'uses'  =>  'VanbanController@edit_van_ban_da_gui'
        ]);
        Route::get('gui_lai_mail_van_ban_den/{id}',[
            'as'    =>  'gui_lai_mail_van_ban_den',
            'uses'  =>  'VanbanController@gui_lai_mail_van_ban_den'
        ]);
        Route::get('chuyen-xu-ly-van-ban/{id}',[
            'as'    =>  'chuyen_xu_ly_van_ban',
            'uses'  =>  'VanbanController@chuyen_xu_ly_van_ban'
        ]);
        Route::post('luu-xu-ly-van-ban',[
            'as'    =>  'luu_xu_ly_van_ban',
            'uses'  =>  'VanbanController@luu_xu_ly_van_ban'
        ]);
        Route::post('save-y-kien',[
            'as'    =>  'trinh_lanh_dao.save_ykien',
            'uses'  =>  'VanbanController@save_ykien'
        ]);
        Route::post('cap-nhat-trang-thai-xu-ly', [
            'as'    =>  'vanban.cap_nhat_trang_thai_xu_ly',
            'uses'  =>  'VanbanController@cap_nhat_trang_thai_xu_ly'
        ]);
        Route::post('check-xu-ly-vanban', [
            'as'    =>  'vanban.check_xu_ly_vanban',
            'uses'  =>  'VanbanController@check_xu_ly_vanban'
        ]);
        Route::get('send-mail-vb-chua-xu-ly','VanbanController@send_mail_van_ban_chua_xu_ly');
    });
    Route::group(['prefix' => 'vanbannoibo'], function () {
        Route::get('danh-sach', 'VanBanNoiBoController@danh_sach');
        Route::get('danh-sach-gui', 'VanBanNoiBoController@danh_sach_gui');
        Route::get('danh-sach-nhan', 'VanBanNoiBoController@danh_sach_nhan');
        Route::get('chi-tiet/{vanbanId}', 'VanBanNoiBoController@chi_tiec');
        Route::get('nhap', 'VanBanNoiBoController@nhap_vanban_noibo');
        Route::post('luu-nhap', 'VanBanNoiBoController@luu_nhap_vanban_noibo');
        Route::get('sua/{vanbanId}', 'VanBanNoiBoController@sua_vanban_noibo');
        Route::post('luu-sua', 'VanBanNoiBoController@luu_sua_vanban_noibo');
        Route::get('chuyen-xu-ly/{id}', 'VanBanNoiBoController@chuyen_xu_ly');
        Route::post('luu-chuyen-xu-ly', 'VanBanNoiBoController@luu_chuyen_xu_ly');
    });
    Route::get('vanban/quy_trinh_chuyen_tiep', 'VanbanController@quy_trinh_chuyen_tiep');
    Route::get('vanban/xu_ly_van_ban_user', 'VanbanController@xu_ly_van_ban_user');
    Route::post('vanban/{id}/sendInfo', 'VanbanController@sendInfo');

    Route::group(['prefix' => 'co-quan'], function () {
        // quản lý cơ quan
        Route::get('danh-sach',[
            'as'    =>  'co_quan.list',
            'uses'  =>  'BookController@get_danh_sach_co_quan'
        ]);
        Route::get('them',[
            'as'    =>  'co_quan.create',
            'uses'  =>  'BookController@create_co_quan'
        ]);
        Route::get('sua/{bookId}',[
            'as'    =>  'co_quan.edit',
            'uses'  =>  'BookController@edit_co_quan'
        ]);
        Route::post('save-co-quan', [
            'as'    =>  'co_quan.save',
            'uses'  =>  'BookController@save_co_quan'
        ]);
        Route::post('xoa-co-quan', [
            'as'    =>  'co_quan.delete',
            'uses'  =>  'BookController@delete_co_quan'
        ]);
        
        // quản lý đơn vị trong cơ quan
        Route::get('{bookId}/danh-sach-don-vi', [
            'as'    =>  'co_quan.list_don_vi',
            'uses'  =>  'BookController@get_danh_sach_don_vi'
        ]);
        Route::get('{bookId}/them-don-vi', [
            'as'    =>  'co_quan.create_don_vi',
            'uses'  =>  'BookController@create_don_vi'
        ]);
        Route::get('sua-don-vi/{bookDetailId}', [
            'as'    =>  'co_quan.edit_don_vi',
            'uses'  =>  'BookController@edit_don_vi'
        ]);
        Route::post('save-don-vi', [
            'as'    =>  'co_quan.save_don_vi',
            'uses'  =>  'BookController@save_don_vi'
        ]);
        Route::post('xoa-don-vi', [
            'as'    =>  'co_quan.delete_don_vi',
            'uses'  =>  'BookController@delete_don_vi'
        ]);
    });

    Route::group(['prefix' => 'sovanban'], function () {
        // quản lý cơ quan
        Route::get('danh-sach',[
            'as'    =>  'sovanban.danh-sach',
            'uses'  =>  'SoVanBanController@get_danh_sach'
        ]);
        Route::get('danh-sach-so-van-ban/{sovanbanId}', [
            'as'    =>  'sovanban.danh_sach_van_ban_thuoc_so',
            'uses'  =>  'SoVanBanController@get_danh_sach_van_ban_thuoc_so'
        ]);
        Route::get('them',[
            'as'    =>  'sovanban.create',
            'uses'  =>  'SoVanBanController@create_so_van_ban'
        ]);
        Route::get('sua/{id}',[
            'as'    =>  'sovanban.edit',
            'uses'  =>  'SoVanBanController@edit_so_van_ban'
        ]);
        Route::post('save', [
            'as'    =>  'sovanban.save',
            'uses'  =>  'SoVanBanController@save_so_van_ban'
        ]);
        Route::post('xoa', [
            'as'    =>  'sovanban.delete',
            'uses'  =>  'SoVanBanController@delete_so_van_ban'
        ]);
    });

    Route::post('load_user_donviden_option', 'CommonController@load_user_donviden_option');
    Route::post('load_user_donvidi_option', 'CommonController@load_user_donvidi_option');
    Route::post('load_user_donviden_checkbox', 'CommonController@load_user_donviden_checkbox');
    Route::post('load_user_donvinoibo_checkbox', 'CommonController@load_user_donvinoibo_checkbox');

    Route::group(['prefix'=>'notification'], function() {
        Route::get('danh-sach', [
            'as' => 'notification.list_notifications',
            'uses'=>'NotificationController@list_notifications'
        ]);
        Route::get('view/{notificationId}', [
            'as' => 'notification.view_notification',
            'uses'=>'NotificationController@view_notification'
        ]);
        Route::post('xem-tatca', [
            'as' => 'notification.view_all',
            'uses'=>'NotificationController@view_all'
        ]);
    });

    Route::post('check_number_van_ban_trong_ngay', 'CommonController@check_number_van_ban_trong_ngay');

    Route::post('save_gop_y', 'GopYController@save_gop_y');

    Route::get('nhap-van-ban-ban-hanh', 'VanbanController@nhap_vanban_banhanh')->name('nhap_vanban_banhanh');
    Route::get('danh-sach-van-ban-ban-hanh', 'VanbanController@danhsach_vanban_banhanh')->name('danhsach_vanban_banhanh'); 
    Route::get('sua-van-ban-ban-hanh/{vanbanbanhanhId}', 'VanbanController@sua_vanban_banhanh')->name('sua_vanban_banhanh');
    Route::post('save-van-ban-ban-hanh', 'VanbanController@save_vanban_banhanh')->name('save_vanban_banhanh');
    Route::get('danh-sach-tai-khoan', 'UserController@danh_sach_tai_khoan')->name('danh_sach_tai_khoan'); 
    Route::get('them-tai-khoan', 'UserController@them_tai_khoan')->name('them_tai_khoan');
    Route::get('sua-tai-khoan/{userId}', 'UserController@sua_tai_khoan')->name('sua_tai_khoan');
    Route::post('save-tai-khoan', 'UserController@save_tai_khoan')->name('save_tai_khoan');
    Route::get('quan-ly-luong-thue', 'UserController@import_luong')->name('import_luong');
    Route::post('import_update_thu_thue', 'UserController@import_update_thu_thue')->name('import_update_thu_thue');
    Route::post('process_import_tong_hop_thu_nhap', 'UserController@process_import_tong_hop_thu_nhap')->name('process_import_tong_hop_thu_nhap');
    Route::post('import_update_luong_phu_cap', 'UserController@import_update_luong_phu_cap')->name('import_update_luong_phu_cap');
    Route::post('process_import_luong_phu_cap', 'UserController@process_import_luong_phu_cap')->name('process_import_luong_phu_cap');
    //thu nhap khac
    Route::post('import_update_thu_nhap_khac', 'UserController@import_update_thu_nhap_khac')->name('import_update_thu_nhap_khac');
    Route::post('process_import_thu_nhap_khac', 'UserController@process_import_thu_nhap_khac')->name('process_import_thu_nhap_khac');
    Route::get('xem-luong-thue', 'UserController@xem_luong_thue')->name('xem_luong_thue');
    Route::get('chi-tiet-luong-phu-cap/{date}', 'UserController@chi_tiet_luong_phu_cap')->name('chi_tiet_luong_phu_cap');
    Route::get('chi-tiet-tong-hop-thu-nhap/{date}', 'UserController@chi_tiet_tong_hop_thu_nhap')->name('chi_tiet_tong_hop_thu_nhap');
    Route::get('chi-tiet-tong-hop-thu-nhap_khac/{date}', 'UserController@chi_tiet_tong_hop_thu_nhap_khac')->name('chi_tiet_tong_hop_thu_nhap_khac');
    Route::post('gui-mail-luong', [
        'as'    =>  'gui_mail_luong',
        'uses'  =>  'UserController@gui_mail_luong'
    ]);
});

Route::get('congviecs/{id}/edit','CongviecController@update');

Route::resource('congviec', 'CongviecController');
Route::resource('congviecfile', 'CongviecFileController');
Route::resource('congviec_chitiet', 'CongviecChiTietController');

Route::group(['prefix' => 'api'], function () {
    Route::get('get-lich-tuan', 'ApiController@GetLichTuan');
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Xóa cache thành công";
});