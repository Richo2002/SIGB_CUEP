<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarianOrReader');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group_id)
    {
        $group = Group::findOrfail($group_id);

        return view('members', [
            'group' => $group
        ]);
    }
}
