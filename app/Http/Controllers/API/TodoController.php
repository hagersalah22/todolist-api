<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = auth()->user()
            ->todos()
            ->with('user')
            ->latest()
            ->get();

        return response()->json(TodoResource::collection($todos), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $todo = auth()->user()->todos()->create($validated);

        return response()->json(new TodoResource($todo->load('user')), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        $this->authorizeAccess($todo);

        return response()->json(new TodoResource($todo->load('user')), 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $this->authorizeAccess($todo);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $todo->update($validated);

        return response()->json(new TodoResource($todo->load('user')), 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $this->authorizeAccess($todo);
    
        $todo->delete();
    
        return response()->json([
        'message' => 'Todo deleted successfully.'
        ], 200);
    }
    

    /**
     * Authorize that the authenticated user owns the todo.
     */
    protected function authorizeAccess(Todo $todo): void
    {
        if ($todo->user_id !== auth()->id()) {
            response()->json([
                'message' => 'You are not authorized to access this todo.',
            ], 403)->send();
            exit; 
    }
   }

}
