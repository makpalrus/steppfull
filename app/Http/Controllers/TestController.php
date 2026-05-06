<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class TestController extends Controller
{
    public function index()
    {
        $tests = [
            ['id'=>1,'title'=>'Типология Голланда','url'=>'https://trud.com/kz/test','active'=>true],
            ['id'=>2,'title'=>'Профессии для студентов','url'=>'https://proforientator.ru/tests','active'=>true],
            ['id'=>3,'title'=>'Soft Skills','url'=>'https://www.16personalities.com/ru','active'=>true],
            ['id'=>4,'title'=>'Тест для студентов KZ','url'=>'https://enbek.kz/ru/career-guidance','active'=>true],
        ];
        return view('moderator.tests.index', compact('tests'));
    }
    public function store(Request $request)
    {
        return back()->with('success', '✅ Тест добавлен');
    }
    public function destroy($id)
    {
        return back()->with('success', '🗑 Тест удалён');
    }
}