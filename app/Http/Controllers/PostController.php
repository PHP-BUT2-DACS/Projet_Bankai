<?php
/*
namespace App\Http\Controllers;

use App\Models\Get;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request) {
        // Validations
        $request->validate([
            'title' => 'required',
            'text' => 'required', // 'text' correspond au contenu du blog
        ]);

        $post = new Post;

        // Assignation des valeurs aux champs de la base de données
        $post->user_username = auth()->user()->getAuthIdentifierName(); // Récupère le nom d'utilisateur de l'utilisateur connecté
        $post->title = $request->title;
        $post->text = $request->text; // 'text' est le contenu du blog
        $post->post_date = now(); // Utilise la date et l'heure actuelles pour 'post_date'
        $post->created_at = now(); // Définit la date de création
        $post->updated_at = now(); // Définit la date de mise à jour

        // Sauvegarde du post dans la base de données
        $post->save();

        // Redirection avec un message de succès
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

}*/

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Sport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager; // Nouvelle classe pour la version 3.x
use Intervention\Image\Drivers\Gd\Driver; // Utiliser le driver GD (ou Imagick si tu préfères)
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Affiche la liste de tous les posts (fil d'actualité).
     *
     * @return View
     */
    public function index(): View
    {
        $posts = Post::query()
            ->with(['user', 'likedBy', 'sport'])
            ->latest()
            ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau post.
     *
     * @return View
     */
    public function create(): View
    {
        $sports = Sport::all();
        return view('posts.create', compact('sports'));
    }

    /**
     * Enregistre un nouveau post.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'sport_id' => ['nullable', 'exists:sports,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Créer une instance de ImageManager avec le driver GD
            $manager = new ImageManager(new Driver());

            // Charger l'image
            $image = $manager->read($request->file('image'));

            // Redimensionner l'image
            $image->resize(800, 800);
            /*$image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });*/

            // Générer un nom unique pour l'image
            $imageName = 'post-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = 'posts/' . $imageName;

            // Sauvegarder l'image redimensionnée
            Storage::disk('public')->put($path, $image->encode());

            $validated['image'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['post_date'] = now();

        Post::create($validated);
        return redirect()->route('posts.index')->with('success', 'Post publié avec succès !');
    }

    /**
     * Supprime un post.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Vérifier que l'utilisateur connecté est l'auteur du post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer ce post.');
        }

        // Supprimer l'image associée (si elle existe)
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Supprimer le post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès !');
    }

    public function like(Post $post): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vous devez être connecté pour liker un post.'], 401);
        }

        $user = Auth::user()->fresh();
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        if (!$post->exists) {
            return response()->json(['error' => 'Post non trouvé.'], 404);
        }

        // Ajouter le like (attach est idempotent, donc pas de doublons)
        $user->likes()->attach($post->id);

        // Recharger le post pour obtenir le nombre de likes mis à jour
        $post->load('likedBy');

        return response()->json([
            'success' => true,
            'message' => 'Post liké !',
            'likes_count' => $post->likedBy()->count(),
            'liked' => true,
        ]);
    }

    public function unlike(Post $post): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vous devez être connecté pour retirer un like.'], 401);
        }

        $user = Auth::user()->fresh();
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        if (!$post->exists) {
            return response()->json(['error' => 'Post non trouvé.'], 404);
        }

        // Retirer le like
        $user->likes()->detach($post->id);

        // Recharger le post pour obtenir le nombre de likes mis à jour
        $post->load('likedBy');

        return response()->json([
            'success' => true,
            'message' => 'Like retiré !',
            'likes_count' => $post->likedBy()->count(),
            'liked' => false,
        ]);
    }
}
