<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * Create a new ReplyController instance.
     */
    public function __construct()
    {
        $this->middleware('can:add-reply,thread')->only('store');
        $this->middleware('can:select-best-answer,thread')->only('bestAnswer');
        $this->middleware('can:update,reply')->only(['edit', 'update']);
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
        alert()->success('Success');
        return redirect($thread->path());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply  $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function edit (Reply $reply)
    {
        $thread = $reply->thread;
        return view('replies.edit', compact('thread', 'reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Reply $reply
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Reply $reply)
    {
        $this->validate(request(), ['body' => 'required']);

        $reply->update([
            'body'        => request('body'),
        ]);

        alert()->success('Success');
        return redirect($reply->thread->path());
    }

    /**
     * Select the best reply for a thread.
     *
     * @param string $categorySlug
     * @param Thread $thread
     * @param Reply  $reply
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bestAnswer(string $categorySlug, Thread $thread, Reply $reply)
    {
        $thread->selectBestReply($reply);

        alert()->success('Success');
        return redirect($thread->path());
    }
}