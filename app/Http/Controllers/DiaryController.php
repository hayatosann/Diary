<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    //
    public function index()
    {
        $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();
        // dd($diaries); 
        // return 'Hello World';
        return view('diaries.index',compact('diaries'));
    }

    public function create()
    {
        // views/diaries/create.blade.phpを表示する
        return view('diaries.create');
    }

    public function store(CreateDiary $request)
    {
        $diary = new Diary(); //Diaryモデルをインスタンス化
        
        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index');
    }

    public function destroy(Diary $diary)
    {
        //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
        // $diary = Diary::find($id); 

        //取得したデータを削除
        $diary->delete();

        return redirect()->route('diary.index');
    }

    public function edit(Diary $diary)
    {
        // $diary = Diary::find($id); 

        return view('diaries.edit', compact('diary'));
    }

    public function update(Diary $diary, CreateDiary $request)
    {
        // $diary = Diary::find($id);

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function like(int $id)
    {
    
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->attach(Auth::user()->id);
    }

    public function dislike(int $id)
    {
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->detach(Auth::user()->id);
    }
}
