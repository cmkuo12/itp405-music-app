<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $maintenance_state = Configuration::getModeIsOn('maintenance-mode');
        return view('admin.index', [
            'maintenance_state' => $maintenance_state,
        ]);
    }

    public function configure(Request $request) {
        Configuration::setMode('maintenance-mode', $request->input('maintenance-mode'));
        $maintenance_state = Configuration::getModeIsOn('maintenance-mode');
        return redirect()->route('admin.index', [
            'maintenance_state' => $maintenance_state,
        ]);
    }
}
