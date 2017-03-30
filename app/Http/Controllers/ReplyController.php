<?php

namespace App\Http\Controllers;

use App\Thread;

class ReplyController extends Controller
{
    /**
     * Create a new ReplyController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Persist a new reply.
     *
     * @param  string   $channelSlug
     * @param  Thread  $thread
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     */
    public function store($channelSlug, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if(request()->wantsJson()){
            return $reply;
        }

        return back();
    }
}
