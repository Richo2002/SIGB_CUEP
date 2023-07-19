<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LateGroupMembersNotification;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian')->except(['index']);
        $this->middleware('librarianOrReader')->only(['index']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groups');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);

        $this->authorize('view', $group);


        $readers = User::where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire']])
                            ->whereDoesntHave('group')
                            ->orWhere('id', $group->responsable->id)->get();


        return view('update-group', [
            'group' => $group,
            'readers' => $readers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['string', 'max:100', Rule::unique('groups')->ignore($id ?? null)],
            'responsable_id' => 'required_with:name',
        ]);

        $group = Group::findOrFail($id);

        $this->authorize('update', $group);

        $group->readers()->attach($group->responsable_id);
        $group->readers()->detach($request->responsable_id);

        $group->name = $request->name;
        $group->responsable_id = $request->responsable_id;
        $group->save();


        return redirect()->route('groups.index')->with(['message' => 'Mis à jour réussie']);
    }

    public function sendNotificationToLateGroupMembers()
    {


        $readers = User::where('role', '<>' ,'Administrateur')
                        ->where('role', '<>' ,'Bibliothécaire')
                        ->where(function($query){
                            $query->whereHas('groups', function($query) {
                                $query->whereHas('loans', function($query) {
                                    $query->where('status', "Retard")
                                    ->orWhere(function($query) {
                                         $query->whereRaw('DATEDIFF(CURDATE(), end_date) >= -2')->where('status', "En cour");
                                    })
                                    ->orderByDesc('id')
                                    ->limit(1);
                                });
                            })->orWhereHas('group', function($query) {
                                $query->whereHas('loans', function($query) {
                                    $query->where('status', "Retard")
                                    ->orWhere(function($query) {
                                         $query->whereRaw('DATEDIFF(CURDATE(), end_date) >= -2')->where('status', "En cour");
                                    })
                                    ->orderByDesc('id')
                                    ->limit(1);
                                });
                            });
                        })->get();

        Notification::send($readers, new LateGroupMembersNotification());
    }

}
