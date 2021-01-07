<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class BaseController extends Controller {

    protected $viewData = [];

    public function __construct() {

    }

    protected function getView($view) {
        $masterTemplate = 'frontend.layouts.master';
        return view($masterTemplate, array(
            'template' => 'frontend.' . $this->moduleName . '.' . $view,
            'masterTemplate' => $masterTemplate,
            'viewData' => $this->viewData,
            'moduleName' => $this->moduleName,
        ));
    }

    public function getSView($view) {
        return view('frontend.' . $this->moduleName . '.' . $view, $this->viewData);
    }


}
