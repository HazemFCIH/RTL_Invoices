<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //all
        $allInvoices_count = Invoice::count();
        $allInvoices_sum = Invoice::sum('total');
        //paid
        $paidInvoices_count = Invoice::where('value_status','3')->count();
        $paidInvoices_sum = Invoice::where('value_status','3')->sum('total');
        //partial
        $partialInvoices_count = Invoice::where('value_status','1')->count();
        $partialInvoices_sum = Invoice::where('value_status','1')->sum('total');
        //unpaid
        $unpaidInvoices_count = Invoice::where('value_status','2')->count();
        $unpaidInvoices_sum = Invoice::where('value_status','2')->sum('total');

        //charts


        $bar_chart = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 150])
            ->labels(['الفواتير الغير مدفوعة' ,'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا' , 'كل الفواتير'])
            ->datasets([
                [
                    "label" => "نسبة الفواتير",
                    'backgroundColor' => ['rgba(255, 0, 0, 0.69)', 'rgba(99, 226, 137, 1)','rgba(237, 130, 29, 1)','rgba(84, 179, 225, 1)'],
                    'data' => [$unpaidInvoices_count, $paidInvoices_count,$partialInvoices_count,$allInvoices_count]
                ],

            ])
            ->options([
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true,
                            ],
                        ],
                    ],
                ],
            ]);


        // pie chart


        $pie_chart = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 230])
            ->labels([ 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئيا','الفواتير المدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#f58142','#73c451'],
                    'hoverBackgroundColor' => ['#FF6384', '#ed641a','#84e85a'],
                    'data' => [$unpaidInvoices_sum,$partialInvoices_sum,$paidInvoices_sum]
                ]
            ])
            ->options([]);



        return view('home',compact(
            'allInvoices_count',
            'allInvoices_sum',
                    'paidInvoices_count',
                    'paidInvoices_sum',
                    'partialInvoices_count',
                    'partialInvoices_sum',
                    'unpaidInvoices_count',
                    'unpaidInvoices_sum',
                    'bar_chart',
                    'pie_chart'));
    }
}
