<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookDetail;
use App\Models\Donvi;
use App\Models\User;
use App\Models\Book;

class BookController extends Controller
{
    public function get_danh_sach_co_quan(Request $request) {
        // get data
        $books = Book::getList()->get();

        // view
        return view('books.danh_sach_co_quan', compact('books'));
    }

    public function create_co_quan() {
        return view('books.create_co_quan');   
    }

    public function edit_co_quan($bookId) {
        // get book
        $book = Book::find($bookId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // view
        return view('books.edit_co_quan', compact('book'));   
    }

    public function save_co_quan(Request $request) {
        if ($request->id) {
            $book = Book::find($request->id);
            if (!$book) {
                flash('Cơ quan không tồn tại');
                return redirect(route('co_quan.list'));
            }
            
            $book->update([
                'name' => $request->name,
                'type' => $request->type
            ]);

            flash('Sửa cơ quan thành công');
        }
        else {
            Book::insert([
                'name' => $request->name,
                'type' => $request->type
            ]);

            flash('Thêm cơ quan thành công');
        }

        return redirect(route('co_quan.list'));
    }

    public function delete_co_quan(Request $request) {
        // xóa data
        Book::whereIn('id', $request->ids)->delete();
        BookDetail::whereIn('book_id', $request->ids)->delete();

        flash('Xóa cơ quan thành công');

        return response()->json(['error' => 0]);
    }

    public function get_danh_sach_don_vi($coquanId) {
        // get book
        $book = Book::find($coquanId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get bookDetails
        $bookDetails = BookDetail::getList($coquanId)->get();

        // get danh sách users trong mỗi bookDetail
        $users = User::getList()->get()->keyBy('id');
        foreach($bookDetails as $bookDetail) {
            $arrUsers = [];
            foreach($bookDetail->userIds as $userId) {
                if (isset($users[$userId])) {
                    $arrUsers[] = $users[$userId];
                }
            }

            $bookDetail->users = $arrUsers;
        }

        // view
        return view('books.danh_sach_don_vi', compact('book', 'bookDetails', 'users'));
    }

    public function delete_don_vi(Request $request) {
        // xóa data
        BookDetail::whereIn('id', $request->ids)->delete();

        flash('Xóa đơn vị thành công');

        return response()->json(['error' => 0]);
    }

    public function create_don_vi($coquanId) {
        $book = Book::find($coquanId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get data for selector
        $donvis = Donvi::getList()->get();
        $users = User::getList()->withDonVi()->get();

        // view
        return view('books.create', compact('book', 'donvis', 'users'));   
    }

    public function edit_don_vi($bookDetailId) {
        // get bookdetail
        $bookDetail = BookDetail::find($bookDetailId);
        if (!$bookDetail) {
            flash('Đơn vị không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get data for selector
        $donvis = Donvi::getList()->get();
        $users = User::getList()->withDonVi()->get();

        // view
        return view('books.edit', compact('donvis', 'users', 'bookDetail'));   
    }

    public function save_don_vi(Request $request) {
        if ($request->id) {
            $bookDetail = BookDetail::find($request->id);
            if (!$bookDetail) {
                flash('Đơn vị không tồn tại');
                return redirect(route('co_quan.list'));
            }
            
            $bookDetail->update([
                'donvi_id' => $request->donvi_id,
                'donvi_email' => ';'.str_replace(',', ';', $request->donvi_email).';',
                'user_id' => ';'.implode(';', $request->user_id).';'
            ]);

            flash('Sửa đơn vị thành công');
        }
        else {
            BookDetail::insert([
                'book_id' => $request->book_id,
                'donvi_id' => $request->donvi_id,
                'donvi_email' => ';'.str_replace(',', ';', $request->donvi_email).';',
                'user_id' => ';'.implode(';', $request->user_id).';'
            ]);

            flash('Thêm đơn vị thành công');
        }

        return redirect(route('co_quan.list_don_vi', [$request->book_id]));
    }
}
