<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Note;
use Carbon\Carbon;

class NotesApiController extends Controller
{

    public function notes($asset_id)
    {
        return Note::where('asset_id', $asset_id)
                ->orderBy('id','desc')
                ->with('user')
                ->get()
                ->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'remarks' => $q->remarks,
                        'asset_id' => $q->asset_id,
                        'created_at' => Carbon::parse($q->created_at)->format('Y-m-d'),
                        'user' => $q->user
                    ];
                });
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'remarks' => 'required',
            'asset_id' => 'required'
        ]);

        $note = new Note;
        $note->remarks = $request->remarks;
        $note->user_id = $request->user_id;
        $note->asset_id = $request->asset_id;
        $note->save();

        return [
            'id' => $note->id,
            'remarks' => $note->remarks,
            'asset_id' => $note->asset_id,
            'created_at' => Carbon::parse($note->created_at)->format('Y-m-d'),
            'user' => $note->user
        ];
    }

    public function delete(Note $note)
    {
        $note->destroy();
        return $note;
    }
}
