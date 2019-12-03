<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satreps_collect_data;
use PhpParser\Node\Expr\AssignOp\Coalesce;
use Input;
use Response;

class PostsController extends Controller
{
    public function ajax(Request $request)
    {
        $json = response()->json([
            $request->get("rect_sx"),
            $request->get("rect_sy"),
            $request->get("rect_ex"),
            $request->get("rect_ey")
        ]);
        return $json;
    }


    public function insert_data()
    {
        $gender = Input::get('gender'); //名
        $gender = htmlspecialchars($gender); //フォーム欄のコード埋め込みを防ぐ
        $age = Input::get('age'); //名前
        $age = htmlspecialchars($age); //フォーム欄のコード埋め込みを防ぐ
        $nationality = Input::get('nationality'); //名前
        $nationality = htmlspecialchars($nationality); //フォーム欄のコード埋め込みを防ぐ  
        $image_name = Input::get('image_name'); //名前
        $image_name = htmlspecialchars($image_name); //フォーム欄のコード埋め込みを防ぐ
        $image_type = Input::get('image_type'); //名前
        $image_type = htmlspecialchars($image_type); //フォーム欄のコード埋め込みを防ぐ
        $factors = Input::get('factors'); //名前
        $factors = htmlspecialchars($factors); //フォーム欄のコード埋め込みを防ぐ
        $image_path = Input::get('image_path'); //名前
        $image_path = htmlspecialchars($image_path); //フォーム欄のコード埋め込みを防ぐ
        $comfortable = Input::get('comfortable'); //名前
        $comfortable = htmlspecialchars($comfortable); //フォーム欄のコード埋め込みを防ぐ
        $rect_sx = Input::get('rect_sx'); //名前
        $rect_sx = htmlspecialchars($rect_sx); //フォーム欄のコード埋め込みを防ぐ
        $rect_sy = Input::get('rect_sy'); //名前
        $rect_sy = htmlspecialchars($rect_sy); //フォーム欄のコード埋め込みを防ぐ
        $rect_ex = Input::get('rect_ex'); //名前
        $rect_ex = htmlspecialchars($rect_ex); //フォーム欄のコード埋め込みを防ぐ
        $rect_ey = Input::get('rect_ey'); //名前
        $rect_ey = htmlspecialchars($rect_ey); //フォーム欄のコード埋め込みを防ぐ

        try //実行
        {
            Satreps_collect_data::insert([
                'gender' => $gender,
                'age' => $age,
                'nationality' => $nationality,
                'image_name' => $image_name,
                'image_type' => $image_type,
                'image_path' => $image_path,
                'comfortable' => $comfortable,
                'factors' => $factors,
                'rect_sx' => $rect_sx,
                'rect_sy' => $rect_sy,
                'rect_ex' => $rect_ex,
                'rect_ey' => $rect_ey,
            ]); //データ登録
            return Response::make('0'); //データ登録成功
        } catch (Exception $e) //例外
        {
            return Response::make('1'); //データ登録失敗
        }
    }
}
