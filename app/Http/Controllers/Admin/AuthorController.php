<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function addAuthor()
    {
        return view('admin.authors.add-author');
    }

    public function fetchAllAuthors(Request $request)
    {
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'];

        $query = Admin::select('admins.*')
            ->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('admins.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('admins.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('admins.phone_number', 'like', '%' . $searchValue . '%');
            })
            ->where('is_deleted', 0)
            ->whereIn('type', ['author', 'admin-author']) // Fetch both author types
            ->whereNot('admins.name', 'Other')
            ->orderBy('admins.id', 'DESC');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('phone', function ($row) {
                return $row->phone_number;
            })
            ->make(true);
    }

    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'phone_number' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
            'type' => 'required|in:author,admin-author'
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone_number = $request->phone_number;
        $admin->about = $request->about;
        $admin->password = bcrypt($request->password);
        $admin->type = $request->type; // Use type from form
        $admin->is_active = 1; // Set as active by default
        $admin->is_deleted = 0; // Set as not deleted

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store directly in public/uploads/authors directory
            $file->move(public_path('uploads/authors'), $filename);
            $admin->profile_picture = $filename;
        }

        $admin->save();

        return redirect()->route('admin.authors')
            ->with('success', 'Author created successfully');
    }

    public function editAuthor(Admin $author)
    {
        return view('admin.authors.edit-author', compact('author'));
    }

    public function updateAuthor(Request $request, Admin $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $author->id,
            'phone_number' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6',
            'type' => 'required|in:author,admin-author'
        ]);

        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_number = $request->phone_number;
        $author->about = $request->about;
        $author->type = $request->type; // Update type field

        if ($request->password) {
            $author->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($author->profile_picture && file_exists(public_path('uploads/authors/' . $author->profile_picture))) {
                unlink(public_path('uploads/authors/' . $author->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/authors'), $filename);
            $author->profile_picture = $filename;
        }

        $author->save();

        return redirect()->route('admin.authors')
            ->with('success', 'Author updated successfully');
    }

    public function updateAuthorVisibility(Admin $author)
    {
        $author->is_active = !$author->is_active;
        $author->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Author visibility updated successfully',
            'is_active' => $author->is_active
        ]);
    }

    public function deleteAuthor(Admin $author)
    {
        $author->is_deleted = 1;
        $author->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Author deleted successfully'
        ]);
    }
}
