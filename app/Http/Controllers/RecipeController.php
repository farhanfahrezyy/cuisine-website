<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class RecipeController extends Controller
{

    public function index(Request $request)
    {
        $type_menu = 'recipe';

        $recipes = Recipe::with('category')
            ->when($request->input('name'), function ($query, $searchTerm) {
                return $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');  // Changed 'category' to 'name'
                    });
            })
            ->when($request->input('sort'), function ($query, $sort) {
                return $query->orderBy('price', $sort);
            })
            ->when($request->input('min_price'), function ($query, $minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($request->input('max_price'), function ($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->paginate($request->input('pagination', 10)); // Default pagination to 10 items per page

        return view('admin.recipes.index', compact('recipes', 'type_menu'));
    }

    public function create()
    {

        $type_menu = 'recipe';

        $categories = Category::all();

        $spicinessOptions = ['low', 'medium', 'high'];

        return view('admin.recipes.create', compact('categories', 'spicinessOptions', 'type_menu'));
    }

    public function store(Request $request)
    {
        // Validate the recipe input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'premium' => 'required|in:yes,no',
            'price' => 'required|numeric|min:0',
            'spiciness' => 'required|in:low,medium,high',
            'country' => 'nullable|string|max:100',
            'detail' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10048'
        ], [
            // Custom error messages
            'name.required' => 'Nama resep harus diisi',
            'category_id.required' => 'Kategori harus dipilih',
            'price.min' => 'Harga minimal 0',
            'ingredients.required' => 'Bahan-bahan harus diisi',
            'instructions.required' => 'Langkah-langkah harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        // Convert ingredients and instructions to JSON
        $ingredients = array_filter(explode("\n", $request->input('ingredients')));
        $instructions = array_filter(explode("\n", $request->input('instructions')));

        $validatedData['ingredients'] = json_encode($ingredients);
        $validatedData['instructions'] = json_encode($instructions);

        // Handle image upload
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            try {
                // Generate a unique filename (optional)
                $filename = \Illuminate\Support\Str::slug($request->input('name')) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();

                // Store the file in the 'recipes' directory under the 'public' disk
                $imagePath = $request->file('image')->storeAs('recipes', $filename, 'public');

                // Assign the file path to the validated data
                $validatedData['image'] = $imagePath;
            } catch (\Exception $e) {
                // Handle any exceptions during file upload
                return back()->withInput()->withErrors(['image' => 'Failed to upload the image. Please try again.']);
            }
        }




        // Create the recipe
        $recipe = Recipe::create($validatedData);

        // Redirect with success message
        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep berhasil ditambahkan');
    }

    public function edit(Recipe $recipe)
    {
        $type_menu = 'recipe';
        $categories = Category::all();
        $spicinessOptions = ['low', 'medium', 'high'];

        return view('admin.recipes.edit', compact('recipe', 'categories', 'spicinessOptions', 'type_menu'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'premium' => 'required|in:no,yes',
            'price' => 'required|numeric|min:0',
            'spiciness' => 'required|in:low,medium,high',
            'country' => 'nullable|string|max:100',
            'detail' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp |max:2048'
        ]);

        // Convert ingredients and instructions to JSON
        $ingredients = array_filter(explode("\n", $request->input('ingredients')));
        $instructions = array_filter(explode("\n", $request->input('instructions')));

        $validatedData['ingredients'] = json_encode($ingredients);
        $validatedData['instructions'] = json_encode($instructions);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }

            $imagePath = $request->file('image')->store('recipes', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the recipe
        $recipe->update($validatedData);

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep berhasil diperbarui');
    }

    public function destroy(Recipe $recipe)
    {
        // Delete associated image
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Resep berhasil dihapus');
    }
}
