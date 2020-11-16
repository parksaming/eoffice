<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use App\Models\VanbanXuLy;
use App\Models\VanbanXuLyDonvi;

include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;

function detect_text($path)
{
    putenv("GOOGLE_APPLICATION_CREDENTIALS=./udbike-28a9706e1d10.json");
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();

    $str = [];
    foreach ($texts as $text) {
        $str[] = $text->getDescription();
    }

    $imageAnnotator->close();

    return (object)['count' => sizeof($texts), 'text' => $str];
}

function base_url($base_url = array())
{
    $url = Request::url() . '?';
    foreach ($base_url as $key => $value) {
        $url .= $key . "=" . $value . "&";
    }
    return rtrim(rtrim($url, "&"), "?");
}

function sort_title($name = '', $title = '')
{
    $base_url = Request::all();
    $base_url['sortby'] = $name;
    $base_url['order'] = "ASC";
    $base_url['ajax'] = 0;
    if (Input::has('page')) {
        $base_url['page'] = Input::get('page');
    }

    //sorting
    if (Input::has('sortby') && Input::has('order')) {
        $base_url['sortby'] = $name;
        $base_url['order'] = (Input::get('order') == "ASC") ? "DESC" : "ASC";
    }


    $type_sort = Input::get('order') == "ASC" ? '<i class="fa fa-sort-amount-asc sort-icon"></i>' : '<i class="fa fa-sort-amount-desc sort-icon"></i>';
    $link = "<a href=" . base_url($base_url) . ">" . (($name == Input::get('sortby')) ? $type_sort : '') . " " . (($title != '') ? $title : $name) . "</a>";
    return $link;
}

function vn_str_filter($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return strtolower(str_replace(" ", '-', trim($str)));
}

//PHP Excel
function col($index)
{
    return PHPExcel_Cell::stringFromColumnIndex($index);
}

function cell($col, $row)
{
    return col($col) . $row;
}

function cells($col1, $row1, $col2, $row2, $type = 'range')
{
    if ($type == 'range') {
        return cell($col1, $row1) . ':' . cell($col1 + $col2 - 1, $row1 + $row2 - 1);
    }
    if ($type == 'coodinate') {
        return cell($col1, $row1) . ':' . cell($col2, $row2);
    }
    return '';
}

//END PHP Excel

function rand_color()
{
    return sprintf('%06X', mt_rand(0x999999, 0xFFFFFF));
}


/**
 * @param string $datetime
 * @param string $formatDisplay : default d/m/Y H:i:s
 * @return string: date after format
 */
function formatDateTimeToDisplay($datetime, $formatDisplay = 'd/m/Y H:i:s')
{
    return ($datetime) ? date($formatDisplay, strtotime(str_replace('/', '-', $datetime))) : '';
}

function formatYMD($dateTime)
{
    return ($dateTime) ? date('Y-m-d', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatYDM($dateTime)
{
    return ($dateTime) ? date('Y-d-m', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatMY($dateTime)
{
    return ($dateTime) ? date('m/Y', strtotime(str_replace('-', '/', $dateTime))) : '';
}

function formatYM($dateTime)
{
    return ($dateTime) ? date('Y-m', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatYM1($dateTime)
{
    return ($dateTime) ? date('Y-m', strtotime(str_replace('/', '_', $dateTime))) : '';
}

function formatDMY($dateTime)
{
    return ($dateTime) ? date('d/m/Y', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatdmYY($dateTime)
{
    return ($dateTime) ? date('d-m-Y', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatHI($dateTime)
{
    return ($dateTime) ? date('H:i', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatMonth($dateTime)
{
    return ($dateTime) ? date('F', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatMonthNumber($dateTime)
{
    return ($dateTime) ? date('m', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatYearNumber($dateTime)
{
    return ($dateTime) ? date('Y', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function formatDayMonth($dateTime)
{
    return ($dateTime) ? date('d-F', strtotime(str_replace('/', '-', $dateTime))) : '';
}

function createLink($parameters, $linkBase)
{
    $str = '';
    foreach ($parameters as $key => $value) {
        $str .= $key . '=' . $value . '&';
    }
    $str = trim($str, '&');

    return trim($linkBase, '?') . '?' . $str;
}

function debug($data)
{
    echo "=================================================================<br/>";
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function formatdate($date)
{
    $month = strtotime($date);
    $month = date("F", $month);
    $day = strtotime($date);
    $day = date("d", $day);
    return ($day . '-' . $month);
}

function formatdatefull($date)
{
    $year = strtotime($date);
    $year = date("Y", $year);
    $month = strtotime($date);
    $month = date("F", $month);
    $day = strtotime($date);
    $day = date("d", $day);
    return ($day . '-' . $month . '-' . $year);
}


function formatByMonth($date)
{
    $month = strtotime($date);
    $month = date("F", $month);
    return ($month);
}

function formatByDay($date)
{
    $day = strtotime($date);
    $day = date("d", $day);
    return ($day);
}

function formatByYear($date)
{
    $year = strtotime($date);
    $year = date("Y", $year);
    return ($year);
}

function callmonthofyear($month, $year)
{
    $year = formatByYear($year);
    $monthFeb = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28);
    if (is_int($year / 4)) {
        $monthFeb = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29);
    }
    $calenderArray = array(
        'January' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'February' => $monthFeb,
        'March' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'April' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30),
        'May' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'June' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30),
        'July' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'August' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'September' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30),
        'October' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),
        'November' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30),
        'December' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31),

    );
    foreach ($calenderArray as $key => $day) {
        if (isset($month) && $month == $key) {
            foreach ($calenderArray[$month] as $value) {
                $arraydatesOfMonth[] = $value . '-' . substr($month, 0, 3);
            }
        }
    }
    return $arraydatesOfMonth;
}

function getCurrentLanguage()
{
    return Session::get('locale');
}

function convertCarbonToVN($time)
{
    $timeVN = \Carbon\Carbon::createFromTimeStamp(strtotime($time))->diffForHumans();
    $timeVN = preg_replace('/(second ago)|(seconds ago)/', 'giây trước', $timeVN);
    $timeVN = preg_replace('/(minutes ago)|(minute ago)/', 'phút trước', $timeVN);
    $timeVN = preg_replace('/(hours ago)|(hour ago)/', 'giờ trước', $timeVN);
    $timeVN = preg_replace('/(day ago)|(days ago)/', 'ngày trước', $timeVN);
    $timeVN = preg_replace('/(week ago)|(weeks ago)/', 'tuần trước', $timeVN);
    $timeVN = preg_replace('/(month ago)|(months ago)/', 'tháng trước', $timeVN);
    $timeVN = preg_replace('/(year ago)|(years ago)/', 'năm trước', $timeVN);
    return $timeVN;
}

function show_menu($donvis = array(), $parent_id = null, $level = null, $donvi_us = null, $str = null)
{
    $level++;
    if (!$parent_id)
        $parent_id = "";
    $current_menus = array();
    $current = array();
    foreach ($donvis as $key => $val) {
        if ($val['Donvi']['parent_id'] == $parent_id) {
            $current_menus[] = $val;
            unset($donvis[$key]);
        }
    }

    if (sizeof($current_menus) > 0) {
        foreach ($current_menus as $key => $val) {
            if ($val['Donvi']['parent'] == $donvi_us || substr($val['Donvi']['parent'], 0, 6) == $donvi_us) {
                echo '
                    <option value="' . $val['Donvi']['madonvi'] . '">' . $str . " " . $val['Donvi']['name'] . '</option>
                ';
            }
            show_menu($donvis, $val['Donvi']['id'], $level, $donvi_us, $str . '--');
        }
    }
}

function search($colum, $search)
{

}

function save_log($username_create = null, $user_affected = null, $content, $key, $donvi_id = null, $vanbanId = null)
{
    $log = new App\Models\Log();
    $log->user_create = $username_create;
    $log->user_affected = $user_affected;
    $log->content = $content;
    $log->created = date('Y-m-d H:i:s');
    $log->type = $key;
    $log->donvi_id = $donvi_id;
    $log->vanban_id = $vanbanId;
    $log->status = 1;
    $log->save();
}

function childVanBan($parent_id, &$vb_child = [])
{
    $vbchilds = VanbanXuLy::select('vanban_xulys.*', 'tbUserGui.fullname as nameUserGui', 'tbUserNhan.fullname as nameUserNhan', 'donvis.name as tenDonVi', 'vanbans.ngaygui', 'vanbans.user_id as IdUser')
        ->where('vanban_xulys.parent_id', $parent_id)
        ->leftJoin('vanbans', 'vanban_xulys.vanbanUser_id', '=', 'vanbans.id')
        ->leftJoin('users as tbUserGui', 'tbUserGui.id', '=', 'vanban_xulys.user_tao')
        ->leftJoin('users as tbUserNhan', 'tbUserNhan.id', '=', 'vanban_xulys.id_nhan')
        ->leftJoin('donvis', 'donvis.id', '=', 'tbUserNhan.donvi_id')
        ->get();

    if ($vbchilds) {
        foreach ($vbchilds as $key => $item) {
            $vb_child[] = (object)$item->toArray();
            childVanBan($item->id, $vb_child);
        }
    }
}

function childVanBanDonvi($parent_id, &$vb_child = [])
{
    $vbchilds = VanbanXuLyDonvi::select('vanban_xulys_donvi.*', 'tbUserGui.fullname as nameUserGui', 'tbUserNhan.fullname as nameUserNhan', 'donvis.name as tenDonVi', 'vanbans_donvi.ngaygui', 'vanbans_donvi.user_id as IdUser')
        ->where('vanban_xulys_donvi.parent_id', $parent_id)
        ->leftJoin('vanbans_donvi', 'vanban_xulys_donvi.vanbanUser_id', '=', 'vanbans_donvi.id')
        ->leftJoin('users as tbUserGui', 'tbUserGui.id', '=', 'vanban_xulys_donvi.user_tao')
        ->leftJoin('users as tbUserNhan', 'tbUserNhan.id', '=', 'vanban_xulys_donvi.id_nhan')
        ->leftJoin('donvis', 'donvis.id', '=', 'tbUserNhan.donvi_id')
        ->get();

    if ($vbchilds) {
        foreach ($vbchilds as $key => $item) {
            $vb_child[] = (object)$item->toArray();
            childVanBanDonvi($item->id, $vb_child);
        }
    }
}

function getCayLuanChuyen($parent_id, $tree = '')
{
    $user = Session::get('user');
    $vbchilds = VanbanXuLy::select('vanban_xulys.*', 'users.fullname', 'donvis.name as tenDonVi')
        ->where('vanban_xulys.parent_id', $parent_id)
        ->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'vanban_xulys.id_nhan');
        })
        ->leftJoin('donvis', function ($join) {
            $join->on('donvis.id', '=', 'users.donvi_id');
        })
        ->get();
    if (sizeof($vbchilds)) {
        $tree .= '<ul class="ulsub ' . (sizeof($vbchilds) == 1 ? 'one-child' : '') . '">';
        foreach ($vbchilds as $item) {
            $tree .= '<li class="li-flex">   
                        <div><div class="' . ($item->ngayxem ? '' : 'anh ' . $item->ngayxem) . '"></div></div>                      
                        <div><div class="' . $item->id . ' title ' . ($item->type == 1 ? 'item-chutri ' : '') . ($item->status == 1 ? 'item-chuaxuly' : ($item->status == 2 ? 'item-dangxuly' : 'item-daxuly')) . '"><span class=' . ($item->id_nhan == $user['id'] ? 'colorblu' : '') . '>' . $item->fullname . '</span>
                        <br><span>' . ($item->tenDonVi) . '</span><br>';
            if ($item->status == 3 && $item->ngayxem == null):
                $tree .= '<span></span>';
            elseif ($item->status == 3 && $item->ngayxem != null):
                $tree .= '<span ><div title="Ngày xem"><i style="margin-right: 2px" class="fa fa-clock-o" aria-hidden="true"></i>' . formatDateTimeToDisplay($item->ngayxem) .'</div><div title="Ngày xử lý"><i style="margin-right: 2px" class="fa fa-history" aria-hidden="true"> </i>'.formatDateTimeToDisplay($item->ngayxuly). '</div></span>';
            elseif ($item->status == 1 && $item->ngayxem != null):
                $tree .= '<span><div title="Ngày xem" ><i style="margin-right: 2px" class="fa fa-clock-o" aria-hidden="true"></i>' . formatDateTimeToDisplay($item->ngayxem) . '</div></span>';
            endif;

            $tree .=' </div></div>';
            $tree = getCayLuanChuyen($item->id, $tree);
            $tree .= "</li>";
        }
        $tree .= "</ul> <div class='clear'></div>";
    }

    return $tree;
}

function getCayLuanChuyenDonvi($parent_id, $tree = '')
{
    $user = Session::get('user');
    $vbchilds = VanbanXuLyDonvi::select('vanban_xulys_donvi.*', 'users.fullname', 'donvis.name as tenDonVi')
        ->where('vanban_xulys_donvi.parent_id', $parent_id)
        ->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'vanban_xulys_donvi.id_nhan');
        })
        ->leftJoin('donvis', function ($join) {
            $join->on('donvis.id', '=', 'users.donvi_id');
        })
        ->get();
    if (sizeof($vbchilds)) {
        $tree .= '<ul class="ulsub ' . (sizeof($vbchilds) == 1 ? 'one-child' : '') . '">';
        foreach ($vbchilds as $item) {
            $tree .= '<li class="li-flex">   
                        <div><div class="' . ($item->ngayxem ? '' : 'anh ' . $item->ngayxem) . '"></div></div>                      
                        <div><div class="' . $item->id . ' title ' . ($item->type == 1 ? 'item-chutri ' : '') . ($item->status == 1 ? 'item-chuaxuly' : ($item->status == 2 ? 'item-dangxuly' : 'item-daxuly')) . '"><span class=' . ($item->id_nhan == $user['id'] ? 'colorblu' : '') . '>' . $item->fullname . '</span>
                        <br><span>' . ($item->tenDonVi) . '</span><br>';
                       // <span>' . ($item->status == 3 ? ($item->ngayxem == null ? '' : formatDateTimeToDisplay($item->ngayxuly)) : formatDateTimeToDisplay($item->ngayxem)) . '</span>
                        //</div></div>';
            if ($item->status == 3 && $item->ngayxem == null):
                $tree .= '<span></span>';
            elseif ($item->status == 3 && $item->ngayxem != null):
                $tree .= '<span ><div title="Ngày xem"><i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 2px"></i>' . formatDateTimeToDisplay($item->ngayxem) .'</div><div title="Ngày xử lý"><i style="margin-right: 2px" class="fa fa-history" aria-hidden="true"> </i> '.formatDateTimeToDisplay($item->ngayxuly). '</div></span>';
            elseif ($item->status == 1 && $item->ngayxem != null):
                $tree .= '<span><div title="Ngày xem" ><i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 2px"></i> ' . formatDateTimeToDisplay($item->ngayxem) . '</div></span>';
            endif;
            $tree = getCayLuanChuyenDonvi($item->id, $tree);
            $tree .= "</li>";
        }
        $tree .= "</ul> <div class='clear'></div>";
    }

    return $tree;
}

function sendMailMailer($data, $template, $subject, $toUsers, $fromUser = null)
{
    // create content
    $content = (string)\Illuminate\Support\Facades\View::make($template, $data);

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = config('mail.host');
        $mail->SMTPAuth = true;
        $mail->Username = config('mail.username');
        $mail->Password = config('mail.password');
        $mail->SMTPSecure = config('mail.encryption');
        $mail->Port = config('mail.port');
        $mail->setFrom($fromUser ? $fromUser->email : config('mail.from.address'), 'Điều Hành Tác Nghiệp');

        //Recipients
        foreach ($toUsers as $toUser) {
            $toUser = (object)$toUser;
            $mail->addAddress($toUser->email, isset($toUser->name) ? $toUser->name : '');
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $content;

        $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];

        $mail->send();
    } catch (\Exception $e) {
    }
}

    function sendMailLuongPhuCap($data, $template, $subject, $emailUser, $fromUser = null)
    {
        //dd([$data,$template,$subject,$emailUser,$fromUser]);die();
        // create content
        $content = (string)\Illuminate\Support\Facades\View::make($template, $data);

        $mail = new PHPMailer(true);
        try {

//            $mail->addAddress(config('mailluong.from.address'), isset($data->fullname) ? $data->fullname : '');
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = getenv('MAIL_HOST');
            $mail->Port       = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth   = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SetFrom(getenv('MAIL_USERNAME'), 'Điều Hành Tác Nghiệp');
            $mail->addAddress($emailUser, isset($data->fullname) ? $data->fullname : '');
//$mail->SMTPDebug  = 3;
//$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; //$mail->Debugoutput = 'echo';

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $content;

            $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
            $mail->send();
        } catch (\Exception $e) {

        }
    }
function sendMailSendgrid($subject, $content_html = '', $to, $from, $toname = '', $fromname = '', $content_text = '')
{
    $request = 'https://api.sendgrid.com/api/mail.send.json';

    $user = 'quangphi4190';
    $pass = 'phi112250522117';
    $fileA = '@attachment.pdf;type=application/pdf';
    //create data post
    $post_data = array(
        'api_user' => $user,
        'api_key' => $pass,
        'to' => $to,
        'toname' => $toname,
        'subject' => $subject,
        'html' => $content_html,
        'text' => $content_text,
        'from' => $from,
        'fromname' => $fromname,
        'files\[attachment.pdf\]' => $fileA
    );

    //create string data post
    foreach ($post_data as $key => $value) {
        $post_items[] = $key . '=' . $value;
    }
    $post_string = implode('&', $post_items);

    //create cURL connection
    $curl_connection = curl_init($request);
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

    //obtain response
    $result = curl_exec($curl_connection);
    //var_dump($result); die();
    //close the connection
    curl_close($curl_connection);

    return json_decode($result);
}
