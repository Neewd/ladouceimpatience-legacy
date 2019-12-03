<?php

namespace Neewd\Newsletter\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $successStatus = 200;
    public $notAuthorizedStatus = 401;
    public $notFoundStatus = 404;
    public $conflictStatus = 409;
    public $errorStatus = 500;

}
