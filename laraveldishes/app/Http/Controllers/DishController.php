<?php
namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:create dishes')->only(['create','store']);
        $this->middleware('can:delete dishes')->only(['destroy']);
    }

    public function index()
    {
        $dishes = Dish::with('creator')->latest()->paginate(12);
        return view('dishes.index', [
            'dishes' => $dishes,
            'title' => 'Tous les plats',
            'isFavorites' => false,
        ]);
    }

    public function favorites()
    {
        $dishes = auth()->user()
            ->favorites()
            ->with('creator')
            ->latest('dish_user.id')
            ->paginate(12);

        return view('dishes.index', [
            'dishes' => $dishes,
            'title' => 'Mes favoris',
            'isFavorites' => true,
        ]);
    }

    public function create()
    {
        return view('dishes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'image' => ['required','image','mimes:jpg,jpeg,png','max:4096'],
            'description' => ['required','string','max:2048'],
            'recipe' => ['required','string'],
        ]);

        $path = $request->file('image')->store('dishes','public');

        $dish = Dish::create([
            'user_id'     => auth()->id(),
            'name'        => $data['name'],
            'image_path'  => $path,
            'description' => $data['description'],
            'recipe'      => $data['recipe'],
        ]);

        auth()->user()->notify(new \App\Notifications\DishPublished($dish));
        return redirect()->route('dishes.show',$dish)->with('ok','Plat publié');
    }

    public function show(Dish $dish)
    {
        $dish->load('creator');
        return view('dishes.show', compact('dish'));
    }

    public function edit(Dish $dish)
    {
        return view('dishes.edit', compact('dish'));
    }

    public function update(Request $request, Dish $dish)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png','max:4096'],
            'description' => ['required','string','max:2048'],
            'recipe'      => ['required','string'],
        ]);

        if ($request->hasFile('image')) {
            if ($dish->image_path) {
                Storage::disk('public')->delete($dish->image_path);
            }
            $dish->image_path = $request->file('image')->store('dishes','public');
        }

        $dish->fill([
            'name'        => $data['name'],
            'description' => $data['description'],
            'recipe'      => $data['recipe'],
        ])->save();

        return redirect()->route('dishes.show',$dish)->with('ok','Plat mis à jour');
    }

    public function destroy(Dish $dish)
    {
        if ($dish->image_path) {
            Storage::disk('public')->delete($dish->image_path);
        }
        $dish->delete();
        return redirect()->route('dishes.index')->with('ok','Plat supprimé');
    }

    public function favorite(Dish $dish)
    {
        auth()->user()->favorites()->syncWithoutDetaching([$dish->id]);
        return back()->with('ok','Ajouté aux favoris');
    }

    public function unfavorite(Dish $dish)
    {
        auth()->user()->favorites()->detach($dish->id);
        return back()->with('ok','Retiré des favoris');
    }
}
