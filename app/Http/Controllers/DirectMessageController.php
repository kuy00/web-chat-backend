<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Arr;

class DirectMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->directMessages()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $directMessage = DirectMessage::whereHas('users', function ($query) use ($request) {
            $query->groupBy('direct_message_id')->havingRaw('group_concat(direct_message_user.user_id) = ?', [implode(',', Arr::sort($request->users))]);
        })->first();

        if (!$directMessage) {
            try {
                DB::beginTransaction();

                $users = $request->users;
                $name = $request->name;
                $directMessage = DirectMessage::CreateDirectMesage($name, $users);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->sendResponse($th->getMessage(), [], 500);
            }
        }

        return $this->sendResponse('Success For Create Direct Message', $directMessage, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DirectMessage $directMessage)
    {
        $directMessage->update([
            'name' => $request->name
        ]);

        return $this->sendResponse('Success For Edit Direct Message', [], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectMessage $directMessage)
    {
        $directMessage->users()->detach(Auth::id());

        return $this->sendResponse('Success For Exit Direct Message', [], 200);
    }
}
