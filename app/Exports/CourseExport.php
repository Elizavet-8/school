<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use Illuminate\Contracts\View\View;

//use Maatwebsite\Excel\Concerns\FromCollection;

class CourseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return Course::all();
//    }
    public function view(): View
    {
        return view('export.course', [
            'courses' => Course::all()
        ]);
    }
}
