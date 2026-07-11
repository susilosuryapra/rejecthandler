<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditTrailController extends Controller
{
    public function index()
    {
        return view('audit-trail.index');
    }
}