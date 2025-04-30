<?php

namespace App\Http\Controllers\Admin;


use App\Models\Author;
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

        $query = Author::select('authors.*')
            ->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('authors.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('authors.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('authors.phone', 'like', '%' . $searchValue . '%');
            })
            ->where('is_deleted', 0)
            ->whereNot('authors.name', 'Other')
            ->orderBy('authors.id', 'DESC');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('phone', function ($row) {
                return $row->phone;
            })
            ->make(true);
    }

    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:authors,email',
            'phone' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6'
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone = $request->phone;
        $author->about = $request->about;
        $author->password = bcrypt($request->password);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store directly in public/uploads/authors directory
            $file->move(public_path('uploads/authors'), $filename);
            $author->profile_picture = $filename;
        }

        $author->save();

        return redirect()->route('admin.authors')
            ->with('success', 'Author created successfully');
    }

    public function editAuthor(Author $author)
    {
        return view('admin.authors.edit-author', compact('author'));
    }

    public function updateAuthor(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6'
        ]);

        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone = $request->phone;
        $author->about = $request->about;

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

    public function updateAuthorVisibility(Author $author)
    {
        $author->is_active = !$author->is_active;
        $author->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Author visibility updated successfully',
            'is_active' => $author->is_active
        ]);
    }

    public function deleteAuthor(Author $author)
    {
        $author->is_deleted = 1;
        $author->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Author deleted successfully'
        ]);
    }
}
