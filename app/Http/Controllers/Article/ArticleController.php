<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Article;
class ArticleController extends Controller
{
    /**
     * Display a listing of articles (authenticated users).
     */
    public function index(Request $request)
    {
        try {
            $query = Article::with(['category', 'user:id,name']);

            // Optional: Filter by category_id if provided
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $articles = $query->get();
            return response()->json([
                'data' => $articles,
                'message' => 'Articles retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching articles: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific article (authenticated users).
     */
    public function show($id)
    {
        try {
            $article = Article::with(['category', 'user:id,name'])->findOrFail($id);
            return response()->json([
                'data' => $article,
                'message' => 'Article retrieved successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching article: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new article (admin only).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
            ]);

            $article->load(['category', 'user:id,name']);

            return response()->json([
                'data' => $article,
                'message' => 'Article created successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating article: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an article (admin only).
     */
    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'category_id' => 'sometimes|exists:categories,id',
            ]);

            $article->update(array_filter([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
            ]));

            $article->load(['category', 'user:id,name']);

            return response()->json([
                'data' => $article,
                'message' => 'Article updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating article: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete an article (admin only).
     */
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();

            return response()->json([
                'message' => 'Article deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting article: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Fetch genres from external JSON (for frontend filtering).
     */
    public function getGenres()
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get('https://my-json-server.typicode.com/mock/genres');
            if ($response->successful()) {
                return response()->json([
                    'data' => $response->json(),
                    'message' => 'Genres retrieved successfully',
                ], 200);
            }
            return response()->json([
                'message' => 'Failed to fetch genres',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching genres: ' . $e->getMessage(),
            ], 500);
        }
    }
}
