<?php

namespace App\View\Composers;


use Illuminate\View\View;

class AdminComposer
{

    public function compose(View $view)
    {
        $view->with('admin', auth()->guard('admin')->user());
    }
}
