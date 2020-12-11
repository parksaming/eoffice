<div>
    <h3 style="font-family: 'Times New Roman',serif; font-variant: normal!important;margin-bottom: 10px">Dear Mr/Ms:
        <b>
            <strong style=" text-transform: capitalize;">
                {{$data['fullname']}}
            </strong>
        </b>
    </h3>
    <h3 style="font-family: 'Times New Roman',serif; font-variant: normal!important;margin-bottom: 10px">
        <b>
            <strong>
                {{$data['title']}}
            </strong>
        </b>
    </h3>
    <?php if($data['type'] =='luongvaphucap'):?>
    <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end ">
        <table border="1" width="50%" style="border-collapse:collapse;margin-left:auto; margin-right:auto;font-family:'Times New Roman', serif;font-variant:normal;font-size: 1rem;">
            <colgroup span="2"></colgroup>
            <colgroup span="2"></colgroup>
            <tr>
                <td style="background: #ffe599;font-weight: bold;text-align: center">STT</td>
                <td style="background: #ffe599;font-weight: bold;text-align: center">Danh mục</td>
                <th style="font-weight: 100;text-align: left;height: 40px;background: #ffe599"  scope="colgroup"></th>
                <th scope="colgroup" style="text-align: center;height: 40px;background:#ffe599;font-weight: bold">Số tiền</th>
            </tr>
            <tr>
                <td style="text-align: center" rowspan="2">1</td>
                <td rowspan="2">Lương ngạch bậc</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_luong_ngach_bac']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{number_format($data['luong_ngach_bac'],0,',',',')}} đ</th>
            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">2</td>
                <td rowspan="2">Phụ cấp chức vụ</td>
                <th style="font-weight: 100;text-align: left;height: 40px"   scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_phucap_chucvu']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_chucvu'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">3</td>
                <td rowspan="2">Phụ cấp thâm niên vượt khung</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{number_format($data['tyle_phucap_thamnien_vuotkhung'],0,',',',')}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_thamnien_vuotkhung'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">4</td>
                <td rowspan="2">Phụ cấp thâm niên nghề</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Tỷ lệ</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{number_format($data['tyle_phucap_thamnien_nghe'],0,',',',')}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_thamnien_nghe'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">5</td>
                <td rowspan="2">Phụ cấp ưu đãi nghề</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Tỷ lệ</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{number_format($data['tyle_phucap_uudai_nghe'],0,',',',')}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px" scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_uudai_nghe'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">6</td>
                <td rowspan="2">Phụ cấp khác</td>
                <th style="font-weight: 100;text-align: left;height: 40px" scope="colgroup">Tỷ lệ</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_phucap_khac']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_khac'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">7</td>
                <td rowspan="2">Phụ cấp Công tác Đảng</td>
                <th style="font-weight: 100;text-align: left;height: 40px" scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_phucap_congtac_dang']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['phucap_congtac_dang'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">8</td>
                <td rowspan="2">Lương tăng thêm</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_luong_tang_them']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['luong_tang_them'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">9</td>
                <td rowspan="2">Quản lý phí</td>
                <th style="font-weight: 100;text-align: left;height: 40px" scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_quan_li_phi']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['quan_li_phi'],0,',',',')}} đ</th>

            </tr>


            <tr>
                <td style="text-align: center">10</td>
                <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tổng thu nhập</th>
                <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tong_thu_nhap'],0,',',',')}} đ</td>
            </tr>

            <tr>
                <td style="text-align: center" rowspan="5">11</td>
                <td rowspan="5">Khấu trừ</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">BHXH</th>
                <th scope="colgroup" style="text-align: right;">{{number_format($data['khautru_BHXH'],0,',',',')}} đ</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px" scope="col">BHTN</th>
                <th scope="col" style="text-align: right;">{{number_format($data['khautru_BHTN'],0,',',',')}} đ</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">BHYT</th>
                <th scope="col" style="text-align: right;">{{number_format($data['khautru_BHYT'],0,',',',')}} đ</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">KPCĐ</th>
                <th scope="col" style="text-align: right;">{{number_format($data['khautru_KPCD'],0,',',',')}} đ</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Tổng</th>
                <th scope="col" style="text-align: right;">{{number_format($data['tong_khau_tru'],0,',',',')}} đ</th>
            </tr>


            <tr>
                <td style="text-align: center;background: #ed7d31">12</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Thuế TNCN</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['thue_TNCN'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31" >13</td>
                <th  style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Trừ tạm ứng, nợ thuế</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['tru_tamung'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31" >14</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Trừ các khoản khác</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['chiphiphatsinhkhac'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31" >15</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Thực lĩnh</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['thuclinh'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31">16</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Số TK cá nhân</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{$data['so_taikhoan_canhan']}}</td>
            </tr>

        </table>
    </div>
    <?php elseif ($data['type'] =='tonghopthunhap'):?>
    <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end ">
            <h3 style="font-family: 'Times New Roman',serif; font-variant: normal!important;">I. Các khoản tính thuế</h3>
            <table class="table table-bordered table-striped txt-center" border="1" width="100%" style="border-collapse:collapse;text-align: center; width: 50%; margin-left:auto; margin-right:auto;font-family:'Times New Roman', serif;font-variant:normal;font-size: 1rem;">
                {{ dd($data) }}
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;font-size: 1rem;">STT</th>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Danh mục</th>
                    <td colspan="2" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Số tiền</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">1</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px;font-size: 1rem;">Lương ngạch bậc</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['luong_ngach_bac'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">2</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp chức vụ</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_chucvu'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">3</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Quản lý phí</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['quan_ly_phi'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">4</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp Công tác Đảng</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_congtac_dang'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">5</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Lương tăng thêm</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['luong_tang_them'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">6</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp thâm niên vượt khung</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_thamnien_vuotkhung'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">7</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp khác	</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_khac'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">8</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tiền giảng</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tien_giang'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">9</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tiền công NCKH</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tiencong_nckh'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">10</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phúc lợi</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phuc_loi'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">11</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Lương tháng 13</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['luongthang_muoi_ba'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">12</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Thu nhập khác</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['thunhap_khac'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">13</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tổng</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tong_cackhoan_tinhthue'],0,',',',')}} đ</td>
                </tr>
            </table>
            <h3 style="font-family: 'Times New Roman',serif; font-variant: normal!important;">II. Các khoản không tính thuế</h3>
        <table class="table table-bordered table-striped txt-center" border="1" width="100%" style="border-collapse:collapse;text-align: center; width: 50%; margin-left:auto; margin-right:auto;font-family:'Times New Roman', serif;font-variant:normal;font-size: 1rem;">
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;">STT</th>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Danh mục</th>
                    <td colspan="2" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Số tiền</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">1</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp thâm niên nghề</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_thamnien_nghe'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">2</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Phụ cấp ưu đãi nghề</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['phucap_uudai_nghe'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">3</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tổng</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tongcackhoan_khongtinhthue'],0,',',',')}} đ</td>
                </tr>
            </table>
            <h3 style="font-family: 'Times New Roman',serif; font-variant: normal!important;">III. Các khoản giảm trừ</h3>
        <table class="table table-bordered table-striped txt-center" border="1" width="100%" style="border-collapse:collapse;text-align: center; width: 50%; margin-left:auto; margin-right:auto;font-family:'Times New Roman', serif;font-variant:normal;font-size: 1rem;">
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;">STT</th>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Danh mục</th>
                    <td colspan="2" style="text-align: center;font-weight: 700;background: #ffe599;height: 40px">Số tiền</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">1</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Bảo hiểm thât nghiệp trừ vào lương</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['baohiem_thatnghiep_truvaoluong'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">2</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Bảo hiểm xã hội trừ vào lương</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['baohiem_xahoi_truvaoluong'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">3</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Bảo hiểm y tế trừ vào lương</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['baohiem_yte_truvaoluong'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">4</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Kinh phí công đoàn trừ vào lương</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['kinhphi_congdoan_truvaoluong'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">5</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Giảm trừ bản thân</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['giamtru_banthan'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">6</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tổng tiền giảm trừ người phụ thuộc</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tongtien_giamtru_nguoiphuthuoc'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 100;">7</th>
                    <th scope="row" style="text-align: left;font-weight: 100;height: 40px">Tổng</th>
                    <td colspan="2" style="text-align: right;font-weight: 700">{{number_format($data['tong_cackhoan_giamtru'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ed7d31"></th>
                    <th scope="row" style="text-align: left;font-weight: 700;height: 40px;background: #ed7d31">Tổng thu nhập tính thuế</th>
                    <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['tong_thunhap_tinhthue'],0,',',',')}} đ</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center;font-weight: 700;background: #ed7d31"></th>
                    <th scope="row" style="text-align: left;font-weight: 700;height: 40px;background: #ed7d31">Thuế TNCN</th>
                    <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['thue_TNCN'],0,',',',')}} đ</td>
                </tr>
            </table>

    </div>
    <?php else:?>
        <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end">
        <table border="1" width="50%" style="border-collapse:collapse;margin-left:auto; margin-right:auto;font-family:'Times New Roman', serif;font-variant:normal;font-size: 1rem;">
            <colgroup span="2"></colgroup>
            <colgroup span="2"></colgroup>
            <tr>
                <td style="background: #ffe599;font-weight: bold;text-align: center">STT</td>
                <td style="background: #ffe599;font-weight: bold;text-align: center">Danh mục</td>
                <th style="font-weight: 100;text-align: left;height: 40px;background: #ffe599"  scope="colgroup"></th>
                <th scope="colgroup" style="text-align: center;height: 40px;background:#ffe599;font-weight: bold">Số tiền</th>
            </tr>
            <tr>
                <td style="text-align: center" rowspan="2">1</td>
                <td rowspan="2">Tiền giảng</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Số tiết</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['sotiet_tien_giang']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{number_format($data['tien_giang'],0,',',',')}} đ</th>
            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">2</td>
                <td rowspan="2">Quản lí phí</td>
                <th style="font-weight: 100;text-align: left;height: 40px"   scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{$data['hs_quan_ly_phi']}}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['quan_ly_phi'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">3</td>
                <td rowspan="2">Lương tăng thêm</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Hệ số</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{ $data['hs_luong_tang_them'] }}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['luong_tang_them'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center" rowspan="2">4</td>
                <td rowspan="2">Khoán điện thoại</td>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="colgroup">Số tháng</th>
                <th scope="colgroup" style="text-align: right;height: 40px">{{ $data['sothang_dienthoai'] }}</th>
            </tr>
            <tr>
                <th style="font-weight: 100;text-align: left;height: 40px"  scope="col">Số tiền</th>
                <th scope="col" style="text-align: right;height: 40px">{{number_format($data['khoan_dien_thoai'],0,',',',')}} đ</th>

            </tr>

            <tr>
                <td style="text-align: center;background: #ed7d31" >5</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Thu nhập khác</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['thu_nhap_khac'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31">6</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Trừ tạm ứng, thuế TNCN</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['trutam_ungthue_tncn'],0,',',',')}} đ</td>
            </tr>
            <tr>
                <td style="text-align: center;background: #ed7d31">7</td>
                <th style="text-align: left;font-weight: 700;background: #ed7d31;height: 40px" scope="row">Thực nhận</th>
                <td colspan="2" style="text-align: right;font-weight: 700;background: #ed7d31">{{number_format($data['thuc_nhan'],0,',',',')}} đ</td>
            </tr>

        </table>
    </div>
    <?php endif;?>
    <br>
    <p>Chi tiết tra cứu vui lòng truy cập hệ thống <a href="http://dieuhanh.ute.udn.vn/"> Điều hành tác nghiệp</a> để xem thêm. Hoặc liên hệ phòng Kế hoạch tài chính</p>
</div>