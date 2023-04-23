<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\Article;

use WithPagination;

class AppController extends Controller
{

    public function find()
    {
        return view(view:'Finding');
    }

    /*
    функция для получения названия месяца по-русски
    $num_month - номер месяца,
    не обязательный параметр, если параметр не задан, 
    то функция вернет название текущего месяца
    */
    public function getMonthRus($num_month = false){
        // если не задан номер месяца
        if(!$num_month){
            // номер текущего месяца
            $num_month = date('n');
        }
        // массив с названиями месяцев
        $monthes = array(   
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 
            4 => 'Апрель', 5 => 'Май', 6 => 'Июнь', 
            7 => 'Июль', 8 => 'Август',9 => 'Сентябрь', 
            10 => 'Октябрь', 11 => 'Ноябрь', 
    12 => 'Декабрь'
        );
        // получаем название месяца из массива
        $name_month = $monthes[$num_month];
        // вернем название месяца
        return $name_month;
    }

    public function welcome()
    {
        return view(view:'welcome');
    }

    public function prompred()
    {
        $articles = Article::query()->paginate(6,['a_date', 'a_text', 'a_title']);

        //$dates = Article::query()->where()
        //$date = DB::select("select CURRENT_DATE() as DATE");

        //$currentDate = date("d.m.Y");

        $year = date("Y");

        $day = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));

        $month = date("n");

        $monthes = array(   
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 
            4 => 'Апрель', 5 => 'Май', 6 => 'Июнь', 
            7 => 'Июль', 8 => 'Август',9 => 'Сентябрь', 
            10 => 'Октябрь', 11 => 'Ноябрь', 
            12 => 'Декабрь'
        );
        // получаем название месяца из массива
        $name_month = $monthes[$month];

        $paginationTheme = 'bootstrap';

        $events = DB::table('article')->where('a_date', '>=', "$year-$month-1")->where('a_date', '<=', "$year-$month-30")->pluck('a_date')->toArray();;

        return view('PromPred', ['articles'=>$articles, 'year'=>$year, 'name_month'=>$name_month, 'month'=>$month, 'events'=>$events]);
    }
 
    public function mailto()
    {
        return view(view:'MailTo');
    }

    public function test()
    {
        return view(view:'test');
    }
}
