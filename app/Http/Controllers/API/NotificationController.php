<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Notification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::where('user_id', '=', Auth::user()->id)->get();
        return response(['notifications' => NotificationResource::collection($notifications), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'status' => 'in:unread,read'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $notification = Notification::create($data);

        return response(['notification' => new NotificationResource($notification), 'message' => 'Created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        if ($notification->getOriginal()['user_id'] !== Auth::user()->id) {
            return response(['error' => 'Forbidden'], 403);
        }

        return response(['notification' => new NotificationResource($notification), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $loggedInUserId = Auth::user()->id;
        if ($notification->getOriginal()['user_id'] !== $loggedInUserId) {
            return response(['error' => 'Forbidden'], 403);
        }

        $data = $request->all();
        $data['user_id'] = $loggedInUserId;

        $notification->update($data);

        return response(['notification' => new NotificationResource($notification), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        if ($notification->getOriginal()['user_id'] !== Auth::user()->id) {
            return response(['error' => 'Forbidden'], 403);
        }

        $notification->delete();

        return response(['message' => 'Deleted']);
    }
}
