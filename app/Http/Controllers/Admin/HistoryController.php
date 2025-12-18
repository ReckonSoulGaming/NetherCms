<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logs;

class HistoryController extends Controller
{
    public function index()
    {
        $history = Logs::orderBy('created_at', 'desc')
            ->where('user_id', $this->getLoggedinUser()->id)
            ->take(40)
            ->get();

        return view('manage.user.history.index', [
            'history' => $history,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
