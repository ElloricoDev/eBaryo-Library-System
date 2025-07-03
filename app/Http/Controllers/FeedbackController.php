<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        return Inertia::render('User/Feedback');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending',
        ]);
        return redirect()->route('feedback.create')->with('success', 'Thank you for your feedback!');
    }

    public function myFeedback()
    {
        $feedbacks = Feedback::where('user_id', auth()->id())->orderByDesc('created_at')->get();
        $newResponses = $feedbacks->where('status', 'responded')->where('notified', false);
        // Mark as notified
        Feedback::whereIn('id', $newResponses->pluck('id'))->update(['notified' => true]);
        return Inertia::render('User/MyFeedback', [
            'feedbacks' => $feedbacks,
            'hasNewResponses' => $newResponses->count() > 0,
        ]);
    }
}
