<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTonghopThunhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tonghop_thunhap', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('fullname')->nullable();
            $table->integer('luong_ngach_bac')->nullable();
            $table->integer('phucap_chucvu')->nullable();
            $table->integer('quan_ly_phi')->nullable();
            $table->integer('phucap_congtac_dang')->nullable();
            $table->integer('luong_tang_them')->nullable();
            $table->integer('phucap_thamnien_vuotkhung')->nullable();
            $table->integer('phucap_khac')->nullable();
            $table->integer('tienthuong')->nullable();
            $table->integer('thunhap_tangthem')->nullable();
            $table->integer('tong_cackhoan_tinhthue')->nullable();

            $table->integer('phucap_thamnien_nghe')->nullable();
            $table->integer('phucap_uudai_nghe')->nullable();
            $table->integer('tongcackhoan_khongtinhthue')->nullable();

            $table->integer('baohiem_thatnghiep_truvaoluong')->nullable();
            $table->integer('baohiem_xahoi_truvaoluong')->nullable();
            $table->integer('baohiem_yte_truvaoluong')->nullable();
            $table->integer('kinhphi_congdoan_truvaoluong')->nullable();
            $table->integer('giamtru_banthan')->nullable();
            $table->integer('tongtien_giamtru_nguoiphuthuoc')->nullable();
            $table->integer('tong_cackhoan_giamtru')->nullable();

            $table->integer('tong_thunhap_tinhthue')->nullable();
            $table->integer('thue_TNCN')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tonghop_thunhap');
    }
}
