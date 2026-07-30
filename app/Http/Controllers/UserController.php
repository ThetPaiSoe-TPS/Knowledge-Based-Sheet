<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('direction', 'asc'));
        }

        $users = $query->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
                'next_page_url' => $users->nextPageUrl(),
                'prev_page_url' => $users->previousPageUrl(),
            ],
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
                'sort_by' => $request->sort_by,
                'direction' => $request->direction ?? 'asc',
            ],
        ], 200);
    }

    public function store(StoreUserRequest $req)
    {
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    public function home()
    {
        $name = 'Keesh';
        return view('home', compact('name'))->with('success', 'You are logged in');
    }

    public function bulkDelete(Request $req)
    {
        $req->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $count = User::where('id', $req->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} users deleted successfully",
            'deleted-count' => $count
        ]);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'status' => 'required|in:active,inactive,pending,suspended'
        ]);

        $count = User::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => "{$count} users updated to {$request->status}",
            'updated_count' => $count,
            'status' => $request->status
        ]);
    }

    public function bulkActivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $count = User::whereIn('id', $request->ids)
            ->update(['status' => 'active']);

        return response()->json([
            'success' => true,
            'message' => "{$count} users activated successfully",
            'activated_count' => $count
        ]);
    }

    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);
        $count = User::whereIn('id', $request->ids)->update(['status' => 'inactive']);

        return response()->json([
            'success' => true,
            'message' => "{$count} users deactivated successfully",
            'deactivated_count' => $count
        ]);
    }

    public function bulkSuspend(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $count = User::whereIn('id', $request->ids)
            ->update(['status' => 'suspend']);

        return response()->json([
            'success' => true,
            'message' => "{$count} users suspended successfully",
            'suspended_count' => $count
        ]);
    }

    public function bulkForceDelete(Request $req)
    {
        $req->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users, id',
        ]);

        $count = User::whereIn('id', $req->ids)->forceDelete();

        return response()->json([
            'success' => true,
            'message' => "{$count} users permanently deleted",
            "deleted_count" => $count
        ]);
    }
}
