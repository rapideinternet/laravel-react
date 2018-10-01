<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;


class BladeIdViewComposer
{
    /**
     * Bind id of the view
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        //get the view path
        //trim viewpath
        //trim blade.php
        //replace / with _
        $viewId = str_replace('.', '_', $view->getName());
        $view->with('viewId', $viewId);
        $view->with('bladeId', '#' . $viewId);
        $view->with('bladeClass', '.' . $viewId);
    }
}
