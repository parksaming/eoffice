<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Vanban;

class NotificationController extends Controller
{
    public function list_notifications() {
        $userId = session('user')['id'];

        $notifications = Notification::listNotifications($userId)->limit(10)->get();

        $noUnReadNotification = Notification::listUnReadNotifications($userId)->count();

        return view('templates._notification_content', compact('notifications', 'noUnReadNotification'));
    }

    public function view_notification($notificationId) {
        // get params
        $notification = Notification::find($notificationId);
        $tyles = Notification::$types;

        // update read_at
        if (!$notification->read_at) {
            $notification->read_at = date('Y-m-d H:i:s');
            $notification->save();
        }

        // redirect: văn bản
        if ($notification->type == $tyles['nhantraodoicongviec_vanbanden']) {
            return redirect(url('vanban/chi-tiet-van-ban-den/'.$notification->notificationable_id.'?tab=2'));
        }
        if ($notification->type == $tyles['nhantraodoicongviec_vanbannoibo']) {
            return redirect(url('vanbannoibo/chi-tiet/'.$notification->notificationable_id.'?tab=2'));
        }
        if ($notification->type == $tyles['nhantraodoicongviec_vanbandonvi']) {
            return redirect(route('chitiet_vanban_donvi', [$notification->notificationable_id, 'tab' => 2]));
        }
        if (in_array($notification->type, [$tyles['nhanvanbanmoi'], $tyles['nhanvanbanchuyenxuly'], $tyles['capnhattrangthaivanban'], $tyles['nhanvanbannoibo'], $tyles['nhanvanbannoibochuyenxuly']])) {
            if ($notification->notificationable) {
                $vanban = Vanban::find($notification->notificationable->vanbanUser_id);

                if ($vanban->book_id == '4') {
                    return redirect(url('vanbannoibo/chi-tiet', $vanban->id));
                }
                else {
                    return redirect(route('chitiet_vanban', [$vanban->id]));
                }
            }
            else {
                flash('Văn bản xử lý không tồn tại hoặc đã bị xóa');
                return redirect(route('danhsach.vanbanden'));
            }
        }
        if (in_array($notification->type, [$tyles['nhanvanbanmoi'], $tyles['nhanvanbanchuyenxuly'], $tyles['capnhattrangthaivanban'], $tyles['nhanvanbannoibo'], $tyles['nhanvanbannoibochuyenxuly']])) {
            if ($notification->notificationable) {
                $vanban = Vanban::find($notification->notificationable->vanbanUser_id);

                if ($vanban->book_id == '4') {
                    return redirect(url('vanbannoibo/chi-tiet', $vanban->id));
                }
                else {
                    return redirect(route('chitiet_vanban', [$vanban->id]));
                }
            }
            else {
                flash('Văn bản xử lý không tồn tại hoặc đã bị xóa');
                return redirect(route('danhsach.vanbanden'));
            }
        }
        // redirect: công việc
        if (in_array($notification->type, [$tyles['nhancongviecmoi'], $tyles['nhanbaocaocongviec']])) {
            if ($notification->notificationable && $notification->notificationable->vanban_id) {
                return redirect(route('chitiet_vanban', [$notification->notificationable->vanban_id]).'?tab=3&congviec_id='.$notification->notificationable->id);
            }
            else if ($notification->notificationable && $notification->notificationable->vanban_donvi_id) {
                return redirect(route('chitiet_vanban_donvi', [$notification->notificationable->vanban_donvi_id]).'?tab=3&congviec_id='.$notification->notificationable->id);
            }
            else {
                flash('Công việc không tồn tại hoặc đã bị xóa');
                return redirect(route('danhsachcongviec'));
            }
        }
        // redirect: lịch tuần
        if (in_array($notification->type, [$tyles['nhandangkylichtuan'], $tyles['dangkylichtuandaduocduyet'], $tyles['dangkylichtuandabituchoi']])) {
            if ($notification->notificationable) {
                return redirect(route('phonghop.danhsachdangkylichtuan', ['date' => $notification->notificationable->time]));
            }
            else {
                flash('Lịch tuần không tồn tại hoặc đã bị xóa');
                return redirect(route('phonghop.danhsachdangkylichtuan'));
            }
        }
        if ($notification->type == $tyles['nhanvanbanbanhanh']) {
            return redirect(route('danhsach_vanban_banhanh'));
        }
    }

    public function view_all() {
        $userId = session('user')['id'];

        Notification::listUnReadNotifications($userId)->update(['read_at' => date('Y-m-d H:i:s')]);

        die(json_encode(['error' => 0]));
    }
}
